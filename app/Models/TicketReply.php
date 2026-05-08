<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'admin_id',
        'seller_id',
        'message',
        'is_internal',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_internal' => 'boolean',
    ];

    /* ================= Relationships ================= */

    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'ticket_id');
    }

    public function admin()
    {
        return $this->belongsTo(AdminUser::class, 'admin_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'seller_id');
    }
}
