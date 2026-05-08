<?php

namespace App\Domain\Catalog\Bulk\Template\Excel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use App\Domain\Catalog\Bulk\DTO\TemplateConfigDTO;

class ExcelWorkbookAssembler
{
    protected const MAX_SHEET_TITLE_LENGTH = 31;

    public function build(
        array $schema,
        TemplateConfigDTO $dto
    ): Spreadsheet {

        $spreadsheet = new Spreadsheet();

        $spreadsheet->removeSheetByIndex(0);

        $masterSheet = new Worksheet(
            $spreadsheet,
            'MASTER'
        );

        $spreadsheet->addSheet($masterSheet);

        foreach ($schema as $sheetName => $config) {
            if (strtolower($sheetName) === 'master') {
                continue;
            }
            if (!($config['exists'] ?? false)) {
                continue;
            }

            $sheet = new Worksheet(
                $spreadsheet,
                $this->sanitizeSheetTitle(
                    $config['title'] ?? $sheetName
                )
            );

            $spreadsheet->addSheet($sheet);

            if (!empty($config['columns'])) {

                $this->writeHeader(
                    $sheet,
                    $config['columns']
                );

                $this->prepareRows(
                    $sheet,
                    count($config['columns']),
                    $this->resolveRowCount($dto)
                );
            }
        }

        return $spreadsheet;
    }

    protected function writeHeader(
        Worksheet $sheet,
        array $columns
    ): void {

        foreach ($columns as $index => $column) {

            $sheet->setCellValueByColumnAndRow(
                $index + 1,
                1,
                $this->formatHeader($column)
            );
        }
    }

    protected function prepareRows(
        Worksheet $sheet,
        int $columnCount,
        int $rowCount
    ): void {


        for ($row = 2; $row <= ($rowCount + 1); $row++) {
            for ($col = 1; $col <= $columnCount; $col++) {
                $sheet->setCellValueByColumnAndRow(
                    $col,
                    $row,
                    ''
                );
            }
        }
    }

    protected function resolveRowCount(
        TemplateConfigDTO $dto
    ): int {

        return match (true) {

            $dto->volume <= 100   => 100,

            $dto->volume <= 500   => 500,

            $dto->volume <= 2000  => 2000,

            default               => 5000,
        };
    }


    protected function sanitizeSheetTitle(
        string $title
    ): string {

        $title = preg_replace(
            '/[\\\\\\/\\?\\*\\[\\]\\:]/',
            '',
            $title
        );

        $title = trim(
            preg_replace('/\\s+/', ' ', $title)
        );

        return mb_substr(
            $title,
            0,
            self::MAX_SHEET_TITLE_LENGTH
        );
    }

    protected function formatHeader(
        string $header
    ): string {

        return ucwords(
            str_replace('_', ' ', $header)
        );
    }
}
