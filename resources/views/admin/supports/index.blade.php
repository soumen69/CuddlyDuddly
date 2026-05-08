@extends('admin.layouts.admin')
@section('title', 'Support Tickets')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/support.css') }}">
@endpush

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><i class="bi bi-headset me-2 text-primary"></i> Support Tickets</h4>
            <a href="{{ route('admin.support.tickets.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Raise Ticket
            </a>
        </div>

        <div class="support-wrapper">
            {{-- ===== Left Panel: Ticket List ===== --}}
            <div class="ticket-list">
                @forelse ($tickets as $ticket)
                    <div class="ticket-card ticket-item" data-id="{{ $ticket->id }}">
                        <!-- HEADER -->
                        <div class="ticket-head">
                            <div>
                                <div class="ticket-title">{{ $ticket->subject }}</div>
                                <div class="ticket-meta">
                                    <i class="bi bi-person-circle me-1"></i>
                                    @if ($ticket->type === 'seller')
                                        {{ $ticket->seller?->contact_person ?? 'Deleted Seller' }}
                                    @else
                                        {{ $ticket->customer?->full_name ?? 'Deleted User' }}
                                    @endif
                                    • {{ $ticket->created_at->diffForHumans() }}
                                </div>
                            </div>

                            <!-- STATUS -->
                            <span class="status-badge">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </div>

                        <!-- TAGS -->
                        <div class="ticket-tags">
                            <span class="badge bg-info text-dark">{{ $ticket->replies_count }} Replies</span>

                            <span
                                class="priority-badge 
            {{ $ticket->priority === 'high' ? 'priority-high' : ($ticket->priority === 'medium' ? 'priority-medium' : 'priority-low') }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>

                        <!-- FOOTER -->
                        <div class="ticket-footer">

                            <div>
                                <div class="assign-label">Assign To</div>
                                <form action="{{ route('admin.support.tickets.assign', $ticket->id) }}" method="POST">
                                    @csrf
                                    <select name="assigned_to" class="assign-dropdown" onchange="this.form.submit()">
                                        <option value="unassigned" {{ !$ticket->assigned_to ? 'selected' : '' }}>Unassigned
                                        </option>
                                        @foreach ($admins as $admin)
                                            <option value="{{ $admin->id }}"
                                                {{ $ticket->assigned_to == $admin->id ? 'selected' : '' }}>
                                                {{ $admin->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>

                            <small>
                                <i class="bi bi-clock"></i>
                                {{ $ticket->last_replied_at ? $ticket->last_replied_at->diffForHumans() : 'Never' }}
                            </small>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-light text-center">No tickets found.</div>
                @endforelse

                <div class="mt-3">{{ $tickets->links('pagination::bootstrap-5') }}</div>
            </div>

            {{-- ===== Right Panel: Chat Area ===== --}}
            <div class="chat-panel">
                <div class="chat-header">
                    <h6 class="mb-0" id="chatTitle">Select a ticket to start</h6>

                    <div id="statusBox" class="d-none text-end">
                        <div class="status-label">Update Status</div>

                        <form id="statusUpdateForm" action="" method="POST">
                            @csrf
                            <select name="status" id="chatStatusDropdown" class="status-update-dropdown"
                                onchange="this.form.submit()">
                                <option value="open">Open</option>
                                <option value="in_progress">In Progress</option>
                                <option value="resolved">Resolved</option>
                                <option value="closed">Closed</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="chat-body" id="chatBody">
                    <p class="text-muted text-center mt-5">No conversation selected.</p>
                </div>
                <form id="chatForm" class="chat-footer d-none">
                    @csrf
                    <textarea id="chatMessage" class="form-control" placeholder="Type your message..."></textarea>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i></button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/js/supportChat.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const statusBox = document.getElementById("statusBox");
            const statusUpdateForm = document.getElementById("statusUpdateForm");
            const chatStatusDropdown = document.getElementById("chatStatusDropdown");
            const ticketList = document.querySelector(".ticket-list");

            ticketList.addEventListener("click", function(e) {
                const card = e.target.closest(".ticket-item");
                if (!card) return;

                const id = card.dataset.id;

                // highlight active card
                document.querySelectorAll(".ticket-item").forEach(x => x.classList.remove("active"));
                card.classList.add("active");

                // load messages and init chat
                loadChat(id);
            });

            function loadChat(ticketId) {
                // load chat UI from backend
                fetch(`/admin/support/tickets/${ticketId}?ajax=1`)
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        chatBody.innerHTML = "";
                        chatTitle.textContent = `${data.subject} — ${data.customer}`;
                        chatForm.classList.remove("d-none");

                        // show & prepare status dropdown section
                        statusBox.classList.remove("d-none");
                        statusUpdateForm.action = `/admin/support/tickets/${ticketId}/status/update`;

                        // Pre-select actual status fetched from backend
                        chatStatusDropdown.value = data.status;


                        // init engine NOW (and only now)
                        SupportChat.init({
                            ticketId: ticketId,
                            role: "admin",
                            fetchUrl: "/admin/support/poll",
                            sendUrl: "/admin/support/reply",
                            container: "#chatBody",
                            input: "#chatMessage",
                            form: "#chatForm"
                        });

                        // render initial messages
                        data.replies.forEach(r => {
                            SupportChat._append({
                                message: r.message,
                                is_admin: r.is_admin,
                                is_seller: r.is_seller,
                                is_user: r.is_user,
                                created_at: r.time
                            });
                        });
                    });
            }
        });
    </script>
@endpush
