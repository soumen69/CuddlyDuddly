@extends('admin.layouts.admin')
@section('title', 'Customer Tickets')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/support.css') }}">
@endpush


@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><i class="bi bi-people me-2 text-primary"></i> Customer Tickets</h4>
        </div>

        <div class="support-wrapper">

            {{-- LEFT PANEL --}}
            <div class="ticket-list">
                @forelse ($tickets as $ticket)
                    <div class="ticket-card ticket-item" data-id="{{ $ticket->id }}">

                        <div class="ticket-head">
                            <div>
                                <div class="ticket-title">{{ $ticket->subject }}</div>
                                <div class="ticket-meta">
                                    <i class="bi bi-person-circle me-1"></i>
                                    {{ $ticket->customer?->full_name ?? 'Deleted User' }} •
                                    {{ $ticket->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <span class="status-badge">{{ ucfirst($ticket->status) }}</span>
                        </div>

                        <div class="ticket-tags">
                            <span class="badge bg-info text-dark">{{ $ticket->replies_count }} Replies</span>

                            <span
                                class="priority-badge
                                    {{ $ticket->priority === 'high' ? 'priority-high' : ($ticket->priority === 'medium' ? 'priority-medium' : 'priority-low') }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>

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
                    <div class="alert alert-light text-center">No customer tickets found.</div>
                @endforelse

                <div class="mt-3">{{ $tickets->links('pagination::bootstrap-5') }}</div>
            </div>

            {{-- RIGHT PANEL --}}
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
        SupportChat.role = "admin";

        document.addEventListener("DOMContentLoaded", () => {
            const ticketList = document.querySelector(".ticket-list");

            ticketList.addEventListener("click", function(e) {
                const card = e.target.closest(".ticket-item");
                if (!card) return;

                document.querySelectorAll(".ticket-item").forEach(x => x.classList.remove("active"));
                card.classList.add("active");

                loadChat(card.dataset.id);
            });

            function loadChat(id) {
                fetch(`/admin/support/tickets/${id}?ajax=1`)
                    .then(res => res.json())
                    .then(data => {
                        chatBody.innerHTML = "";
                        chatTitle.textContent = `${data.subject} — ${data.customer}`;
                        chatForm.classList.remove("d-none");

                        statusBox.classList.remove("d-none");
                        statusUpdateForm.action = `/admin/support/tickets/${id}/status/update`;

                        chatStatusDropdown.value = data.status;

                        SupportChat.init({
                            ticketId: id,
                            role: "admin",
                            fetchUrl: "/admin/support/poll",
                            sendUrl: "/admin/support/reply",
                            container: "#chatBody",
                            input: "#chatMessage",
                            form: "#chatForm"
                        });

                        data.replies.forEach(r => {
                            SupportChat._append(r);
                        });
                    });
            }
        });
    </script>
@endpush
