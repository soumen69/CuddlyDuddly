<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;              // <- required
use Illuminate\Support\Facades\Auth;
use App\Models\TicketReply;

class TicketReplyController extends Controller
{
    // public function store(Request $request)
    // {
    //     // validate
    //     $request->validate([
    //         'ticket_id' => 'required|exists:support_tickets,id',
    //         'message'   => 'required|string|max:5000',
    //     ]);

    //     // get admin from admin guard
    //     $admin = Auth::guard('admin')->user();

    //     // create reply
    //     $reply = TicketReply::create([
    //         'ticket_id' => $request->ticket_id,
    //         'admin_id'  => $admin->id,
    //         'message'   => $request->message,
    //     ]);

    //     // broadcast to others (no queue)
    //     broadcast(new TicketMessageSent($reply))->toOthers();

    //     // prepare response
    //     $replies = TicketReply::where('ticket_id', $request->ticket_id)
    //         ->orderBy('created_at', 'asc')
    //         ->get()
    //         ->map(function ($r) {
    //             return [
    //                 'id'         => $r->id,
    //                 'message'    => $r->message,
    //                 'is_admin'   => (bool) $r->admin_id,
    //                 'created_at' => optional($r->created_at)->toISOString() ?? now()->toISOString(),
    //             ];
    //         });

    //     return response()->json([
    //         'success' => true,
    //         'replies' => $replies,
    //     ]);
    // }

    // ============= Admin Send Reply =============
    public function adminReply(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:support_tickets,id',
            'message'   => 'required|string'
        ]);

        $reply = TicketReply::create([
            'ticket_id' => $request->ticket_id,
            'admin_id'  => auth('admin')->id(),
            'message'   => $request->message
        ]);

        return response()->json([
            'success' => true,
            'replies' => $reply->ticket->replies()
                ->orderBy('id', 'asc')
                ->get()
                ->map(function ($r) {
                    return [
                        'id' => $r->id,
                        'message' => $r->message,
                        'is_admin' => (bool) $r->admin_id,
                        'is_seller' => (bool) $r->seller_id,
                        'is_user' => (bool) $r->user_id,
                        'created_at' => $r->created_at->toISOString(),
                    ];
                }),
        ]);
    }
}
