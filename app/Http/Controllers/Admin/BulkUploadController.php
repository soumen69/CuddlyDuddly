<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Catalog\Bulk\Pipeline\BulkUploadPipeline;
use App\Domain\Catalog\Bulk\Review\EnterpriseBatchReviewService;
use App\Domain\Catalog\Bulk\Jobs\CommitBulkBatchJob;
use App\Domain\Catalog\Bulk\Builder\TemplateConfigBuilder;
use App\Domain\Catalog\Bulk\Parser\ExcelBulkRowParser;
use Illuminate\Support\Facades\DB;

class BulkUploadController extends Controller
{
    public function index()
    {
        return view('admin.bulk.upload.index');
    }

    public function process(
        Request $request,
        BulkUploadPipeline $pipeline,
        TemplateConfigBuilder $builder
    ) {
        $request->validate([
            'excel' => [
                'required',
                'file',
                'mimes:xlsx,xls'
            ],
        ]);

        $config = app(
            ExcelBulkRowParser::class
        )->extractTemplateConfig(
            $request->file('excel')->getRealPath()
        );

        $dto = $builder->buildFromWizard(
            $config
        );

        $result = $pipeline->process(
            $request->file('excel'),
            $dto,
            1
            // auth('seller')->id()
        );

        return redirect()->route(
            'admin.bulk.batch.review',
            $result['batch_id']
        );
    }

    public function review(
        int $batchId,
        EnterpriseBatchReviewService $review
    ) {
        $summary = $review->batchSummary(
            $batchId
        );

        $products = DB::table('ingestion_products')

            ->leftJoin(
                'product_categories',
                'ingestion_products.category_id',
                '=',
                'product_categories.id'
            )

            ->select(
                'ingestion_products.*',
                'product_categories.name as category_name'
            )

            ->where('batch_id', $batchId)

            ->get();

        $errors = DB::table('ingestion_errors')
            ->where('batch_id', $batchId)
            ->get()
            ->groupBy('product_code');

        return view(
            'admin.bulk.upload.review',
            compact(
                'batchId',
                'summary',
                'products',
                'errors'
            )
        );
    }

    public function batches(Request $request)
    {
        $query = DB::table('ingestion_batches')
            ->leftJoin(
                'sellers',
                'ingestion_batches.seller_id',
                '=',
                'sellers.id'
            )
            ->select(
                'ingestion_batches.*',
                'sellers.name as seller_name',

                DB::raw("
        (
            SELECT COUNT(*)
            FROM ingestion_products ip
            WHERE ip.batch_id = ingestion_batches.id
            AND ip.status = 'approved'
        ) as approved_products
        "),

                DB::raw("
            (
                SELECT COUNT(*)
                FROM ingestion_products ip
                WHERE ip.batch_id = ingestion_batches.id
                AND ip.status IN (
                    'compile_failed',
                    'validation_failed',
                    'rejected'
                )
            ) as failed_products
        ")
            )
            ->latest('ingestion_batches.id');

        // STATUS FILTER
        if ($request->filled('status')) {

            $query->where(
                'ingestion_batches.status',
                $request->status
            );
        }

        // SEARCH FILTER
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where(
                    'ingestion_batches.id',
                    'LIKE',
                    "%{$search}%"
                )

                    ->orWhere(
                        'sellers.name',
                        'LIKE',
                        "%{$search}%"
                    );
            });
        }

        $batches = $query->paginate(20);

        return view(
            'admin.bulk.upload.batches',
            compact('batches')
        );
    }

    public function approve(
        int $productId,
        EnterpriseBatchReviewService $review
    ) {
        try {

            $review->markProductApproved(
                $productId
            );

            return back()->with(
                'success',
                'Product approved.'
            );
        } catch (\Throwable $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    public function reject(
        Request $request,
        int $productId,
        EnterpriseBatchReviewService $review
    ) {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $review->rejectProduct(
            $productId,
            $request->reason
        );

        return back()->with(
            'success',
            'Product rejected.'
        );
    }

    public function commit(
        int $batchId,
        EnterpriseBatchReviewService $review
    ) {

        $canCommit = $review->canCommitBatch(
            $batchId
        );

        if (!$canCommit['allowed']) {

            return back()->with(
                'error',
                $canCommit['message']
            );
        }

        CommitBulkBatchJob::dispatch($batchId);

        DB::table('ingestion_batches')
            ->where('id', $batchId)
            ->update([
                'status' => 'queued',
                'updated_at' => now(),
            ]);

        return back()->with(
            'success',
            'Batch queued successfully.'
        );

        // CommitBulkBatchJob::dispatch(
        //     $batchId
        // );

        // return redirect()->route(
        //     'admin.bulk.images.gateway',
        //     $batchId
        // )->with(
        //     'success',
        //     'Batch queued successfully.'
        // );
    }
}
