<?php

namespace App\Services\Logistics\Tracking;

class StatusMapper
{
    /**
     * Shiprocket / Courier status
     *                ↓
     * Marketplace shipment status
     */
    private const STATUS_MAP = [

        // ---------------------------------------------------------
        // Shipment Created
        // ---------------------------------------------------------

        'NEW'                           => 'pending',
        'CREATED'                       => 'pending',
        'SHIPMENT CREATED'              => 'pending',
        'MANIFEST GENERATED'            => 'pending',

        // ---------------------------------------------------------
        // AWB
        // ---------------------------------------------------------

        'AWB ASSIGNED'                  => 'confirmed',
        'AWB GENERATED'                 => 'confirmed',

        // ---------------------------------------------------------
        // Pickup
        // ---------------------------------------------------------

        'PICKUP SCHEDULED'              => 'confirmed',
        'PICKUP GENERATED'              => 'confirmed',

        'PICKED UP'                     => 'picked_up',
        'PICKUP COMPLETE'               => 'picked_up',

        // ---------------------------------------------------------
        // Warehouse
        // ---------------------------------------------------------

        'PACKED'                        => 'packed',

        // ---------------------------------------------------------
        // Shipping
        // ---------------------------------------------------------

        'SHIPPED'                       => 'shipped',
        'DISPATCHED'                    => 'shipped',

        'IN TRANSIT'                    => 'in_transit',
        'REACHED HUB'                   => 'in_transit',
        'ARRIVED AT HUB'                => 'in_transit',
        'DEPARTED HUB'                  => 'in_transit',

        // ---------------------------------------------------------
        // Last Mile
        // ---------------------------------------------------------

        'OUT FOR DELIVERY'              => 'out_for_delivery',

        // ---------------------------------------------------------
        // Success
        // ---------------------------------------------------------

        'DELIVERED'                     => 'delivered',

        // ---------------------------------------------------------
        // Cancel
        // ---------------------------------------------------------

        'CANCELLED'                     => 'cancelled',
        'CANCELED'                      => 'cancelled',

        // ---------------------------------------------------------
        // RTO
        // ---------------------------------------------------------

        'RTO INITIATED'                 => 'rto_initiated',
        'RTO IN TRANSIT'                => 'rto_initiated',
        'RTO REACHED HUB'               => 'rto_initiated',

        'RTO DELIVERED'                 => 'rto_delivered',
        'RTO COMPLETED'                 => 'rto_delivered',
    ];

    /**
     * Convert a provider status into
     * marketplace shipment status.
     */
    public function map(string|null $providerStatus): ?string
    {
        if (blank($providerStatus)) {
            return null;
        }

        $status = strtoupper(trim($providerStatus));

        return self::STATUS_MAP[$status] ?? null;
    }

    /**
     * Whether provider status
     * is recognized.
     */
    public function supported(string|null $providerStatus): bool
    {
        return $this->map($providerStatus) !== null;
    }

    /**
     * Return all supported mappings.
     */
    public function mappings(): array
    {
        return self::STATUS_MAP;
    }
}
