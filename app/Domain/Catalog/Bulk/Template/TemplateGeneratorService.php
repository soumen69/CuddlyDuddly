<?php

namespace App\Domain\Catalog\Bulk\Template;

use App\Domain\Catalog\Bulk\DTO\TemplateConfigDTO;
use App\Domain\Catalog\Bulk\Template\Excel\ExcelWorkbookAssembler;
use App\Domain\Catalog\Bulk\Template\Excel\MasterSheetBuilder;
use App\Domain\Catalog\Bulk\Template\Excel\DropdownInjectionEngine;
use App\Domain\Catalog\Bulk\Template\Excel\NamedRangeRegistrar;
use App\Domain\Catalog\Bulk\Template\Excel\GuideSheetBuilder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TemplateGeneratorService
{
    public function __construct(
        protected TemplateSheetSchemaCompiler $schemaCompiler,
        protected ExcelWorkbookAssembler $assembler,
        protected MasterSheetBuilder $masterBuilder,
        protected DropdownInjectionEngine $dropdownEngine,
        protected NamedRangeRegistrar $rangeRegistrar,
        protected GuideSheetBuilder $guideBuilder
    ) {}


    public function generate(TemplateConfigDTO $dto)
    {
        $schema = $this->schemaCompiler
            ->compile($dto);

        $spreadsheet = $this->assembler
            ->build($schema, $dto);

        $this->guideBuilder
            ->build($spreadsheet, $dto);

        $this->masterBuilder
            ->build($spreadsheet, $dto);

        $this->rangeRegistrar
            ->registerAttributeRanges($spreadsheet, $dto);

        $this->dropdownEngine
            ->inject($spreadsheet, $dto, $schema);

        if ($spreadsheet->getSheetByName('MASTER')) {

            $spreadsheet->getSheetByName('MASTER')
                ->setSheetState(
                    Worksheet::SHEETSTATE_HIDDEN
                );
        }

        $firstCategory = $dto->categoryNameMap[$dto->categories[0]];

        $spreadsheet->setActiveSheetIndexByName(
            $firstCategory
        );

        return response()->streamDownload(
            function () use ($spreadsheet) {

                $writer = new Xlsx($spreadsheet);

                $writer->save('php://output');
            },

            'bulk_catalog_template.xlsx'
        );
    }
}
