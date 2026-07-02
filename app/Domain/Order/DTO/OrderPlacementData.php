<?php

namespace App\Domain\Order\DTO;

use App\Models\Cart;
use Illuminate\Support\Collection;
use App\Domain\Order\DTO\OrderItemData;

final class OrderPlacementData
{
    /**
     * Customer placing the order.
     */
    public readonly int $userId;

    /**
     * Selected shipping address.
     */
    public readonly int $shippingAddressId;

    /**
     * Razorpay Order ID (null in mock mode until generated).
     */
    public readonly ?string $razorpayOrderId;

    /**
     * Razorpay Payment ID.
     */
    public readonly ?string $razorpayPaymentId;

    /**
     * Payment Method.
     */
    public readonly string $paymentMethod;

    /**
     * Payment Status.
     */
    public readonly string $paymentStatus;

    /**
     * Total Amount.
     */
    public readonly float $amount;

    /**
     * Cart hash used for tamper detection.
     */
    public readonly string $cartHash;

    /**
     * Cart Items.
     *
     * @var Collection<int, OrderItemData>
     */
    public readonly Collection $items;

    public function __construct(
        int $userId,
        int $shippingAddressId,
        float $amount,
        string $cartHash,
        Collection $items,
        string $paymentMethod = 'online',
        string $paymentStatus = 'paid',
        ?string $razorpayOrderId = null,
        ?string $razorpayPaymentId = null
    ) {
        $this->userId = $userId;
        $this->shippingAddressId = $shippingAddressId;
        $this->amount = $amount;
        $this->cartHash = $cartHash;
        $this->items = $items;
        $this->paymentMethod = $paymentMethod;
        $this->paymentStatus = $paymentStatus;
        $this->razorpayOrderId = $razorpayOrderId;
        $this->razorpayPaymentId = $razorpayPaymentId;
    }

    /**
     * Build DTO directly from cart collection.
     */
    public static function fromCart(
        int $userId,
        int $shippingAddressId,
        Collection $cartItems,
        string $cartHash,
        float $amount,
        ?string $razorpayOrderId = null,
        ?string $razorpayPaymentId = null,
        string $paymentMethod = 'online',
        string $paymentStatus = 'paid'
    ): self {

        $items = $cartItems->map(function (Cart $cart) {

            $product = $cart->product;
            $variant = $cart->variant;

            $price = $variant?->price ?? $product->price;
            $stock = $variant?->stock ?? $product->stock;

            return new OrderItemData(
                cartId: $cart->id,
                productId: $product->id,
                sellerId: $product->seller_id,
                variantId: $variant?->id,
                quantity: $cart->quantity,
                price: (float) $price,
                stock: (int) $stock,
                commissionPercent: (float) ($product->commission_percent ?? 0),
                productName: $product->name
            );
        });

        return new self(
            userId: $userId,
            shippingAddressId: $shippingAddressId,
            amount: $amount,
            cartHash: $cartHash,
            items: $items,
            paymentMethod: $paymentMethod,
            paymentStatus: $paymentStatus,
            razorpayOrderId: $razorpayOrderId,
            razorpayPaymentId: $razorpayPaymentId
        );
    }

    /**
     * Total quantity.
     */
    public function totalQuantity(): int
    {
        return $this->items->sum(fn(OrderItemData $item) => $item->quantity);
    }

    /**
     * Total sellers involved.
     */
    public function sellerCount(): int
    {
        return $this->items
            ->pluck('sellerId')
            ->unique()
            ->count();
    }

    /**
     * Group cart items seller wise.
     *
     * @return Collection<int, Collection<OrderItemData>>
     */
    public function groupedBySeller(): Collection
    {
        return $this->items->groupBy(
            fn(OrderItemData $item) => $item->sellerId
        );
    }

    /**
     * Total amount calculated from items.
     */
    public function calculatedAmount(): float
    {
        return $this->items->sum(
            fn(OrderItemData $item) => $item->subtotal()
        );
    }

    /**
     * Check whether calculated total matches checkout total.
     */
    public function isAmountValid(): bool
    {
        return round($this->calculatedAmount(), 2) === round($this->amount, 2);
    }

    /**
     * Convert to array.
     */
    public function toArray(): array
    {
        return [

            'user_id' => $this->userId,

            'shipping_address_id' => $this->shippingAddressId,

            'amount' => $this->amount,

            'cart_hash' => $this->cartHash,

            'payment_method' => $this->paymentMethod,

            'payment_status' => $this->paymentStatus,

            'razorpay_order_id' => $this->razorpayOrderId,

            'razorpay_payment_id' => $this->razorpayPaymentId,

            'seller_count' => $this->sellerCount(),

            'quantity' => $this->totalQuantity(),

            'items' => $this->items->map(
                fn(OrderItemData $item) => $item->toArray()
            )->values()->toArray()

        ];
    }
}
