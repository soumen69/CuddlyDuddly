// supportChat.js — Stable, optimized, minimal
// - Always oldest -> newest
// - Dedupes by real DB ids
// - Handles initial load + polling + send (provisional -> confirmed)
// - Lightweight DOM ops (uses DocumentFragment)
// - Keeps polling safe during re-renders

// window.SupportChat = (() => {

//     // small HTML-escape
//     const escapeHTML = (s = "") => String(s)
//         .replace(/&/g, "&amp;")
//         .replace(/</g, "&lt;")
//         .replace(/>/g, "&gt;")
//         .replace(/\n/g, "<br>");

//     // safe JSON fetch
//     async function fetchJSON(url, opts = {}) {
//         try {
//             const r = await fetch(url, opts);
//             return await r.json();
//         } catch (e) {
//             console.warn("SupportChat fetch error:", e);
//             return { success: false };
//         }
//     }

//     // utilities
//     const el = (sel, ctx = document) => ctx.querySelector(sel);
//     const nl = (sel, ctx = document) => Array.from((ctx || document).querySelectorAll(sel));

//     // main implementation
//     return {
//         // initialize with config: { ticketId, role, fetchUrl, sendUrl, container, input, form, initialReplies (optional) }
//         init(config = {}) {
//             this.ticketId = config.ticketId;
//             this.role = config.role || "admin";
//             this.fetchUrl = config.fetchUrl || "/admin/support/poll";
//             this.sendUrl = config.sendUrl || "/admin/support/reply";
//             this.body = document.querySelector(config.container || "#chatBody");
//             this.input = document.querySelector(config.input || "#chatMessage");
//             this.form = document.querySelector(config.form || "#chatForm");

//             this.pollIntervalMs = config.pollIntervalMs || 1500;
//             this._seen = new Set();       // real reply ids seen (positive integers)
//             this._pending = new Map();    // provisional messages keyed by tempId -> DOM node
//             this.lastId = 0;              // last real DB id seen
//             this.pollTimer = null;
//             this.loading = false;

//             if (!this.ticketId || !this.body) {
//                 console.warn("SupportChat init: missing ticketId or container");
//                 return;
//             }

//             // bind form & start polling
//             this._bindForm();
//             // if caller provided initial replies, render them deterministically
//             if (Array.isArray(config.initialReplies) && config.initialReplies.length) {
//                 this._renderInitial(config.initialReplies);
//             }
//             // start polling loop
//             this._startPolling();
//         },

//         // render initial replies (assumed oldest->newest)
//         _renderInitial(replies = []) {
//             // clear and render
//             this.body.innerHTML = "";
//             if (!replies.length) return;
//             const frag = document.createDocumentFragment();
//             replies.forEach(r => {
//                 // only render if not seen
//                 if (!this._isSeen(r.id)) {
//                     frag.appendChild(this._createMsgNode(r));
//                     this._markSeen(r.id);
//                 }
//             });
//             this.body.appendChild(frag);
//             this._setLastIdFrom(replies);
//             this._scrollToBottom();
//         },

//         // create a message DOM node from server reply object
//         _createMsgNode(reply) {
//             // reply shape: { id, message, is_admin, is_seller, is_user, created_at OR time, name? }
//             const wrapper = document.createElement("div");
//             const roleCls = reply.is_admin ? "admin" : (reply.is_seller ? "seller" : "user");
//             wrapper.className = `msg ${roleCls}`;
//             const created = reply.created_at || reply.time || reply.createdAt || "";
//             const time = created ? new Date(created).toLocaleString("en-IN", {
//                 day: "2-digit", month: "short", year: "numeric",
//                 hour: "2-digit", minute: "2-digit", hour12: true
//             }) : "";
//             wrapper.dataset.replyId = reply.id ?? ""; // real id (might be undefined for provisional)
//             wrapper.innerHTML = `<div>${escapeHTML(reply.message)}</div>
//                                  <div class="small text-muted mt-1">${escapeHTML(time)}</div>`;
//             return wrapper;
//         },

//         // append single reply (server-provided)
//         _append(reply) {
//             // skip if already seen (dedupe)
//             if (reply.id && this._isSeen(reply.id)) return;
//             const node = this._createMsgNode(reply);
//             this.body.appendChild(node);
//             if (reply.id) this._markSeen(reply.id);
//             if (reply.id && reply.id > this.lastId) this.lastId = reply.id;
//             // smooth scroll
//             requestAnimationFrame(() => this._scrollToBottom());
//         },

//         // check/set seen
//         _isSeen(id) {
//             return !id ? false : this._seen.has(Number(id));
//         },
//         _markSeen(id) {
//             if (!id) return;
//             this._seen.add(Number(id));
//         },

//         // set lastId from an array of replies (assumed ascending)
//         _setLastIdFrom(replies = []) {
//             if (!replies.length) return;
//             const last = replies[replies.length - 1];
//             if (last && last.id) this.lastId = last.id;
//         },

//         // scroll helper
//         _scrollToBottom() {
//             try {
//                 this.body.scrollTop = this.body.scrollHeight;
//             } catch (e) { /* ignore */ }
//         },

//         // polling: fetch only replies after lastId
//         async _poll() {
//             if (!this.ticketId || this.loading) return;
//             // build URL: `${fetchUrl}/${ticketId}?after=${lastId}`
//             const url = `${this.fetchUrl}/${this.ticketId}?after=${this.lastId}`;
//             const data = await fetchJSON(url);
//             if (!data || !data.success) return;
//             const newReplies = data.new_replies || [];
//             if (!newReplies.length) return;
//             // server expected to return ascending list
//             // append each (dedupe inside _append)
//             newReplies.forEach(r => {
//                 this._append(this._normalizeReply(r));
//             });
//         },

//         _startPolling() {
//             // one immediate poll (fast initial reaction)
//             this._poll();
//             // then interval
//             if (this.pollTimer) clearInterval(this.pollTimer);
//             this.pollTimer = setInterval(() => this._poll(), this.pollIntervalMs);
//         },

//         stopPolling() {
//             if (this.pollTimer) {
//                 clearInterval(this.pollTimer);
//                 this.pollTimer = null;
//             }
//         },

//         // normalize reply keys across endpoints (created_at vs time)
//         _normalizeReply(r) {
//             // ensure fields exist: id, message, is_admin/is_seller/is_user, created_at
//             return {
//                 id: r.id ?? r.ID ?? null,
//                 message: r.message ?? r.msg ?? "",
//                 is_admin: !!r.is_admin,
//                 is_seller: !!r.is_seller,
//                 is_user: !!r.is_user,
//                 created_at: r.created_at ?? r.time ?? r.createdAt ?? null,
//                 name: r.name ?? null
//             };
//         },

//         // form submit handling (provisional + send)
//         _bindForm() {
//             if (!this.form) return;

//             this.form.addEventListener("submit", async (e) => {
//                 e.preventDefault();
//                 const raw = (this.input && this.input.value) ? this.input.value.trim() : "";
//                 if (!raw) return;
//                 // create provisional entry with negative timestamp id
//                 const tempId = `p_${Date.now()}`;
//                 const provReply = {
//                     id: tempId,
//                     message: raw,
//                     is_admin: this.role === "admin",
//                     is_seller: this.role === "seller",
//                     is_user: this.role === "user",
//                     created_at: new Date().toISOString()
//                 };

//                 // render provisional
//                 const provNode = this._createMsgNode(provReply);
//                 provNode.classList.add("provisional");
//                 provNode.dataset.tempId = tempId;
//                 this.body.appendChild(provNode);
//                 this._pending.set(tempId, provNode);
//                 this._scrollToBottom();

//                 // clear input immediately
//                 if (this.input) this.input.value = "";

//                 // POST to server
//                 try {
//                     this.loading = true;
//                     const res = await fetch(this.sendUrl, {
//                         method: "POST",
//                         headers: {
//                             "Content-Type": "application/json",
//                             "X-CSRF-TOKEN": (document.querySelector('meta[name="csrf-token"]') || {}).content || ""
//                         },
//                         body: JSON.stringify({
//                             ticket_id: this.ticketId,
//                             message: raw
//                         })
//                     });
//                     const data = await res.json();
//                     this.loading = false;

//                     if (data && data.success) {
//                         // server returns full replies array (ascending) — re-render deterministically
//                         if (Array.isArray(data.replies)) {
//                             this._renderFullFromServer(data.replies);
//                         } else {
//                             // fallback: remove provisional if server returned last id
//                             this._clearProvisional(tempId);
//                         }
//                     } else {
//                         // mark provisional as failed
//                         this._markProvisionalFailed(tempId);
//                     }
//                 } catch (err) {
//                     this.loading = false;
//                     this._markProvisionalFailed(tempId);
//                 }
//             });
//         },

//         // remove a provisional node
//         _clearProvisional(tempId) {
//             const node = this._pending.get(tempId);
//             if (node && node.parentNode) node.parentNode.removeChild(node);
//             this._pending.delete(tempId);
//         },

//         _markProvisionalFailed(tempId) {
//             const node = this._pending.get(tempId);
//             if (!node) return;
//             const sm = node.querySelector(".small");
//             if (sm) sm.textContent = "Failed";
//             node.classList.add("failed");
//             this._pending.delete(tempId);
//         },

//         // deterministic full render from server replies (assume ascending oldest->newest)
//         _renderFullFromServer(replies) {
//             // normalize and dedupe: filter out already seen ids
//             const normalized = replies.map(r => this._normalizeReply(r));
//             const frag = document.createDocumentFragment();
//             normalized.forEach(r => {
//                 if (r.id && this._isSeen(r.id)) return; // skip duplicates
//                 frag.appendChild(this._createMsgNode(r));
//                 this._markSeen(r.id);
//             });

//             // append to existing body — but to avoid duplicates we can rebuild if client side is messy
//             // simpler & safe approach: rebuild whole body from server array (recommended when server returns full replies)
//             // -> do a full rebuild for absolute correctness
//             this.body.innerHTML = "";
//             normalized.forEach(r => {
//                 const node = this._createMsgNode(r);
//                 this.body.appendChild(node);
//                 if (r.id) this._markSeen(r.id);
//             });

//             // clear any provisional nodes (they're now confirmed)
//             this._pending.forEach((node, key) => {
//                 if (node && node.parentNode) node.parentNode.removeChild(node);
//             });
//             this._pending.clear();

//             // update lastId
//             if (normalized.length) {
//                 this.lastId = normalized[normalized.length - 1].id || this.lastId;
//             }
//             this._scrollToBottom();
//         }
//     };

// })();
