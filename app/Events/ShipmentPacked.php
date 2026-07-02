<?php

namespace App\Events;

use App\Models\Shipment;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShipmentPacked
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Shipment $shipment,
        public array $payload = []
    ) {}
}
