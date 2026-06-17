<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SupportTicket;
use App\Models\TicketReply;

class SellerSupportController extends Controller
{
    public function index(Request $request, \App\Models\Sellers $seller)
    {
        // Security check: Ensure the logged-in seller is accessing their own slug
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403);
        }

        // Fetch existing ticket for this seller (if any)
        $ticket = SupportTicket::where('type', 'seller')
            ->where('user_id', $seller->id)
            ->latest()
            ->with(['replies.admin'])
            ->first();

        return view('seller.supports.index', compact('seller', 'ticket'));
    }

    public function sendReply(Request $request, \App\Models\Sellers $seller)
    {
        // Security check
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'ticket_id' => 'required|exists:support_tickets,id',
            'message' => 'required|string|max:5000',
        ]);

        $reply = TicketReply::create([
            'ticket_id' => $request->ticket_id,
            'user_id' => null,
            'admin_id' => null,
            'seller_id' => $seller->id ?? null,
            'message' => $request->message,
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

    // ============= Long Polling =============
    public function poll(Request $request, \App\Models\Sellers $seller, $ticketId)
    {
        // Security check
        if (Auth::guard('seller')->id() !== $seller->id) {
            abort(403, 'Unauthorized');
        }

        $after = (int) $request->get('after', 0);

        $replies = TicketReply::where('ticket_id', $ticketId)
            ->where('id', '>', $after)
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
            });

        return response()->json([
            'success' => true,
            'new_replies' => $replies
        ]);
    }
}
