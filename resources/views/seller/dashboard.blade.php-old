@extends('seller.layouts.seller')

@section('title', 'Seller Dashboard')

@section('content')
    <div class="container-fluid">
        <h3 class="mb-4">Welcome back, {{ Auth::guard('seller')->user()->name }} 👋</h3>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="bi bi-box fs-2 text-primary"></i>
                        <h5 class="mt-2">My Products</h5>
                        <p>{{ $productCount ?? 0 }} total</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="bi bi-cart-check fs-2 text-success"></i>
                        <h5 class="mt-2">My Orders</h5>
                        <p>{{ $orderCount ?? 0 }} total</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="bi bi-wallet2 fs-2 text-warning"></i>
                        <h5 class="mt-2">Payouts</h5>
                        <p>₹{{ $payoutTotal ?? '0.00' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
