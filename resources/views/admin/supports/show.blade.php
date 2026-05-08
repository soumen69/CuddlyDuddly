@extends('admin.layouts.admin')
@section('title', 'View Ticket')

@push('styles')
    <style>
        .chat-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            height: 70vh;
            overflow-y: auto;
        }

        .msg {
            margin-bottom: 1rem;
            max-width: 70%;
            padding: .7rem 1rem;
            border-radius: 12px;
            position: relative;
        }

        .msg.admin {
            background: #e0f0ff;
            align-self: flex-end;
            margin-left: auto;
            border: 1px solid #b6daff;
        }

        .msg.user {
            background: #fff;
            border: 1px solid #e4e4e4;
        }

        .msg small {
            display: block;
            font-size: .75rem;
            color: #6c757d;
        }

        .reply-box {
            border-top: 1px solid #ddd;
            background: #fff;
            padding: .8rem 1rem;
            border-radius: 0 0 10px 10px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-3">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><i class="bi bi-ticket-detailed text-primary me-2"></i> {{ $ticket->subject }}</h4>
            <div>
                <a href="{{ route('admin.support.tickets.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <a href="{{ route('admin.support.tickets.show', $ticket->id) }}" target="_blank"
                    class="btn btn-outline-dark btn-sm">
                    <i class="bi bi-box-arrow-up-right"></i> Open Full Page
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="chat-container d-flex flex-column">
                    @foreach ($ticket->replies as $reply)
                        <div class="msg {{ $reply->admin_id ? 'admin' : 'user' }}">
                            <strong>
                                {{ $reply->admin_id ? $reply->admin->name ?? 'Admin' : $reply->user->name ?? 'User' }}
                            </strong>
                            <p class="mb-1">{{ $reply->message }}</p>
                            <small>{{ $reply->created_at->diffForHumans() }}</small>
                        </div>
                    @endforeach
                </div>

                @include('admin.supports._reply_form')
            </div>
        </div>
    </div>
@endsection
