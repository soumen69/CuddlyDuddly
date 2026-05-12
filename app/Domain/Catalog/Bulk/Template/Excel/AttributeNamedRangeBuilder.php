<?php

namespace App\Domain\Catalog\Bulk\Template\Excel;

use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class AttributeNamedRangeBuilder
{
    public function build($spreadsheet, $dto)
    {
        $sheet = $spreadsheet->getSheetByName('MASTER');

        $colIndex = 20; // after category + subcategory zones

        foreach ($dto->unionAttributes as $attrId => $attr) {

            if (empty($attr['values'])) continue;

            $rangeName = 'ATTR_' . $attrId;

            $colLetter = Coordinate::stringFromColumnIndex($colIndex);

            $row = 2;

            foreach ($attr['values'] as $value) {
                $sheet->setCellValue("{$colLetter}{$row}", $value);
                $row++;
            }

            $spreadsheet->addNamedRange(
                new NamedRange(
                    $rangeName,
                    $sheet,
                    'MASTER!$' . $colLetter . '$2:$' . $colLetter . '$' . ($row - 1)
                )
            );

            $colIndex++;
        }
    }

    
    // protected function safeRange($name)
    // {
    //     $name = preg_replace('/[^A-Za-z0-9]/', '_', $name);
    //     return substr($name, 0, 50);
    // }
}
