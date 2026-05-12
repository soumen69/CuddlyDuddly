<?php

namespace App\Domain\Catalog\Bulk\Template\Excel;

use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class AttributeDropdownInjectionEngine
{
    public function inject($spreadsheet, $dto, $schema)
    {
        $this->injectProductsAttributes($spreadsheet, $dto, $schema);

        if ($dto->variantMode === 'variant') {
            $this->injectVariantAttributes($spreadsheet, $dto, $schema);
        }
    }

    protected function injectProductsAttributes($spreadsheet, $dto, $schema)
    {
        $sheet = $spreadsheet->getSheetByName('Products');

        $columns = $schema['products']['columns'];
        $maxRows = $dto->volume + 1;

        foreach ($dto->simpleAttributes as $attrId) {

            $attrName = $dto->unionAttributes[$attrId]['name'];
            $colIndex = array_search($attrName, $columns) + 1;

            $this->applyAttributeDropdown($sheet, $colIndex, $maxRows, $attrId);
        }

        if ($dto->variantMode === 'simple') {

            foreach ($dto->variantAttributes as $attrId) {

                $attrName = $dto->unionAttributes[$attrId]['name'];
                $colIndex = array_search($attrName, $columns) + 1;

                $this->applyAttributeDropdown($sheet, $colIndex, $maxRows, $attrId);
            }
        }
    }

    protected function injectVariantAttributes($spreadsheet, $dto, $schema)
    {
        $sheet = $spreadsheet->getSheetByName('Variants');

        $columns = $schema['variants']['columns'];
        $maxRows = ($dto->volume * 10) + 1;

        foreach ($dto->variantAttributes as $attrId) {

            $attrName = $dto->unionAttributes[$attrId]['name'];

            $pos = array_search($attrName, $columns);
            if ($pos === false) continue;
            $colIndex = $pos + 1;

            $this->applyAttributeDropdown($sheet, $colIndex, $maxRows, $attrId);
        }
    }

    protected function applyAttributeDropdown($sheet, $colIndex, $maxRows, $attrId)
    {
        $colLetter = Coordinate::stringFromColumnIndex($colIndex);

        for ($row = 2; $row <= $maxRows; $row++) {

            $validation = $sheet->getCell($colLetter . $row)->getDataValidation();

            $validation->setType(DataValidation::TYPE_LIST);
            $validation->setAllowBlank(true);
            $validation->setShowDropDown(true);
            $validation->setFormula1('ATTR_' . $attrId);
        }
    }
}
