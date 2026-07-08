@extends('seller.layouts.seller')
@section('title', 'Seller Settings ')

@section('content')

    <div class="seller-profile flex-1 min-w-0">
        @include('seller.layouts.header')
        <div class=" flex flex-col md:flex-row justify-between pt-6 px-6 md:pl-14 md:pr-9 pb-[45px]">
            <div class="w-full">
                <div class="flex items-center gap-4 mb-6">
                    <button type="button" onclick="window.history.back()"
                        class="flex-none w-9 h-9 rounded-full bg-black text-white flex items-center justify-center cursor-pointer">
                        <svg width="25" height="25" viewBox="0 0 35 35" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1182_398)">
                                <path d="M11.4647 21.4961L7.16551 17.1969L11.4647 12.8977" stroke="white"
                                    stroke-width="2.02667" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M7.16523 17.1969L27.2282 17.1969" stroke="white" stroke-width="2.02667"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_1182_398">
                                    <rect width="24.32" height="24.32" fill="white"
                                        transform="translate(17.1968 34.3937) rotate(-135)"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                    <div>
                        <h3
                            class="font-sans font-normal text-lg md:text-xl lg:text-2xl xl:text-3xl leading-tight tracking-1 text-black">
                            Settings
                        </h3>
                    </div>
                </div>

                <div class="settings-tab-wrap">
                    <button class="settings-tab active" onclick="switchTab('business', this)">Business Details</button>
                    {{-- <button class="settings-tab" onclick="switchTab('whatsapp', this)">Whatsapp
                        Notifications</button> --}}
                    {{-- <button class="settings-tab" onclick="switchTab('number', this)">Change Number</button> --}}
                    <button class="settings-tab" onclick="switchTab('legal', this)">Legal and Policies</button>
                    <button class="settings-tab" onclick="switchTab('bank', this)">Bank Details</button>
                </div>

                <div class="settings-content">

                    <!-- ════════════════════════════════════════
                           PANEL 0 — Business Details
                    ════════════════════════════════════════ -->

                    @include('seller.setting.business-details')

                    <!-- ════════════════════════════════════════
                            PANEL 1 — WhatsApp Notifications
                    ════════════════════════════════════════ -->
                    {{-- @include('seller.setting.whatsapp-notification') --}}

                    <!-- ════════════════════════════════════════
                            PANEL 2 — Change Number
                    ════════════════════════════════════════ -->
                    {{-- <div id="panel-number" style="display:none;">

                        <div class="settings-card">
                            <div class="settings-title">Change Primary Mobile Number</div>

                            <div class="form-grid-2 mb-4">
                                <!-- Current -->
                                <div>
                                    <label class="field-label">Current Registered Number</label>
                                    <div class="phone-input-wrap">
                                        <!-- <span class="phone-prefix">+1 (555)</span> -->
                                        <input class="phone-input" type="text" value="+1 (555) 012-3456" disabled>
                                    </div>
                                </div>
                                <!-- New -->
                                <div>
                                    <label class="field-label">Enter New Mobile Number</label>
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <div class="phone-input-wrap flex-1">
                                            <!-- <span class="phone-prefix">+1</span> -->
                                            <input class="phone-input" type="tel" placeholder="5550000000">
                                        </div>
                                        <button class="btn-pink">Send OTP</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-grid-2 mb-4">
                                <div>
                                    <label class="field-label">One-Time Password (OTP)</label>
                                    <div class="otp-row">
                                        <input class="phone-input" type="text" placeholder="Enter OTP" maxlength="6">
                                        <button class="btn-verify">Verify OTP</button>
                                    </div>
                                </div>

                                <div class="setting-info-box">
                                    <i class="fa-solid fa-circle-info"></i> <span>Your number will be used for two-factor
                                        authentication and
                                        official communications only. Changing this will update your WhatsApp settings as
                                        well.</span>
                                </div>
                            </div>
                            <button class="btn-pink">Update Number</button>
                        </div>

                    </div> --}}

                    <!-- ════════════════════════════════════════
                            PANEL 3 — Legal & Store Policies
                    ════════════════════════════════════════ -->
                    @include('seller.setting.legal-policie')

                    <!-- ════════════════════════════════════════
                            PANEL 4 — Bank & Payout Details
                    ════════════════════════════════════════ -->
                    @include('seller.setting.bank-details')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/seller-setting.js') }}"></script>
@endpush
