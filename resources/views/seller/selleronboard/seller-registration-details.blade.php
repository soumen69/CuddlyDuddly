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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
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
                    <div id="cd-form-pane" class="cd-form-pane">
                        <form id="cd-seller-registration-form" method="POST"
                            action="{{ route('business-details.register') }}">
                            @csrf
                            <!-- ════ STEPPER (always visible) ════ -->
                            <div class="cd-stepper">
                                <div class="cd-step-circle cd-step-circle--active" id="cd-step-1">1</div>
                                <div class="cd-step-line" id="cd-line-12"></div>
                                <div class="cd-step-circle" id="cd-step-2">2</div>
                                <div class="cd-step-line" id="cd-line-23"></div>
                                <div class="cd-step-circle" id="cd-step-3">3</div>
                                <div class="cd-step-line" id="cd-line-34"></div>
                                <div class="cd-step-circle" id="cd-step-4">4</div>
                            </div>

                            <!-- ═══════════════════════════════════════
               SUB-SCREEN 1a — Business Details
               (Step 1 stepper stays active)
              ═══════════════════════════════════════ -->
                            <div id="cd-sub-1a">

                                <h2 class="cd-heading">Business Details</h2>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-legal-name">
                                        Legal Business Name <span class="cd-required">*</span>
                                    </label>
                                    <input id="cd-legal-name" name="legal_business_name" class="cd-input" type="text"
                                        placeholder="Enter legal business name" />
                                </div>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-store-name">
                                        Store Display Name <span class="cd-required">*</span>
                                    </label>
                                    <input id="cd-store-name" name="store_display_name" class="cd-input" type="text"
                                        placeholder="Enter your store name" />
                                </div>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-biz-type">
                                        Business Type <span class="cd-required">*</span>
                                    </label>
                                    <select id="cd-biz-type" name="business_type" class="cd-select">
                                        <option value="" disabled selected>Select business type</option>
                                        <option value="sole">Sole Proprietorship</option>
                                        <option value="partnership">Partnership</option>
                                        <option value="pvt">Private Limited</option>
                                        <option value="llp">LLP</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <!-- GST Toggle -->
                                <div class="cd-field-group">
                                    <label class="cd-field-label">I have GST number</label>
                                    <div class="cd-gst-toggle-row">
                                        <!-- Yes pill -->
                                        <input type="radio" id="cd-gst-yes" name="gst_available" class="cd-gst-radio"
                                            value="yes" checked onchange="cdGstToggle('yes')" />
                                        <label for="cd-gst-yes" class="cd-gst-pill-label">Yes</label>

                                        <!-- No pill -->
                                        <input type="radio" id="cd-gst-no" name="gst_available"
                                            class="cd-gst-radio" value="no" onchange="cdGstToggle('no')" />
                                        <label for="cd-gst-no" class="cd-gst-pill-label">No</label>
                                    </div>
                                </div>

                                <!-- GST Number — visible only when Yes is selected -->
                                <div class="cd-field-group" id="cd-gst-field">
                                    <label class="cd-field-label" for="cd-gst-number">
                                        GST Number <span class="cd-required">*</span>
                                    </label>
                                    <input id="cd-gst-number" class="cd-input" name="gst_number" type="text"
                                        maxlength="15" placeholder="Enter 15-digit GSTIN"
                                        oninput="this.value=this.value.toUpperCase()" />
                                </div>

                                <div id="cd-toast-1a" class="cd-toast"></div>

                                <button type="button" class="mcp-btn w-full mt-2" onclick="cdSub1aContinue()">
                                    Continue <i class="fas fa-arrow-right"></i>
                                </button>
                                <button type="button" class="cd-back-text-link"
                                    onclick="history.back()">Back</button>

                            </div>
                            <!-- /sub-1a -->


                            <!-- ═══════════════════════════════════════
               SUB-SCREEN 1b — PAN, Contact & Address
               (Step 1 stepper still active)
          ═══════════════════════════════════════ -->
                            <div id="cd-sub-1b" class="cd-screen--hidden">

                                <h2 class="cd-heading">PAN and Contact Details</h2>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-pan">
                                        PAN Number <span class="cd-required">*</span>
                                    </label>
                                    <input id="cd-pan" class="cd-input" name="pan_number" type="text"
                                        maxlength="10" placeholder="Enter PAN number"
                                        oninput="this.value=this.value.toUpperCase()" />
                                </div>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-pan-name">
                                        Name <span class="cd-required">*</span>
                                    </label>
                                    <input id="cd-pan-name" class="cd-input" name="pan_name" type="text"
                                        placeholder="Name as per PAN" />
                                </div>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-email">
                                        Email Address <span class="cd-required">*</span>
                                    </label>
                                    <input id="cd-email" class="cd-input" name="email" type="email"
                                        placeholder="your@email@example.com" />
                                </div>

                                <h2 class="cd-heading">Address Details</h2>

                                <div class="cd-field-row">
                                    <div class="cd-field-group">
                                        <label class="cd-field-label" for="cd-city">City <span
                                                class="cd-required">*</span></label>
                                        <input id="cd-city" class="cd-input" name="city" type="text"
                                            placeholder="City" />
                                    </div>
                                    <div class="cd-field-group">
                                        <label class="cd-field-label" for="cd-state">State <span
                                                class="cd-required">*</span></label>
                                        <input id="cd-state" class="cd-input" name="state" type="text"
                                            placeholder="State" />
                                    </div>
                                </div>

                                <div class="cd-field-row">
                                    <div class="cd-field-group">
                                        <label class="cd-field-label" for="cd-district">District <span
                                                class="cd-required">*</span></label>
                                        <input id="cd-district" class="cd-input" name="district" type="text"
                                            placeholder="State" />
                                    </div>
                                    <div class="cd-field-group">
                                        <label class="cd-field-label" for="cd-pincode">
                                            Pincode <span class="cd-required">*</span>
                                        </label>

                                        <div style="position: relative;">
                                            <input id="cd-pincode" class="cd-input" name="pincode" type="text"
                                                maxlength="6" placeholder="Enter Pincode"
                                                oninput="this.value=this.value.replace(/\D/g,'')" />

                                            <!-- Loader -->
                                            <span id="cd-pincode-loader"
                                                style="display:none;position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:12px;">
                                                ⏳
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-building">
                                        Room/ Floor/ Building Number <span class="cd-required">*</span>
                                    </label>
                                    <input id="cd-building" class="cd-input" name="building_number" type="text"
                                        placeholder="Type" />
                                </div>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-street">Street/Locality/Landmark</label>
                                    <input id="cd-street" class="cd-input" name="street" type="text"
                                        placeholder="Type" />
                                </div>

                                <!-- CAPTCHA row -->
                                <div class="cd-captcha-row">
                                    <button type="button" class="cd-captcha-btn" id="cd-captcha-btn"
                                        onclick="cdRequestCaptcha()">
                                        <i class="fas fa-shield-alt"></i>
                                        Request CAPTCHA
                                    </button>
                                    <img id="cd-captcha-img" class="cd-captcha-logo" alt="CAPTCHA"
                                        style="display:none" />
                                </div>

                                <div class="cd-field-group">
                                    <input id="cd-captcha-val" name="captcha" class="cd-input" type="text"
                                        placeholder="Type the characters" autocomplete="off" />
                                </div>

                                <div id="cd-toast-1b" class="cd-toast"></div>

                                <button id="cd-sub-1b-continue" type="button" class="mcp-btn w-full"
                                    onclick="cdSub1bContinue()">
                                    Continue <i class="fas fa-arrow-right"></i>
                                </button>
                                <button type="button" class="cd-back-text-link"
                                    onclick="cdShowSub('1a')">Back</button>

                            </div>
                            <!-- /sub-1b -->


                            <!-- ═══════════════════════════════════════
               STEP 2 — Pickup Address
          ═══════════════════════════════════════ -->
                            <div id="cd-sub-2" class="cd-screen--hidden">

                                <h2 class="cd-heading">Pickup Address</h2>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-addr1">
                                        Address Line 1 <span class="cd-required">*</span>
                                    </label>
                                    <input id="cd-addr1" name="pickup_address_line1" class="cd-input"
                                        type="text" placeholder="House/Plot/Building No." />
                                </div>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-addr2">
                                        Address Line 2 <span class="cd-required">*</span>
                                    </label>
                                    <input id="cd-addr2" name="pickup_address_line2" class="cd-input"
                                        type="text" placeholder="Street/Area/Locality" />
                                </div>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-p-pincode">
                                        Pincode <span class="cd-required">*</span>
                                    </label>
                                    <input id="cd-p-pincode" name="pickup_pincode" class="cd-input" type="text"
                                        maxlength="6" placeholder="Enter 6 digit pincode"
                                        oninput="this.value=this.value.replace(/\D/g,''); if (window.cdTriggerPickupPincodeLookup) window.cdTriggerPickupPincodeLookup();" />
                                </div>

                                <div class="cd-field-row">
                                    <div class="cd-field-group">
                                        <label class="cd-field-label" for="cd-p-city">City <span
                                                class="cd-required">*</span></label>
                                        <input id="cd-p-city" class="cd-input" name="pickup_city" type="text"
                                            placeholder="City" />
                                    </div>
                                    <div class="cd-field-group">
                                        <label class="cd-field-label" for="cd-p-state">State <span
                                                class="cd-required">*</span></label>
                                        <input id="cd-p-state" class="cd-input" name="pickup_state" type="text"
                                            placeholder="State" />
                                    </div>
                                </div>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-landmark">Landmark (Optional)</label>
                                    <input id="cd-landmark" class="cd-input" name="pickup_landmark" type="text"
                                        placeholder="e.g., Near City Mall" />
                                </div>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-contact-name">
                                        Contact Person Name <span class="cd-required">*</span>
                                    </label>
                                    <input id="cd-contact-name" name="contact_person_name" class="cd-input"
                                        type="text" placeholder="Full name of contact person" />
                                </div>

                                <div class="cd-field-row">
                                    <div>
                                        <label class="cd-field-label">
                                            Contact Mobile Number <span class="cd-required">*</span>
                                        </label>
                                        <div class="cd-phone-wrap">
                                            <span class="cd-phone-prefix">+91</span>
                                            <input id="cd-contact-mobile" name="contact_mobile"
                                                class="cd-phone-input" type="tel" maxlength="10"
                                                oninput="this.value=this.value.replace(/\D/g,'')" />
                                        </div>
                                    </div>
                                    <div>
                                        <label class="cd-field-label">Mobile Number (Optional)</label>
                                        <div class="cd-phone-wrap">
                                            <span class="cd-phone-prefix">+91</span>
                                            <input id="cd-alt-mobile" name="alternate_mobile" class="cd-phone-input"
                                                type="tel" maxlength="10"
                                                oninput="this.value=this.value.replace(/\D/g,'')" />
                                        </div>
                                    </div>
                                </div>

                                <div id="cd-toast-2" class="cd-toast"></div>

                                <button type="button" class="mcp-btn w-full" onclick="cdStep2Continue()">
                                    Continue <i class="fas fa-arrow-right"></i>
                                </button>
                                <button type="button" class="cd-back-text-link"
                                    onclick="cdShowSub('1b')">Back</button>

                            </div>
                            <!-- /sub-2 -->


                            <!-- ═══════════════════════════════════════
               STEP 3 — Bank Details
          ═══════════════════════════════════════ -->
                            <div id="cd-sub-3" class="cd-screen--hidden">

                                <h2 class="cd-heading">Bank Details</h2>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-account-holder">
                                        Account Holder Name <span class="cd-required">*</span>
                                    </label>
                                    <input id="cd-account-holder" name="account_holder_name" class="cd-input"
                                        type="text" placeholder="As per bank records" />
                                </div>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-bank-name">
                                        Bank Name <span class="cd-required">*</span>
                                    </label>
                                    <select id="cd-bank-name" name="bank_name" class="cd-select">
                                        <option value="" disabled selected>Select your bank</option>
                                        <option>State Bank of India</option>
                                        <option>HDFC Bank</option>
                                        <option>ICICI Bank</option>
                                        <option>Axis Bank</option>
                                        <option>Kotak Mahindra Bank</option>
                                        <option>Punjab National Bank</option>
                                        <option>Bank of Baroda</option>
                                        <option>Canara Bank</option>
                                        <option>IndusInd Bank</option>
                                        <option>Yes Bank</option>
                                        <option>Other</option>
                                    </select>
                                </div>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-acc-num">
                                        Account Number <span class="cd-required">*</span>
                                    </label>
                                    <input id="cd-acc-num" class="cd-input" name="account_number" type="password"
                                        placeholder="Enter account number" />
                                </div>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-acc-num-confirm">
                                        Confirm Account Number <span class="cd-required">*</span>
                                    </label>
                                    <input id="cd-acc-num-confirm" class="cd-input" name="confirm_account_number"
                                        type="text" placeholder="Enter account number" />
                                </div>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-ifsc">
                                        IFSC Code <span class="cd-required">*</span>
                                    </label>
                                    <input id="cd-ifsc" name="ifsc_code" class="cd-input" type="text"
                                        maxlength="11" placeholder="Enter 11-character IFSC code"
                                        oninput="this.value=this.value.toUpperCase()" />
                                </div>

                                <p class="cd-secure-note">our bank details are encrypted and secure</p>

                                <div id="cd-toast-3" class="cd-toast"></div>

                                <button type="button" class="mcp-btn w-full mt-2" onclick="cdStep3Continue()">
                                    Continue <i class="fas fa-arrow-right"></i>
                                </button>
                                <button type="button" class="cd-back-text-link"
                                    onclick="cdShowSub('2')">Back</button>

                            </div>
                            <!-- /sub-3 -->


                            <!-- ═══════════════════════════════════════
               STEP 4 — Supplier Details
          ═══════════════════════════════════════ -->
                            <div id="cd-sub-4" class="cd-screen--hidden">

                                <h2 class="cd-heading">Supplier Details</h2>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-categories">
                                        Product Categories <span class="cd-required">*</span>
                                    </label>
                                    @php
                                        $selectedCategories = old('product_categories', []);
                                        if (is_string($selectedCategories)) {
                                            $selectedCategories = [$selectedCategories];
                                        }
                                        if (!is_array($selectedCategories)) {
                                            $selectedCategories = [];
                                        }
                                    @endphp
                                    <select id="cd-categories" name="product_categories[]" class="cd-select" multiple
                                        data-placeholder="Select categories you want to sell">
                                        <option></option>
                                        @if (isset($categoryTree) && $categoryTree->count())
                                            @foreach ($categoryTree as $section)
                                                <option value="{{ $section->id }}"
                                                    {{ in_array((string) $section->id, array_map('strval', $selectedCategories)) ? 'selected' : '' }}>
                                                    {{ $section->name ?? '' }}
                                                 </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="text-xs text-[rgba(75,74,74,0.55)] mt-1.5">You can select multiple
                                        products</p>
                                </div>




                                
                                <h2 class="cd-heading">Business Capacity</h2>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-capacity">
                                        Monthly Order Capacity <span class="cd-required">*</span>
                                    </label>
                                    <select id="cd-capacity" name="monthly_order_capacity" class="cd-select">
                                        <option value="" disabled selected>Select your capacity</option>
                                        <option value="lt50">Less than 50 orders</option>
                                        <option value="50-200">50 – 200 orders</option>
                                        <option value="200-500">200 – 500 orders</option>
                                        <option value="500-1000">500 – 1000 orders</option>
                                        <option value="gt1000">More than 1000 orders</option>
                                    </select>
                                </div>

                                <div class="cd-field-group">
                                    <label class="cd-field-label" for="cd-dispatch">
                                        Average Dispatch Time <span class="cd-required">*</span>
                                    </label>
                                    <select id="cd-dispatch" name="average_dispatch_time" class="cd-select">
                                        <option value="" disabled selected>Select dispatch time</option>
                                        <option value="same">Same day</option>
                                        <option value="1">Within 1 day</option>
                                        <option value="2-3">2 – 3 days</option>
                                        <option value="3-5">3 – 5 days</option>
                                        <option value="gt5">More than 5 days</option>
                                    </select>
                                </div>

                                <div id="cd-toast-4" class="cd-toast"></div>

                                <button type="submit" class="mcp-btn w-full">
                                    Continue &amp; Send OTP <i class="fas fa-arrow-right"></i>
                                </button>
                                <button type="button" class="cd-back-text-link"
                                    onclick="cdShowSub('3')">Back</button>
                            </div>
                    </div>
                    </form>

                </div>
            </main>

        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        window.cdPincodeLookupUrl = "{{ route('pincode.lookup', ['pin' => '__PIN__']) }}";
    </script>
    <script src="{{ asset('js/seller-registration.js') }}"></script>
    <script>
        (function() {
            if (typeof window.jQuery === 'undefined' || typeof jQuery.fn.select2 !== 'function') return;
            const $el = jQuery('#cd-categories');
            if (!$el.length) return;
            $el.select2({
                width: '100%',
                placeholder: $el.data('placeholder') || 'Select categories',
                closeOnSelect: false
            });
        })();
    </script>


    <!--footer-->
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

</body>

</html>
