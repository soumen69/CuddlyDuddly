<html lang="en">

<head>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Home | CuddlyDuddly</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Rethink+Sans:ital,wght@0,400..800;1,400..800&amp;display=swap"
        rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('css/seller-registration.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product-details.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="container max-w-container px-5 mx-auto">
        <div class="cd-page">
            <div class="cd-header">
                <div class="cd-logo-wrapper">
                    <img src="{{ asset('storage/WebsiteImages/companylogoContact.webp') }}" alt="Logo"
                        class="max-w-52 md:max-w-72 lg:max-w-96 lg:max-w-md">
                </div>
            </div>

            <!-- ═══════════════════════════════════
   MAIN
════════════════════════════════════ -->
            <main class="cd-main">
                <div class="cd-card">

                    <!-- Left: Photo -->
                    <div class="cd-image-pane">
                        <img class="cd-image" src="{{ asset('storage/WebsiteImages/motherandchildContact.webp') }}"
                            alt="Mother kissing her baby" />
                    </div>

                    <!-- Right: Form -->
                    <div class="cd-form-pane">

<!-- ══════════════════════════
    SCREEN 1 — Phone Number
══════════════════════════ -->
                        <div id="cd-screen-phone" class="cd-screen">

                        <h1 class="cd-heading">Start Selling Online</h1>
                        <p class="cd-subheading">Let's get you started.</p>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                            <label for="cd-login-input" class="cd-input-label">
                                Enter mobile number or email address
                            </label>

                            <div class="cd-phone-wrap">
                                <span id="cd-phone-prefix" style="padding-top:3px ;" class="cd-phone-prefix">+91</span>
                                <span id="cd-email-icon" class="cd-phone-prefix" style="display:none;">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                
                            <input id="cd-login-input" class="cd-phone-input" type="text" maxlength="50"
                                    autocomplete="username" oninput="cdOnMobileInput(this)"
                                    placeholder="Enter mobile number or email" />
                            </div>

                            <div class="cd-terms-row">
                                <input id="cd-terms-checkbox" type="checkbox" class="cd-checkbox"
                                    onchange="cdValidateForm()" />
                                <label for="cd-terms-checkbox" class="cd-terms-text">
                                    I agree to the
                                    <a href="#" class="cd-terms-link">Terms &amp; Conditions</a>
                                    and
                                    <a href="#" class="cd-terms-link">Privacy Policy</a>
                                </label>
                            </div>

                            <button id="cd-send-otp-btn" type="button" class="mcp-btn w-full mb-5"
                                onclick="cdHandleSendOtp()" disabled>
                                Send OTP
                                <i class="fas fa-arrow-right"></i>
                            </button>

                            <!-- <button id="cd-login-btn" type="button" class="mcp-btn mcp-btn-outline w-full">
                                Existing User? Log in
                                <i class="fas fa-arrow-right"></i>
                            </button> -->

                            <div id="cd-toast" class="cd-toast"></div>

                        </div>

<!-- ══════════════════════════
    SCREEN 2 — OTP Verify
══════════════════════════ -->
                        <div id="cd-screen-otp" class="cd-screen cd-screen--hidden">

                            <!-- Back link -->
                            <button class="cd-back-link" onclick="cdGoBack()">
                                <i class="fas fa-arrow-left"></i>
                                <span>Change number</span>
                            </button>

                            <h1 class="cd-heading">Start Selling Online</h1>
                            <p id="cd-otp-subheading" class="cd-subheading">
                                <span id="cd-otp-target-icon" style="display:none; margin-right:6px;">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                Enter the OTP sent to <span id="cd-otp-phone-display"></span>
                            </p>

                            <label class="cd-input-label">Enter 6-Digit OTP</label>

                            <!-- OTP Boxes -->
                            <div class="cd-otp-group" id="cd-otp-group">
                                <input class="cd-otp-box" type="tel" maxlength="1" inputmode="numeric"
                                    data-index="0" />
                                <input class="cd-otp-box" type="tel" maxlength="1" inputmode="numeric"
                                    data-index="1" />
                                <input class="cd-otp-box" type="tel" maxlength="1" inputmode="numeric"
                                    data-index="2" />
                                <input class="cd-otp-box" type="tel" maxlength="1" inputmode="numeric"
                                    data-index="3" />
                                <input class="cd-otp-box" type="tel" maxlength="1" inputmode="numeric"
                                    data-index="4" />
                                <input class="cd-otp-box" type="tel" maxlength="1" inputmode="numeric"
                                    data-index="5" />
                            </div>

                            <!-- Resend countdown -->
                            <div class="cd-resend-row">
                                <span id="cd-resend-timer" class="cd-subheading">Resend OTP in <span
                                        id="cd-countdown">30</span>s</span>
                                <button id="cd-resend-btn" class="cd-resend-btn" onclick="cdHandleSendOtp()">Resend
                                    OTP</button>
                            </div>

                            <!-- Submit -->
                            <button id="cd-submit-btn" type="button" class="mcp-btn w-full mb-5"
                                onclick="cdHandleSubmit()" disabled>
                                Submit
                                <i class="fas fa-arrow-right"></i>
                            </button>

                            <!-- <button type="button" class="mcp-btn mcp-btn-outline w-full">
                                Existing User? Log in
                                <i class="fas fa-arrow-right"></i>
                            </button> -->

                            <div id="cd-otp-toast" class="cd-toast"></div>

                        </div>
                        <!-- /screen-otp -->

                        <!-- ══════════════════════════
    SCREEN 3 — Success
══════════════════════════ -->
                        <div id="cd-screen-success" class="cd-screen cd-screen--hidden">
                            <div class="cd-screen-success-inner">

                                <!-- Badge icon + "Welcome Aboard!" inline -->
                                {{-- <!-- <div class="cd-success-title-row">
                                    <img src="{{ asset('storage/SellerImages/success-badge.png') }}"
                                        alt="Success Badge Background" class="cd-success-badge" />
                                    <h1 class="cd-heading">Welcome Aboard!</h1>
                                </div> --> --}}

                                <!-- Subtext -->
                                <p class="cd-subheading">Your account has been verified successfully</p>

                                <!-- Redirect button -->
                                <a href="#" class="mcp-btn w-full cd-success-redirect-btn">
                                    Redirecting to next step
                                    <i class="fas fa-arrow-right"></i>
                                </a>

                                <!-- Security note -->
                                <p class="cd-subheading cd-success-secure-text">Your information is secure and
                                    encrypted
                                </p>

                            </div>
                        </div>
                        <!-- /screen-success -->
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

<footer class="mt-lg">
    <div class="wrapper mt-0 px-5">
        <div class="container max-w-container mx-auto">
            <div class="grid grid-cols-2 gap-9 md:grid-cols-4 md:gap-28 text-center py-[50px]">
                <div><a href="#!" class="footer-link">Shipping Policy</a></div>
                <div><a href="#!" class="footer-link">Terms &amp; Conditions</a></div>
                <div><a href="#!" class="footer-link">Cancellation Policy</a></div>
                <div><a href="#!" class="footer-link">Privacy Policy</a></div>
            </div>
        </div>
        <div class="text-center">
            <p class="font-sans font-normal text-base leading-tight tracking-1 text-black/50">CuddlyDuddly @
                2025
            </p>
        </div>
    </div>
</footer>

<script src="{{ asset('js/seller-registration.js') }}" defer></script>

</html>
