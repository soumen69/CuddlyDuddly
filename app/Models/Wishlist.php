<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlists';

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    /**
     * 🔗 Relationship: Wishlist belongs to a User (Customer)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 🔗 Relationship: Wishlist belongs to a Product
     */
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
