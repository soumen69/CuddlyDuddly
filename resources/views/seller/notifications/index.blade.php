@extends('seller.layouts.seller')

@section('title', 'Notifications')


@section('content')
    <div class="seller-profile flex-1 min-w-0">
        @include('seller.layouts.header')
        <div class=" flex flex-col md:flex-row justify-between pt-6 px-6 md:pl-14 md:pr-9 pb-[45px]">
            <div class="w-full">
                <div class="flex items-center gap-4 mb-6">
                    <button type="button" onclick="window.history.back()"
                        class="flex-none w-9 h-9 rounded-full bg-black text-white flex items-center justify-center cursor-pointer">
                        <svg width="25" height="25" viewBox="0 0 35 35" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1182_398)">
                                <path d="M11.4647 21.4961L7.16551 17.1969L11.4647 12.8977" stroke="white"
                                    stroke-width="2.02667" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M7.16523 17.1969L27.2282 17.1969" stroke="white" stroke-width="2.02667"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_1182_398">
                                    <rect width="24.32" height="24.32" fill="white"
                                        transform="translate(17.1968 34.3937) rotate(-135)"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                    <div>
                        <h3
                            class="font-sans font-normal text-lg md:text-xl lg:text-2xl xl:text-3xl leading-tight tracking-1 text-black">
                            Notifications
                        </h3>
                        <p class="font-sans font-normal text-base leading-tight tracking-1 text-black">
                            Stay updated with product approvals, order alerts, return requests, and seller activities.
                        </p>
                    </div>
                </div>
                <!-- Search -->
                {{-- <div class="search-wrap">
                    <form method="GET"
                        action="{{ route('seller.notifications', ['seller' => auth('seller')->user()->slug]) }}">
                        <div class="search-box">
                            <svg class="search-icon" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                            </svg>

                            <input type="text" name="search" id="search-input" class="notification-search-input"
                                placeholder="Search notifications..." value="{{ request('search') }}"
                                onkeyup="if(event.key==='Enter') this.form.submit();">
                        </div>
                    </form>
                </div> --}}

                <!-- Notifications list -->
                <div class="notification-list" id="notification_list">

                    @forelse($notifications as $notification)
                        <a href="{{ route('seller.notifications.show', $notification->id) }}"
                            class="notif-card {{ !$notification->is_read ? 'notif-card--unread' : '' }}"
                            data-text="{{ strtolower(($notification->title ?? '') . ' ' . ($notification->message ?? '')) }}">

                            <div class="notif-thumb">
                                <img src="{{ $notification->image ? Storage::url($notification->image) : asset('images/no-image.png') }}"
                                    alt="{{ $notification->title }}">
                            </div>

                            <div class="notif-body">

                                <div class="notif-badge-row">
                                    <span class="notif-badge notif-badge--system">
                                        {{ ucfirst($notification->type ?? 'Notification') }}
                                    </span>
                                </div>

                                <p class="notif-title">
                                    {{ $notification->title }}
                                </p>

                                <p class="notif-desc">
                                    {{ $notification->message }}
                                </p>

                                <p class="notif-time">
                                    {{ $notification->created_at->format('M d, Y • h:i A') }}
                                </p>

                            </div>

                            <div class="notif-actions">
                                <button class="notif-delete-btn"
                                    onclick="event.preventDefault(); event.stopPropagation(); deleteNotif(this, {{ $notification->id }})"
                                    title="Delete">
                                    <svg class="notif-delete-icon" fill="none" stroke="currentColor" stroke-width="1.8"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                <button class="notif-view-btn">View Details</button>
                            </div>
                        </a>
                    @empty
                        <!-- Empty state (hidden by default) -->
                        <div id="empty-state" class="empty-state hidden">
                            <svg class="empty-state__icon" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <p class="empty-state__text">No notifications found.</p>
                        </div>
                    @endforelse

                </div>

                <!-- Pagination -->
                @php
                    $current = $notifications->currentPage();
                    $last = $notifications->lastPage();
                @endphp

                <div class="pagination">

                    {{-- Previous --}}
                    <a href="{{ $notifications->previousPageUrl() ?: '#' }}"
                        class="pagination__btn {{ $notifications->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }}">
                        <svg class="pagination__icon" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>

                    {{-- Current Page --}}
                    <a href="{{ $notifications->url($current) }}" class="pagination__btn pagination__btn--active">
                        {{ $current }}
                    </a>

                    {{-- Dots --}}
                    @if ($current < $last - 1)
                        <span class="pagination__btn pointer-events-none">
                            ...
                        </span>
                    @endif

                    {{-- Last Page --}}
                    @if ($last > $current)
                        <a href="{{ $notifications->url($last) }}" class="pagination__btn">
                            {{ $last }}
                        </a>
                    @endif

                    {{-- Next --}}
                    <a href="{{ $notifications->nextPageUrl() ?: '#' }}"
                        class="pagination__btn {{ !$notifications->hasMorePages() ? 'opacity-50 pointer-events-none' : '' }}">
                        <svg class="pagination__icon" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                </div>
            </div>
        </div>
    </div>

    <script>
        /* ── Search ── */
        function filterNotifications(query) {
            const cards = document.querySelectorAll('.notif-card');
            const q = query.toLowerCase().trim();
            let visible = 0;
            cards.forEach(card => {
                const text = (card.dataset.text || '') + card.innerText.toLowerCase();
                const show = !q || text.includes(q);
                card.style.display = show ? '' : 'none';
                if (show) visible++;
            });
            document.getElementById('empty-state').classList.toggle('hidden', visible > 0);
        }

        /* ── Delete ── */
        function deleteNotif(btn, notificationId) {

            if (!confirm('Delete this notification?')) {
                return;
            }

            fetch(
                    "{{ route('seller.notifications.destroy', ['seller' => auth('seller')->user()->slug, 'notification' => '__ID__']) }}"
                    .replace('__ID__', notificationId), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    }
                )
                .then(response => response.json())
                .then(data => {

                    if (data.success) {

                        const card = btn.closest('.notif-card');

                        card.style.transition = 'opacity .25s ease, transform .25s ease';
                        card.style.opacity = '0';
                        card.style.transform = 'translateX(20px)';

                        setTimeout(() => {

                            card.remove();

                            const remaining = document.querySelectorAll('.notif-card').length;

                            if (remaining === 0) {
                                location.reload();
                            }

                        }, 250);
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Unable to delete notification.');
                });
        }

        /* ── Pagination ── */
        let currentPage = 1;
        const totalPages = 2;

        function updatePagination() {
            document.getElementById('prev-btn').disabled = currentPage === 1;
            document.getElementById('next-btn').disabled = currentPage === totalPages;
            for (let i = 1; i <= totalPages; i++) {
                const btn = document.getElementById('page-' + i);
                if (btn) {
                    btn.classList.toggle('pagination__btn--active', i === currentPage);
                }
            }
        }

        function changePage(dir) {
            const next = currentPage + dir;
            if (next < 1 || next > totalPages) return;
            goToPage(next);
        }

        function goToPage(page) {
            currentPage = page;
            updatePagination();
            // In a real app you'd fetch/render page data here
        }
    </script>
@endsection
