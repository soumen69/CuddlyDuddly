<?php

namespace App\Domain\Catalog\Bulk\Template\Excel;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

use App\Domain\Catalog\Bulk\DTO\TemplateConfigDTO;

class DropdownInjectionEngine
{
    public function inject(
        $spreadsheet,
        TemplateConfigDTO $dto,
        array $schema
    ): void {

        foreach ($schema as $sheetName => $config) {

            if (!($config['exists'] ?? false)) {
                continue;
            }

            if ($sheetName === 'master') {
                continue;
            }

            $sheetTitle = $config['title'] ?? $sheetName;

            $sheet = $spreadsheet->getSheetByName(
                $sheetTitle
            );

            if (!$sheet) {
                continue;
            }

            $this->applySheetDropdowns(
                $sheet,
                $dto,
                $config
            );
        }
    }

    protected function applyBrandDropdown(
        Worksheet $sheet,
        TemplateConfigDTO $dto,
        int $maxRows
    ): void {

        if ($dto->brandMode !== 'multiple') {
            return;
        }

        $column = $this->findColumnIndex(
            $sheet,
            'brand'
        );

        if (!$column) {
            return;
        }

        for ($row = 2; $row <= $maxRows; $row++) {

            $validation = $sheet
                ->getCell($column . $row)
                ->getDataValidation();

            $validation->setType(
                DataValidation::TYPE_LIST
            );

            $validation->setAllowBlank(true);
            $validation->setShowDropDown(true);
            $validation->setShowErrorMessage(true);
            $validation->setFormula1(
                '=BRANDS'
            );
        }
    }

    protected function applySheetDropdowns(
        Worksheet $sheet,
        TemplateConfigDTO $dto,
        array $config
    ): void {

        $maxRows = $dto->volume + 1;

        foreach ($dto->unionAttributes as $attributeId => $attribute) {

            if (
                !isset($attribute['values']) ||
                empty($attribute['values'])
            ) {
                continue;
            }

            $column = $this->findColumnIndex(
                $sheet,
                $attribute['name']
            );

            if (!$column) {
                continue;
            }

            $rangeName = 'ATTR_' . $attributeId;

            for ($row = 2; $row <= $maxRows; $row++) {

                $validation = $sheet
                    ->getCell($column . $row)
                    ->getDataValidation();

                $validation->setType(
                    DataValidation::TYPE_LIST
                );

                $validation->setAllowBlank(true);

                $validation->setShowDropDown(true);

                $validation->setShowInputMessage(true);

                $validation->setShowErrorMessage(true);

                $validation->setErrorStyle(
                    DataValidation::STYLE_STOP
                );

                $validation->setErrorTitle(
                    'Invalid Value'
                );

                $validation->setError(
                    'Please select a value from the dropdown list.'
                );

                $validation->setFormula1(
                    '=' . $rangeName
                );
            }
        }

        $this->applyStatusDropdown(
            $sheet,
            $maxRows
        );

        $this->applyBrandDropdown(
            $sheet,
            $dto,
            $maxRows
        );

        $this->applySubcategoryDropdown(
            $sheet,
            $config,
            $maxRows
        );
    }

    protected function applySubcategoryDropdown(
        Worksheet $sheet,
        array $config,
        int $maxRows
    ): void {

        $column = $this->findColumnIndex(
            $sheet,
            'subcategory'
        );

        if (!$column) {
            return;
        }

        $categoryId = $config['category_id'];

        $rangeName = 'SUBCATEGORY_' . $categoryId;

        for ($row = 2; $row <= $maxRows; $row++) {

            $validation = $sheet
                ->getCell($column . $row)
                ->getDataValidation();

            $validation->setType(
                DataValidation::TYPE_LIST
            );

            $validation->setAllowBlank(false);

            $validation->setShowDropDown(true);

            $validation->setShowErrorMessage(true);

            $validation->setFormula1(
                '=' . $rangeName
            );
        }
    }

    protected function applyStatusDropdown(
        Worksheet $sheet,
        int $maxRows
    ): void {

        $column = $this->findColumnIndex(
            $sheet,
            'status'
        );

        if (!$column) {
            return;
        }

        for ($row = 2; $row <= $maxRows; $row++) {

            $validation = $sheet
                ->getCell($column . $row)
                ->getDataValidation();

            $validation->setType(
                DataValidation::TYPE_LIST
            );

            $validation->setAllowBlank(false);

            $validation->setShowDropDown(true);

            $validation->setShowErrorMessage(true);

            $validation->setFormula1(
                '"active,inactive"'
            );
        }
    }

    protected function findColumnIndex(
        Worksheet $sheet,
        string $columnName
    ): ?string {

        $highestColumn = $sheet->getHighestColumn();

        $highestIndex = Coordinate::columnIndexFromString(
            $highestColumn
        );

        for ($i = 1; $i <= $highestIndex; $i++) {

            $value = $sheet
                ->getCellByColumnAndRow($i, 1)
                ->getValue();

            if (
                strtolower(trim($value)) ===
                strtolower(trim($columnName))
            ) {

                return Coordinate::stringFromColumnIndex($i);
            }
        }

        return null;
    }
}
