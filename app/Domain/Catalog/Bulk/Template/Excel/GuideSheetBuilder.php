<?php

namespace App\Domain\Catalog\Bulk\Template\Excel;

// use PhpOffice\PhpSpreadsheet\Spreadsheet;

// use PhpOffice\PhpSpreadsheet\Style\Alignment;
// use PhpOffice\PhpSpreadsheet\Style\Border;
// use PhpOffice\PhpSpreadsheet\Style\Fill;

// use App\Domain\Catalog\Bulk\DTO\TemplateConfigDTO;

// class GuideSheetBuilder
// {
//     public function build(
//         Spreadsheet $spreadsheet,
//         TemplateConfigDTO $dto
//     ): void {

//         $sheet = $spreadsheet->createSheet(0);

//         $sheet->setTitle('Guide');

//         $this->layout($sheet);

//         $row = 1;

//         $this->title(
//             $sheet,
//             $row,
//             '📦 BULK CATALOG UPLOAD GUIDE'
//         );

//         $row += 3;

//         $row = $this->stepOverview(
//             $sheet,
//             $row,
//             $dto
//         );

//         $row = $this->stepDomainSheets(
//             $sheet,
//             $row,
//             $dto
//         );

//         $row = $this->stepVariants(
//             $sheet,
//             $row
//         );

//         $row = $this->stepAttributes(
//             $sheet,
//             $row
//         );

//         $row = $this->stepRules(
//             $sheet,
//             $row,
//             $dto
//         );

//         $spreadsheet->setActiveSheetIndexByName(
//             'Guide'
//         );
//     }

//     protected function layout($sheet): void
//     {
//         $sheet->getColumnDimension('A')
//             ->setWidth(120);

//         $sheet->getStyle('A:A')
//             ->getAlignment()
//             ->setWrapText(true);
//     }

//     protected function title(
//         $sheet,
//         int $row,
//         string $text
//     ): void {

//         $sheet->setCellValue(
//             "A{$row}",
//             $text
//         );

//         $sheet->getStyle("A{$row}")
//             ->getFont()
//             ->setBold(true)
//             ->setSize(22);

//         $sheet->getStyle("A{$row}")
//             ->getAlignment()
//             ->setHorizontal(
//                 Alignment::HORIZONTAL_CENTER
//             );
//     }

//     protected function section(
//         $sheet,
//         int $row,
//         string $text
//     ): int {

//         $sheet->setCellValue(
//             "A{$row}",
//             $text
//         );

//         $sheet->getStyle("A{$row}")
//             ->getFont()
//             ->setBold(true)
//             ->setSize(14);

//         $sheet->getStyle("A{$row}")
//             ->getFill()
//             ->setFillType(Fill::FILL_SOLID)
//             ->getStartColor()
//             ->setRGB('D9EAF7');

//         return $row + 1;
//     }

//     protected function box(
//         $sheet,
//         int $row,
//         string $text
//     ): int {

//         $sheet->setCellValue(
//             "A{$row}",
//             $text
//         );

//         $sheet->getStyle("A{$row}")
//             ->getBorders()
//             ->getAllBorders()
//             ->setBorderStyle(Border::BORDER_THIN);

//         return $row + 1;
//     }

//     protected function stepOverview(
//         $sheet,
//         int $row,
//         TemplateConfigDTO $dto
//     ): int {

//         $row = $this->section(
//             $sheet,
//             $row,
//             'STEP 1 — UNDERSTAND THE TEMPLATE'
//         );

//         $row = $this->box(
//             $sheet,
//             $row,
//             'This template is divided into category-specific sheets.'
//         );

//         $row = $this->box(
//             $sheet,
//             $row,
//             'Each sheet is designed for a specific product domain like Clothing, Toys or Feeding.'
//         );

//         $row = $this->box(
//             $sheet,
//             $row,
//             'Only fill products in their relevant category sheet.'
//         );

//         return $row + 2;
//     }


//     protected function stepDomainSheets(
//         $sheet,
//         int $row,
//         TemplateConfigDTO $dto
//     ): int {

//         $row = $this->section(
//             $sheet,
//             $row,
//             'STEP 2 — CATEGORY SHEETS'
//         );

