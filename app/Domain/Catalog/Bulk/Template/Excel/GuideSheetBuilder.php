<?php

namespace App\Domain\Catalog\Bulk\Template\Excel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

use App\Domain\Catalog\Bulk\DTO\TemplateConfigDTO;

class GuideSheetBuilder
{
    public function build(
        Spreadsheet $spreadsheet,
        TemplateConfigDTO $dto
    ): void {

        $sheet = $spreadsheet->createSheet(0);

        $sheet->setTitle('Guide');

        $this->layout($sheet);

        $row = 1;

        /*
        |--------------------------------------------------------------------------
        | TITLE
        |--------------------------------------------------------------------------
        */

        $this->title(
            $sheet,
            $row,
            '📦 BULK CATALOG UPLOAD GUIDE'
        );

        $row += 3;

        /*
        |--------------------------------------------------------------------------
        | STEPS
        |--------------------------------------------------------------------------
        */

        $row = $this->stepOverview(
            $sheet,
            $row,
            $dto
        );

        $row = $this->stepDomainSheets(
            $sheet,
            $row,
            $dto
        );

        $row = $this->stepVariants(
            $sheet,
            $row
        );

        $row = $this->stepAttributes(
            $sheet,
            $row
        );

        $row = $this->stepRules(
            $sheet,
            $row,
            $dto
        );

        /*
        |--------------------------------------------------------------------------
        | DEFAULT ACTIVE SHEET
        |--------------------------------------------------------------------------
        */

        $spreadsheet->setActiveSheetIndexByName(
            'Guide'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LAYOUT
    |--------------------------------------------------------------------------
    */

    protected function layout($sheet): void
    {
        $sheet->getColumnDimension('A')
            ->setWidth(120);

        $sheet->getStyle('A:A')
            ->getAlignment()
            ->setWrapText(true);
    }

    /*
    |--------------------------------------------------------------------------
    | TITLE
    |--------------------------------------------------------------------------
    */

    protected function title(
        $sheet,
        int $row,
        string $text
    ): void {

        $sheet->setCellValue(
            "A{$row}",
            $text
        );

        $sheet->getStyle("A{$row}")
            ->getFont()
            ->setBold(true)
            ->setSize(22);

        $sheet->getStyle("A{$row}")
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SECTION HEADER
    |--------------------------------------------------------------------------
    */

    protected function section(
        $sheet,
        int $row,
        string $text
    ): int {

        $sheet->setCellValue(
            "A{$row}",
            $text
        );

        $sheet->getStyle("A{$row}")
            ->getFont()
            ->setBold(true)
            ->setSize(14);

        $sheet->getStyle("A{$row}")
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('D9EAF7');

        return $row + 1;
    }

    /*
    |--------------------------------------------------------------------------
    | CONTENT BOX
    |--------------------------------------------------------------------------
    */

    protected function box(
        $sheet,
        int $row,
        string $text
    ): int {

        $sheet->setCellValue(
            "A{$row}",
            $text
        );

        $sheet->getStyle("A{$row}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        return $row + 1;
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 1 — OVERVIEW
    |--------------------------------------------------------------------------
    */

    protected function stepOverview(
        $sheet,
        int $row,
        TemplateConfigDTO $dto
    ): int {

        $row = $this->section(
            $sheet,
            $row,
            'STEP 1 — UNDERSTAND THE TEMPLATE'
        );

        $row = $this->box(
            $sheet,
            $row,
            'This template is divided into category-specific sheets.'
        );

        $row = $this->box(
            $sheet,
            $row,
            'Each sheet is designed for a specific product domain like Clothing, Toys or Feeding.'
        );

        $row = $this->box(
            $sheet,
            $row,
            'Only fill products in their relevant category sheet.'
        );

        return $row + 2;
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 2 — DOMAIN SHEETS
    |--------------------------------------------------------------------------
    */

    protected function stepDomainSheets(
        $sheet,
        int $row,
        TemplateConfigDTO $dto
    ): int {

        $row = $this->section(
            $sheet,
            $row,
            'STEP 2 — CATEGORY SHEETS'
        );

        foreach ($dto->categoryNameMap as $name) {

            $row = $this->box(
                $sheet,
                $row,
                "• {$name} Sheet → Fill only {$name} related products."
            );
        }

        return $row + 2;
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 3 — VARIANTS
    |--------------------------------------------------------------------------
    */

    protected function stepVariants(
        $sheet,
        int $row
    ): int {

        $row = $this->section(
            $sheet,
            $row,
            'STEP 3 — VARIANT PRODUCTS'
        );

        $row = $this->box(
            $sheet,
            $row,
            'Variant products like different Size or Color should be entered as separate rows using the same group_code.'
        );

        $row = $this->box(
            $sheet,
            $row,
            'Example: Same T-Shirt with different Size or Color = same group_code.'
        );

        $row = $this->box(
            $sheet,
            $row,
            'Each row represents one purchasable variation.'
        );

        return $row + 2;
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 4 — ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    protected function stepAttributes(
        $sheet,
        int $row
    ): int {

        $row = $this->section(
            $sheet,
            $row,
            'STEP 4 — ATTRIBUTES & DROPDOWNS'
        );

        $row = $this->box(
            $sheet,
            $row,
            'Always select dropdown values wherever available.'
        );

        $row = $this->box(
            $sheet,
            $row,
            'Do not manually type custom values unless the field allows free text.'
        );

        $row = $this->box(
            $sheet,
            $row,
            'Required fields should never be left empty.'
        );

        return $row + 2;
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 5 — RULES
    |--------------------------------------------------------------------------
    */

    protected function stepRules(
        $sheet,
        int $row,
        TemplateConfigDTO $dto
    ): int {

        $row = $this->section(
            $sheet,
            $row,
            'STEP 5 — IMPORTANT RULES'
        );

        $row = $this->box(
            $sheet,
            $row,
            'Do not rename columns.'
        );

        $row = $this->box(
            $sheet,
            $row,
            'Do not delete sheets.'
        );

        $row = $this->box(
            $sheet,
            $row,
            'Do not insert extra header rows.'
        );

        $row = $this->box(
            $sheet,
            $row,
            'Do not leave completely blank rows between products.'
        );

        $row = $this->box(
            $sheet,
            $row,
            "Maximum upload volume configured: {$dto->volume}"
        );

        $row = $this->box(
            $sheet,
            $row,
            'Product images will be uploaded separately after catalog import.'
        );

        return $row;
    }
}
