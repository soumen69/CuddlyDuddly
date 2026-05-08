<?php

namespace App\Domain\Catalog\Bulk\Parser;

use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelBulkRowParser
{
    protected array $ignoredSheets = [
        'Guide',
        'MASTER',
    ];

    public function parse(
        string $filePath
    ): Collection {

        $spreadsheet = IOFactory::load(
            $filePath
        );

        $rows = collect();

        foreach (
            $spreadsheet->getWorksheetIterator()
            as $sheet
        ) {

            $sheetName = trim(
                $sheet->getTitle()
            );

            if (
                in_array(
                    $sheetName,
                    $this->ignoredSheets
                )
            ) {
                continue;
            }

            $parsedRows = $this->parseSheet(
                $sheet
            );

            foreach ($parsedRows as $row) {

                $row['_sheet'] = $this->normalizeSheetKey(
                    $sheetName
                );
                $rows->push($row);
            }
        }

        return $rows;
    }

    public function extractTemplateConfig(
        string $filePath
    ): array {

        $spreadsheet = IOFactory::load(
            $filePath
        );

        $sheet = $spreadsheet
            ->getSheetByName('MASTER');

        if (!$sheet) {

            throw new \Exception(
                'MASTER sheet missing.'
            );
        }

        $encoded = $sheet->getCell('ZZ1')
            ->getValue();

        if (!$encoded) {

            throw new \Exception(
                'Template configuration missing.'
            );
        }

        return json_decode(
            base64_decode($encoded),
            true
        );
    }

    protected function normalizeSheetKey(
        string $sheet
    ): string {

        return preg_replace(
            '/[^a-z0-9]+/',
            '_',
            mb_strtolower(trim($sheet))
        );
    }

    protected function parseSheet(
        $sheet
    ): Collection {

        $rows = $sheet->toArray(
            null,
            true,
            true,
            true
        );

        if (count($rows) <= 1) {
            return collect();
        }

        $header = array_shift($rows);

        $header = array_map(

            fn($value) => $this->normalizeHeader(
                $value
            ),

            $header
        );

        $mapped = [];

        foreach ($rows as $row) {

            if (
                $this->isEmptyRow($row)
            ) {
                continue;
            }

            $mappedRow = [];

            foreach (
                $header as $column => $columnName
            ) {

                if (!$columnName) {
                    continue;
                }

                $mappedRow[$columnName] = trim(
                    (string) (
                        $row[$column] ?? ''
                    )
                );
            }

            $mapped[] = $mappedRow;
        }

        return collect($mapped);
    }

    protected function normalizeHeader(
        ?string $header
    ): ?string {

        if (!$header) {
            return null;
        }

        $header = mb_strtolower(
            trim($header)
        );

        $header = preg_replace(
            '/[^a-z0-9]+/',
            '_',
            $header
        );

        return trim(
            $header,
            '_'
        );
    }

    protected function isEmptyRow(
        array $row
    ): bool {

        foreach ($row as $cell) {

            if (
                trim((string) $cell) !== ''
            ) {
                return false;
            }
        }

        return true;
    }
}