//         foreach ($dto->categoryNameMap as $name) {

//             $row = $this->box(
//                 $sheet,
//                 $row,
//                 "• {$name} Sheet → Fill only {$name} related products."
//             );
//         }

//         return $row + 2;
//     }

//     protected function stepVariants(
//         $sheet,
//         int $row
//     ): int {

//         $row = $this->section(
//             $sheet,
//             $row,
//             'STEP 3 — VARIANT PRODUCTS'
//         );

//         $row = $this->box(
//             $sheet,
//             $row,
//             'Variant products like different Size or Color should be entered as separate rows using the same group_code.'
//         );

//         $row = $this->box(
//             $sheet,
//             $row,
//             'Example: Same T-Shirt with different Size or Color = same group_code.'
//         );

//         $row = $this->box(
//             $sheet,
//             $row,
//             'Each row represents one purchasable variation.'
//         );

//         return $row + 2;
//     }

//     protected function stepAttributes(
//         $sheet,
//         int $row
//     ): int {

//         $row = $this->section(
//             $sheet,
//             $row,
//             'STEP 4 — ATTRIBUTES & DROPDOWNS'
//         );

//         $row = $this->box(
//             $sheet,
//             $row,
//             'Always select dropdown values wherever available.'
//         );

//         $row = $this->box(
//             $sheet,
//             $row,
//             'Do not manually type custom values unless the field allows free text.'
//         );

//         $row = $this->box(
//             $sheet,
//             $row,
//             'Required fields should never be left empty.'
//         );

//         return $row + 2;
//     }


//     protected function stepRules(
//         $sheet,
//         int $row,
//         TemplateConfigDTO $dto
//     ): int {

//         $row = $this->section(
//             $sheet,
//             $row,
//             'STEP 5 — IMPORTANT RULES'
//         );

//         $row = $this->box(
//             $sheet,
//             $row,
//             'Do not rename columns.'
//         );

//         $row = $this->box(
//             $sheet,
//             $row,
//             'Do not delete sheets.'
//         );

//         $row = $this->box(
//             $sheet,
//             $row,
//             'Do not insert extra header rows.'
//         );

//         $row = $this->box(
//             $sheet,
//             $row,
//             'Do not leave completely blank rows between products.'
//         );

//         $row = $this->box(
//             $sheet,
//             $row,
//             "Maximum upload volume configured: {$dto->volume}"
//         );

//         $row = $this->box(
//             $sheet,
//             $row,
//             'Product images will be uploaded separately after catalog import.'
//         );

