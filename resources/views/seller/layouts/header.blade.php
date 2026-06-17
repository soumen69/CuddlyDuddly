<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Seller Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/output.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sellerportal.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* ── Bell Button ── */
        #notif-btn {
            cursor: pointer;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 1px solid rgba(0, 0, 0, 0.18);
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: background 0.22s, border-color 0.22s;
            flex-shrink: 0;
        }

        #notif-btn:hover {
            background: #111;
            border-color: #111;
        }

        #notif-btn:hover svg {
            color: #fff;
        }

        #notif-btn.active {
            background: #111;
            border-color: #111;
        }

        #notif-btn.active svg {
            color: #fff;
        }

        #notif-btn svg {
            color: #111;
            transition: color 0.22s;
        }

        #badge {
            position: absolute;
            top: 9px;
            right: 9px;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #E24B4A;
            border: 2px solid #fff;
            display: none;
        }

        /* ── Wrapper ── */
        .notif-wrapper {
            position: relative;
            display: inline-block;
        }

        /* ── Dropdown Panel ── */
        #notif-panel {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 340px;
            background: #fff;
            border: 0.5px solid rgba(0, 0, 0, 0.12);
            border-radius: 16px;
            overflow: hidden;
            z-index: 200;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.10);
            transform: translateY(-8px);
            opacity: 0;
            transition: transform 0.22s cubic-bezier(.4, 0, .2, 1), opacity 0.22s ease;
        }

        #notif-panel.open {
            display: block;
        }

        #notif-panel.visible {
            transform: translateY(0);
            opacity: 1;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px 12px;
            border-bottom: 0.5px solid rgba(0, 0, 0, 0.08);
        }

        .panel-header span {
            font-size: 15px;
            font-weight: 600;
            color: #111;
        }

        .panel-header button {
            font-size: 12px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            color: #185FA5;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            transition: opacity 0.15s;
        }

        .panel-header button:hover {
            opacity: 0.7;
        }

        /* ── Notification List ── */
        #notif-list {
            max-height: 340px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 0, 0, 0.1) transparent;
        }

        .notif-item {
            display: flex;
            gap: 12px;
            padding: 12px 16px;
            border-bottom: 0.5px solid rgba(0, 0, 0, 0.06);
            cursor: pointer;
            transition: background 0.15s;
            position: relative;
        }

        .notif-item:last-child {
            border-bottom: none;
        }

        .notif-item.unread {
            background: #EBF3FC;
        }

        .notif-item:hover {
            background: #f4f3ef;
        }

        .notif-item.unread:hover {
            background: #dceaf7;
        }

        .notif-item.selected {
            background: #e8e7e2;
        }

        .notif-avatar {
            flex-shrink: 0;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
        }

        .notif-body {
            flex: 1;
            min-width: 0;
        }

        .notif-title {
            font-size: 13px;
            font-weight: 500;
            color: #111;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .notif-desc {
            font-size: 12px;
            color: #555;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .notif-time {
            font-size: 11px;
            color: #999;
        }

        .notif-dot {
            flex-shrink: 0;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #378ADD;
            margin-top: 5px;
            align-self: flex-start;
        }

        .panel-footer {
            padding: 10px 16px;
            border-top: 0.5px solid rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .panel-footer button {
            font-size: 13px;
            font-family: 'DM Sans', sans-serif;
            color: #555;
            background: none;
            border: none;
            cursor: pointer;
            transition: color 0.15s;
        }

        .panel-footer button:hover {
            color: #111;
        }

        /* ── Preview Panel ── */
        #preview-panel {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 358px;
            width: 320px;
            background: #fff;
            border: 0.5px solid rgba(0, 0, 0, 0.12);
            border-radius: 16px;
            overflow: hidden;
            z-index: 199;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.10);
            transform: translateX(8px);
            opacity: 0;
            transition: transform 0.22s cubic-bezier(.4, 0, .2, 1), opacity 0.22s ease;
        }

        #preview-panel.open {
            display: block;
        }

        #preview-panel.visible {
            transform: translateX(0);
            opacity: 1;
        }

        .preview-banner {
            width: 100%;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .preview-body {
            padding: 16px;
        }

        .preview-tag {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 99px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .preview-title {
            font-size: 15px;
            font-weight: 600;
            color: #111;
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .preview-desc {
            font-size: 13px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 14px;
        }

        .preview-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .preview-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 600;
            color: #fff;
        }

        .preview-meta-text {
            font-size: 12px;
            color: #777;
        }

        .preview-actions {
            display: flex;
            gap: 8px;
        }

        .btn-primary {
            flex: 1;
            padding: 9px 0;
            background: #111;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-primary:hover {
            background: #333;
        }

        .btn-ghost {
            flex: 1;
            padding: 9px 0;
            background: #f4f3ef;
            color: #333;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-ghost:hover {
            background: #e8e7e2;
        }

        .preview-divider {
            height: 0.5px;
            background: rgba(0, 0, 0, 0.08);
            margin: 14px 0;
        }

        .preview-close {
            position: absolute;
            top: 10px;
            right: 12px;
            background: rgba(0, 0, 0, 0.08);
            border: none;
            border-radius: 50%;
            width: 26px;
            height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
            color: #333;
            transition: background 0.15s;
        }

        .preview-close:hover {
            background: rgba(0, 0, 0, 0.15);
        }


        @media (max-width: 767.98px) {
            #notif-btn {
                width: 36px;
                height: 36px;
            }

            #notif-panel {
                right: inherit;
                left: -145px;
                max-width: 300px;
                border-radius: 10px;
            }

            #preview-panel {
                display: none !important;
            }
        }
    </style>

