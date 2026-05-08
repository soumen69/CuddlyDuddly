@extends('seller.layouts.seller')
@section('title', 'Support Chat')

@push('styles')
    <style>
        .support-chat {
            max-width: 700px;
            margin: 20px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            height: 75vh;
        }

        .chat-header {
            padding: .8rem 1rem;
            border-bottom: 1px solid #eee;
            background: #f8f9fa;
            font-weight: 600;
        }

        .chat-body {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .msg {
            max-width: 70%;
            margin: .4rem 0;
            padding: .6rem .9rem;
            border-radius: 10px;
            font-size: .9rem;
            line-height: 1.5;
            word-wrap: break-word;
        }

        .msg.admin {
            background: #0d6efd;
            color: #fff;
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }

        .msg.seller {
            background: #e9ecef;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }

        .chat-footer {
            display: flex;
            padding: .8rem 1rem;
            border-top: 1px solid #eee;
            gap: .6rem;
        }

        .chat-footer textarea {
            flex: 1;
            resize: none;
            border-radius: 8px;
            padding: .6rem;
            height: 45px;
        }

        .chat-footer button {
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="support-chat">
        <div class="chat-header">
            <i class="bi bi-headset me-1"></i> Seller Support
        </div>

        <div class="chat-body" id="sellerChatBody">
            @if ($ticket && $ticket->replies)
                @foreach ($ticket->replies->sortBy('created_at') as $reply)
                    <div class="msg {{ $reply->admin_id ? 'admin' : 'seller' }}">
                        {{ $reply->message }}
                        <div class="small text-muted mt-1">{{ $reply->created_at->diffForHumans() }}</div>
                    </div>
                @endforeach
            @else
                <p class="text-muted text-center mt-5">No messages yet. Start chatting with admin.</p>
            @endif
        </div>

        <form id="sellerChatForm" class="chat-footer" onsubmit="return false;">
            @csrf
            <textarea id="sellerMessage" placeholder="Type your message..."></textarea>
            <button class="btn btn-primary"><i class="bi bi-send"></i></button>
        </form>
    </div>
@endsection

@push('scripts')
    {{-- <script>
        const chatBody = document.getElementById('sellerChatBody');
        const chatForm = document.getElementById('sellerChatForm');
        const chatInput = document.getElementById('sellerMessage');
        const ticketId = {{ $ticket->id ?? 'null' }};

        // 🧩 Function: Listen to Reverb real-time updates for this ticket
        function listenToTicket(ticketId) {
            if (!window.Echo) {
                console.warn('Echo not initialized, cannot listen to ticket.');
                return;
            }

            console.log(`🎧 Seller listening to ticket.${ticketId}`);

            // Leave old channels (avoid duplicates)
            window.Echo.leave(`private-ticket.${ticketId}`);

            // Subscribe to the private Reverb channel
            window.Echo.private(`ticket.${ticketId}`)
                .listen('.TicketMessageSent', (data) => {
                    console.log('📩 Live message received on seller side:', data);

                    // Seller should not duplicate their own sent messages
                    if (!data.is_admin) return; // Only show admin’s messages

                    const el = document.createElement('div');
                    el.className = `msg ${data.is_admin ? 'admin' : 'seller'}`;

                    const safeMessage = (data.message || '')
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;')
                        .replace(/\n/g, '<br>');

                    const now = new Date();
                    const formattedTime = now.toLocaleString('en-IN', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });

                    el.innerHTML = `
                    <div class="msg-body">${safeMessage}</div>
                    <small class="text-muted">${formattedTime}</small>
                `;

                    chatBody.appendChild(el);
                    requestAnimationFrame(() => chatBody.scrollTop = chatBody.scrollHeight);
                })
                .error((err) => {
                    console.error('❌ Reverb listen error (seller):', err);
                });
        }

        // 🕓 Wait until Echo is ready, then subscribe safely
        function waitForEchoAndListen(ticketId) {
            if (typeof window.Echo !== 'undefined') {
                console.log('🎧 Echo ready — subscribing to ticket channel...');
                listenToTicket(ticketId);
            } else {
                console.log('⏳ Waiting for Echo to initialize...');
                setTimeout(() => waitForEchoAndListen(ticketId), 500);
            }
        }

        // 🧠 Initialize real-time listener (with delay handling)
        if (ticketId) {
            waitForEchoAndListen(ticketId);
        }

        // 💬 Send message (seller side)
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = chatInput.value.trim();
            if (!message || !ticketId) return;

            chatInput.value = '';

            const msgDiv = document.createElement('div');
            msgDiv.className = 'msg seller';
            msgDiv.innerHTML = `
            <div class="msg-body">${message}</div>
            <small class="text-muted">Sending...</small>
        `;
            chatBody.appendChild(msgDiv);
            chatBody.scrollTop = chatBody.scrollHeight;

            try {
                const res = await fetch(`/seller/support/reply`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        ticket_id: ticketId,
                        message
                    })
                });

                const data = await res.json();
                if (data.success) {
                    const time = new Date().toLocaleString('en-IN', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });
                    msgDiv.querySelector('small').textContent = time;
                } else {
                    msgDiv.querySelector('small').textContent = 'Failed to send';
                }
            } catch (err) {
                console.error('❌ Seller send error:', err);
                msgDiv.querySelector('small').textContent = 'Failed to send';
            }
        });
    </script> --}}

    <script src="/js/supportChat.js"></script>
    <script>
        SupportChat.init({
            ticketId: {{ $ticket->id }},
            role: "seller",
            fetchUrl: "/seller/support/poll",
            sendUrl: "/seller/support/reply",
            container: "#sellerChatBody",
            input: "#sellerMessage",
            form: "#sellerChatForm"
        });
    </script>
@endpush
