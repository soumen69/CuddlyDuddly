<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkTemplateGenerateRequest;

use Maatwebsite\Excel\Facades\Excel;
use App\Domain\Catalog\Bulk\Builder\TemplateConfigBuilder;
use App\Domain\Catalog\Bulk\Template\TemplateGeneratorService;

class BulkTemplateController extends Controller
{
    public function showWizard()
    {
        // Temporary test page
        return view('seller.bulk.template_wizard');
    }

    public function generateTemplate(BulkTemplateGenerateRequest $request)
    {
        $payload = $request->validated();

        $dto = app(TemplateConfigBuilder::class)
            ->buildFromWizard($payload);

        return app(TemplateGeneratorService::class)->generate($dto);
    }
}