</head>

<body>
    <div
        class="w-full flex flex-wrap-reverse lg:flex-nowrap justify-center py-6 px-6 md:pl-14 md:pr-9 border-b border-black/20 gap-5">

        <div class="flex gap-4 justify-end absolute top-6 right-6 z-50">
            <style>
                .alert {
                    transition: all 0.4s ease;
                }
            </style>


            {{-- RIGHT SIDE ALERTS --}}
            <div class="w-full flex justify-end items-start">

                {{-- SUCCESS --}}
                @if (session('success'))
                    <div
                        class="alert alert-dismissible fade show 
                        flex items-center gap-3 
                        bg-gradient-to-r from-green-50 to-green-200 
                        !text-green-900 border !border-green-300 
                        shadow-md rounded-xl px-5 py-3">

                        <i class="fa-solid fa-circle-check text-green-700 text-xl"></i>

                        <span class="font-medium">{{ session('success') }}</span>

                        <button type="button" class="btn-close !ml-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- ERROR --}}
                @if (session('error'))
                    <div
                        class="alert alert-dismissible fade show 
                        flex items-center gap-3 
                        bg-gradient-to-r from-red-50 to-red-200 
                        text-red-900 border border-red-300
                        shadow-md rounded-xl px-5 py-3">

                        <i class="fa-solid fa-triangle-exclamation text-red-700 text-xl"></i>

                        <span class="font-medium">{{ session('error') }}</span>

                        <button type="button" class="btn-close !ml-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

            </div>


        </div>

        <div class="w-full flex flex-wrap gap-4">
            <div
                class="flex-1 flex-box w-full max-w-full order-2 lg:order-[unset] max-w-auto justify-start rounded-[64.18px] border border-black/20 pl-4 pr-2.5 py-3">
                <span><img src={{ asset('storage/images/dahboard-search.png') }} alt=""
                        class="max-w-4 object-contain"></span><input type="text"
                    class="w-full h-full placeholder:font-sans placeholder:text-base placeholder:text-black placeholder:font-normal placeholder:tracking-1 placeholder:leading-tight"
                    placeholder="Search">
            </div>
            <div class="w-full lg:w-auto flex items-center gap-5">
                <button id="dashboardhamburger" type="button" class="text-[28px] block lg:hidden ml-0 lg:m-auto">
                    <i class="fa-solid fa-bars"></i>
                </button>


                {{-- <button
                    class="cursor-pointer w-9 h-9 md:w-12 md:h-12 ml-auto inline-block lg:mr-0 my-0 lg:m-auto group rounded-full border border-black/20 hover:bg-black transition-all duration-300">
                    <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="w-full max-h-4 md:max-h-6 group-hover:text-white">
                        <path
                            d="M14.0681 28.7721C14.3086 29.1886 14.6545 29.5345 15.0711 29.775C15.4876 30.0154 15.9601 30.142 16.4411 30.142C16.9221 30.142 17.3946 30.0154 17.8112 29.775C18.2277 29.5345 18.5736 29.1886 18.8141 28.7721"
                            stroke="currentColor" stroke-width="2.7402" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                        <path
                            d="M4.46917 20.9981C4.29019 21.1943 4.17207 21.4383 4.12919 21.7003C4.08631 21.9624 4.12051 22.2313 4.22763 22.4743C4.33476 22.7173 4.51018 22.9239 4.73258 23.069C4.95497 23.2141 5.21475 23.2915 5.4803 23.2917H27.4019C27.6674 23.2918 27.9272 23.2147 28.1498 23.0699C28.3723 22.925 28.5479 22.7186 28.6554 22.4758C28.7628 22.233 28.7973 21.9642 28.7548 21.7021C28.7122 21.44 28.5944 21.1959 28.4157 20.9995C26.5935 19.1211 24.6617 17.1249 24.6617 10.9608C24.6617 8.78056 23.7956 6.68962 22.2539 5.14796C20.7123 3.6063 18.6213 2.7402 16.4411 2.7402C14.2609 2.7402 12.1699 3.6063 10.6283 5.14796C9.08659 6.68962 8.2205 8.78056 8.2205 10.9608C8.2205 17.1249 6.28729 19.1211 4.46917 20.9981Z"
                            stroke="currentColor" stroke-width="2.7402" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg>
                </button> --}}

                <div class="notif-wrapper ml-auto">
                    <!-- Bell button -->
                    <button id="notif-btn" aria-label="Notifications" aria-expanded="false" aria-haspopup="true">
                        <svg width="22" height="22" viewBox="0 0 33 33" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.0681 28.7721C14.3086 29.1886 14.6545 29.5345 15.0711 29.775C15.4876 30.0154 15.9601 30.142 16.4411 30.142C16.9221 30.142 17.3946 30.0154 17.8112 29.775C18.2277 29.5345 18.5736 29.1886 18.8141 28.7721"
                                stroke="currentColor" stroke-width="2.7402" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M4.46917 20.9981C4.29019 21.1943 4.17207 21.4383 4.12919 21.7003C4.08631 21.9624 4.12051 22.2313 4.22763 22.4743C4.33476 22.7173 4.51018 22.9239 4.73258 23.069C4.95497 23.2141 5.21475 23.2915 5.4803 23.2917H27.4019C27.6674 23.2918 27.9272 23.2147 28.1498 23.0699C28.3723 22.925 28.5479 22.7186 28.6554 22.4758C28.7628 22.233 28.7973 21.9642 28.7548 21.7021C28.7122 21.44 28.5944 21.1959 28.4157 20.9995C26.5935 19.1211 24.6617 17.1249 24.6617 10.9608C24.6617 8.78056 23.7956 6.68962 22.2539 5.14796C20.7123 3.6063 18.6213 2.7402 16.4411 2.7402C14.2609 2.7402 12.1699 3.6063 10.6283 5.14796C9.08659 6.68962 8.2205 8.78056 8.2205 10.9608C8.2205 17.1249 6.28729 19.1211 4.46917 20.9981Z"
                                stroke="currentColor" stroke-width="2.7402" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <span id="badge"></span>
                    </button>

                    <!-- ── Notification Dropdown ── -->
                    <div id="notif-panel" role="dialog" aria-label="Notifications">

                        <div class="panel-header">
                            <span>Notifications</span>
                            <button id="mark-all">Mark all as read</button>
                        </div>

                        <div id="notif-list">
                            @forelse ($sellerNotifications ?? [] as $notification)
                                @php
                                    $isUnread = !$notification->is_read;
                                    $type = strtolower($notification->type ?? 'update');
                                    $typeMeta = [
                                        'order' => ['label' => 'Order', 'bg' => '#B5D4F4', 'color' => '#0C447C', 'emoji' => '📦'],
                                        'product' => ['label' => 'Product', 'bg' => '#9FE1CB', 'color' => '#085041', 'emoji' => '🛍️'],
                                        'alert' => ['label' => 'Alert', 'bg' => '#F5C4B3', 'color' => '#712B13', 'emoji' => '🚨'],
                                        'review' => ['label' => 'Review', 'bg' => '#FAC775', 'color' => '#412402', 'emoji' => '⭐'],
                                        'update' => ['label' => 'Update', 'bg' => '#C0DD97', 'color' => '#173404', 'emoji' => '🔔'],
                                    ];
                                    $meta = $typeMeta[$type] ?? $typeMeta['update'];
                                    $avatarText = strtoupper(substr($notification->title ?? 'N', 0, 2));
                                @endphp
                                <div class="notif-item {{ $isUnread ? 'unread' : '' }}" data-id="{{ $notification->id }}"
                                    data-title="{{ e($notification->title ?? '') }}"
                                    data-desc="{{ e($notification->message ?? '') }}"
                                    data-details="{{ e($notification->details ?? '') }}"
                                    data-image="{{ e($notification->image ? asset('storage/' . ltrim($notification->image, '/')) : '') }}"
                                    data-url="{{ e(route('seller.notifications.show', $notification->id)) }}"
                                    data-time="{{ e(optional($notification->created_at)->diffForHumans() ?? '') }}"
                                    data-tag-label="{{ e($meta['label']) }}"
                                    data-tag-bg="{{ e($meta['bg']) }}"
                                    data-tag-color="{{ e($meta['color']) }}"
                                    data-banner-bg="{{ e($meta['bg']) }}"
                                    data-banner-emoji="{{ e($meta['emoji']) }}"
                                    data-avatar="{{ e($avatarText) }}"
                                    data-avatar-bg="#185FA5"
                                    data-meta="{{ e(optional($notification->created_at)->format('M d, Y h:i A') ?? '') }}"
                                    data-primary="View notification">
                                    <div class="notif-avatar" style="background:#185FA5;">{{ $avatarText }}</div>
                                    <div class="notif-body">
                                        <p class="notif-title">{{ $notification->title }}</p>
                                        <p class="notif-desc">{{ $notification->message }}</p>
                                        <p class="notif-time">{{ $notification->created_at ? $notification->created_at->diffForHumans() : '' }}</p>
                                    </div>
                                    @if ($isUnread)
                                        <span class="notif-dot"></span>
                                    @endif
                                </div>
                            @empty
                                <div class="p-4 text-sm text-gray-500">
                                    No notifications yet.
                                </div>
                            @endforelse

                        </div>

                        <div class="panel-footer">
                            <button id="view-all">View all notifications</button>
                        </div>
                    </div>

                    <!-- ── Preview Panel ── -->
                    <div id="preview-panel">
                        <button class="preview-close" id="preview-close" aria-label="Close preview">✕</button>
                        <div class="preview-banner" id="preview-banner"></div>
                        <div class="preview-body">
                            <span class="preview-tag" id="preview-tag"></span>
                            <img id="preview-image" alt="" style="display:none;width:100%;max-height:140px;object-fit:cover;border-radius:12px;margin:0 0 12px;">
                            <p class="preview-title" id="preview-title"></p>
                            <div class="preview-meta">
                                <div class="preview-avatar" id="preview-avatar"></div>
                                <span class="preview-meta-text" id="preview-meta-text"></span>
                            </div>
                            <p class="preview-desc" id="preview-desc"></p>
                            <div class="preview-divider"></div>
                            <div class="preview-actions">
                                <button class="btn-primary" id="preview-action-primary"></button>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="w-9 h-9 md:w-12 md:h-12 rounded-full border border-black/20 overflow-hidden">
                    <img src="{{ asset('storage/images/profileimg.png') }}" alt="" class="scale-150">
                </div>
                <span class="">
                    <form id="logoutForm" method="POST" action="{{ route('seller.logout') }}" class="">
                        @csrf
                        <button type="button" id="logoutBtn"
                            class="cursor-pointer w-9 h-9 md:w-12 md:h-12 ml-auto mr-0 my-0 md:m-auto group rounded-full border-[1.5px] 
                        border-[var(--color-pink-transparent)] bg-white text-[var(--color-pink-transparent)] hover:border-black 
                        focus:border-black hover:text-black focus:text-black flex items-center justify-center transition-all 
                        duration-300">
                            <!-- <i class="fa-solid fa-arrow-right-from-bracket"></i> -->
                            <i class="fa-solid fa-power-off"></i>
                        </button>
                    </form>
                </span>


            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 3000);
            });
        });

        // Logout 
        document.getElementById('logoutBtn').addEventListener('click', function(e) {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to logout from your account.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, logout",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });
    </script>

    <script>
        // ── State ──
        let panelOpen = false;
        let previewOpen = false;
        let selectedId = null;

        const btn = document.getElementById('notif-btn');
        const panel = document.getElementById('notif-panel');
        const badge = document.getElementById('badge');
        const markAllBtn = document.getElementById('mark-all');
        const previewPanel = document.getElementById('preview-panel');
        const previewClose = document.getElementById('preview-close');

        // ── Badge ──
        function updateBadge() {
            const count = document.querySelectorAll('.notif-item.unread').length;
            badge.style.display = count > 0 ? 'block' : 'none';
        }

        // ── Open / Close Dropdown ──
        function openPanel() {
            panelOpen = true;
            btn.classList.add('active');
            btn.setAttribute('aria-expanded', 'true');
            panel.classList.add('open');
            requestAnimationFrame(() => panel.classList.add('visible'));
        }

        function closePanel() {
            panelOpen = false;
            btn.classList.remove('active');
            btn.setAttribute('aria-expanded', 'false');
            panel.classList.remove('visible');
            setTimeout(() => {
                if (!panelOpen) panel.classList.remove('open');
            }, 220);
            closePreview();
        }

        // ── Open / Close Preview ──
        function openPreview(id) {
            const activeItem = document.querySelector(`.notif-item[data-id="${id}"]`);
            if (!activeItem) return;

            selectedId = id;

            const data = {
                title: activeItem.dataset.title || '',
                desc: activeItem.dataset.desc || '',
                details: activeItem.dataset.details || '',
                image: activeItem.dataset.image || '',
                url: activeItem.dataset.url || '',
                time: activeItem.dataset.time || '',
                primary: activeItem.dataset.primary || 'View notification',
                avatar: activeItem.dataset.avatar || 'N',
                avatarBg: activeItem.dataset.avatarBg || '#185FA5',
                tagLabel: activeItem.dataset.tagLabel || 'Update',
                tagBg: activeItem.dataset.tagBg || '#C0DD97',
                tagColor: activeItem.dataset.tagColor || '#173404',
                bannerBg: activeItem.dataset.bannerBg || '#C0DD97',
                bannerEmoji: activeItem.dataset.bannerEmoji || '🔔',
                meta: activeItem.dataset.meta || '',
            };

            // Populate preview
            const banner = document.getElementById('preview-banner');
            banner.style.background = data.bannerBg;
            banner.textContent = data.bannerEmoji;

            const tag = document.getElementById('preview-tag');
            tag.textContent = data.tagLabel;
            tag.style.background = data.tagBg;
            tag.style.color = data.tagColor;

            document.getElementById('preview-title').textContent = data.title;
            document.getElementById('preview-desc').textContent = data.details || data.desc;

            const previewImage = document.getElementById('preview-image');
            if (data.image) {
                previewImage.src = data.image;
                previewImage.style.display = 'block';
            } else {
                previewImage.removeAttribute('src');
                previewImage.style.display = 'none';
            }

            const av = document.getElementById('preview-avatar');
            av.textContent = data.avatar;
            av.style.background = data.avatarBg;

            document.getElementById('preview-meta-text').textContent = data.meta || data.time;
            document.getElementById('preview-action-primary').textContent = data.primary;
            document.getElementById('preview-action-primary').dataset.url = data.url;

            // Highlight selected item
            document.querySelectorAll('.notif-item').forEach(el => el.classList.remove('selected'));
            if (activeItem) activeItem.classList.add('selected');

            // Mark as read
            if (activeItem && activeItem.classList.contains('unread')) {
                activeItem.classList.remove('unread');
                const dot = activeItem.querySelector('.notif-dot');
                if (dot) dot.remove();
                updateBadge();
            }

            previewOpen = true;
            previewPanel.classList.add('open');
            requestAnimationFrame(() => previewPanel.classList.add('visible'));
        }

        function closePreview() {
            previewOpen = false;
            selectedId = null;
            previewPanel.classList.remove('visible');
            setTimeout(() => {
                if (!previewOpen) previewPanel.classList.remove('open');
            }, 220);
            document.querySelectorAll('.notif-item').forEach(el => el.classList.remove('selected'));
        }

        // ── Event Listeners ──
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            panelOpen ? closePanel() : openPanel();
        });

        document.querySelectorAll('.notif-item').forEach(item => {
            item.addEventListener('click', () => {
                const id = parseInt(item.dataset.id);
                if (selectedId === id) {
                    closePreview();
                } else {
                    openPreview(id);
                }
            });
        });

        markAllBtn.addEventListener('click', () => {
            document.querySelectorAll('.notif-item.unread').forEach(item => {
                item.classList.remove('unread');
                const dot = item.querySelector('.notif-dot');
                if (dot) dot.remove();
            });
            updateBadge();

            fetch("{{ route('seller.notifications.mark-all-read', ['seller' => auth('seller')->user()->slug]) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            }).catch(() => {});
        });

        previewClose.addEventListener('click', (e) => {
            e.stopPropagation();
            closePreview();
        });

        document.getElementById('preview-action-primary').addEventListener('click', () => {
            const url = document.getElementById('preview-action-primary').dataset.url;
            if (url) window.location.href = url;
        });

        document.getElementById('preview-action-ghost')?.addEventListener('click', () => closePreview());

        document.addEventListener('click', (e) => {
            const wrapper = document.querySelector('.notif-wrapper');
            if (panelOpen && !wrapper.contains(e.target)) closePanel();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (previewOpen) closePreview();
                else if (panelOpen) closePanel();
            }
        });


        updateBadge();
    </script>

</body>

</html>
