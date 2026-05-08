<?php

namespace App\Domain\Catalog\Bulk\Intelligence;

use App\Models\AttributeValue;
use Illuminate\Support\Str;

class AttributeValueAutoCreator
{
    public function resolveOrCreate(int $attributeId, string $value): int
    {
        $normalized = trim(mb_strtolower($value));

        $existing = AttributeValue::where('attribute_id', $attributeId)
            ->whereRaw('LOWER(value) = ?', [$normalized])
            ->first();

        if ($existing) {
            return $existing->id;
        }

        return AttributeValue::create([
            'attribute_id' => $attributeId,
            'value' => $value,
            'slug' => Str::slug($value),
        ])->id;
    }
}
