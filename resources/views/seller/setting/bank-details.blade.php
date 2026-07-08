<div id="panel-bank" style="display:none;">

    <div class="settings-card">
        <div class="settings-title">Bank &amp; Payout Details</div>

        <div class="form-grid-2 mb-8">
            <div>
                <label class="field-label">Account Holder Name</label>
                <div class="phone-input-wrap">
                    <input class="phone-input" type="text" value="{{ $seller->bankDetail?->account_holder_name }}">
                </div>
            </div>
            <div>
                <label class="field-label">Bank Name</label>
                <div class="phone-input-wrap">
                    <input class="phone-input" type="text" value="{{ $seller->bankDetail?->bank_name }}">
                </div>
            </div>
            <div>
                <label class="field-label">Account Number</label>
                <div class="phone-input-wrap">
                    <input class="phone-input" type="text" value="{{ $seller->bankDetail?->account_number }}">
                </div>
            </div>
            <div>
                <label class="field-label">IFSC Code / SWIFT</label>
                <div class="phone-input-wrap">
                    <input class="phone-input" type="text" value="{{ $seller->bankDetail?->ifsc_code }}">
                </div>
            </div>
        </div>
    </div>
</div>
