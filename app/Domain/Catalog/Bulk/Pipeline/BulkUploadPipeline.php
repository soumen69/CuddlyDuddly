<?php

namespace App\Domain\Catalog\Bulk\Pipeline;

use Exception;
use Illuminate\Http\UploadedFile;
use App\Domain\Catalog\Bulk\DTO\TemplateConfigDTO;
use App\Domain\Catalog\Bulk\Parser\ExcelBulkRowParser;
use App\Domain\Catalog\Bulk\Compiler\ProductFamilyCompiler;
use App\Domain\Catalog\Bulk\Validation\BulkValidationEngine;
use App\Domain\Catalog\Bulk\Staging\BulkStagingInsertionService;
use App\Domain\Catalog\Bulk\Compiler\Support\AttributeValueResolver;
use App\Domain\Catalog\Bulk\Jobs\CommitBulkBatchJob;

class BulkUploadPipeline
{
    protected ExcelBulkRowParser $parser;

    protected ProductFamilyCompiler $compiler;

    protected BulkValidationEngine $validator;

    protected BulkStagingInsertionService $staging;

    public function __construct(
        ExcelBulkRowParser $parser,
        ProductFamilyCompiler $compiler,
        BulkValidationEngine $validator,
        BulkStagingInsertionService $staging
    ) {

        $this->parser = $parser;

        $this->compiler = $compiler;

        $this->validator = $validator;

        $this->staging = $staging;
    }

    public function process(
        UploadedFile $file,
        TemplateConfigDTO $dto,
        int $sellerId
    ): array {

        $rows = $this->parser->parse(
            $file->getRealPath()
        );

        // dd($rows->take(5)->toArray());

        if ($rows->isEmpty()) {

            throw new Exception(
                'Uploaded file contains no products.'
            );
        }

        $resolver = new AttributeValueResolver(
            $dto
        );

        $compiled = $this->compiler->compile(
            $rows,
            $dto,
            $resolver
        );

        foreach ($compiled['products'] as &$family) {

            $family['product']['seller_id'] = $sellerId;
        }


        $validationErrors = array_merge(

            $compiled['errors'] ?? [],

            $this->validator->validate(
                $compiled,
                $dto
            )
        );

        $batchId = $this->staging->insert(
            $sellerId,
            $compiled,
            $validationErrors
        );

        return [

            'batch_id' => $batchId,

            'total_products' =>
            count($compiled['products']),

            'total_errors' =>
            count($validationErrors),

            'status' =>
            empty($validationErrors)
                ? 'publishing'
                : 'review_required',
        ];
    }
}
