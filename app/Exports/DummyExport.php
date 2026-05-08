<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class DummyExport implements FromArray
{
    public function array(): array
    {
        return [
            ['Bulk system booted successfully']
        ];
    }
}
