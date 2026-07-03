<?php

namespace App\Services\Order;

use Illuminate\Support\Facades\DB;

class WorkflowNumberGenerator
{
    /**
     * Supported Prefixes
     *
     * ORD - Order
     * SHP - Shipment
     * CAN - Cancellation
     * RET - Return
     * REP - Replacement
     * RFD - Refund
     */

    public function generate(string $prefix): string
    {
        return DB::transaction(function () use ($prefix) {

            $prefix = strtoupper($prefix);

            $period = now()->format('Ym');

            $lock = "{$prefix}-{$period}";

            DB::select(
                'SELECT GET_LOCK(?, 10)',
                [$lock]
            );

            try {

                $number = $this->nextRunningNumber(
                    $prefix,
                    $period
                );

                return sprintf(
                    '%s-%s-%06d',
                    $prefix,
                    $period,
                    $number
                );
            } finally {

                DB::select(
                    'SELECT RELEASE_LOCK(?)',
                    [$lock]
                );
            }
        });
    }

    protected function nextRunningNumber(
        string $prefix,
        string $period
    ): int {

        $tables = [

            'ORD' => ['orders', 'order_number'],

            'CAN' => [
                'order_cancellations',
                'cancel_number'
            ],

            'RET' => [
                'order_returns',
                'return_number'
            ],

            'REP' => [
                'order_replacements',
                'replacement_number'
            ],

        ];

        if (! isset($tables[$prefix])) {
            throw new \InvalidArgumentException(
                "Unknown workflow prefix [$prefix]."
            );
        }

        [$table, $column] = $tables[$prefix];

        $last = DB::table($table)
            ->where(
                $column,
                'like',
                "{$prefix}-{$period}-%"
            )
            ->orderByDesc($column)
            ->value($column);

        if (! $last) {
            return 1;
        }

        return ((int) substr($last, -6)) + 1;
    }
}
