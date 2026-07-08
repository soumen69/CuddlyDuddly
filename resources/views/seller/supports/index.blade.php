@extends('seller.layouts.seller')
@section('title', 'Support Chat')

{{-- styles moved inline so they always load regardless of layout stack --}}
<style>
    /* ── Chat pane show/hide ── */
    .st-chat-pane {
        display: none;
    }

    .st-chat-pane.open {
        display: flex;
    }

    /* ── File preview ── */
    .file-preview {
        margin-top: 8px;
    }

    .file-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background: #f5f5f5;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        font-size: 14px;
    }

    .file-remove {
        cursor: pointer;
        color: #dc2626;
        font-weight: 600;
    }

    /* ── Message bubbles ── */
    .st-messages {
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding: 15px;
    }

    .st-msg-out {
        display: flex;
        justify-content: flex-end;
        width: 100%;
    }

    .st-msg-in {
        display: flex;
        justify-content: flex-start;
        width: 100%;
    }

    .st-bubble-out {
        max-width: 75%;
        background: #ff3b5c;
        color: #fff;
        padding: 10px 14px;
        border-radius: 16px 16px 0 16px;
        word-break: break-word;
    }

    .st-bubble-in {
        max-width: 75%;
        background: #ffffff;
        color: #222;
        padding: 10px 14px;
        border-radius: 16px 16px 16px 0;
        border: 1px solid #e5e5e5;
        word-break: break-word;
    }

    .st-msg-time {
        font-size: 11px;
        margin-top: 4px;
        opacity: .7;
    }

    /* ── Subject input ── */
    #ticketSubjectWrapper input {
        width: 100%;
        border: none;
        outline: none;
        font-size: 16px;
        font-weight: 600;
        background: transparent;
        color: #111;
        padding: 2px 0;
    }

    /* ── FAQ bubble list ── */
    .faq-list-wrap {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .faq-category-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: #ff3b5c;
        padding: 14px 2px 7px;
    }

    .faq-list-wrap {
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 16px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
    }

    .faq-chip {
        width: 100%;
        border: none;
        border-bottom: 1px solid #f0f0f0;
        border-radius: 0;
        margin-bottom: 0;
        box-shadow: none;
        background: transparent;
    }

    .faq-chip:last-child {
        border-bottom: none;
    }

    .faq-chip {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        width: 100%;
        background: #fff;
        border: 1px solid #efefef;
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 13.5px;
        font-weight: 500;
        color: #222;
        text-align: left;
        cursor: pointer;
        margin-bottom: 7px;
        line-height: 1.3;
        transition: border-color .15s, background .15s, color .15s, box-shadow .15s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .04);
    }

    .faq-chip .faq-num {
        flex-shrink: 0;
        font-weight: 700;
        color: #ff3b5c;
        font-size: 13px;
        min-width: 18px;
    }

    .faq-chip .faq-text {
        flex: 1;
        min-width: 0;
    }

    .faq-chip:hover {
        border-color: #ffb3be;
        background: #fff5f6;
        color: #ff3b5c;
        box-shadow: 0 2px 8px rgba(255, 59, 92, .1);
    }

    .faq-chip.active {
        border-color: #ff3b5c;
        background: #fff0f3;
        color: #ff3b5c;
        box-shadow: 0 2px 8px rgba(255, 59, 92, .12);
    }

    .faq-chip .faq-arrow {
        flex-shrink: 0;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f5f5;
        border-radius: 50%;
        color: #aaa;
        font-size: 13px;
        transition: background .15s, color .15s;
    }

    .faq-chip:hover .faq-arrow,
    .faq-chip.active .faq-arrow {
        background: #ff3b5c;
        color: #fff;
    }

    .faq-open-ticket-btn {
        display: inline-block;
        padding: 10px 22px;
        background: #ff3b5c;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s;
        margin-top: 6px;
    }

    .faq-open-ticket-btn:hover {
        background: #e0294a;
    }

    .st-msg-sender {
        font-size: 11px;
        font-weight: 600;
        opacity: .7;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .st-raise-ticket-btn {
        width: 100%;
        padding: 10px 14px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }
</style>

@section('content')
    <div class="seller-profile flex-1 min-w-0">
        @include('seller.layouts.header')

        <div class="flex flex-col md:flex-row justify-between pt-6 px-6 md:pl-14 md:pr-9 pb-[45px]">
            <div class="w-full">

                {{-- ── Top bar ── --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5 mb-6">
                    <div class="flex items-center gap-4">
                        <button type="button" onclick="window.history.back()"
                            class="flex-none w-9 h-9 rounded-full bg-black text-white flex items-center justify-center cursor-pointer">
                            <svg width="25" height="25" viewBox="0 0 35 35" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1182_398)">
                                    <path d="M11.4647 21.4961L7.16551 17.1969L11.4647 12.8977" stroke="white"
                                        stroke-width="2.02667" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M7.16523 17.1969L27.2282 17.1969" stroke="white" stroke-width="2.02667"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_1182_398">
                                        <rect width="24.32" height="24.32" fill="white"
                                            transform="translate(17.1968 34.3937) rotate(-135)" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </button>
                        <h3 class="font-normal text-lg md:text-xl lg:text-2xl xl:text-3xl leading-tight text-black">
                            Support Tickets
                        </h3>
                    </div>

                    <div class="st-topbar-search">
                        <svg class="st-search-icon" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                        </svg>
                        <input class="st-search-input" type="text" placeholder="Search tickets..."
                            oninput="filterTickets(this.value)">
                    </div>
                </div>

                @if ($tickets->count() > 0)
                    <div class="st-filter-wrap">
                        <button type="button" class="raise-ticket-btn" onclick="openNewTicketFlow()">
                            Raise Ticket
                        </button>
                    </div>
                @endif

                {{-- <div class="st-filter-wrap">
                    <select class="st-filter-select" onchange="filterByStatus(this.value)">
                        <option value="all">All</option>
                        <option value="open">Open</option>
                        <option value="pending">Pending</option>
                        <option value="resolved">Resolved</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div> --}}

                <div class="st-body">

                    {{-- ════════════════════════════════
                         TICKET LIST PANE
                    ════════════════════════════════ --}}
                    <div class="st-list-pane" id="listPane">

                        {{-- ticketListScroll is the container prependTicketCard() looks for --}}
                        <div id="ticketListScroll">

                            @forelse ($tickets as $ticket)
                                <div class="st-ticket {{ $loop->first ? 'active' : '' }}"
                                    data-status="{{ strtolower($ticket->status) }}"
                                    data-text="{{ strtolower($ticket->subject . ' ' . $ticket->message) }}"
                                    onclick="loadTicket({{ $ticket->id }}, this)">

                                    <div class="st-ticket-top">
                                        <span class="st-ticket-id">
                                            #TK-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                        <div class="st-ticket-badges">
                                            <span class="support-badge badge-{{ strtolower($ticket->priority) }}">
                                                {{ ucfirst($ticket->priority) }}
                                            </span>
                                            <span class="support-badge badge-{{ strtolower($ticket->status) }}">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="st-ticket-title">{{ $ticket->subject }}</div>

                                    <div class="st-ticket-preview">
                                        {{ \Illuminate\Support\Str::limit($ticket->message, 50) }}
                                    </div>

                                    <div class="st-ticket-footer">
                                        <div class="st-ticket-admin">
                                            <span>
                                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                                    <circle cx="12" cy="7" r="4" />
                                                </svg>
                                            </span>
                                            Admin: {{ optional($ticket->assignedAdmin)->name ?? 'Unassigned' }}
                                        </div>
                                        <span class="st-ticket-time">{{ $ticket->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @empty
                                {{-- empty state shown by default when no tickets exist --}}
                            @endforelse

                        </div>
                        {{-- /ticketListScroll --}}

                        <div class="st-empty {{ $tickets->isEmpty() ? 'show' : '' }}" id="emptyState">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p>No tickets found.</p>
                        </div>

                    </div>
                    {{-- /st-list-pane --}}

                    {{-- ════════════════════════════════
                         CHAT PANE
                    ════════════════════════════════ --}}
                    <div class="st-chat-pane" id="chatPane">

                        {{-- Chat header --}}
                        <div class="st-chat-header">
                            <div class="st-chat-header-info">

                                <button class="st-close-btn" onclick="closeChat()">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                        <path d="M19 12H5M12 5l-7 7 7 7" />
                                    </svg>
                                </button>

                                <div class="st-chat-icon">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                        <path
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>

                                <div>
                                    {{-- Subject display (shown when viewing an existing ticket) --}}
                                    <div id="ticketSubjectWrapper" style="display:none;">
                                        <input type="text" id="ticketSubject"
                                            placeholder="Enter ticket subject here…">
                                    </div>

                                    <div class="st-chat-title" id="chatTitle">Support</div>
                                    <div class="st-chat-subtitle" id="chatSubtitle"></div>
                                </div>
                            </div>

                            <div class="st-ticket-badges" id="chatHeaderBadges">
                                {{-- synced dynamically by JS --}}
                            </div>
                        </div>
                        {{-- /chat header --}}

                        {{-- Messages / FAQ area --}}
                        <div class="st-messages" id="messagesArea" style="display:none;">
                            {{-- Populated by JS when a ticket is opened or new ticket composer is shown --}}
                        </div>
                        {{-- /messagesArea --}}

                        {{-- ── FAQ container ─────────────────────── --}}
                        <div id="faqContainer"
                            style="display:none; flex-direction:column; overflow-y:auto; padding:15px; flex:1;">

                            <div style="text-align:center; padding: 8px 0 18px;">
                                <p style="font-size:15px; font-weight:600; color:#111; margin:0 0 4px;">How can we help
                                    you?</p>
                                <p style="font-size:13px; color:#888; margin:0;">Click a question to see the answer.</p>
                            </div>

                            <div class="faq-list-wrap">
                                @forelse ($faqCategories as $category)
                                    @foreach ($category->faqs as $faq)
                                        <button class="faq-chip" type="button"
                                            data-answer="{{ htmlspecialchars($faq->answer, ENT_QUOTES, 'UTF-8') }}"
                                            data-question="{{ htmlspecialchars($faq->question, ENT_QUOTES, 'UTF-8') }}"
                                            onclick="showFaqAnswer(this)">
                                            <span class="faq-num">{{ $loop->iteration }}.</span>
                                            <span class="faq-text">{{ $faq->question }}</span>
                                            <span class="faq-arrow">›</span>
                                        </button>
                                    @endforeach
                                @empty
                                    <p style="text-align:center; color:#aaa; font-size:14px; padding:20px 0;">
                                        No FAQs available at the moment.
                                    </p>
                                @endforelse
                            </div>

                            {{-- Answer bubble renders here (injected by JS) --}}
                            <div id="faqAnswerBubble"></div>

                            <div style="text-align:center; padding: 20px 0 8px;">
                                <button type="button" class="faq-open-ticket-btn" onclick="showTicketComposer()">
                                    My issue is not resolved
                                </button>
                            </div>

                        </div>
                        {{-- /faqContainer --}}

                        <div id="filePreview" class="file-preview" style="padding:0 14px;"></div>

                        {{-- ── Compose box ─────────────────────────────── --}}
                        <div class="st-compose" id="ticketComposer" style="display:none;">
                            <div class="st-compose-box">

                                {{-- Hidden file input --}}
                                <input type="file" id="attachmentInput" hidden
                                    accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx">

                                {{-- Attach button --}}
                                <button type="button" class="st-icon-btn" title="Attach file"
                                    onclick="document.getElementById('attachmentInput').click()">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                        <path
                                            d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48" />
                                    </svg>
                                </button>

                                {{-- Subject row — only for new tickets (hidden by default) --}}
                                <div id="subjectBox" style="display:none; width:100%; margin-bottom:6px;">
                                    <input type="text" id="ticketSubjectCompose" class="st-compose-input"
                                        placeholder="Ticket subject…"
                                        style="border-bottom:1px solid #e5e5e5; border-radius:0; margin-bottom:4px;">
                                </div>

                                <textarea class="st-compose-input" id="composeInput" placeholder="Type your message…" rows="1"
                                    oninput="autoGrow(this)" onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendMsg();}"></textarea>

                                <button type="button" class="st-send-btn" onclick="sendMsg()">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="white" stroke-width="2.5" stroke-linecap="round">
                                        <line x1="22" y1="2" x2="11" y2="13" />
                                        <polygon points="22 2 15 22 11 13 2 9 22 2" />
                                    </svg>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    window.supportConfig = {
        sellerSlug: "{{ $seller->slug }}",
        ticketShowUrl: "{{ rtrim(url('seller/' . $seller->slug . '/support'), '/') }}",
        storeUrl: "{{ route('seller.support.store', ['seller' => $seller->slug]) }}",
        replyUrl: "{{ route('seller.support.reply', ['seller' => $seller->slug]) }}",
        pollBaseUrl: "{{ rtrim(url('seller/' . $seller->slug . '/support'), '/') }}",
        csrfToken: "{{ csrf_token() }}"
    };

    // "Raise Ticket" → shows FAQ pane first (openNewTicketFlow)
    window.raiseTicket = function() {
        if (typeof window.openNewTicketFlow === 'function') {
            window.openNewTicketFlow();
        } else {
            document.addEventListener('DOMContentLoaded', function() {
                window.openNewTicketFlow && window.openNewTicketFlow();
            });
        }
    };

    // Safety stub — only registers if JS hasn't loaded yet
    // Uses assignment (not ||) so the real JS always overwrites it
    if (typeof window.showTicketComposer !== 'function') {
        window.showTicketComposer = function() {
            var p = document.getElementById('chatPane');
            if (p) p.classList.add('open');
            var f = document.getElementById('faqContainer');
            if (f) f.style.display = 'none';
            var m = document.getElementById('messagesArea');
            if (m) m.style.display = 'flex';
            var c = document.getElementById('ticketComposer');
            if (c) c.style.display = 'block';
            var s = document.getElementById('subjectBox');
            if (s) s.style.display = 'block';
            var w = document.getElementById('ticketSubjectWrapper');
            if (w) w.style.display = 'block';
            var t = document.getElementById('chatTitle');
            if (t) t.innerText = 'Create Support Ticket';
        };
    }
</script>

@push('scripts')
    <script src="{{ asset('js/seller-support.js') }}?v={{ filemtime(public_path('js/seller-support.js')) }}"></script>
@endpush
