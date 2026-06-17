<?php

namespace App\Http\Controllers\Seller;

use App\Domain\Catalog\Bulk\Builder\TemplateConfigBuilder;
use App\Domain\Catalog\Bulk\Jobs\CommitBulkBatchJob;
use App\Domain\Catalog\Bulk\Parser\ExcelBulkRowParser;
use App\Domain\Catalog\Bulk\Pipeline\BulkUploadPipeline;
use App\Domain\Catalog\Bulk\Review\EnterpriseBatchReviewService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sellers;
use App\Domain\Catalog\Bulk\Review\BatchWorkflowManager;

class BulkUploadController extends Controller
{
    public function index(Sellers $seller)
    {
        return view('seller.bulk.upload.index', compact('seller'));
    }

    public function process(
        Sellers $seller,
        Request $request,
        BulkUploadPipeline $pipeline,
        TemplateConfigBuilder $builder
    ) {
        $request->validate([
            'excel' => [
                'required',
                'file',
                'mimes:xlsx,xls',
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
            $seller->id
        );

        return redirect()->route(
            'seller.bulk.batch.review',
            [
                'seller' => $request->seller,
                'batchId' => $result['batch_id'],
            ]
        );
    }


    public function review(Sellers $seller, EnterpriseBatchReviewService $review, int $batchId)
    {

        $batch = DB::table('ingestion_batches')
            ->where('id', $batchId)
            ->first();

        abort_if(! $batch, 404);

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
            'seller.bulk.upload.review',
            compact(
                'batch',
                'batchId',
                'summary',
                'products',
                'errors',
                'seller'
            )
        );
    }

    public function batches(
        Sellers $seller,
        Request $request
    ) {
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
            'seller.bulk.upload.batches',
            compact('batches', 'seller')
        );
    }

    public function bulkApprove(Request $request, EnterpriseBatchReviewService $review)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*' => 'integer|exists:ingestion_products,id',
        ]);

        $approved = 0;
        $failed = [];

        foreach ($request->products as $productId) {
            try {
                $review->markProductApproved(
                    (int) $productId
                );
                $approved++;
            } catch (\Throwable $e) {
                $failed[] = $productId;
            }
        }

        if ($approved === 0) {
            return back()->with(
                'error',
                'Selected products could not be approved.'
            );
        }
        if (count($failed)) {
            return back()->with(
                'success',
                "{$approved} product(s) approved. Some products were skipped due to validation restrictions."
            );
        }

        return back()->with(
            'success',
            "{$approved} product(s) approved successfully."
        );
    }

    public function approve(int $productId, EnterpriseBatchReviewService $review)
    {
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

    public function reject(Request $request, int $productId, EnterpriseBatchReviewService $review)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
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



    public function commit(Sellers $seller, int $batchId, EnterpriseBatchReviewService $review, BatchWorkflowManager $workflow)
    {
        $batch = DB::table('ingestion_batches')
            ->where('id', $batchId)
            ->first();

        abort_if(! $batch, 404);

        abort_unless(
            $workflow->canPublish(
                $batch->status
            ),
            403
        );

        $canCommit = $review->canCommitBatch(
            $batchId
        );

        if (! $canCommit['allowed']) {

            return back()->with(
                'error',
                $canCommit['message']
            );
        }

        try {

            $workflow->startPublishing(
                $batchId
            );

            CommitBulkBatchJob::dispatch(
                $batchId
            );
        } catch (\Throwable $e) {

            $workflow->publishingFailed(
                $batchId
            );

            report($e);

            return back()->with(
                'error',
                'Unable to start publishing process.'
            );
        }

        return redirect()->route(
            'seller.bulk.images.gateway',
            [
                'seller' => $seller->slug,
                'batchId' => $batchId,
            ]
        )->with(
            'success',
            'Products are being published.'
        );
    }
}
