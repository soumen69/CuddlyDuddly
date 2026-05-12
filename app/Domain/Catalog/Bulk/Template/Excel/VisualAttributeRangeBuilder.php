<?php

namespace App\Domain\Catalog\Bulk\Template\Excel;

use PhpOffice\PhpSpreadsheet\NamedRange;

class VisualAttributeRangeBuilder
{
    public function build($spreadsheet, $dto)
    {
        if (!$dto->visualPossible) return;

        $sheet = $spreadsheet->getSheetByName('MASTER');

        $sheet->setCellValue('Z1', 'VISUAL_VALUES');

        $row = 2;

        foreach ($dto->visualAttributes as $attrId) {

            $values = $dto->attributeValueMap[$attrId] ?? [];

            foreach ($values as $value) {
                $sheet->setCellValue("Z{$row}", $value);
                $row++;
            }
        }

        $spreadsheet->addNamedRange(
            new NamedRange(
                "VISUAL_VALUES",
                $sheet,
                "Z2:Z" . ($row - 1)
            )
        );
    }
}
