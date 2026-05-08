<?php

namespace App\Domain\Catalog\Bulk\Validation;

use App\Models\Products;

class BulkConflictResolver
{
    public function groupCodeExists(
        string $groupCode
    ): bool {

        return Products::where(
            'product_code',
            $groupCode
        )->exists();
    }

    public function skuExists(
        string $sku
    ): bool {

        return Products::where(
            'sku',
            $sku
        )->exists();
    }
}
