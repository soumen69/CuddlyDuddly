@extends('admin.layouts.admin')

@section('title', 'Order Details')

@section('content')
    <style>
        /* ULTRA-COMPACT PREMIUM */
        :root {
            --muted: #6c757d;
            --card-pad: 8px;
        }

        .card {
            border-radius: 10px !important;
        }

        .card-header {
            padding: 6px 10px !important;
            font-size: 0.82rem;
        }

        .card-body {
            padding: 8px 10px !important;
            font-size: 0.85rem;
        }

        .small {
            font-size: 0.78rem !important;
        }

        .table-sm td,
        .table-sm th {
            padding: 6px 8px !important;
        }

        .badge-sm {
            padding: .25rem .45rem;
            font-size: .72rem;
            border-radius: .4rem;
        }

        .muted {
            color: var(--muted);
        }

        .compact-row {
            gap: 8px;
        }

        .timeline {
            display: flex;
            align-items: center;
            gap: 8px;
            overflow: hidden;
            white-space: nowrap;
        }

        .milestone {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 72px;
            font-size: .72rem;
        }

        .milestone .dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            display: block;
            margin-bottom: 6px;
        }

        .milestone.locked .dot {
            opacity: .25;
        }

        .milestone.done .dot {
            box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.02) inset;
        }

        .milestone .label {
            text-align: center;
            color: var(--muted);
        }

        .timeline-bar {
            height: 6px;
            background: #e9ecef;
            border-radius: 6px;
            flex: 1;
            position: relative;
        }

        .timeline-bar .progress {
            height: 100%;
            background: linear-gradient(90deg, #0d6efd, #20c997);
            border-radius: 6px;
            width: 0%;
        }

        .event-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 8px;
            border-radius: 8px;
            margin-bottom: 6px;
        }

        .event-badge i {
            font-size: 1rem;
        }

        .payload {
            font-family: monospace;
            font-size: .78rem;
            background: #f8f9fa;
            padding: 8px;
            border-radius: 6px;
            max-height: 160px;
            overflow: auto;
        }

        .mini-btn {
            padding: .28rem .45rem;
            font-size: .78rem;
        }

        .nowrap {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
            max-width: 220px;
            vertical-align: middle;
        }
    </style>

    <div class="container-fluid py-2">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                {{-- <h5 class="fw-bold mb-0"><i class="bi bi-receipt-cutoff me-1"></i> Order #{{ $order->order_number }}</h5>
                <small class="text-muted">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</small> --}}
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-dark">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>
            <div class="d-flex gap-2">
                @canAccess('admin.orders.edit')
                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                </a>
                @endcanAccess
                @canAccess('admin.orders.printInvoice')
                <a href="#" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-printer me-1"></i> Print Invoice
                </a>
                @endcanAccess
                @canAccess('admin.orders.sendmail')
                <a href="#" class="btn btn-sm btn-outline-success">
                    <i class="bi bi-envelope me-1"></i> Send Mail
                </a>
                @endcanAccess
            </div>
        </div>
        <div class="card shadow-sm mb-2">
            <div class="card-body d-flex justify-content-between align-items-center compact-row">
                <div>
                    <div class="small muted">Order</div>
                    <div class="fw-semibold">#{{ $order->order_number }}</div>
                    <div class="muted small">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                </div>

                <div class="text-end">
                    <div class="small muted">Total</div>
                    <div class="fw-semibold">₹{{ number_format($order->total_amount, 2) }}</div>
                </div>
            </div>
        </div>

        <div class="row g-2">
            {{-- LEFT: compact shipping + actions --}}
            <div class="col-md-4">
                <div class="card shadow-sm mb-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div><i class="bi bi-truck"></i> Shipping</div>
                        <div class="small muted">Provider: <span
                                id="provider-badge">{{ $order->shipment?->provider ? ucfirst($order->shipment->provider) : '—' }}</span>
                        </div>
                    </div>

                    <div class="card-body small">
                        {{-- Name & address (single line compact) --}}
                        <div class="mb-2">
                            <div class="fw-semibold">{{ $order->shippingAddress->shipping_name }}</div>
                            <div class="muted small nowrap">
                                {{ $order->shippingAddress->address_line1 }}, {{ $order->shippingAddress->city }} ·
                                {{ $order->shippingAddress->shipping_phone }}
                            </div>
                        </div>

                        {{-- AWB + actions --}}
                        <div class="d-flex align-items-center mb-2" style="gap:8px;">
                            <div>
                                <div class="muted small">AWB</div>
                                <div class="fw-semibold nowrap" id="awb-number">{{ $order->shipment->awb_number ?? '—' }}
                                </div>
                                <div class="muted small">ID: <span
                                        id="shipment-id">{{ $order->shipment->shipment_id ?? '—' }}</span></div>
                            </div>

                            <div class="ms-auto d-flex" style="gap:6px;">
                                <button id="copy-awb" class="btn btn-outline-secondary btn-sm mini-btn" title="Copy AWB">
                                    <i class="bi bi-clipboard"></i>
                                </button>

                                <a id="track-link" class="btn btn-outline-primary btn-sm mini-btn" target="_blank"
                                    rel="noopener" title="Track AWB">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>

                                @if (!$order->shipment)
                                    <button class="btn btn-primary btn-sm mini-btn" data-bs-toggle="modal"
                                        data-bs-target="#confirmShipmentModal">Create</button>
                                @else
                                    <button id="force-refresh"
                                        class="btn btn-outline-secondary btn-sm mini-btn">Refresh</button>
                                @endif
                            </div>
                        </div>

                        {{-- Horizontal milestone timeline (compact) --}}
                        <div class="mb-2">
                            <div class="timeline" aria-hidden="true">
                                <div class="milestone" data-key="pending">
                                    <span class="dot" style="background:#6c757d"></span>
                                    <div class="label">Pending</div>
                                </div>
                                <div class="milestone" data-key="awb_assigned">
                                    <span class="dot" style="background:#0d6efd"></span>
                                    <div class="label">AWB</div>
                                </div>
                                <div class="milestone" data-key="pickup_scheduled">
                                    <span class="dot" style="background:#0dcaf0"></span>
                                    <div class="label">Pickup</div>
                                </div>
                                <div class="milestone" data-key="in_transit">
                                    <span class="dot" style="background:#ffc107"></span>
                                    <div class="label">Transit</div>
                                </div>
                                <div class="milestone" data-key="out_for_delivery">
                                    <span class="dot" style="background:#fd7e14"></span>
                                    <div class="label">OFD</div>
                                </div>
                                <div class="milestone" data-key="delivered">
                                    <span class="dot" style="background:#198754"></span>
                                    <div class="label">Delivered</div>
                                </div>
                            </div>

                            <div class="timeline-bar mt-2">
                                <div id="timeline-progress" class="progress" style="width:0%;"></div>
                            </div>

                            <div class="muted small mt-1">Status: <span
                                    id="shipment-status-text">{{ $order->shipment?->status ?? 'pending' }}</span></div>
                        </div>

                        {{-- Settlement compact --}}
                        <div class="muted small">
                            <strong>Settlement:</strong> <span
                                id="settlement-status">{{ $order->shipment->settlement_status ?? '—' }}</span>
                            <div id="hold-until-block" class="muted small">
                                @if ($order->shipment?->hold_until)
                                    Hold until: {{ $order->shipment->hold_until->format('d M, h:i A') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Collapsible payload drawer --}}
                <div class="card shadow-sm mb-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="small"><i class="bi bi-code-slash"></i> Payload (last)</div>
                        <button class="btn btn-sm btn-outline-secondary mini-btn" type="button"
                            data-bs-toggle="collapse" data-bs-target="#payloadCollapse" aria-expanded="false"
                            aria-controls="payloadCollapse">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                    <div class="card-body small py-2 collapse" id="payloadCollapse">
                        <div id="payload-content" class="payload">No payload</div>
                    </div>
                </div>

                {{-- Recent events list (compact) --}}
                <div class="card shadow-sm">
                    <div class="card-header small">Recent</div>
                    <div class="card-body small py-2" style="max-height:160px; overflow:auto;">
                        <div id="events-list">
                            {{-- JS will populate --}}
                            @foreach ($order->shipment?->shipmentLogs?->take(5) ?? \DB::table('shipping_logs')->where('order_id', $order->id)->orderBy('id', 'desc')->limit(5)->get() as $log)
                                @php
                                    $readable = \App\Models\Shipment::readableStatus($log->event_name);
                                    // map class & icon
                                    $mapClass = match ($log->event_name) {
                                        'Delivered', 'MOCK_DELIVERED' => 'bg-success text-white',
                                        'Out For Delivery' => 'bg-warning text-dark',
                                        'In Transit' => 'bg-info text-dark',
                                        'Pickup Scheduled' => 'bg-primary text-white',
                                        'AWB Assigned' => 'bg-primary text-white',
                                        'RTO Initiated' => 'bg-danger text-white',
                                        'RTO Delivered' => 'bg-danger text-white',
                                        default => 'bg-light text-dark',
                                    };
                                    $mapIcon = match ($log->event_name) {
                                        'Delivered', 'MOCK_DELIVERED' => 'bi-check-circle',
                                        'Out For Delivery' => 'bi-truck-flatbed',
                                        'In Transit' => 'bi-arrow-repeat',
                                        'Pickup Scheduled' => 'bi-calendar-check',
                                        'AWB Assigned' => 'bi-card-list',
                                        'RTO Initiated' => 'bi-arrow-counterclockwise',
                                        'RTO Delivered' => 'bi-box-arrow-in-left',
                                        default => 'bi-info-circle',
                                    };
                                @endphp
                                <div class="d-flex align-items-center mb-1">
                                    <span class="event-badge {{ $mapClass }}"
                                        style="min-width:34px; justify-content:center;">
                                        <i class="bi {{ $mapIcon }}"></i>
                                    </span>
                                    <div class="ms-2">
                                        <div class="fw-semibold small">{{ $readable }}</div>
                                        <div class="muted small">
                                            {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT: items + compact timeline details --}}
            <div class="col-md-8">
                <div class="d-flex gap-2 mb-2">
                    <div class="card shadow-sm flex-fill">
                        <div class="card-header small fw-semibold">Items</div>
                        <div class="card-body p-2 small">
                            <table class="table table-sm mb-0">
                                <thead class="table-light small">
                                    <tr>
                                        <th>#</th>
                                        <th>Item</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $i => $it)
                                        <tr>
                                            <td style="width:36px;">{{ $i + 1 }}</td>
                                            <td>{{ $it->product?->name }}</td>
                                            <td class="text-center">{{ $it->quantity }}</td>
                                            <td class="text-end text-success">
                                                ₹{{ number_format($it->price * $it->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card shadow-sm" style="width:260px;">
                        <div class="card-header small fw-semibold">Summary</div>
                        <div class="card-body small p-2">
                            <div class="d-flex justify-content-between">
                                <div class="muted">Subtotal</div>
                                <div>₹{{ number_format($order->total_amount, 2) }}</div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <div class="muted">Payment</div>
                                <div class="fw-semibold">{{ ucfirst($order->payment_status) }}</div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <div class="muted">Shipment</div>
                                <div id="mini-status">{{ ucfirst($order->shipment?->status ?? 'pending') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Detailed timeline (readable events) --}}
                <div class="card shadow-sm">
                    <div class="card-header small fw-semibold">Timeline</div>
                    <div class="card-body small" style="max-height:260px; overflow:auto;">
                        <div id="timeline-detail">
                            {{-- JS will populate readable timeline with icons & payload toggles --}}
                            @if ($order->shipment)
                                @foreach ($order->shipment->shipmentLogs as $log)
                                    @php
                                        $readable = \App\Models\Shipment::readableStatus($log->event_name);
                                        $icon = match ($log->event_name) {
                                            'Delivered', 'MOCK_DELIVERED' => 'bi-check-circle-fill',
                                            'Out For Delivery' => 'bi-truck-flatbed',
                                            'In Transit' => 'bi-arrow-repeat',
                                            'Pickup Scheduled' => 'bi-calendar-check',
                                            'AWB Assigned' => 'bi-card-list',
                                            'RTO Initiated' => 'bi-arrow-counterclockwise',
                                            'RTO Delivered' => 'bi-box-arrow-in-left',
                                            default => 'bi-info-circle',
                                        };
                                        $colorClass = match ($log->event_name) {
                                            'Delivered', 'MOCK_DELIVERED' => 'text-success',
                                            'Out For Delivery' => 'text-warning',
                                            'In Transit' => 'text-info',
                                            'Pickup Scheduled' => 'text-primary',
                                            'AWB Assigned' => 'text-primary',
                                            'RTO Initiated' => 'text-danger',
                                            'RTO Delivered' => 'text-danger',
                                            default => 'text-muted',
                                        };
                                    @endphp

                                    <div class="timeline-entry mb-2">
                                        <div class="d-flex align-items-start">
                                            <div class="me-2">
                                                <i class="bi {{ $icon }} {{ $colorClass }}"
                                                    style="font-size:1.1rem"></i>
                                            </div>
                                            <div style="flex:1;">
                                                <div class="fw-semibold">{{ $readable }}</div>
                                                <div class="muted small">{{ $log->created_at->toDateTimeString() }}</div>

                                                <a href="#" class="small text-decoration-underline"
                                                    onclick="togglePayload(this);return false;"
                                                    data-payload='@json($log->payload)'>
                                                    View payload
                                                </a>

                                                <div class="payload-box mt-1"
                                                    style="display:none; background:#f8f9fa; border-radius:6px; padding:8px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="muted small">No shipment yet</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div class="modal fade" id="confirmShipmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content small">
                <form method="POST" action="{{ route('admin.orders.shipping.create', $order->id) }}">
                    @csrf
                    <div class="modal-header py-2">
                        <h6 class="modal-title fw-semibold">Create Shipment</h6>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body small">
                        Confirm: package is packed & ready for pickup.
                    </div>
                    <div class="modal-footer py-1">
                        <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-sm btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        (function() {
            const orderId = {{ $order->id }};
            const statusUrl = "{{ route('admin.orders.shipping.status', $order->id) }}";
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const timelineKeys = ['pending', 'awb_assigned', 'pickup_scheduled', 'in_transit', 'out_for_delivery',
                'delivered'
            ];
            const progressMap = {
                'pending': 4,
                'awb_assigned': 20,
                'pickup_scheduled': 40,
                'in_transit': 60,
                'out_for_delivery': 80,
                'delivered': 100,
                'rto_initiated': 50,
                'rto_delivered': 100,
                'cancelled': 0
            };

            // Helper to pretty print JSON
            function prettyJSON(obj) {
                try {
                    return JSON.stringify(obj, null, 2);
                } catch (e) {
                    return String(obj);
                }
            }
            // ---- FIXED PAYLOAD TOGGLER ----
            window.togglePayload = function(anchor) {
                const payloadRaw = anchor.getAttribute('data-payload') || '{}';

                // convert safely
                let formatted = '';
                try {
                    formatted = JSON.stringify(JSON.parse(payloadRaw), null, 2);
                } catch (e) {
                    formatted = payloadRaw;
                }

                // find the correct payload drawer
                const payloadBox = anchor.closest('.timeline-entry').querySelector('.payload-box');

                if (!payloadBox) return;

                // toggle
                if (payloadBox.style.display === 'none' || payloadBox.style.display === '') {
                    payloadBox.style.display = 'block';
                    payloadBox.innerHTML = `<pre>${formatted}</pre>`;
                } else {
                    payloadBox.style.display = 'none';
                    payloadBox.innerHTML = '';
                }
            };

            // Set track link (Shiprocket)
            function setTrackLink(awb) {
                const a = document.getElementById('track-link');
                const base = 'https://track.shiprocket.co/'; // common shiprocket tracking base
                if (!awb || awb === '—') {
                    a.href = '#';
                    a.classList.add('disabled');
                    return;
                }
                a.href = base + encodeURIComponent(awb);
                a.classList.remove('disabled');
            }

            // Copy AWB
            const copyBtn = document.getElementById('copy-awb');
            if (copyBtn) {
                copyBtn.addEventListener('click', async function() {
                    const awb = document.getElementById('awb-number')?.textContent?.trim();
                    if (!awb || awb === '—') return alert('No AWB to copy');
                    try {
                        await navigator.clipboard.writeText(awb);
                        copyBtn.innerHTML = '<i class="bi bi-clipboard-check"></i>';
                        setTimeout(() => copyBtn.innerHTML = '<i class="bi bi-clipboard"></i>', 1200);
                    } catch (e) {
                        prompt('Copy AWB:', awb);
                    }
                });
            }

            // Render events (compact + color/icon)
            function renderEvents(logs) {
                const eventsList = document.getElementById('events-list');
                eventsList.innerHTML = '';
                if (!logs || logs.length === 0) {
                    eventsList.innerHTML = '<div class="muted small">No events</div>';
                    return;
                }
                logs.forEach(l => {
                    const div = document.createElement('div');
                    div.className = 'd-flex align-items-center mb-1';
                    // choose icon & color by raw_event or event
                    const raw = l.raw_event || l.raw || '';
                    let icon = 'bi-info-circle',
                        cls = 'bg-light text-dark';
                    switch (raw) {
                        case 'Delivered':
                        case 'MOCK_DELIVERED':
                            icon = 'bi-check-circle';
                            cls = 'bg-success text-white';
                            break;
                        case 'Out For Delivery':
                            icon = 'bi-truck-flatbed';
                            cls = 'bg-warning text-dark';
                            break;
                        case 'In Transit':
                            icon = 'bi-arrow-repeat';
                            cls = 'bg-info text-dark';
                            break;
                        case 'Pickup Scheduled':
                            icon = 'bi-calendar-check';
                            cls = 'bg-primary text-white';
                            break;
                        case 'AWB Assigned':
                            icon = 'bi-card-list';
                            cls = 'bg-primary text-white';
                            break;
                        case 'RTO Initiated':
                            icon = 'bi-arrow-counterclockwise';
                            cls = 'bg-danger text-white';
                            break;
                        case 'RTO Delivered':
                            icon = 'bi-box-arrow-in-left';
                            cls = 'bg-danger text-white';
                            break;
                    }
                    div.innerHTML = `<span class="event-badge ${cls}" style="min-width:34px;justify-content:center;"><i class="bi ${icon}"></i></span>
                <div class="ms-2"><div class="fw-semibold small">${escapeHtml(l.event)}</div>
                <div class="muted small">${escapeHtml(l.time)}</div></div>`;
                    eventsList.appendChild(div);
                });
            }

            // Render timeline & compact summary
            function applyShipment(shipment, logs) {
                if (!shipment) {
                    document.getElementById('awb-number').textContent = '—';
                    setTrackLink(null);
                    return;
                }

                document.getElementById('awb-number').textContent = shipment.awb_number || '—';
                document.getElementById('shipment-id').textContent = shipment.shipment_id || '—';
                document.getElementById('provider-badge').textContent = shipment.provider ? shipment.provider.charAt(0)
                    .toUpperCase() + shipment.provider.slice(1) : '—';
                document.getElementById('shipment-status-text').textContent = (shipment.status || 'pending').replace(
                    /_/g, ' ');
                document.getElementById('mini-status').textContent = (shipment.status || 'pending').replace(/_/g, ' ');

                // payload
                const payloadEl = document.getElementById('payload-content');
                if (payloadEl) {
                    payloadEl.textContent = shipment.payload_last ? JSON.stringify(shipment.payload_last, null, 2) :
                        'No payload';
                }

                // set track link
                setTrackLink(shipment.awb_number);

                // progress bar
                const prog = progressMap[shipment.status] ?? 0;
                const bar = document.getElementById('timeline-progress');
                if (bar) bar.style.width = prog + '%';

                // mark milestones done/locked quickly
                const keys = timelineKeys;
                document.querySelectorAll('.milestone').forEach(ms => {
                    const key = ms.getAttribute('data-key');
                    ms.classList.remove('done');
                    ms.classList.remove('locked');
                    if (!key) return;
                    const idxKey = keys.indexOf(key);
                    const idxStatus = keys.indexOf(shipment.status);
                    if (idxStatus === -1) {
                        // special states (rto/cancelled)
                        if (shipment.status === 'delivered') {
                            ms.classList.add('done');
                        }
                    } else {
                        if (idxKey <= idxStatus) ms.classList.add('done');
                        else ms.classList.add('locked');
                    }
                });

                // render events
                renderEvents(logs || []);
            }

            // escape helper (safe)
            function escapeHtml(s) {
                return String(s || '').replace(/[&<>"'`=\/]/g, function(c) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;',
                    '/': '&#47;',
                    '`': '&#96;',
                        '=': '&#61;'
                    } [c];
                });
            }

            // fetch status from server
            async function fetchStatus() {
                try {
                    const res = await fetch(statusUrl, {
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json'
                        }
                    });
                    if (!res.ok) return;
                    const body = await res.json();
                    if (body.status !== 'ok') return;
                    applyShipment(body.shipment, body.logs);
                } catch (e) {
                    console.error('status fetch failed', e);
                }
            }

            // wire refresh button
            document.getElementById('force-refresh')?.addEventListener('click', fetchStatus);

            // initial load + poll
            fetchStatus();
            setInterval(fetchStatus, 8000);

        })();
    </script>
@endpush
