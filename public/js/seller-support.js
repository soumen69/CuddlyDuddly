/*
* Seller Support Chat — seller-support.js
* Place in: public/js/seller-support.js
*
* Fixes applied vs original:
*  1. sendMsg() guards against empty text + no file (no blank sends)
*  2. closeChat() now calls openNewTicketFlow() → FAQ always shows on back/close
*  3. messagesArea visibility toggled properly alongside faqContainer
*  4. showFaqMode / showChatMode correctly toggle #messagesArea display
*  5. Boot logic: if no tickets exist → FAQ; if tickets exist on desktop → open first
*  6. setFilter() helper for active state on filter buttons
*  7. autoGrow() for textarea auto-height (wired in blade)
*/

(function () {
    'use strict';

    const config = window.supportConfig || {};
    const csrfToken =
        config.csrfToken ||
        document.querySelector('meta[name="csrf-token"]')?.content ||
        '';

    const state = {
        activeTicketId: null,
        selectedFile: null,
        isCreatingTicket: false,
    };

    /* ─── DOM helpers ─── */
    const dom = {
        listPane: () => document.getElementById('listPane'),
        chatPane: () => document.getElementById('chatPane'),
        messagesArea: () => document.getElementById('messagesArea'),
        composeInput: () => document.getElementById('composeInput'),
        ticketComposer: () => document.getElementById('ticketComposer'),
        fileInput: () => document.getElementById('attachmentInput'),
        filePreview: () => document.getElementById('filePreview'),
        chatTitle: () => document.getElementById('chatTitle'),
        chatSubtitle: () => document.getElementById('chatSubtitle'),
        chatBadges: () => document.getElementById('chatHeaderBadges'),
        faqContainer: () => document.getElementById('faqContainer'),
        faqAnswer: () => document.getElementById('faqAnswerBubble'),
        subjectWrapper: () => document.getElementById('ticketSubjectWrapper'),
        subjectBox: () => document.getElementById('subjectBox'),
        subjectInput: () => document.getElementById('ticketSubjectCompose'),
        sendButton: () => document.querySelector('.st-send-btn'),
        emptyState: () => document.getElementById('emptyState'),
    };

    function hasSupportChat() {
        return Boolean(
            dom.chatPane() && dom.messagesArea() && dom.ticketComposer()
        );
    }

    /* ─── Utilities ─── */
    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatTime(value) {
        const date = value ? new Date(value) : new Date();
        if (Number.isNaN(date.getTime())) return '';
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    function padTicketId(id) {
        return '#TK-' + String(id).padStart(4, '0');
    }

    function cap(value) {
        const text = String(value || '');
        return text ? text.charAt(0).toUpperCase() + text.slice(1) : '';
    }

    function scrollToBottom() {
        const area = dom.messagesArea();
        if (area) area.scrollTop = area.scrollHeight;
    }

    function endpoint(path) {
        return String(path || '').replace(/\/+$/, '');
    }

    function show(el, display = 'block') {
        if (el) el.style.display = display;
    }

    function hide(el) {
        if (el) el.style.display = 'none';
    }

    function isImageUrl(url) {
        return /\.(jpg|jpeg|png|webp|gif)(\?.*)?$/i.test(String(url || ''));
    }

    function isImageFile(file) {
        return file?.type?.startsWith('image/');
    }

    function isPdfFile(file) {
        return file?.type === 'application/pdf';
    }

    /* ─── Attachment rendering ─── */
    function attachmentFromUrl(url) {
        if (!url) return '';
        const safeUrl = escapeHtml(url);

        if (isImageUrl(url)) {
            return `<div class="msg-attachment" style="margin-top:6px">
                    <img src="${safeUrl}" alt="attachment"
                        style="max-width:200px;border-radius:8px;display:block;cursor:pointer"
                        onclick="window.open('${safeUrl}','_blank')">
                </div>`;
        }

        return `<div class="msg-attachment" style="margin-top:6px">
                <a href="${safeUrl}" target="_blank" rel="noopener"
                style="color:inherit;font-size:13px;opacity:.85">View attachment</a>
            </div>`;
    }

    function attachmentFromFile(file) {
        if (!file) return '';
        const name = escapeHtml(file.name);
        const url = URL.createObjectURL(file);

        if (isImageFile(file)) {
            return `<div class="msg-attachment" style="margin-top:6px">
                    <img src="${url}" alt="${name}"
                        style="max-width:200px;border-radius:8px;display:block">
                </div>`;
        }

        if (isPdfFile(file)) {
            return `<div class="msg-attachment" style="margin-top:6px">
                    <a href="${url}" target="_blank" rel="noopener"
                    style="color:inherit;font-size:13px;opacity:.85">${name}</a>
                </div>`;
        }

        return `<div class="msg-attachment" style="margin-top:6px">${name}</div>`;
    }

    /* ─── Message rendering ─── */
    function renderMessage(message, fallbackSelf = false) {

        const sender = String(message?.sender_type || '').toLowerCase();

        const isSelf = fallbackSelf || sender === 'seller';
        const direction = isSelf ? 'out' : 'in';

        const senderLabel = sender === 'admin'
            ? 'Support Team'
            : 'You';

        const attachments = Array.isArray(message?.attachments)
            ? message.attachments
            : (message?.attachment ? [message.attachment] : []);

        const attachmentHtml = attachments.map(attachmentFromUrl).join('');

        return `
        <div class="st-msg-${direction}">
            <div class="st-bubble-${direction}">

                <div class="st-msg-sender">
                    ${senderLabel}
                </div>

                ${message?.message
                ? `<div class="st-msg-text">${escapeHtml(message.message)}</div>`
                : ''}

                ${attachmentHtml}

                <div class="st-msg-time">
                    ${formatTime(message?.created_at)}
                </div>
            </div>
        </div>
    `;
    }

    function renderLocalMessage(text, file) {
        return `<div class="st-msg-out">
                <div class="st-bubble-out">
                    ${text ? `<div class="st-msg-text">${escapeHtml(text)}</div>` : ''}
                    ${file ? attachmentFromFile(file) : ''}
                    <div class="st-msg-time">${formatTime()}</div>
                </div>
            </div>`;
    }

    /* ─── File preview ─── */
    function renderFilePreview(file) {
        const preview = dom.filePreview();
        if (!preview) return;

        if (!file) {
            preview.innerHTML = '';
            return;
        }

        const icon = isPdfFile(file) ? 'PDF' : isImageFile(file) ? 'IMG' : 'FILE';
        const thumb = isImageFile(file)
            ? `<img src="${URL.createObjectURL(file)}" alt="${escapeHtml(file.name)}"
                        style="max-width:80px;border-radius:6px;display:block;margin-top:4px;">`
            : '';

        preview.innerHTML = `<div class="file-item">
                <span>${icon}</span>
                <span>${escapeHtml(file.name)}</span>
                <span class="file-remove" title="Remove" onclick="clearAttachment()">×</span>
            </div>${thumb}`;
    }

    function clearAttachment() {
        state.selectedFile = null;
        const input = dom.fileInput();
        if (input) input.value = '';
        renderFilePreview(null);
    }

    /* ─── Pane helpers ─── */
    function openChatPane() {
        dom.chatPane()?.classList.add('open');
        dom.listPane()?.classList.add('chat-open');
    }

    /**
     * FIX #2 & #3 — closeChat now shows FAQ instead of blank screen.
     * On mobile this closes the chat pane; the FAQ pane is shown inside chatPane.
     */
    function closeChat() {
        dom.chatPane()?.classList.remove('open');
        dom.listPane()?.classList.remove('chat-open');

        // Reset active ticket selection
        state.activeTicketId = null;
        state.isCreatingTicket = false;
        document.querySelectorAll('.st-ticket').forEach(t => t.classList.remove('active'));

        // Show FAQ so the right panel is never blank
        openNewTicketFlow();
    }

    function setHeader(subject, subtitle = '') {
        const title = dom.chatTitle();
        const sub = dom.chatSubtitle();
        if (title) {
            title.style.display = '';
            title.textContent = subject || 'Support';
        }
        if (sub) sub.textContent = subtitle;
    }

    function showSubjectFields(visible) {
        visible ? show(dom.subjectWrapper()) : hide(dom.subjectWrapper());
        visible ? show(dom.subjectBox()) : hide(dom.subjectBox());
    }

    function showComposer(visible) {
        visible ? show(dom.ticketComposer()) : hide(dom.ticketComposer());
    }

    /**
     * FIX #4 — properly toggle messagesArea alongside faqContainer.
     */
    function showFaqMode() {
        show(dom.faqContainer(), 'flex');
        hide(dom.messagesArea());
        showComposer(false);
        showSubjectFields(false);
    }

    function showChatMode() {
        hide(dom.faqContainer());
        show(dom.messagesArea(), 'flex');
        showComposer(true);
        showSubjectFields(false);
    }

    /* ─── Send button state ─── */
    function setSending(isSending) {
        const btn = dom.sendButton();
        if (!btn) return;

        if (isSending) {
            btn.disabled = true;
            btn.dataset.originalHtml = btn.innerHTML;
            btn.innerHTML = '…';
        } else {
            btn.disabled = false;
            btn.innerHTML = btn.dataset.originalHtml || btn.innerHTML;
            delete btn.dataset.originalHtml;
        }
    }

    /* ─── API helpers ─── */
    async function postForm(url, body) {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body,
        });

        const data = await response.json().catch(() => ({}));

        if (!response.ok || data.success === false) {
            throw new Error(data.message || 'Request failed. Please try again.');
        }

        return data;
    }

    /* ─── Load ticket ─── */
    async function loadTicket(ticketId, el) {
        if (!hasSupportChat()) return;

        state.activeTicketId = ticketId;
        state.isCreatingTicket = false;
        clearAttachment();

        document.querySelectorAll('.st-ticket').forEach(t => t.classList.remove('active'));
        el?.classList.add('active');

        openChatPane();
        showChatMode();
        setHeader(
            el?.querySelector('.st-ticket-title')?.textContent?.trim() || 'Support',
            el?.querySelector('.st-ticket-id')?.textContent?.trim() || ''
        );

        const badges = dom.chatBadges();
        const sourceBadges = el?.querySelector('.st-ticket-badges');
        if (badges && sourceBadges) badges.innerHTML = sourceBadges.innerHTML;

        const area = dom.messagesArea();
        if (area) area.innerHTML = '<div class="st-msg-loading">Loading…</div>';

        try {
            const response = await fetch(
                `${endpoint(config.ticketShowUrl)}/${ticketId}`,
                { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken } }
            );
            const data = await response.json();
            const messages = Array.isArray(data.messages) ? data.messages : [];

            setHeader(
                data.ticket?.subject || 'Support',
                data.ticket?.id ? padTicketId(data.ticket.id) : ''
            );

            if (area) {
                area.innerHTML = messages.length
                    ? messages.map(m => renderMessage(m)).join('')
                    : '<div style="padding:20px;color:#888;text-align:center">No messages yet.</div>';
            }
            scrollToBottom();
        } catch (err) {
            console.error('loadTicket:', err);
            if (area) area.innerHTML = '<div class="st-msg-error">Failed to load messages.</div>';
        }
    }

    /* ─── New ticket composer ─── */
    function showTicketComposer() {
        if (!hasSupportChat()) return;

        state.activeTicketId = null;
        state.isCreatingTicket = true;
        clearAttachment();

        openChatPane();
        hide(dom.faqContainer());
        show(dom.messagesArea(), 'flex');
        showComposer(true);
        showSubjectFields(true);
        setHeader('Create Support Ticket', '');

        const area = dom.messagesArea();
        const subject = dom.subjectInput();
        const compose = dom.composeInput();
        const answer = dom.faqAnswer();

        if (area) area.innerHTML = '<div style="padding:20px;color:#bbb;text-align:center;font-size:13px;">Describe your issue below.</div>';
        if (subject) subject.value = '';
        if (compose) compose.value = '';
        if (answer) answer.innerHTML = '';

        subject?.focus();
    }

    /**
     * FIX #3 — openNewTicketFlow always shows the FAQ pane.
     * Called on boot when no tickets exist, and also from closeChat().
     */
    function openNewTicketFlow() {
        if (!hasSupportChat()) return;

        state.activeTicketId = null;
        state.isCreatingTicket = false;
        clearAttachment();

        openChatPane();
        setHeader('Support', '');
        showFaqMode();
    }

    /* ─── Create ticket ─── */
    async function createTicket(text, file) {
        const subjectInput = dom.subjectInput();
        const subject = subjectInput?.value?.trim() || '';

        if (!subject) {
            alert('Please enter a subject for your ticket.');
            subjectInput?.focus();
            return;
        }

        const body = new FormData();
        body.append('subject', subject);
        body.append('message', text);
        body.append('priority', 'medium');
        if (file) body.append('attachment', file);

        setSending(true);
        try {
            const response = await postForm(config.storeUrl, body);
            const ticket = response.ticket || {};

            state.activeTicketId = ticket.id || null;
            state.isCreatingTicket = false;

            setHeader(
                ticket.subject || subject,
                ticket.id ? padTicketId(ticket.id) : ''
            );
            showSubjectFields(false);

            const area = dom.messagesArea();
            if (area) area.innerHTML = renderLocalMessage(text, file);

            prependTicketCard(ticket, text);

            if (dom.composeInput()) dom.composeInput().value = '';
            if (subjectInput) subjectInput.value = '';
            clearAttachment();
            scrollToBottom();
        } catch (err) {
            console.error('createTicket:', err);
            alert(err.message || 'Failed to create ticket.');
        } finally {
            setSending(false);
        }
    }

    /* ─── Send reply ─── */
    async function sendReply(text, file) {
        if (!state.activeTicketId) return;

        const body = new FormData();
        body.append('ticket_id', state.activeTicketId);
        body.append('message', text);
        if (file) body.append('attachment', file);

        setSending(true);
        try {
            const response = await postForm(config.replyUrl, body);
            const reply = response.reply || {
                message: text,
                sender_type: 'seller',
                created_at: new Date().toISOString(),
            };

            const area = dom.messagesArea();
            if (area) area.insertAdjacentHTML('beforeend', renderMessage(reply, true));

            if (dom.composeInput()) dom.composeInput().value = '';
            clearAttachment();
            scrollToBottom();
        } catch (err) {
            console.error('sendReply:', err);
            alert(err.message || 'Failed to send message.');
        } finally {
            setSending(false);
        }
    }

    function getPendingFile() {
        const input = dom.fileInput();
        return state.selectedFile || input?.files?.[0] || null;
    }

    /* ─── FIX #1 — sendMsg guards empty sends ─── */
    function sendMsg() {
        if (!hasSupportChat()) return;

        const text = dom.composeInput()?.value?.trim() || '';
        const file = getPendingFile();

        // Guard: nothing to send
        if (!text && !file) return;

        if (state.isCreatingTicket || !state.activeTicketId) {
            createTicket(text, file);
        } else {
            sendReply(text, file);
        }
    }

    /* ─── Prepend new ticket card to list ─── */
    function prependTicketCard(ticket, message) {
        const pane = dom.listPane();
        if (!pane || !ticket?.id) return;

        const id = ticket.id;
        const status = String(ticket.status || 'open').toLowerCase();
        const priority = String(ticket.priority || 'medium').toLowerCase();
        const preview = String(message || ticket.message || '').slice(0, 60);
        const card = document.createElement('div');

        document.querySelectorAll('.st-ticket').forEach(t => t.classList.remove('active'));

        card.className = 'st-ticket active';
        card.dataset.status = status;
        card.dataset.text = `${ticket.subject || ''} ${preview}`.toLowerCase();
        card.setAttribute('onclick', `loadTicket(${id}, this)`);

        card.innerHTML = `
                <div class="st-ticket-top">
                    <span class="st-ticket-id">${padTicketId(id)}</span>
                    <div class="st-ticket-badges">
                        <span class="support-badge badge-${priority}">${cap(priority)}</span>
                        <span class="support-badge badge-${status}">${cap(status)}</span>
                    </div>
                </div>
                <div class="st-ticket-title">${escapeHtml(ticket.subject || '')}</div>
                <div class="st-ticket-preview">${escapeHtml(preview)}${preview ? '…' : ''}</div>
                <div class="st-ticket-footer">
                    <div class="st-ticket-admin">Admin: Unassigned</div>
                    <span class="st-ticket-time">just now</span>
                </div>`;

        const scroll = document.getElementById('ticketListScroll');
        const firstCard = scroll?.querySelector('.st-ticket');
        const emptyEl = dom.emptyState();

        if (firstCard) {
            scroll.insertBefore(card, firstCard);
        } else if (emptyEl) {
            scroll.insertBefore(card, emptyEl);
        } else if (scroll) {
            scroll.appendChild(card);
        }

        toggleEmpty(false);
    }

    /* ─── Filter / search ─── */
    function filterTickets(query) {
        const needle = String(query || '').toLowerCase().trim();
        let visible = 0;

        document.querySelectorAll('.st-ticket').forEach(ticket => {
            const haystack = `${ticket.dataset.text || ''} ${ticket.textContent || ''}`.toLowerCase();
            const show_ = !needle || haystack.includes(needle);
            ticket.style.display = show_ ? '' : 'none';
            if (show_) visible += 1;
        });

        toggleEmpty(visible === 0);
    }

    function filterByStatus(status) {
        const selected = String(status || 'all').toLowerCase();
        let visible = 0;

        document.querySelectorAll('.st-ticket').forEach(ticket => {
            const show_ = selected === 'all' || ticket.dataset.status === selected;
            ticket.style.display = show_ ? '' : 'none';
            if (show_) visible += 1;
        });

        toggleEmpty(visible === 0);
    }

    /** Handles active class on filter buttons + runs filterByStatus */
    function setFilter(btn, status) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn?.classList.add('active');
        filterByStatus(status);
    }

    function toggleEmpty(visible) {
        const empty = dom.emptyState();
        if (!empty) return;
        empty.classList.toggle('show', visible);
        empty.style.display = visible ? '' : 'none';
    }

    /* ─── FAQ answer ─── */
    function showFaqAnswer(chipEl) {
        if (!chipEl) return;

        document.querySelectorAll('.faq-chip').forEach(c => c.classList.remove('active'));
        chipEl.classList.add('active');

        const question = chipEl.dataset.question || '';
        const answer = chipEl.dataset.answer || '';
        const number = chipEl.querySelector('.faq-num')?.textContent?.trim() || '';
        const target = dom.faqAnswer();
        if (!target) return;

        target.innerHTML = `
                <div style="display:flex;flex-direction:column;gap:10px;margin:14px 0 4px;">
                    <div class="st-msg-out">
                        <div class="st-bubble-out">
                            ${number
                ? `<div style="font-size:11px;opacity:.7;margin-bottom:3px;font-weight:600;letter-spacing:.04em;">Q${escapeHtml(number)}</div>`
                : ''}
                            <div>${escapeHtml(question)}</div>
                            <div class="st-msg-time">${formatTime()}</div>
                        </div>
                    </div>
                    <div class="st-msg-in">
                        <div class="st-bubble-in">
                            <div style="font-size:11px;font-weight:700;color:#ff3b5c;margin-bottom:5px;letter-spacing:.04em;">ANSWER</div>
                            <div style="font-size:13px;line-height:1.7;">${escapeHtml(answer).replace(/\n/g, '<br>')}</div>
                            <div class="st-msg-time">${formatTime()}</div>
                        </div>
                    </div>
                </div>`;

        // Scroll the FAQ container, not the messages area
        const faq = dom.faqContainer();
        if (faq) faq.scrollTop = faq.scrollHeight;
    }

    /* ─── Textarea auto-grow ─── */
    function autoGrow(el) {
        el.style.height = 'auto';
        el.style.height = Math.min(el.scrollHeight, 120) + 'px';
    }

    /* ─── Event binding ─── */
    function bindEvents() {
        if (!hasSupportChat()) return;

        dom.composeInput()?.addEventListener('keydown', e => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMsg();
            }
        });

        dom.fileInput()?.addEventListener('change', e => {
            const picked = e.target.files?.[0] || null;
            state.selectedFile = picked;
            renderFilePreview(picked);
        });
    }

    /* ─── Boot ─── */
    function boot() {
        if (!hasSupportChat()) return;

        bindEvents();


        const firstActive = document.querySelector('.st-ticket.active');
        const hasTickets = document.querySelectorAll('.st-ticket').length > 0;

        // On desktop, auto-open the first (active) ticket
        if (firstActive && window.innerWidth >= 768) {
            const match = firstActive.getAttribute('onclick')?.match(/loadTicket\((\d+)/);
            const ticketId = match?.[1];
            if (ticketId) {
                loadTicket(Number(ticketId), firstActive);
                return;
            }
        }

        // No tickets at all, or mobile → show FAQ flow
        openNewTicketFlow();
    }

    /* ─── Expose globals FIRST so onclick handlers find them immediately ─── */
    window.loadTicket = loadTicket;
    window.closeChat = closeChat;
    window.showTicketComposer = showTicketComposer;  // overwrites the stub
    window.openNewTicketFlow = openNewTicketFlow;   // raiseTicket() uses this
    window.openRaiseTicket = showTicketComposer;
    window.sendMsg = sendMsg;
    window.clearAttachment = clearAttachment;
    window.filterTickets = filterTickets;
    window.filterByStatus = filterByStatus;
    window.setFilter = setFilter;
    window.showFaqAnswer = showFaqAnswer;
    window.autoGrow = autoGrow;

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();