//         return $row;
//     }
// }


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

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

        $this->hero($sheet, $row);

        $row += 5;

        $row = $this->workflowSection($sheet, $row);

        $row = $this->sellableConceptSection($sheet, $row);

        $row = $this->groupCodeSection($sheet, $row);

        $row = $this->variantOptionSection($sheet, $row);

        $row = $this->categorySheetSection($sheet, $row, $dto);

        $row = $this->dropdownSection($sheet, $row);

        $row = $this->mistakeSection($sheet, $row);

        $row = $this->imageUploadSection($sheet, $row);

        $row = $this->finalRulesSection($sheet, $row, $dto);

        $spreadsheet->setActiveSheetIndexByName('Guide');
    }

    protected function layout($sheet): void
    {
        $sheet->getColumnDimension('A')->setWidth(35);
        $sheet->getColumnDimension('B')->setWidth(35);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(20);

        $sheet->getStyle('A:D')
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->freezePane('A2');

        $sheet->getDefaultRowDimension()->setRowHeight(24);
    }

    protected function hero($sheet, int $row): void
    {
        $sheet->mergeCells("A{$row}:D{$row}");
        $sheet->setCellValue(
            "A{$row}",
            '🛍 BULK PRODUCT CATALOG GUIDE'
        );

        $sheet->getStyle("A{$row}")
            ->getFont()
            ->setBold(true)
            ->setSize(24)
            ->getColor()
            ->setRGB('FFFFFF');

        $sheet->getStyle("A{$row}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("A{$row}")
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('FF6B6B');

        $subRow = $row + 1;

        $sheet->mergeCells("A{$subRow}:D{$subRow}");

        $sheet->setCellValue(
            "A{$subRow}",
            'Baby, Kids & Maternity Marketplace Catalog Upload Guide'
        );

        $sheet->getStyle("A{$subRow}")
            ->getFont()
            ->setSize(12)
            ->setItalic(true);

        $sheet->getStyle("A{$subRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    protected function sectionTitle($sheet, int $row, string $title): int
    {
        $sheet->mergeCells("A{$row}:D{$row}");

        $sheet->setCellValue("A{$row}", $title);

        $sheet->getStyle("A{$row}")
            ->getFont()
            ->setBold(true)
            ->setSize(14)
            ->getColor()
            ->setRGB('FFFFFF');

        $sheet->getStyle("A{$row}")
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('4E73DF');

        $sheet->getStyle("A{$row}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT);

        return $row + 1;
    }

    protected function infoBox(
        $sheet,
        int $row,
        string $text,
        string $color = 'F8F9FC'
    ): int {

        $sheet->mergeCells("A{$row}:D{$row}");

        $sheet->setCellValue("A{$row}", $text);

        $sheet->getStyle("A{$row}:D{$row}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $sheet->getStyle("A{$row}:D{$row}")
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB($color);

        return $row + 1;
    }

    protected function workflowSection($sheet, int $row): int
    {
        $row = $this->sectionTitle(
            $sheet,
            $row,
            'STEP-BY-STEP WORKFLOW'
        );

        $steps = [
            '1️⃣ Fill category sheets',
            '2️⃣ Upload catalog file',
            '3️⃣ Validate & approve catalog',
            '4️⃣ Commit products',
            '5️⃣ Upload product images',
        ];

        foreach ($steps as $step) {
            $row = $this->infoBox($sheet, $row, $step, 'E8F4FD');
        }

        $row = $this->infoBox(
            $sheet,
            $row,
            '📌 Product images are uploaded AFTER catalog approval and commit.',
            'FFF3CD'
        );

        return $row + 2;
    }

    protected function sellableConceptSection($sheet, int $row): int
    {
        $row = $this->sectionTitle(
            $sheet,
            $row,
            'MOST IMPORTANT CONCEPT — EACH ROW = ONE SELLABLE PRODUCT'
        );

        $headers = ['group_code', 'Product Name', 'Color', 'Size'];

        $data = [
            ['ROMPER01', 'Baby Romper', 'Blue', 'S'],
            ['ROMPER01', 'Baby Romper', 'Blue', 'M'],
            ['TEDDY01', 'Soft Teddy Bear', '-', '-'],
        ];

        $row = $this->table($sheet, $row, $headers, $data);

        $row = $this->infoBox(
            $sheet,
            $row,
            '✅ Same product family → same group_code',
            'D4EDDA'
        );

        $row = $this->infoBox(
            $sheet,
            $row,
            '✅ Different product → different group_code',
            'D4EDDA'
        );

        return $row + 2;
    }

    protected function groupCodeSection($sheet, int $row): int
    {
        $row = $this->sectionTitle(
            $sheet,
            $row,
            'HOW TO USE group_code'
        );

        $row = $this->infoBox(
            $sheet,
            $row,
            'group_code connects related rows of the same product family.',
            'EAF7EA'
        );

        $examples = [
            ['BABYROMPER01'],
            ['KIDTSHIRT_BLUE'],
            ['SCHOOLBAG_PANDA'],
        ];

        $row = $this->table(
            $sheet,
            $row,
            ['GOOD group_code EXAMPLES'],
            $examples
        );

        $row = $this->infoBox(
            $sheet,
            $row,
            '❌ Do not use the same group_code for unrelated products.',
            'F8D7DA'
        );

        return $row + 2;
    }

    protected function variantOptionSection($sheet, int $row): int
    {
        $row = $this->sectionTitle(
            $sheet,
            $row,
            'PRODUCTS WITH SIZE / COLOR OPTIONS'
        );

        $row = $this->infoBox(
            $sheet,
            $row,
            'If your product has Size, Color or similar options, create separate rows for each sellable option.',
            'E8F4FD'
        );

        $headers = ['group_code', 'Product Name', 'Color', 'Size'];

        $data = [
            ['KIDTSHIRT01', 'Kids T-Shirt', 'Red', 'S'],
            ['KIDTSHIRT01', 'Kids T-Shirt', 'Red', 'M'],
            ['KIDTSHIRT01', 'Kids T-Shirt', 'Blue', 'S'],
        ];

        $row = $this->table($sheet, $row, $headers, $data);

        $row = $this->infoBox(
            $sheet,
            $row,
            '📌 Each row should represent one purchasable product.',
            'FFF3CD'
        );

        return $row + 2;
    }

    protected function categorySheetSection(
        $sheet,
        int $row,
        TemplateConfigDTO $dto
    ): int {

        $row = $this->sectionTitle(
            $sheet,
            $row,
            'CATEGORY SHEETS'
        );

        $headers = ['Sheet Name', 'Fill Products'];

        $data = [];

        foreach ($dto->categoryNameMap as $name) {

            $data[] = [
                $name,
                "Only {$name} related products"
            ];
        }

        $row = $this->table($sheet, $row, $headers, $data);

        return $row + 2;
    }

    protected function dropdownSection($sheet, int $row): int
    {
        $row = $this->sectionTitle(
            $sheet,
            $row,
            'DROPDOWNS & REQUIRED FIELDS'
        );

        $points = [
            '✅ Use dropdown values wherever available',
            '✅ Required columns should not be empty',
            '✅ Fill products only in matching category sheets',
            '✅ Keep product names clean and readable',
        ];

        foreach ($points as $point) {
            $row = $this->infoBox($sheet, $row, $point, 'EAF7EA');
        }

        return $row + 2;
    }

    protected function mistakeSection($sheet, int $row): int
    {
        $row = $this->sectionTitle(
            $sheet,
            $row,
            'COMMON MISTAKES TO AVOID'
        );

        $mistakes = [
            '❌ Different group_code for same product family',
            '❌ Uploading products in wrong category sheet',
            '❌ Renaming columns or sheets',
            '❌ Adding extra header rows',
            '❌ Typing random values instead of dropdown selection',
        ];

        foreach ($mistakes as $mistake) {
            $row = $this->infoBox($sheet, $row, $mistake, 'F8D7DA');
        }

        return $row + 2;
    }

    protected function imageUploadSection($sheet, int $row): int
    {
        $row = $this->sectionTitle(
            $sheet,
            $row,
            'PRODUCT IMAGE UPLOAD'
        );

        $row = $this->infoBox(
            $sheet,
            $row,
            'Download ZIP folder template → Unzip the file → Place images inside matching product folders → Upload ZIP file',
            'E8F4FD'
        );

        $row = $this->infoBox(
            $sheet,
            $row,
            'Manual Upload → Open image upload panel → Select product → Drag & drop images',
            'E8F4FD'
        );

        return $row + 2;
    }

    protected function finalRulesSection(
        $sheet,
        int $row,
        TemplateConfigDTO $dto
    ): int {

        $row = $this->sectionTitle(
            $sheet,
            $row,
            'IMPORTANT FINAL RULES'
        );

        $rules = [
            '• Do not rename columns',
            '• Do not delete sheets',
            '• Do not insert extra columns',
            '• Do not leave unnecessary blank rows',
            '• Use one row per sellable product',
            "• Maximum upload volume: {$dto->volume}",
        ];

        foreach ($rules as $rule) {
            $row = $this->infoBox($sheet, $row, $rule, 'FFF3CD');
        }

        return $row;
    }

    protected function table(
        $sheet,
        int $row,
        array $headers,
        array $rows
    ): int {

        $column = 'A';

        foreach ($headers as $header) {

            $sheet->setCellValue("{$column}{$row}", $header);

            $sheet->getStyle("{$column}{$row}")
                ->getFont()
                ->setBold(true)
                ->getColor()
                ->setRGB('FFFFFF');

            $sheet->getStyle("{$column}{$row}")
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('5A5C69');

            $sheet->getStyle("{$column}{$row}")
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            $column++;
        }

        $row++;

        foreach ($rows as $tableRow) {

            $column = 'A';

            foreach ($tableRow as $value) {

                $sheet->setCellValue(
                    "{$column}{$row}",
                    $value
                );

                $sheet->getStyle("{$column}{$row}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                $column++;
            }

            $row++;
        }

        return $row;
    }
}
