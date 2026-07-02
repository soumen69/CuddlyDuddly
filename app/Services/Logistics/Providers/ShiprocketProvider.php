<?php

namespace App\Services\Logistics\Providers;

use App\Models\Shipment;
use App\Services\Logistics\Contracts\CourierProvider;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class ShiprocketProvider implements CourierProvider
{
    protected const TOKEN_CACHE_KEY = 'shiprocket.api.token';

    protected PendingRequest $http;

    public function __construct()
    {
        $this->http = Http::baseUrl(
            rtrim(config('services.shiprocket.base_url'), '/')
        )
            ->acceptJson()
            ->asJson()
            ->timeout(30)
            ->connectTimeout(10);
    }

    public function name(): string
    {
        return 'shiprocket';
    }

    public function enabled(): bool
    {
        return filled(config('services.shiprocket.email'))
            && filled(config('services.shiprocket.password'));
    }

    protected function token(): string
    {
        return Cache::remember(
            self::TOKEN_CACHE_KEY,
            now()->addHours(230),
            fn() => $this->authenticate()
        );
    }

    protected function authenticate(): string
    {
        $response = $this->http
            ->post('/auth/login', [
                'email' => config('services.shiprocket.email'),
                'password' => config('services.shiprocket.password'),
            ])
            ->throw();

        $token = data_get(
            $response->json(),
            'token'
        );

        if (blank($token)) {
            throw new RuntimeException(
                'Shiprocket authentication failed.'
            );
        }

        return $token;
    }

    protected function forgetToken(): void
    {
        Cache::forget(
            self::TOKEN_CACHE_KEY
        );
    }

    protected function request(string $method, string $uri, array $payload = []): Response
    {
        $response = $this->authorized()
            ->send(
                $method,
                $uri,
                [
                    'json' => $payload,
                ]
            );

        if ($response->status() !== 401) {
            return $response->throw();
        }

        $this->forgetToken();

        return $this->authorized()
            ->send(
                $method,
                $uri,
                [
                    'json' => $payload,
                ]
            )
            ->throw();
    }

    protected function authorized(): PendingRequest
    {
        return $this->http
            ->withToken(
                $this->token()
            );
    }

    protected function get(string $uri, array $query = []): Response
    {
        $response = $this->authorized()
            ->get(
                $uri,
                $query
            );

        if ($response->status() !== 401) {
            return $response->throw();
        }

        $this->forgetToken();

        return $this->authorized()
            ->get(
                $uri,
                $query
            )
            ->throw();
    }

    protected function providerReference(Shipment $shipment): string
    {
        return $shipment->provider_reference
            ?: (string) $shipment->order_id;
    }

    public function createShipment(Shipment $shipment): array
    {
        $shipment->loadMissing([
            'order.shippingAddress',
            'seller',
            'items.product',
            'items.variant',
        ]);

        $response = $this->request(
            'POST',
            '/orders/create/adhoc',
            $this->buildShipmentPayload($shipment)
        );

        $data = $response->json();

        return [
            'provider'             => $this->name(),
            'provider_status'      => data_get($data, 'status'),
            'provider_reference'   => data_get($data, 'order_id'),
            'shipment_id'          => data_get($data, 'shipment_id'),
            'awb_number'           => data_get($data, 'awb_code'),
            'tracking_number'      => data_get($data, 'awb_code'),
            'courier_name'         => data_get($data, 'courier_name'),
            'courier_code'         => data_get($data, 'courier_company_id'),
            'tracking_url'         => data_get($data, 'tracking_url'),
            'payload'              => $data,
        ];
    }

    public function schedulePickup(Shipment $shipment): array
    {
        if (blank($shipment->shipment_id)) {
            throw new RuntimeException(
                'Shipment has not yet been created in Shiprocket.'
            );
        }

        $response = $this->request(
            'POST',
            '/courier/generate/pickup',
            [
                'shipment_id' => [
                    $shipment->shipment_id,
                ],
            ]
        );

        $data = $response->json();

        return [
            'provider'         => $this->name(),
            'provider_status'  => data_get($data, 'message'),
            'pickup_token'     => data_get($data, 'pickup_token'),
            'payload'          => $data,
        ];
    }

    public function cancelShipment(Shipment $shipment): array
    {
        if (blank($shipment->shipment_id)) {
            throw new RuntimeException(
                'Shipment has not yet been created in Shiprocket.'
            );
        }

        $response = $this->request(
            'POST',
            '/orders/cancel',
            [
                'ids' => [
                    $shipment->shipment_id,
                ],
            ]
        );

        $data = $response->json();

        return [
            'provider'        => $this->name(),
            'provider_status' => data_get($data, 'message', 'Cancelled'),
            'shipment_id'     => $shipment->shipment_id,
            'payload'         => $data,
        ];
    }

    public function supportsTracking(): bool
    {
        return true;
    }

    public function supportsShipmentCreation(): bool
    {
        return true;
    }

    public function supportsPickupScheduling(): bool
    {
        return true;
    }

    public function supportsCancellation(): bool
    {
        return true;
    }

    public function trackShipment(Shipment $shipment): array
    {
        if (blank($shipment->awb_number)) {
            throw new RuntimeException(
                'Shipment does not have an AWB number.'
            );
        }

        $response = $this->get(
            '/courier/track/awb/' . $shipment->awb_number
        );

        $data = $response->json();

        $activity = collect(
            data_get($data, 'tracking_data.shipment_track_activities', [])
        )->first();

        return [
            'provider'          => $this->name(),
            'provider_status'   => data_get(
                $activity,
                'activity'
            ) ?? data_get(
                $data,
                'tracking_data.shipment_status'
            ),
            'location'          => data_get($activity, 'location'),
            'remarks'           => data_get($activity, 'activity'),
            'event_time'        => data_get($activity, 'date'),
            'tracking_number'   => $shipment->tracking_number,
            'awb_number'        => $shipment->awb_number,
            'tracking_url'      => $shipment->tracking_url,
            'payload'           => $data,
        ];
    }

    public function shippingLabel(Shipment $shipment): array
    {
        if (blank($shipment->shipment_id)) {
            throw new RuntimeException(
                'Shipment has not yet been created in Shiprocket.'
            );
        }

        $response = $this->request(
            'POST',
            '/courier/generate/label',
            [
                'shipment_id' => [
                    $shipment->shipment_id,
                ],
            ]
        );

        $data = $response->json();

        return [
            'provider' => $this->name(),
            'label_url' => data_get(
                $data,
                'label_url'
            ),
            'payload' => $data,
        ];
    }

    public function invoice(Shipment $shipment): array
    {
        if (blank($shipment->shipment_id)) {
            throw new RuntimeException(
                'Shipment has not yet been created in Shiprocket.'
            );
        }

        $response = $this->request(
            'POST',
            '/orders/print/invoice',
            [
                'ids' => [
                    $shipment->shipment_id,
                ],
            ]
        );

        $data = $response->json();

        return [
            'provider' => $this->name(),
            'invoice_url' => data_get(
                $data,
                'invoice_url'
            ),
            'payload' => $data,
        ];
    }

    protected function buildShipmentPayload(Shipment $shipment): array
    {
        $order = $shipment->order;
        $address = $order->shippingAddress;

        return [
            'order_id' => $this->providerReference($shipment),

            'order_date' => $order->created_at
                ->format('Y-m-d H:i'),

            'pickup_location' => config('services.shiprocket.pickup_location'),

            'billing_customer_name' => $address->full_name,
            'billing_last_name' => '',
            'billing_address' => $address->address_line_1,
            'billing_address_2' => $address->address_line_2,
            'billing_city' => $address->city,
            'billing_state' => $address->state,
            'billing_country' => 'India',
            'billing_pincode' => $address->postal_code,
            'billing_phone' => $address->phone,
            'billing_email' => $order->user->email,

            'shipping_is_billing' => true,

            'order_items' => $shipment->items
                ->map(function ($item) {

                    return [
                        'name' => $item->product->name,
                        'sku' => $item->variant?->sku
                            ?? $item->product->sku,
                        'units' => $item->quantity,
                        'selling_price' => $item->price,
                    ];
                })
                ->values()
                ->all(),

            'payment_method' => strtoupper(
                $order->payment_method
            ) === 'COD'
                ? 'COD'
                : 'Prepaid',

            'sub_total' => $shipment->items
                ->sum(function ($item) {
                    return $item->price * $item->quantity;
                }),

            'length' => 10,
            'breadth' => 10,
            'height' => 10,
            'weight' => 0.5,
        ];
    }

    protected function ensureSuccessful(Response $response): array
    {
        try {
            return $response->throw()->json();
        } catch (RequestException $exception) {
            throw new RuntimeException(
                data_get(
                    $exception->response?->json(),
                    'message',
                    'Shiprocket request failed.'
                ),
                $exception->getCode(),
                $exception
            );
        }
    }
}
