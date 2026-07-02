<?php

namespace App\Domain\Shipment\DTO;

use App\Domain\Order\DTO\OrderItemData;
use Illuminate\Support\Collection;

final class ShipmentData
{
    /**
     * Parent Order
     */
    public readonly int $orderId;

    /**
     * Seller
     */
    public readonly int $sellerId;

    /**
     * Customer
     */
    public readonly int $userId;

    /**
     * Shipping Address
     */
    public readonly int $shippingAddressId;

    /**
     * Courier Provider
     */
    public readonly string $provider;

    /**
     * Shipment Status
     */
    public readonly string $status;

    /**
     * Settlement Status
     */
    public readonly string $settlementStatus;

    /**
     * Hold Until
     */
    public readonly ?\Carbon\Carbon $holdUntil;

    /**
     * Shipment Items
     *
     * @var Collection<int, OrderItemData>
     */
    public readonly Collection $items;

    /**
     * Shipment Total
     */
    public readonly float $totalAmount;

    /**
     * Total Quantity
     */
    public readonly int $totalQuantity;

    /**
     * Shipment Weight
     */
    public readonly float $totalWeight;

    public function __construct(
        int $orderId,
        int $sellerId,
        int $userId,
        int $shippingAddressId,
        Collection $items,
        string $provider = 'mock',
        string $status = 'pending',
        string $settlementStatus = 'none',
        ?\Carbon\Carbon $holdUntil = null
    ) {

        $this->orderId = $orderId;
        $this->sellerId = $sellerId;
        $this->userId = $userId;
        $this->shippingAddressId = $shippingAddressId;

        $this->provider = $provider;
        $this->status = $status;
        $this->settlementStatus = $settlementStatus;
        $this->holdUntil = $holdUntil;

        $this->items = $items;

        $this->totalAmount = $items->sum(
            fn(OrderItemData $item) => $item->subtotal()
        );

        $this->totalQuantity = $items->sum(
            fn(OrderItemData $item) => $item->quantity
        );

        /**
         * Weight will later come from product variants.
         * Shiprocket requires shipment weight.
         */
        $this->totalWeight = 0;
    }

    /**
     * Total marketplace commission.
     */
    public function commissionAmount(): float
    {
        return round(

            $this->items->sum(
                fn(OrderItemData $item) => $item->commissionAmount()
            ),

            2

        );
    }

    /**
     * Seller payable.
     */
    public function sellerAmount(): float
    {
        return round(

            $this->items->sum(
                fn(OrderItemData $item) => $item->sellerAmount()
            ),

            2

        );
    }

    /**
     * Shipment Item Count
     */
    public function itemCount(): int
    {
        return $this->items->count();
    }

    /**
     * Check if shipment has products.
     */
    public function isEmpty(): bool
    {
        return $this->items->isEmpty();
    }

    /**
     * Export.
     */
    public function toArray(): array
    {
        return [

            'order_id' => $this->orderId,

            'seller_id' => $this->sellerId,

            'user_id' => $this->userId,

            'shipping_address_id' => $this->shippingAddressId,

            'provider' => $this->provider,

            'status' => $this->status,

            'settlement_status' => $this->settlementStatus,

            'hold_until' => $this->holdUntil,

            'total_amount' => $this->totalAmount,

            'seller_amount' => $this->sellerAmount(),

            'commission_amount' => $this->commissionAmount(),

            'quantity' => $this->totalQuantity,

            'item_count' => $this->itemCount(),

            'weight' => $this->totalWeight,

            'items' => $this->items
                ->map(fn(OrderItemData $item) => $item->toArray())
                ->values()
                ->toArray()

        ];
    }
}
