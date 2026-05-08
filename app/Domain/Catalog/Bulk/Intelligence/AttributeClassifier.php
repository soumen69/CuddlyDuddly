<?php

namespace App\Domain\Catalog\Bulk\Intelligence;

class AttributeClassifier
{
    public function classify(array $union): array
    {
        $variant = [];
        $visual = [];
        $simple = [];

        foreach ($union as $attr) {

            if ($attr['is_variant']) {
                $variant[] = $attr['id'];
            }

            if ($attr['is_visual']) {
                $visual[] = $attr['id'];
            }

            if (!$attr['is_variant'] && !$attr['is_visual']) {
                $simple[] = $attr['id'];
            }
        }

        return [
            'variant' => $variant,
            'visual' => $visual,
            'simple' => $simple,
        ];
    }
}
