<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    use HasFactory;

    protected $table = 'inventory_logs';

    protected $fillable = [
        'inventory_id',
        'action',
        'quantity',
        'remarks',
        'created_by',
    ];

    
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function creator()
    {
        return $this->belongsTo(AdminUser::class, 'created_by');
    }
}
