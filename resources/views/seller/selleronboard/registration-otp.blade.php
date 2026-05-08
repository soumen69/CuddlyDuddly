<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Start Selling Online | Verify OTP</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/seller-registration.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product-details.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="container max-w-container px-5 mx-auto">
        <div class="cd-page cd-registration-detail">
            <div class="cd-header">
                <div class="cd-logo-wrapper">
                    <img src="{{ asset('storage/WebsiteImages/companylogoContact.webp') }}" alt="Logo"
                        class="max-w-52 md:max-w-72 lg:max-w-96 lg:max-w-md">
                </div>
            </div>

            <main class="cd-main">
                <div class="cd-card">
                    <div class="cd-image-pane">
                        <img class="cd-image" src="{{ asset('storage/WebsiteImages/motherandchildContact.webp') }}"
                            alt="Start selling online" />
                    </div>

                    <div class="cd-form-pane">
                        <button class="cd-back-link" onclick="window.history.back()">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back</span>
                        </button>

                        <h2 class="cd-heading">Start Selling Online</h2>
                        <p class="cd-subheading">
                            We sent an OTP to your seller email and phone. Verify it to activate your registration.
                        </p>

                        <div class="mb-3">
                            <div class="alert alert-info">
                                <div class="fw-semibold">Seller details</div>
                                <div class="small">Email: {{ $sellerEmail ?? '-' }}</div>
                                <div class="small">Phone: {{ $sellerPhone ?? '-' }}</div>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('registration-otp.verify') }}">
                            @csrf

                            <div class="cd-field-group">
                                <label class="cd-field-label" for="otp">
                                    Enter OTP <span class="cd-required">*</span>
                                </label>
                                <input id="otp" name="otp" type="text" maxlength="6" inputmode="numeric"
                                    class="cd-input @error('otp') is-invalid @enderror" placeholder="Enter 6-digit OTP"
                                    autocomplete="one-time-code" required>
                                @error('otp')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex flex-wrap gap-2 align-items-center mt-4">
                                <button type="submit" class="mcp-btn">
                                    Verify OTP <i class="fas fa-arrow-right"></i>
                                </button>
                                <button id="cd-resend-btn" type="button" class="cd-resend-btn cd-resend-btn--visible"
                                    onclick="cdResendOtp()">
                                    Resend OTP
                                </button>
                            </div>

                            <div id="cd-resend-timer" class="small mt-2 hidden">
                                You can resend OTP in <span id="cd-countdown">30</span>s
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div id="cd-otp-toast" class="cd-toast"></div>
    <script>
        window.cdRegistrationOtpResendUrl = "{{ route('registration-otp.resend') }}";
        window.cdRegistrationOtpToastId = "cd-otp-toast";
        document.addEventListener("DOMContentLoaded", () => {
            if (typeof cdStartCountdown === "function") cdStartCountdown();
        });
    </script>
    <script src="{{ asset('js/seller-registration.js') }}"></script>
</body>

</html>
