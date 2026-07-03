<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Services\Payment\PaymentWebhookService;
use Illuminate\Http\Request;
use App\Services\Payment\PaymentGateway;

class RazorpayWebhookController extends Controller
{
    public function __construct(
        protected PaymentGateway $gateway,
        protected PaymentWebhookService $service
    ) {}
    public function __invoke(
        Request $request
    ) {

        $this->gateway->verifyWebhook(
            $request->getContent(),
            $request->header('X-Razorpay-Signature')
        );

        $this->service->handle($request->all());

        return response()->json([
            'success' => true
        ]);
    }
}
