<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class SellerAuth extends Model
{
    protected $fillable = [
        'mobile',
        'email',
        'is_mobile_verified',
        'last_login_at'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = Schema::hasTable('seller_auth') ? 'seller_auth' : 'seller_auths';
    }

    public function seller()
    {
        return $this->hasOne(Sellers::class, 'auth_id');
    }
}
