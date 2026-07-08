    <div id="panel-business">
        <div class="bd-card">
            <div class="bd-card-head">
                <div class="bd-card-title">Manage Business Information</div>
            </div>

            <div class="bd-form-grid">

                <!-- Legal Business Name -->
                <div>
                    <label class="bd-field-label">Legal Business Name</label>
                    <input class="bd-field-input" type="text" value="{{ $seller->businessDetail?->legal_business_name }}" readonly>
                </div>

                <!-- Business Type -->
                <div>
                    <label class="bd-field-label">Business Type</label>
                    <div class="bd-select-wrap">
                        <input class="bd-select" value="{{ $seller->businessDetail?->business_type }}" readonly>
                    </div>
                </div>

                <!-- Store Display Name -->
                <div>
                    <label class="bd-field-label">Store Display Name</label>
                    <input class="bd-field-input" type="text" value="{{ $seller->businessDetail?->store_display_name }}" readonly>
                </div>

                <!-- GST Number -->
                <div>
                    <label class="bd-field-label">GST Number</label>
                    <div class="relative">
                        <input class="bd-field-input" type="text" value="{{ $seller->businessDetail?->gst_number }}" readonly
                            style="padding-right:2.5rem;">
                    </div>
                </div>

                <!-- Address Line 1 -->
                <div>
                    <label class="bd-field-label">Address Line 1</label>
                    <input class="bd-field-input" type="text" value="{{ $seller->pickupAddress?->pickup_address_line1 }}" readonly>
                </div>

                <!-- Address Line 2 -->
                <div>
                    <label class="bd-field-label">Address Line 2</label>
                    <input class="bd-field-input" type="text" value="{{ $seller->pickupAddress?->pickup_address_line2 }}" readonly>
                </div>

                <!-- Pincode -->
                <div>
                    <label class="bd-field-label">Pincode</label>
                    <input class="bd-field-input" type="text" value="{{ $seller->pickupAddress?->pickup_pincode }}" readonly>
                </div>

                <!-- City -->
                <div>
                    <label class="bd-field-label">City</label>
                    <input class="bd-field-input" type="text" value="{{ $seller->pickupAddress?->pickup_city }}" readonly>
                </div>

                <!-- State -->
                <div>
                    <label class="bd-field-label">State</label>
                    <input class="bd-field-input" type="text" value="{{ $seller->pickupAddress?->pickup_state }}" readonly>
                </div>

                <!-- Landmark -->
                <div>
                    <label class="bd-field-label">Landmark (Optional)</label>
                    <input class="bd-field-input" type="text" readonly value="{{ $seller->pickupAddress?->pickup_landmark }}">
                </div>

                <!-- Contact Person Name -->
                <div>
                    <label class="bd-field-label">Contact Person Name</label>
                    <input class="bd-field-input" type="text" readonly value="{{ $seller->pickupAddress?->contact_person_name }}">
                </div>

                <!-- Contact Mobile Number -->
                <div>
                    <label class="bd-field-label">Contact Mobile Number</label>
                    <input class="bd-field-input" type="tel" readonly value="{{ $seller->pickupAddress?->contact_mobile }}">
                </div>

                <!-- Mobile Number (Optional) -->
                <div>
                    <label class="bd-field-label">Mobile Number (Optional)</label>
                    <input class="bd-field-input" type="tel" readonly value="{{ $seller->pickupAddress?->alternate_mobile }}">
                </div>

                <!-- Product Categories -->
                {{-- <div>
                    <label class="bd-field-label">Product Categories</label>
                    <div class="bd-select-wrap">
                        <select class="bd-select">
                            <option value="" disabled selected>Select all categories you want to sell
                            </option>
                            <option>Baby Clothing</option>
                            <option>Strollers &amp; Prams</option>
                            <option>Feeding &amp; Nursing</option>
                            <option>Toys &amp; Games</option>
                        </select>
                        <svg class="bd-select-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round">
                            <path d="M6 9l6 6 6-6" />
                        </svg>
                    </div>
                </div> --}}

                <!-- Monthly Order Capacity -->
                <div>
                    <label class="bd-field-label">Monthly Order Capacity</label>
                    <div class="bd-select-wrap">
                        <input type="text" class="bd-select" value="{{ $seller->supplierDetail?->monthly_order_capacity }}" readonly>
                    </div>
                </div>

                <!-- Average Dispatch Time -->
                <div>
                    <label class="bd-field-label">Average Dispatch Time</label>
                    <div class="bd-select-wrap">
                        <input type="text" class="bd-select" value="{{ $seller->supplierDetail?->average_dispatch_time }}" readonly>
                    </div>
                </div>

            </div>
        </div>
    </div>
