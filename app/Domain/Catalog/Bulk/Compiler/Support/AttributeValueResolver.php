<?php

namespace App\Domain\Catalog\Bulk\Compiler\Support;

use App\Domain\Catalog\Bulk\DTO\TemplateConfigDTO;

class AttributeValueResolver
{

    protected array $index = [];

    public function __construct(
        TemplateConfigDTO $dto
    ) {

        foreach (
            $dto->attributeValueMap
            as $attributeId => $values
        ) {

            foreach ($values as $valueId => $text) {

                $normalized =
                    $this->normalize($text);

                $this->index[$attributeId][$normalized]
                    = $valueId;
            }
        }
    }

    public function resolve(
        int $attributeId,
        ?string $value
    ): ?int {

        if (!$value) {
            return null;
        }

        return $this->index[$attributeId][$this->normalize($value)]
            ?? null;
    }
    protected function normalize(
        string $value
    ): string {

        $value = trim($value);

        $value = preg_replace(
            '/\s+/',
            ' ',
            $value
        );
        return mb_strtolower($value);
    }
}
