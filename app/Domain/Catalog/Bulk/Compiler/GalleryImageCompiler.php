<?php

namespace App\Domain\Catalog\Bulk\Compiler;

class GalleryImageCompiler
{
    public function compile(array $rows): array
    {
        $map = [];

        foreach ($rows as $row) {

            $map[$row['product_code']][] = [
                'image_url' => $row['image_url'],
                'is_primary' => (bool)$row['is_primary'],
                'sort_order' => (int)$row['sort_order'],
            ];
        }

        return $map;
    }
}
