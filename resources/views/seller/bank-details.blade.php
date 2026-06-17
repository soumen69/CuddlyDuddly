<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bank Details | Seller</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/seller-registration.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product-details.css') }}">
</head>

<body style="margin:0; background: rgba(0,0,0,.6); min-height:100vh;">

    <div class="d-flex align-items-center justify-content-center min-vh-100 p-3">
        <div class="card shadow-lg border-0" style="width:100%; max-width:650px; border-radius:16px;">
            <div class="card-body p-4 p-md-5 position-relative">

                <button onclick="window.location.href='{{ url()->previous() }}'"
                    class="btn btn-light position-absolute top-0 end-0 m-3 rounded-circle"
                    style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;font-size:20px;text-decoration:none;">
                    &times;
                </button>

                <h3 class="cd-heading">Bank Details</h3>
                <p class="text-muted mb-4">
                    Add bank details to continue with product upload
                </p>

                <form method="POST"
                    action="{{ route('seller.bank.details.store', ['seller' => $seller->slug, 'type' => $type]) }}">
                    @csrf

                    <div class="cd-field-group">
                        <label class="cd-field-label">Account Holder Name <span class="cd-required">*</span></label>
                        <input type="text" name="account_holder_name" class="cd-input"
                            value="{{ old('account_holder_name', $bank->account_holder_name ?? '') }}">
                        @error('account_holder_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="cd-field-group">
                        <label class="cd-field-label">Bank Name <span class="cd-required">*</span></label>
                        <input type="text" name="bank_name" class="cd-input"
                            value="{{ old('bank_name', $bank->bank_name ?? '') }}">
                        @error('bank_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="cd-field-group">
                        <label class="cd-field-label">Account Number <span class="cd-required">*</span></label>
                        <input type="password" name="account_number" class="cd-input"
                            value="{{ old('account_number', $bank->account_number ?? '') }}">
                        @error('account_number')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="cd-field-group">
                        <label class="cd-field-label">Confirm Account Number <span class="cd-required">*</span></label>
                        <input type="password" name="confirm_account_number" class="cd-input"
                            value="{{ old('confirm_account_number', $bank->account_number ?? '') }}">
                        @error('confirm_account_number')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="cd-field-group">
                        <label class="cd-field-label">IFSC Code <span class="cd-required">*</span></label>
                        <input type="text" name="ifsc_code" class="cd-input text-uppercase" maxlength="11"
                            value="{{ old('ifsc_code', $bank->ifsc_code ?? '') }}">
                        @error('ifsc_code')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <p class="cd-secure-note">our bank details are encrypted and secure</p>

                    <button type="submit" class="mcp-btn w-full mt-2">
                        Continue <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

            </div>
        </div>
    </div>

</body>

</html>
