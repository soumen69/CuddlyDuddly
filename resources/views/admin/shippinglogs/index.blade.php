@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-3">Shipping Logs</h4>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Order ID</th>
                            <th>Event</th>
                            <th>Received At</th>
                            <th>Payload</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>{{ $log->order_id }}</td>
                                <td>{{ $log->event_name }}</td>
                                <td>{{ $log->created_at->format('d M, h:i A') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#payloadModal{{ $log->id }}">
                                        View
                                    </button>

                                    <div class="modal fade" id="payloadModal{{ $log->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5>Payload</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <pre class="bg-dark text-white p-3 rounded">
{{ json_encode($log->payload, JSON_PRETTY_PRINT) }}
                                        </pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection
