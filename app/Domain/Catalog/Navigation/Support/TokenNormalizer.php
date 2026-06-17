<?php

namespace App\Domain\Catalog\Navigation\Support;

class TokenNormalizer
{
    /**
     * Convert text into normalized searchable tokens.
     */
    public function tokens(?string $value): array
    {
        if (blank($value)) {
            return [];
        }

        $normalized = $this->normalize($value);

        $tokens = preg_split('/\s+/', $normalized) ?: [];

        $tokens = array_filter($tokens);

        return array_values(array_unique($tokens));
    }

    /**
     * Normalize a text value into a deterministic form.
     */
    public function normalize(?string $value): string
    {
        if (blank($value)) {
            return '';
        }

        $value = mb_strtolower($value);

        /*
         |--------------------------------------------------------------------------
         | Standard Separators
         |--------------------------------------------------------------------------
         */

        $value = str_replace(
            ['&', '/', '\\', '-', '_', ',', '.', '(', ')'],
            ' ',
            $value
        );

        /*
         |--------------------------------------------------------------------------
         | Collapse Spaces
         |--------------------------------------------------------------------------
         */

        $value = preg_replace('/\s+/', ' ', $value);

        $value = trim($value);

        return $value;
    }

    /**
     * Generate comparable forms.
     *
     * Examples:
     *
     * T-Shirt
     * T Shirt
     * TShirt
     * T-Shirts
     *
     * become:
     *
     * tshirt
     */
    public function canonical(?string $value): string
    {
        $normalized = $this->normalize($value);

        $normalized = str_replace(' ', '', $normalized);

        /*
         |--------------------------------------------------------------------------
         | Basic plural normalization
         |--------------------------------------------------------------------------
         */

        $normalized = preg_replace('/ies$/', 'y', $normalized);
        $normalized = preg_replace('/s$/', '', $normalized);

        return $normalized;
    }

    /**
     * Produce a set of comparable forms.
     */
    public function variants(?string $value): array
    {
        if (blank($value)) {
            return [];
        }

        $normalized = $this->normalize($value);

        return array_values(array_unique([
            $normalized,
            $this->canonical($normalized),
        ]));
    }
}
