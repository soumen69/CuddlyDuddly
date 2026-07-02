<?php

namespace App\Domain\Order\DTO;

final class OrderItemData
{
    /**
     * Cart ID
     */
    public readonly int $cartId;

    /**
     * Product ID
     */
    public readonly int $productId;

    /**
     * Seller ID
     */
    public readonly int $sellerId;

    /**
     * Variant ID (nullable)
     */
    public readonly ?int $variantId;

    /**
     * Quantity
     */
    public readonly int $quantity;

    /**
     * Selling Price
     */
    public readonly float $price;

    /**
     * Current Available Stock
     */
    public readonly int $stock;

    /**
     * Commission %
     */
    public readonly float $commissionPercent;

    /**
     * Product Name
     */
    public readonly string $productName;

    public function __construct(
        int $cartId,
        int $productId,
        int $sellerId,
        ?int $variantId,
        int $quantity,
        float $price,
        int $stock,
        float $commissionPercent,
        string $productName
    ) {
        $this->cartId = $cartId;
        $this->productId = $productId;
        $this->sellerId = $sellerId;
        $this->variantId = $variantId;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->stock = $stock;
        $this->commissionPercent = $commissionPercent;
        $this->productName = $productName;
    }

    /**
     * Line subtotal.
     */
    public function subtotal(): float
    {
        return round(
            $this->price * $this->quantity,
            2
        );
    }

    /**
     * Marketplace commission.
     */
    public function commissionAmount(): float
    {
        return round(
            ($this->subtotal() * $this->commissionPercent) / 100,
            2
        );
    }

    /**
     * Seller payable amount.
     */
    public function sellerAmount(): float
    {
        return round(
            $this->subtotal() - $this->commissionAmount(),
            2
        );
    }

    /**
     * Inventory validation.
     */
    public function hasEnoughStock(): bool
    {
        return $this->stock >= $this->quantity;
    }

    /**
     * Export.
     */
    public function toArray(): array
    {
        return [

            'cart_id' => $this->cartId,

            'product_id' => $this->productId,

            'seller_id' => $this->sellerId,

            'variant_id' => $this->variantId,

            'quantity' => $this->quantity,

            'price' => $this->price,

            'subtotal' => $this->subtotal(),

            'commission_percent' => $this->commissionPercent,

            'commission_amount' => $this->commissionAmount(),

            'seller_amount' => $this->sellerAmount(),

            'stock' => $this->stock,

            'product_name' => $this->productName

        ];
    }
}
