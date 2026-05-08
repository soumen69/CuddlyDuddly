@extends('admin.layouts.admin')

@section('title', 'Shipping Logs for Order ' . $order->order_number)

@section('content')
    <div class="container-fluid mt-4">
        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-dark mb-3">← Back to Order</a>

        <div class="card border-0 shadow-sm p-3">
            <h5 class="mb-3">Shipping Logs — Order #{{ $order->order_number }}</h5>
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="table-light small">
                        <tr>
                            <th>Time</th>
                            <th>Event</th>
                            <th>Payload</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d M Y, h:i A') }}</td>
                                <td>{{ $log->event_name }}</td>
                                <td>
                                    <pre style="max-width:600px; white-space:pre-wrap;">{{ json_encode($log->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No logs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection
