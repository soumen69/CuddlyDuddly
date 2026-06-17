<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory;
use App\Models\Sellers;
use App\Domain\Catalog\Bulk\Builder\TemplateConfigBuilder;
use App\Domain\Catalog\Bulk\Template\TemplateGeneratorService;
use App\Http\Requests\BulkTemplateGenerateRequest;

class SellerBulkDashboardController extends Controller
{
    public function index(Sellers $seller)
    {
        $stats = [

            'total_batches' => DB::table('ingestion_batches')
                ->count(),

            'pending_images' => DB::table('ingestion_batches')
                ->whereIn('status', [
                    'image_upload_pending',
                    'image_upload_in_progress',
                ])
                ->count(),

            'completed_batches' => DB::table('ingestion_batches')
                ->where('status', 'completed')
                ->count(),
        ];

        $failedJobs = DB::table('failed_jobs')
            ->count();

        $processingBatches = DB::table('ingestion_batches')
            ->whereIn('status', [
                'processing',
                'image_upload_in_progress',
            ])
            ->count();

        $stuckBatches = DB::table('ingestion_batches')
            ->whereIn('status', [
                'processing',
                'image_upload_in_progress',
            ])
            ->where(
                'updated_at',
                '<',
                now()->subMinutes(30)
            )
            ->count();

        $health = 'healthy';

        if (
            $failedJobs > 20 ||
            $stuckBatches > 10
        ) {

            $health = 'critical';
        } elseif (
            $failedJobs > 5 ||
            $processingBatches > 50 ||
            $stuckBatches > 3
        ) {

            $health = 'warning';
        }


        $recentBatches = DB::table('ingestion_batches')
            ->latest('id')
            ->limit(5)
            ->get();

        return view(
            'seller.bulk.dashboard',
            compact(
                'stats',
                'recentBatches',
                'seller',
                'health'
            )
        );
    }

    public function showWizard(Sellers $seller)
    {
        $categories = ProductCategory::query()
            ->latest('name')
            ->get();

        $brands = Brands::query()
            ->latest('name')
            ->get();

        return view(
            'seller.bulk.builder',
            compact(
                'categories',
                'brands',
                'seller'
            )
        );
    }

    public function generateTemplate(BulkTemplateGenerateRequest $request)
    {
        $payload = $request->validated();

        $dto = app(TemplateConfigBuilder::class)
            ->buildFromWizard($payload);

        return app(TemplateGeneratorService::class)->generate($dto);
    }
}
