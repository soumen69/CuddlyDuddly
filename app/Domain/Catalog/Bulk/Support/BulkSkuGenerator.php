<?php

namespace App\Domain\Catalog\Bulk\Support;

use Illuminate\Support\Str;

class BulkSkuGenerator
{
    public function productCode(string $excelKey): string
    {
        return 'PRD-' . strtoupper(Str::random(6)) . '-' . strtoupper($excelKey);
    }

    public function productSku(string $productName): string
    {
        return 'PSKU-' . strtoupper(Str::random(8));
    }

    public function variantSku(string $productCode, array $variantLabels): string
    {
        $variantCode = collect($variantLabels)
            ->map(function ($value) {
                return strtoupper(
                    preg_replace(
                        '/[^A-Za-z0-9]/',
                        '',
                        $value
                    )
                );
            })
            ->implode('-');

        return strtoupper($productCode)
            . '-'
            . $variantCode
            . '-'
            . strtoupper(Str::random(4));
    }


    public function slug(string $name): string
    {
        return Str::slug($name) . '-' . uniqid();
    }
}
