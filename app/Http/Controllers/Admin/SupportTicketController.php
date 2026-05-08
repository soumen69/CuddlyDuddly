<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\TicketTag;
use App\Models\Sellers;
use App\Models\User;
use App\Models\AdminUser;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupportTicketController extends Controller
{

    // public function index(Request $request)
    // {
    //     $filters = $request->only(['status', 'priority', 'search', 'type']);
    //     $admins = AdminUser::select('id', 'name')->where('is_active', 1)->get();

    //     $tickets = SupportTicket::query()
    //         ->with(['assignedAdmin', 'tags', 'customer', 'seller']) // ensure relations available
    //         ->withCount('replies')
    //         ->when(!empty($filters['type']), function ($query) use ($filters) {
    //             $query->where('type', $filters['type']);
    //         })
    //         ->filter($filters)
    //         ->latest()
    //         ->paginate(10);

    //     $tickets->getCollection()->transform(function ($ticket) {

    //         // decide which relation is the "owner" of the ticket
    //         $owner = $ticket->type === 'seller' ? $ticket->seller : $ticket->customer;

    //         // normalized display name for view convenience
    //         if ($ticket->type === 'seller') {
    //             $ticket->display_name = optional($owner)->contact_person ?? 'Deleted Seller';
    //         } else {
    //             $ticket->display_name = optional($owner)->full_name ?? 'Deleted User';
    //         }

    //         // keep previous helper relation if you like (optional)
    //         $ticket->relation = $owner;

    //         return $ticket;
    //     });


    //     $statuses = SupportTicket::$statuses ?? ['open', 'in_progress', 'resolved', 'closed'];
    //     $priorities = SupportTicket::$priorities ?? ['low', 'medium', 'high', 'urgent'];

    //     return view('admin.supports.index', compact('tickets', 'statuses', 'priorities', 'filters', 'admins'));
    // }

    public function index(Request $request)
    {
        $admins = AdminUser::select('id', 'name')->where('is_active', 1)->get();

        $tickets = $this->fetchTickets($request);

        $statuses = SupportTicket::$statuses ?? ['open', 'in_progress', 'resolved', 'closed'];
        $priorities = SupportTicket::$priorities ?? ['low', 'medium', 'high', 'urgent'];

        $filters = $request->only(['status', 'priority', 'search', 'type']);

        return view('admin.supports.index', compact('tickets', 'statuses', 'priorities', 'filters', 'admins'));
    }

    private function fetchTickets(Request $request, $type = null)
    {
        $filters = $request->only(['status', 'priority', 'search', 'type']);

        $tickets = SupportTicket::query()
            ->with(['assignedAdmin', 'tags', 'customer', 'seller'])
            ->withCount('replies')
            ->when($type, function ($q) use ($type) {
                $q->where('type', $type);
            })
            ->when(!$type && !empty($filters['type']), function ($q) use ($filters) {
                $q->where('type', $filters['type']);
            })
            ->filter($filters)
            ->latest()
            ->paginate(10);

        // normalize owner + display name
        $tickets->getCollection()->transform(function ($ticket) {
            $owner = $ticket->type === 'seller' ? $ticket->seller : $ticket->customer;

            $ticket->display_name = $ticket->type === 'seller'
                ? (optional($owner)->contact_person ?? 'Deleted Seller')
                : (optional($owner)->full_name ?? 'Deleted User');

            $ticket->relation = $owner;

            return $ticket;
        });

        return $tickets;
    }


    public function show(Request $request, $id)
    {
        // eager load replies and their possible senders
        $ticket = SupportTicket::with([
            'replies.user:id,name',
            'replies.admin:id,name',
            'replies.seller:id,contact_person', // ensure seller relation on reply (if exists)
            'seller',
            'customer',
            'assignedAdmin'
        ])->findOrFail($id);

        // Handle AJAX request
        if ($request->ajax() || $request->has('ajax')) {

            // Ensure replies are fetched in ascending order (oldest -> newest)
            $repliesCollection = $ticket->replies()->orderBy('id', 'asc')->get();

            $replies = $repliesCollection->map(function ($reply) {
                // determine sender name robustly: admin > seller > user
                $name = 'User';
                if (!empty($reply->admin_id) && $reply->relationLoaded('admin') && $reply->admin) {
                    $name = $reply->admin->name;
                } elseif (!empty($reply->seller_id) && $reply->relationLoaded('seller') && $reply->seller) {
                    // seller contact person if exists, else fallback
                    $name = $reply->seller->contact_person ?? 'Seller';
                } elseif (!empty($reply->user_id) && $reply->relationLoaded('user') && $reply->user) {
                    $name = $reply->user->name ?? 'User';
                }

                return [
                    'id' => $reply->id,
                    'name' => $name,
                    'message' => $reply->message,
                    'is_admin' => (bool) $reply->admin_id,
                    'is_seller' => (bool) $reply->seller_id,
                    'is_user' => (bool) $reply->user_id,
                    'time' => $reply->created_at->toISOString(),
                ];
            })->values();

            return response()->json([
                'success' => true,
                'subject' => $ticket->subject,
                'customer' => $ticket->type === 'seller'
                    ? optional($ticket->seller)->contact_person
                    : optional($ticket->customer)->full_name,
                'status' => $ticket->status,     // ticket-level status (important)
                'priority' => $ticket->priority, // ticket-level priority
                'replies' => $replies,
            ]);
        }

        // Otherwise, load full page
        return view('admin.supports.show', compact('ticket'));
    }

    public function assign(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        // Unassign: set assigned_to = null and optionally reset status to 'open' only if it is not resolved/closed
        if ($request->assigned_to === 'unassigned' || empty($request->assigned_to)) {
            $ticket->update([
                'assigned_to' => null,
                // only set to open if the ticket is not resolved/closed
                'status' => in_array($ticket->status, ['resolved', 'closed']) ? $ticket->status : 'open',
            ]);

            return back()->with('success', 'Ticket unassigned successfully.');
        }

        $request->validate([
            'assigned_to' => 'exists:admin_users,id',
        ]);

        // If assigning to someone, set to in_progress only if currently 'open' (do not override resolved/closed)
        $newData = ['assigned_to' => $request->assigned_to];
        if ($ticket->status === 'open') {
            $newData['status'] = 'in_progress';
        }

        $ticket->update($newData);

        return back()->with('success', 'Ticket assigned successfully.');
    }


    public function update(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        $validated = $request->validate([
            'status' => 'nullable|string|in:' . implode(',', SupportTicket::$statuses),
            'priority' => 'nullable|string|in:' . implode(',', SupportTicket::$priorities),
        ]);

        $ticket->update($validated);

        return back()->with('success', 'Ticket updated successfully.');
    }

    public function updateTags(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $tagIds = $request->input('tags', []);

        $ticket->tags()->sync($tagIds);

        return response()->json(['success' => true, 'message' => 'Tags updated successfully.']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $ticket = SupportTicket::findOrFail($id);
            $ticket->replies()->delete();
            $ticket->tags()->detach();
            $ticket->delete();
        });

        return back()->with('success', 'Ticket deleted successfully.');
    }

    // public function seller()
    // {
    //     $tickets = SupportTicket::with(['seller', 'assignedAdmin'])
    //         ->latest()
    //         ->paginate(10);

    //     return view('admin.supports.seller', compact('tickets'));
    // }

    public function seller(Request $request)
    {
        $tickets = $this->fetchTickets($request, 'seller');
        $admins = AdminUser::select('id', 'name')->where('is_active', 1)->get();

        return view('admin.supports.seller', compact('tickets', 'admins'));
    }


    // public function customer()
    // {
    //     $tickets = SupportTicket::with(['customer', 'assignedAdmin'])
    //         ->latest()
    //         ->paginate(10);

    //     return view('admin.supports.customer', compact('tickets'));
    // }

    public function customer(Request $request)
    {
        $tickets = $this->fetchTickets($request, 'customer');
        $admins = AdminUser::select('id', 'name')->where('is_active', 1)->get();

        return view('admin.supports.customer', compact('tickets', 'admins'));
    }



    public function create()
    {
        $customers = User::select('id', 'name', 'email')->orderBy('name')->get();
        $sellers = Sellers::select('id', 'contact_person', 'email')->orderBy('contact_person')->get();

        return view('admin.supports.create', compact('customers', 'sellers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:customer,seller',
            'user_id' => 'required|numeric',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $ticket = SupportTicket::create([
            'user_id' => $validated['user_id'],
            'assigned_to' => auth('admin')->id(),
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'type' => $validated['type'],
            'priority' => $validated['priority'],
            'status' => 'open',
            'last_reply_by' => auth('admin')->id(),
            'last_replied_at' => now(),
        ]);

        $ticket->replies()->create([
            'admin_id' => auth('admin')->id(),
            'message' => $validated['message'],
            'is_internal' => false,
        ]);

        return redirect()
            ->route('admin.support.tickets.show', $ticket->id)
            ->with('success', 'Ticket raised successfully!');
    }

    public function fetchUsers(Request $request)
    {
        $type = $request->get('type');

        if ($type === 'seller') {
            $sellers = Sellers::select('id', 'contact_person')->orderBy('contact_person')->get();
            return response()->json($sellers);
        }

        $users = User::select('id', 'name')->orderBy('name')->get();
        return response()->json($users);
    }

    // ============= Long Polling =============
    public function poll(Request $request, $ticketId)
    {
        $after = (int) $request->get('after', 0);

        $replies = TicketReply::with(['admin:id,name', 'user:id,name', 'seller:id,contact_person'])
            ->where('ticket_id', $ticketId)
            ->where('id', '>', $after)
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($r) {
                $name = 'User';
                if (!empty($r->admin_id) && $r->relationLoaded('admin') && $r->admin) {
                    $name = $r->admin->name;
                } elseif (!empty($r->seller_id) && $r->relationLoaded('seller') && $r->seller) {
                    $name = $r->seller->contact_person ?? 'Seller';
                } elseif (!empty($r->user_id) && $r->relationLoaded('user') && $r->user) {
                    $name = $r->user->name ??  'User';
                }

                return [
                    'id' => $r->id,
                    'message' => $r->message,
                    'is_admin' => (bool) $r->admin_id,
                    'is_seller' => (bool) $r->seller_id,
                    'is_user' => (bool) $r->user_id,
                    'name' => $name,
                    'created_at' => $r->created_at->toISOString(),
                ];
            });

        return response()->json([
            'success' => true,
            'new_replies' => $replies
        ]);
    }
}
