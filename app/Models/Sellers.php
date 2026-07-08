<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasRoles;
use \Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Sellers extends Authenticatable
{
    use HasFactory, HasRoles, SoftDeletes, HasApiTokens;

    protected $guard = 'seller';
    protected $table = 'sellers';

    protected $fillable = [
        'auth_id',
        'slug',
        'name',
        'contact_person',
        'email',
        'mobile',
        'compliance_status',
        'logo',
        'avatar',
        'commission_rate',
        'is_active',
        'is_onboard',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($seller) {
            if (!$seller->slug) {
                $seller->slug = Str::slug($seller->name);
            }
        });
    }


    public function products()
    {
        return $this->hasMany(Products::class, 'seller_id');
    }

    public function activeOrders()
    {
        return $this->hasManyThrough(OrderItem::class, Products::class, 'seller_id', 'product_id');
    }

    /** Always return a valid commission rate (defaults to 0) */
    public function getCommission()
    {
        return $this->commission_rate ?? 0;
    }


    public function role()
    {
        // Return the seller role directly (not a relationship)
        return Role::where('slug', 'seller')->first();
    }

    public function permissions()
    {
        $role = $this->role();
        return $role ? $role->permissions : collect();
    }

    public function hasPermission(string $slug): bool
    {
        // If seller’s role has the permission, allow
        return $this->permissions()->contains('slug', $slug);
    }

    public function hasAnyPermission(array $slugs): bool
    {
        return $this->permissions()->whereIn('slug', $slugs)->isNotEmpty();
    }


    public function businessDetail()
    {
        return $this->hasOne(SellerBusinessDetail::class, 'seller_id');
    }

    public function address()
    {
        return $this->hasOne(SellerAddress::class, 'seller_id');
    }

    public function pickupAddress()
    {
        return $this->hasOne(SellerPickupAddress::class, 'seller_id');
    }

    public function bankDetail()
    {
        return $this->hasOne(SellerBankDetail::class, 'seller_id');
    }

    public function supplierDetail()
    {
        return $this->hasOne(SellerSupplierDetail::class, 'seller_id');
    }

    public function documents()
    {
        return $this->hasMany(
            SellerDocument::class,
            'seller_id',
            'id'
        );
    }



}
