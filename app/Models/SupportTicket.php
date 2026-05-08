<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\TicketEnums;

class SupportTicket extends Model
{
    use HasFactory, TicketEnums; // ✅ include trait properly here

    protected $fillable = [
        'user_id',
        'assigned_to',
        'subject',
        'message',
        'type',
        'priority',
        'status',
        'last_reply_by',
        'last_replied_at',
    ];

    protected $casts = [
        'last_replied_at' => 'datetime',
    ];

    // ✅ Eager load for performance
    protected $with = ['customer', 'seller', 'assignedAdmin', 'tags'];

    /* ================= Relationships ================= */

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'user_id');
    }


    public function assignedAdmin()
    {
        // ✅ Assuming your admin model is AdminUser (as per your codebase)
        return $this->belongsTo(AdminUser::class, 'assigned_to');
    }

    public function replies()
    {
        // Always return replies in ascending order (oldest first)
        return $this->hasMany(TicketReply::class, 'ticket_id')->orderBy('id', 'asc');
    }


    public function tags()
    {
        return $this->belongsToMany(TicketTag::class, 'ticket_tag_pivot');
    }

    /* ================= Scopes ================= */

    public function scopeFilter($query, $filters)
    {
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    // search customer's first/last/email
                    ->orWhereHas('customer', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    // search seller's contact_person / email (if type may be seller)
                    ->orWhereHas('seller', function ($sub) use ($search) {
                        $sub->where('contact_person', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        return $query;
    }
}
