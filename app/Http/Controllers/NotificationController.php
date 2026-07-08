<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Notification;
use App\Models\PushDeviceToken;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function adminNotifications()
    {
        $adminId = auth('admin')->id();

        return Notification::where('receiver_id', $adminId)
            ->where('receiver_type', 'admin_user')
            ->latest()
            ->get();
    }



    public function sellerNotifications(Request $request)
    {
        $sellerId = auth('seller')->id();

        $notifications = Notification::where('receiver_id', $sellerId)
            ->where('receiver_type', 'seller')
            ->latest()
            ->paginate(7);
        return view('seller.notifications.index', compact('notifications'));
    }


    public function showSellerNotification(Notification $notification)
    {
        $sellerId = auth('seller')->id();

        abort_unless(
            $notification->receiver_id === $sellerId && $notification->receiver_type === 'seller',
            403
        );

        if (!$notification->is_read) {
            $notification->update(['is_read' => true]);
        }

        $product = null;
        if ($notification->reference_id) {
            $product = Products::with(['primaryImage', 'images'])
                ->where('seller_id', $sellerId)
                ->find($notification->reference_id);
        }

        if (!$product) {
            $product = Products::with(['primaryImage', 'images'])
                ->where('seller_id', $sellerId)
                ->where('created_at', '<=', $notification->created_at)
                ->latest('created_at')
                ->latest('id')
                ->first();

            if ($product && !$notification->reference_id) {
                $notification->update([
                    'reference_id' => $product->id,
                    'image' => $product->primaryImage->image_path
                        ?? optional($product->images->first())->image_path,
                ]);
            }
        }

        return view('seller.notifications.show', compact('notification', 'product'));
    }

    public function customerNotifications()
    {
        $customerId = auth('customer')->id();

        return Notification::where('receiver_id', $customerId)
            ->where('receiver_type', 'users')
            ->latest()
            ->get();
    }

    public function markAllSellerRead()
    {
        $sellerId = auth('seller')->id();

        Notification::where('receiver_id', $sellerId)
            ->where('receiver_type', 'seller')
            ->update([
                'is_read' => true
            ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function sellerPushState(Request $request)
    {
        $seller = auth('seller')->user();

        return response()->json([
            'authenticated' => (bool) $seller,
            'seller_id' => $seller?->id,
            'seller_path' => $request->is('seller') || $request->is('seller/*'),
        ]);
    }



    public function subscribeSellerPush(Request $request)
    {
        $sellerId = auth('seller')->id();

        $validated = $request->validate([
            'fcm_token' => ['required', 'string', 'max:2048'],
            'platform' => ['nullable', 'string', 'max:50'],
        ]);

        PushDeviceToken::updateOrCreate(
            [
                'receiver_id' => $sellerId,
                'receiver_type' => 'seller',
                'fcm_token' => $validated['fcm_token'],
            ],
            [
                'platform' => $validated['platform'] ?? 'web',
                'last_used_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
        ]);
    }


    public function firebaseMessagingServiceWorker()
    {
        $config = [
            'apiKey' => config('services.fcm.api_key'),
            'authDomain' => config('services.fcm.project_id') ? config('services.fcm.project_id') . '.firebaseapp.com' : null,
            'projectId' => config('services.fcm.project_id'),
            'storageBucket' => config('services.fcm.project_id') ? config('services.fcm.project_id') . '.appspot.com' : null,
            'messagingSenderId' => config('services.fcm.sender_id'),
            'appId' => config('services.fcm.app_id'),
        ];

        $js = <<<'JS'
                importScripts('https://www.gstatic.com/firebasejs/10.13.2/firebase-app-compat.js');
                importScripts('https://www.gstatic.com/firebasejs/10.13.2/firebase-messaging-compat.js');

                self.__FIREBASE_CONFIG__ = __FIREBASE_CONFIG__;

                firebase.initializeApp(self.__FIREBASE_CONFIG__);
                const messaging = firebase.messaging();

                async function shouldDisplayNotification() {
                    const clientList = await clients.matchAll({
                        type: 'window',
                        includeUncontrolled: true,
                    });

                    const sameOriginClients = clientList.filter(function(client) {
                        const url = new URL(client.url);

                        return url.origin === self.location.origin;
                    });

                    const activeClient = sameOriginClients.find(function(client) {
                        return client.focused || client.visibilityState === 'visible';
                    });

                    const activeUrl = activeClient ? new URL(activeClient.url) : null;
                    const hasSellerClient = sameOriginClients.some(function(client) {
                        return new URL(client.url).pathname.startsWith('/seller');
                    });

                    if (activeUrl && !activeUrl.pathname.startsWith('/seller')) {
                        return false;
                    }

                    if (!activeUrl && !hasSellerClient) {
                        return false;
                    }

                    try {
                        const response = await fetch('/seller/notifications/push-state', {
                            credentials: 'include',
                            cache: 'no-store',
                            headers: {
                                'Accept': 'application/json',
                            },
                        });

                        if (!response.ok) {
                            return false;
                        }

                        const state = await response.json();

                        return state.seller_path === true;
                    } catch (error) {
                        return false;
                    }
                }

                messaging.onBackgroundMessage(function(payload) {
                    shouldDisplayNotification().then(function(canDisplay) {
                        if (!canDisplay) {
                            return;
                        }

                        const title = payload?.notification?.title || payload?.data?.title || 'Notification';
                        const options = {
                            body: payload?.notification?.body || payload?.data?.message || '',
                            icon: '/favicon.ico',
                            data: payload?.data || {},
                        };

                        self.registration.showNotification(title, options);
                    });
                });

                self.addEventListener('notificationclick', function (event) {
                    event.notification.close();

                    const url = event.notification?.data?.url || '/';

                    event.waitUntil(clients.openWindow(url));
                });
                JS;

        $js = str_replace('__FIREBASE_CONFIG__', json_encode($config), $js);

        return response($js, 200)->header('Content-Type', 'application/javascript');
    }

    public function destroySellerNotification($seller, $notification)
    {
        $sellerId = auth('seller')->id();

        $notification = Notification::where('id', $notification)
            ->where('receiver_id', $sellerId)
            ->where('receiver_type', 'seller')
            ->firstOrFail();

        $notification->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
