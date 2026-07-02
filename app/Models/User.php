<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'profile_image',
        'dob',
        'gender',
        'is_verified',
        'status',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'date',
        'last_login_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id', 'id');
    }

    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class, 'user_id');
    }

    public function defaultShippingAddress()
    {
        return $this->hasOne(ShippingAddress::class, 'user_id')
            ->where('is_default', 1);
    }

    public function orderCancellations()
    {
        return $this->hasMany(
            OrderCancellation::class
        );
    }

    public function orderReturns()
    {
        return $this->hasMany(
            OrderReturn::class
        );
    }

    public function orderReplacements()
    {
        return $this->hasMany(
            OrderReplacement::class
        );
    }
}
