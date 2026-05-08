<form id="replyForm" action="{{ route('admin.support.reply', $ticket->id) }}" method="POST"
    class="reply-box mt-2">
    @csrf
    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
    <textarea name="message" class="form-control" rows="3" placeholder="Type your reply..."></textarea>
    <button type="submit" class="btn btn-primary btn-sm mt-2">
        <i class="bi bi-send"></i> Send Reply
    </button>
</form>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('replyForm');
            const messageInput = document.getElementById('replyMessage');
            const btn = document.getElementById('sendReplyBtn');
            const chatContainer = document.querySelector('.chat-container');

            // Auto scroll to bottom on load
            const scrollToBottom = () => {
                chatContainer.scrollTo({
                    top: chatContainer.scrollHeight,
                    behavior: 'smooth'
                });
            };
            scrollToBottom();

            // Submit reply via AJAX
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const message = messageInput.value.trim();
                if (!message) return;

                btn.disabled = true;
                btn.innerHTML = `<span class="spinner-border spinner-border-sm"></span>`;

                try {
                    const res = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            message
                        })
                    });

                    const data = await res.json();
                    if (data.success) {
                        messageInput.value = '';
                        appendReply(data.reply);
                    } else {
                        alert(data.message || 'Failed to send reply.');
                    }
                } catch (err) {
                    console.error(err);
                    alert('Something went wrong.');
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = `<i class="bi bi-send-fill"></i> Send`;
                }
            });

            // Function to append a reply dynamically
            function appendReply(reply) {
                const msg = document.createElement('div');
                msg.className = `msg ${reply.is_admin ? 'admin' : 'user'}`;
                msg.innerHTML = `
                <strong>${reply.name}</strong>
                <p class="mb-1">${reply.message}</p>
                <small>just now</small>
            `;
                chatContainer.appendChild(msg);
                scrollToBottom();
            }

            // Polling for new replies every 10 seconds
            setInterval(async () => {
                try {
                    const res = await fetch(
                        `{{ route('admin.support.tickets.show', $ticket->id) }}?ajax=1`);
                    const data = await res.json();

                    if (data.success && Array.isArray(data.replies)) {
                        chatContainer.innerHTML = '';
                        data.replies.forEach(r => {
                            const msg = document.createElement('div');
                            msg.className = `msg ${r.is_admin ? 'admin' : 'user'}`;
                            msg.innerHTML = `
                            <strong>${r.name}</strong>
                            <p class="mb-1">${r.message}</p>
                            <small>${r.time}</small>
                        `;
                            chatContainer.appendChild(msg);
                        });
                        scrollToBottom();
                    }
                } catch (err) {
                    console.error('Polling error:', err);
                }
            }, 10000);
        });
    </script>
@endpush
