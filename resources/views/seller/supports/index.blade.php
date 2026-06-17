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

    <script src="/js/supportChat.js"></script>
    <script>
        SupportChat.init({
            ticketId: {{ $ticket->id }},
            role: "seller",
            fetchUrl: "{{ route('seller.support.poll', ['seller' => $seller->slug, 'ticket' => $ticket->id]) }}",
            sendUrl: "{{ route('seller.support.reply', $seller->slug) }}",
            container: "#sellerChatBody",
            input: "#sellerMessage",
            form: "#sellerChatForm"
        });
    </script>
@endpush