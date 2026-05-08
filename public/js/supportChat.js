window.SupportChat = (() => {

    // small HTML-escape
    const escapeHTML = (s = "") => String(s)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/\n/g, "<br>");

    // safe JSON fetch
    async function fetchJSON(url, opts = {}) {
        try {
            const r = await fetch(url, opts);
            return await r.json();
        } catch (e) {
            console.warn("SupportChat fetch error:", e);
            return { success: false };
        }
    }

    // utilities
    const el = (sel, ctx = document) => ctx.querySelector(sel);
    const nl = (sel, ctx = document) => Array.from((ctx || document).querySelectorAll(sel));

    return {

        // initialize with config
        init(config = {}) {
            this.ticketId = config.ticketId;
            this.role = config.role || "admin";
            this.fetchUrl = config.fetchUrl || "/admin/support/poll";
            this.sendUrl = config.sendUrl || "/admin/support/reply";
            this.body = document.querySelector(config.container || "#chatBody");
            this.input = document.querySelector(config.input || "#chatMessage");
            this.form = document.querySelector(config.form || "#chatForm");

            this.pollIntervalMs = config.pollIntervalMs || 1500;
            this._seen = new Set();
            this._pending = new Map();
            this.lastId = 0;
            this.pollTimer = null;
            this.loading = false;

            // NEW FLAG (fix double scroll)
            this._initialRendered = false;

            if (!this.ticketId || !this.body) {
                console.warn("SupportChat init: missing ticketId or container");
                return;
            }

            this._bindForm();

            if (Array.isArray(config.initialReplies) && config.initialReplies.length) {
                this._renderInitial(config.initialReplies);
            }

            this._startPolling();
        },

        // initial messages
        _renderInitial(replies = []) {
            this.body.innerHTML = "";
            if (!replies.length) return;

            const frag = document.createDocumentFragment();

            replies.forEach(r => {
                if (!this._isSeen(r.id)) {
                    frag.appendChild(this._createMsgNode(r));
                    this._markSeen(r.id);
                }
            });

            this.body.appendChild(frag);
            this._setLastIdFrom(replies);

            // FIXED double scroll: only scroll ONCE on initial render
            if (!this._initialRendered) {
                this._scrollToBottom();
                this._initialRendered = true;
            }
        },

        // create message node
        _createMsgNode(reply) {
            const wrapper = document.createElement("div");
            const roleCls = reply.is_admin ? "admin" : (reply.is_seller ? "seller" : "user");
            wrapper.className = `msg ${roleCls}`;

            const created = reply.created_at || reply.time || reply.createdAt || "";
            const time = created
                ? new Date(created).toLocaleString("en-IN", {
                    day: "2-digit", month: "short", year: "numeric",
                    hour: "2-digit", minute: "2-digit", hour12: true
                })
                : "";

            wrapper.dataset.replyId = reply.id ?? "";
            wrapper.innerHTML = `
                <div>${escapeHTML(reply.message)}</div>
                <div class="small text-muted mt-1">${escapeHTML(time)}</div>
            `;

            return wrapper;
        },

        // append a single reply
        _append(reply) {
            if (reply.id && this._isSeen(reply.id)) return;

            const node = this._createMsgNode(reply);
            this.body.appendChild(node);

            if (reply.id) this._markSeen(reply.id);
            if (reply.id && reply.id > this.lastId) this.lastId = reply.id;

            // smooth scroll (kept same, safe)
            requestAnimationFrame(() => this._scrollToBottom());
        },

        // helpers
        _isSeen(id) {
            return id && this._seen.has(+id);
        },
        _markSeen(id) {
            if (!id) return;
            this._seen.add(+id);
        },
        _setLastIdFrom(replies = []) {
            if (!replies.length) return;
            const last = replies[replies.length - 1];
            if (last && last.id) this.lastId = last.id;
        },
        _scrollToBottom() {
            try {
                this.body.scrollTop = this.body.scrollHeight;
            } catch (e) { }
        },

        // polling
        async _poll() {
            if (!this.ticketId || this.loading) return;

            const url = `${this.fetchUrl}/${this.ticketId}?after=${this.lastId}`;
            const data = await fetchJSON(url);
            if (!data || !data.success) return;

            const newReplies = data.new_replies || [];
            if (!newReplies.length) return;

            newReplies.forEach(r => {
                this._append(this._normalizeReply(r));
            });
        },

        _startPolling() {
            this._poll();
            if (this.pollTimer) clearInterval(this.pollTimer);
            this.pollTimer = setInterval(() => this._poll(), this.pollIntervalMs);
        },

        stopPolling() {
            if (this.pollTimer) {
                clearInterval(this.pollTimer);
                this.pollTimer = null;
            }
        },

        // normalize reply object
        _normalizeReply(r) {
            return {
                id: r.id ?? r.ID ?? null,
                message: r.message ?? r.msg ?? "",
                is_admin: !!r.is_admin,
                is_seller: !!r.is_seller,
                is_user: !!r.is_user,
                created_at: r.created_at ?? r.time ?? r.createdAt ?? null,
                name: r.name ?? null
            };
        },

        // form submit handler
        _bindForm() {
            if (!this.form) return;

            this.form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const raw = this.input?.value?.trim();
                if (!raw) return;

                const tempId = `p_${Date.now()}`;

                const provReply = {
                    id: tempId,
                    message: raw,
                    is_admin: this.role === "admin",
                    is_seller: this.role === "seller",
                    is_user: this.role === "user",
                    created_at: new Date().toISOString()
                };

                const provNode = this._createMsgNode(provReply);
                provNode.classList.add("provisional");
                provNode.dataset.tempId = tempId;

                this.body.appendChild(provNode);
                this._pending.set(tempId, provNode);
                this._scrollToBottom();

                if (this.input) this.input.value = "";

                try {
                    this.loading = true;

                    const res = await fetch(this.sendUrl, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": (document.querySelector('meta[name="csrf-token"]') || {}).content || ""
                        },
                        body: JSON.stringify({
                            ticket_id: this.ticketId,
                            message: raw
                        })
                    });

                    const data = await res.json();
                    this.loading = false;

                    if (data && data.success) {
                        if (Array.isArray(data.replies)) {
                            this._renderFullFromServer(data.replies);
                        } else {
                            this._clearProvisional(tempId);
                        }
                    } else {
                        this._markProvisionalFailed(tempId);
                    }

                } catch (err) {
                    this.loading = false;
                    this._markProvisionalFailed(tempId);
                }
            });
        },

        _clearProvisional(tempId) {
            const node = this._pending.get(tempId);
            if (node && node.parentNode) node.parentNode.removeChild(node);
            this._pending.delete(tempId);
        },

        _markProvisionalFailed(tempId) {
            const node = this._pending.get(tempId);
            if (!node) return;
            const sm = node.querySelector(".small");
            if (sm) sm.textContent = "Failed";
            node.classList.add("failed");
            this._pending.delete(tempId);
        },

        // full rebuild from server replies
        _renderFullFromServer(replies) {
            const normalized = replies.map(r => this._normalizeReply(r));

            this.body.innerHTML = "";

            normalized.forEach(r => {
                const node = this._createMsgNode(r);
                this.body.appendChild(node);
                if (r.id) this._markSeen(r.id);
            });

            this._pending.forEach((node, key) => {
                if (node && node.parentNode) node.parentNode.removeChild(node);
            });
            this._pending.clear();

            if (normalized.length) {
                this.lastId = normalized[normalized.length - 1].id || this.lastId;
            }

            requestAnimationFrame(() => this._scrollToBottom());
        }
    };

})();