<?php

namespace App\Domain\Catalog\Bulk\Validation;

use App\Domain\Catalog\Bulk\DTO\TemplateConfigDTO;

class BulkValidationEngine
{
    protected BulkConflictResolver $conflicts;

    public function __construct(
        BulkConflictResolver $conflicts
    ) {
        $this->conflicts = $conflicts;
    }

    public function validate(
        array $compiled,
        TemplateConfigDTO $dto
    ): array {

        $errors = [];

        $seenGroupCodes = [];

        foreach ($compiled['products'] as $family) {

            $product =
                $family['product'];

            $groupCode =
                $product['group_code'];

            if (
                isset($seenGroupCodes[$groupCode])
            ) {

                $errors[] = $this->error(
                    $groupCode,
                    'Duplicate group_code inside upload.'
                );

                continue;
            }

            $seenGroupCodes[$groupCode] = true;

            /*
            |--------------------------------------------------------------------------
            | EXISTING SYSTEM GROUP CODE
            |--------------------------------------------------------------------------
            */

            if (
                $this->conflicts
                ->groupCodeExists($groupCode)
            ) {

                $errors[] = $this->error(
                    $groupCode,
                    'group_code already exists in catalog.'
                );
            }

            if (
                empty($product['name'])
            ) {

                $errors[] = $this->error(
                    $groupCode,
                    'Product name is required.'
                );
            }

            if (
                empty($product['category_id'])
            ) {

                $errors[] = $this->error(
                    $groupCode,
                    'Category resolution failed.'
                );
            }

            $variantKeys = [];

            foreach ($family['variants'] as $variant) {

                if (
                    isset(
                        $variantKeys[$variant['variant_key']]
                    )
                ) {

                    $errors[] = $this->error(
                        $groupCode,
                        'Duplicate variant combination detected.'
                    );

                    continue;
                }

                $variantKeys[$variant['variant_key']] = true;

                if (
                    $variant['price'] <= 0
                ) {

                    $errors[] = $this->error(
                        $groupCode,
                        'Variant price must be greater than zero.'
                    );
                }

                if (
                    $variant['stock'] < 0
                ) {

                    $errors[] = $this->error(
                        $groupCode,
                        'Variant stock cannot be negative.'
                    );
                }

                if (
                    empty($variant['variant_attribute_value_ids'])
                    &&
                    count($family['variants']) > 1
                ) {

                    $errors[] = $this->error(
                        $groupCode,
                        'Variant attribute combination missing.'
                    );
                }
            }
            // if (
            //     $dto->brandMode === 'multiple'
            //     &&
            //     empty($product['brand_id'])
            // ) {

            //     $errors[] = $this->error(
            //         $groupCode,
            //         'Brand is required.'
            //     );
            // }
        }

        return $errors;
    }

    protected function error(
        string $groupCode,
        string $message
    ): array {

        return [

            'group_code' => $groupCode,

            'message' => $message,
        ];
    }
}
