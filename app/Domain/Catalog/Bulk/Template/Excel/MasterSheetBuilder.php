<?php

namespace App\Domain\Catalog\Bulk\Template\Excel;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use App\Domain\Catalog\Bulk\DTO\TemplateConfigDTO;

class MasterSheetBuilder
{
    public function build(
        $spreadsheet,
        TemplateConfigDTO $dto
    ): void {

        $sheet = $spreadsheet->getSheetByName('MASTER');

        if (!$sheet) {

            throw new \RuntimeException(
                'MASTER sheet not found.'
            );
        }

        $sheet->setCellValue('A1', 'ATTRIBUTE');
        $sheet->setCellValue('B1', 'VALUE');

        $this->writeAttributeValues(
            $sheet,
            $dto
        );

        $this->writeTemplateConfig(
            $sheet,
            $dto
        );

        $sheet->setSheetState(
            Worksheet::SHEETSTATE_HIDDEN
        );
    }

    protected function writeTemplateConfig(
        Worksheet $sheet,
        TemplateConfigDTO $dto
    ): void {

        $sheet->setCellValue(
            'ZZ1',
            base64_encode(json_encode([
                'categories' => $dto->categories,
                'subcategories' => $dto->subcategories,
                'brand_mode' => $dto->brandMode,
                'brand_id' => $dto->brandId,
                'volume' => $dto->volume,
            ]))
        );
    }

    protected function writeAttributeValues(
        Worksheet $sheet,
        TemplateConfigDTO $dto
    ): void {

        $row = 2;

        foreach ($dto->unionAttributes as $attributeId => $attribute) {

            if (
                empty($attribute['values'])
            ) {
                continue;
            }

            foreach ($attribute['values'] as $valueId => $valueLabel) {

                $sheet->setCellValue(
                    'A' . $row,
                    $attribute['name']
                );

                $sheet->setCellValue(
                    'B' . $row,
                    $valueLabel
                );

                $row++;
            }
            $row++;
        }
    }
}
