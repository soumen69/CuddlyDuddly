<?php

namespace App\Domain\Catalog\Bulk\Intelligence;

class CategoryAttributeContextBuilder
{
    public function build(array $unionAttributes, array $categories): array
    {
        $variant = [];
        $simple = [];
        $visual = [];

        foreach ($categories as $catId) {

            foreach ($unionAttributes as $attr) {

                if (!in_array($catId, $attr['required_in_categories'])) {
                    continue;
                }

                if ($attr['is_variant']) {
                    $variant[$catId][] = $attr['id'];
                } elseif ($attr['is_visual']) {
                    $visual[$catId][] = $attr['id'];
                } else {
                    $simple[$catId][] = $attr['id'];
                }
            }
        }

        return [
            'variant' => $variant,
            'simple' => $simple,
            'visual' => $visual,
        ];
    }
}
