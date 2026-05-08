<?php

namespace App\Domain\Catalog\Bulk\Template\Excel;

use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Domain\Catalog\Bulk\DTO\TemplateConfigDTO;

class NamedRangeRegistrar
{
    public function registerAttributeRanges(
        $spreadsheet,
        TemplateConfigDTO $dto
    ): void {

        $sheet = $spreadsheet->getSheetByName('MASTER');

        if (!$sheet instanceof Worksheet) {

            throw new \RuntimeException(
                'MASTER sheet not found.'
            );
        }

        $currentRow = 2;

        foreach ($dto->unionAttributes as $attributeId => $attribute) {
            if (
                empty($attribute['values'])
            ) {
                continue;
            }

            $startRow = $currentRow;

            foreach ($attribute['values'] as $valueId => $valueLabel) {

                $sheet->setCellValue(
                    'B' . $currentRow,
                    $valueLabel
                );

                $currentRow++;
            }

            $endRow = $currentRow - 1;

            $rangeName = 'ATTR_' . $attributeId;

            $spreadsheet->addNamedRange(

                new NamedRange(

                    $rangeName,

                    $sheet,

                    'MASTER!$B$' .
                        $startRow .
                        ':$B$' .
                        $endRow
                )
            );

            $currentRow++;
        }

        $this->registerBrandRange(
            $spreadsheet,
            $dto,
            $currentRow
        );

        $this->registerSubcategoryRanges(
            $spreadsheet,
            $dto,
            $currentRow
        );
    }

    protected function registerSubcategoryRanges(
        $spreadsheet,
        TemplateConfigDTO $dto,
        int &$currentRow
    ): void {

        $sheet = $spreadsheet->getSheetByName(
            'MASTER'
        );

        foreach (
            $dto->categorySubcategoryMap
            as $categoryId => $subcategories
        ) {

            if (empty($subcategories)) {
                continue;
            }

            $startRow = $currentRow;

            foreach ($subcategories as $subName) {

                $sheet->setCellValue(
                    'F' . $currentRow,
                    $subName
                );

                $currentRow++;
            }

            $endRow = $currentRow - 1;

            $spreadsheet->addNamedRange(

                new NamedRange(

                    'SUBCATEGORY_' . $categoryId,

                    $sheet,

                    'MASTER!$F$' .
                        $startRow .
                        ':$F$' .
                        $endRow
                )
            );

            $currentRow++;
        }
    }


    protected function registerBrandRange(
        $spreadsheet,
        TemplateConfigDTO $dto,
        int &$currentRow
    ): void {

        if (empty($dto->brandMap)) {
            return;
        }

        $sheet = $spreadsheet->getSheetByName(
            'MASTER'
        );

        $startRow = $currentRow;

        foreach ($dto->brandMap as $brandName) {

            $sheet->setCellValue(
                'D' . $currentRow,
                $brandName
            );

            $currentRow++;
        }

        $endRow = $currentRow - 1;

        $spreadsheet->addNamedRange(

            new NamedRange(

                'BRANDS',

                $sheet,

                'MASTER!$D$' .
                    $startRow .
                    ':$D$' .
                    $endRow
            )
        );

        $currentRow++;
    }
}
