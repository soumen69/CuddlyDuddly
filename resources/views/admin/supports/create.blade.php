@extends('admin.layouts.admin')
@section('title', 'Raise New Support Ticket')

@push('styles')
    <style>
        .card {
            border-radius: 12px;
            overflow: hidden;
        }

        .form-select,
        .form-control {
            border-radius: 10px !important;
        }

        .loader {
            display: none;
            margin-left: 6px;
        }

        .ticket-form-header {
            background: linear-gradient(90deg, #0d6efd, #6610f2);
            color: white;
            padding: 1rem;
        }

        .ticket-form-header h5 {
            margin: 0;
            font-weight: 600;
        }

        .ticket-type {
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
    <div class="container py-3">
        <div class="card shadow-sm border-0">
            <div class="ticket-form-header d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-plus-circle me-2"></i> Raise New Ticket</h5>
                <a href="{{ route('admin.support.tickets.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left"></i> Back to Tickets
                </a>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.support.tickets.store') }}">
                    @csrf

                    {{-- Type Selection --}}
                    <div class="mb-3">
                        <label class="form-label ticket-type">Ticket Type</label>
                        <select id="ticketType" name="type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="customer">Customer</option>
                            <option value="seller">Seller</option>
                        </select>
                    </div>

                    {{-- User / Seller Dynamic Dropdown --}}
                    <div class="mb-3">
                        <label class="form-label" id="userLabel">Select User / Seller</label>
                        <div class="d-flex align-items-center">
                            <select id="userSelect" name="user_id" class="form-select" required>
                                <option value="">Select type first</option>
                            </select>
                            <div class="loader spinner-border spinner-border-sm text-primary"></div>
                        </div>
                    </div>

                    {{-- Subject --}}
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control" placeholder="Enter subject..." required>
                    </div>

                    {{-- Message --}}
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea name="message" rows="4" class="form-control" placeholder="Describe the issue..." required></textarea>
                    </div>

                    {{-- Priority --}}
                    <div class="mb-3">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>

                    {{-- Submit --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Submit Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('ticketType');
            const userSelect = document.getElementById('userSelect');
            const loader = document.querySelector('.loader');

            typeSelect.addEventListener('change', function() {
                const type = this.value;
                userSelect.innerHTML = '<option value="">Loading...</option>';
                loader.style.display = 'inline-block';

                fetch(`/admin/support/fetch-users?type=${type}`)
                    .then(res => res.json())
                    .then(data => {
                        userSelect.innerHTML = '<option value="">Select ' + (type === 'seller' ?
                            'Seller' : 'Customer') + '</option>';
                        data.forEach(item => {
                            const label = type === 'seller' ?
                                `${item.contact_person} (ID: ${item.id})` :
                                `${item.name} (ID: ${item.id})`;
                            userSelect.insertAdjacentHTML('beforeend',
                                `<option value="${item.id}">${label}</option>`);
                        });
                    })
                    .catch(err => {
                        console.error(err);
                        userSelect.innerHTML = '<option value="">Error loading list</option>';
                    })
                    .finally(() => loader.style.display = 'none');
            });
        });
    </script>
@endpush
