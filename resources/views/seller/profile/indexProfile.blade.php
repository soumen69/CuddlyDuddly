@extends('seller.layouts.seller')

@section('title', 'Seller Profile')

@section('content')

    <div class="seller-profile flex-1 min-w-0">
        @include('seller.layouts.header')
        <div class=" flex flex-col md:flex-row justify-between pt-6 px-6 md:pl-14 md:pr-9 pb-[45px]">
            <div class="w-full">
                <div class="flex items-center gap-4 mb-6">
                    <button type="button" onclick="window.history.back()"
                        class="flex-none w-9 h-9 rounded-full bg-black text-white flex items-center justify-center cursor-pointer">
                        <svg width="25" height="25" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                            My Profile
                        </h3>
                        <p class="font-sans font-normal text-base leading-tight tracking-1 text-black">
                            Manage your personal information and account security settings.
                        </p>
                    </div>
                </div>


                <form id="profile-form" method="POST" action="{{ route('seller.profile.update', ['seller' => $seller->slug]) }}" enctype="multipart/form-data">
                    @csrf
                <div class="profile-layout">

                    <!-- Sidebar -->
                    <div class="profile-sidebar">
                        <div class="profile-sidebar__avatar-wrap">
                            <div class="profile-sidebar__avatar-ring">
                                <img src="{{ $profile['avatar_url'] }}" alt="{{ $profile['full_name'] }}" id="avatar-preview" />
                            </div>
                            <label id="avatar-upload-label" for="avatar-upload" class="profile-sidebar__upload-overlay">
                                <svg class="profile-sidebar__upload-icon" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </label>
                            <input type="file" name="avatar" id="avatar-upload" accept="image/*" class="hidden"
                                onchange="previewAvatar(this)" />
                        </div>

                        <div class="profile-sidebar__info">
                            <p class="profile-sidebar__name">{{ $profile['full_name'] }}</p>
                            <!-- <span class="profile-sidebar__badge"><span>●</span> ADMIN</span> -->
                            <div class="profile-sidebar__contacts">
                                <div class="profile-sidebar__contact-row">
                                    <svg class="profile-sidebar__contact-icon" fill="none" stroke="currentColor"
                                        stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="profile-sidebar__contact-text">{{ $profile['email'] }}</span>
                                </div>
                                <div class="profile-sidebar__contact-row">
                                    <svg class="profile-sidebar__contact-icon" fill="none" stroke="currentColor"
                                        stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span class="profile-sidebar__contact-text">{{ $profile['mobile'] }}</span>
                                </div>
                            </div>

                            <button type="button" onclick="toggleEdit()" id="edit-profile-btn" class="profile-sidebar__edit-btn">Edit
                                Profile</button>
                        </div>
                    </div>

                    <!-- Main content -->
                    <div class="profile-main">

                        <!-- Personal Details card -->
                        <div class="profile-card">
                            <p class="profile-card__title">Personal Details</p>
                            <p class="profile-card__subtitle">Update your basic identity information here.</p>

                            <div class="profile-form-grid">
                                <div>
                                    <label class="field-label">Full Name</label>
                                    <input type="text" id="field-fullname" name="full_name" class="profile-input" value="{{ old('full_name', $profile['full_name']) }}"
                                        disabled />
                                </div>
                                <div>
                                    <label class="field-label">Email ID</label>
                                    <input type="email" id="field-email" name="email" class="profile-input"
                                        value="{{ old('email', $profile['email']) }}" disabled />
                                </div>
                                <div>
                                    <label class="field-label">Phone Number</label>
                                    <input type="tel" id="field-phone" name="mobile" class="profile-input" value="{{ old('mobile', $profile['mobile']) }}"
                                        disabled />
                                </div>
                                <div class="hidden sm:block"></div>
                                <div class="profile-form-grid--full">
                                    <label class="field-label">Address</label>
                                    <textarea id="field-address" name="address" class="profile-input"
                                        disabled>{{ old('address', $profile['address']) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Account Information card -->
                        <!-- <div class="profile-card">
                            <p class="profile-card__title">Account Information</p>
                            <p class="profile-card__subtitle" style="margin-bottom:1rem;">Read-only account metadata.</p>
                            <div class="account-info-grid">
                                <div>
                                    <p class="account-info-label">Username</p>
                                    <div class="profile-input profile-input--static">asterling_admin</div>
                                </div>
                                <div>
                                    <p class="account-info-label">Role</p>
                                    <div class="profile-input profile-input--static gap-2">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        System Admin
                                    </div>
                                </div>
                                <div>
                                    <p class="account-info-label">Last Login</p>
                                    <div class="profile-input profile-input--static">Oct 24, 2023 – 09:42</div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Account Security card -->
                        <!-- <div class="security-card">
                            <div class="security-card__top">
                                <div class="security-card__left">
                                    <div class="security-card__icon-wrap">
                                        <svg class="security-card__icon" fill="none" stroke="currentColor"
                                            stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="security-card__title">Account Security</p>
                                        <p class="security-card__sub">Update your password or manage 2FA settings.</p>
                                    </div>
                                </div>
                                <button onclick="togglePassword()" id="change-password-btn"
                                    class="btn-change-password">Change Password</button>
                            </div>

                            <div id="password-section" class="password-section">
                                <div class="password-section__inner">
                                    <div>
                                        <label class="field-label">Current Password</label>
                                        <div class="input-wrap">
                                            <input type="password" id="field-current-pass"
                                                placeholder="Enter current password" class="profile-input" />
                                            <button type="button" onclick="toggleVisibility('field-current-pass',this)"
                                                class="input-eye-btn">
                                                <svg class="input-eye-icon" fill="none" stroke="currentColor"
                                                    stroke-width="1.8" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="hidden sm:block"></div>
                                    <div>
                                        <label class="field-label">New Password</label>
                                        <div class="input-wrap">
                                            <input type="password" id="field-new-pass" placeholder="Enter new password"
                                                class="profile-input" />
                                            <button type="button" onclick="toggleVisibility('field-new-pass',this)"
                                                class="input-eye-btn">
                                                <svg class="input-eye-icon" fill="none" stroke="currentColor"
                                                    stroke-width="1.8" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="field-label">Confirm New Password</label>
                                        <div class="input-wrap">
                                            <input type="password" id="field-confirm-pass"
                                                placeholder="Re-enter new password" class="profile-input" />
                                            <button type="button" onclick="toggleVisibility('field-confirm-pass',this)"
                                                class="input-eye-btn">
                                                <svg class="input-eye-icon" fill="none" stroke="currentColor"
                                                    stroke-width="1.8" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div id="password-error" class="sm:col-span-2 hidden">
                                        <p class="field-error" id="password-error-text"></p>
                                    </div>
                                    <div class="sm:col-span-2 flex justify-end gap-3 mt-1">
                                        <button onclick="togglePassword()" class="btn-cancel-outline">Cancel</button>
                                        <button onclick="savePassword()" class="btn-save">Update Password</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Save / Cancel row -->
                        <div id="save-row" class="save-row">
                            <button type="button" onclick="cancelEdit()" class="mcp-btn mcp-btn-outline btn-cancel-outline">Cancel</button>
                            <button type="submit" onclick="saveChanges()" class="mcp-btn btn-save">Save Changes</button>
                        </div>

                    </div><!-- /profile-main -->
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        /* ── Edit mode ────────────────────────────── */
        const editableFields = ['field-fullname', 'field-email', 'field-phone', 'field-address'];
        let editMode = false;

        function toggleEdit() {
            editMode = !editMode;
            const btn = document.getElementById('edit-profile-btn');
            const saveRow = document.getElementById('save-row');
            const uploadLabel = document.getElementById('avatar-upload-label');

            editableFields.forEach(id => {
                const el = document.getElementById(id);
                el.disabled = !editMode;
            });

            if (editMode) {
                btn.textContent = 'Editing...';
                btn.classList.add('profile-sidebar__edit-btn--active');
                saveRow.classList.add('save-row--show');
                uploadLabel.classList.add('profile-sidebar__upload-overlay--show');
            } else {
                btn.textContent = 'Edit Profile';
                btn.classList.remove('profile-sidebar__edit-btn--active');
                saveRow.classList.remove('save-row--show');
                uploadLabel.classList.remove('profile-sidebar__upload-overlay--show');
            }
        }

        function cancelEdit() { if (editMode) toggleEdit(); }

        function saveChanges() {
            showToast('Saving profile changes...');
        }

        document.getElementById('profile-form').addEventListener('submit', function() {
            editableFields.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.disabled = false;
            });
        });

        /* ── Password section ─────────────────────── */
        let passwordOpen = false;

        function togglePassword() {
            passwordOpen = !passwordOpen;
            const section = document.getElementById('password-section');
            const btn = document.getElementById('change-password-btn');
            if (passwordOpen) {
                section.classList.add('password-section--open');
                btn.textContent = 'Cancel';
                btn.classList.add('btn-change-password--cancel');
            } else {
                section.classList.remove('password-section--open');
                btn.textContent = 'Change Password';
                btn.classList.remove('btn-change-password--cancel');
                clearPasswordFields();
            }
        }

        function savePassword() {
            const current = document.getElementById('field-current-pass').value;
            const newPass = document.getElementById('field-new-pass').value;
            const confirm = document.getElementById('field-confirm-pass').value;
            const errBox = document.getElementById('password-error');
            const errText = document.getElementById('password-error-text');
            errBox.classList.add('hidden');
            if (!current || !newPass || !confirm) { errText.textContent = 'All password fields are required.'; errBox.classList.remove('hidden'); return; }
            if (newPass !== confirm) { errText.textContent = 'New password and confirmation do not match.'; errBox.classList.remove('hidden'); return; }
            if (newPass.length < 8) { errText.textContent = 'Password must be at least 8 characters.'; errBox.classList.remove('hidden'); return; }
            showToast('Password updated successfully!');
            togglePassword();
        }

        function clearPasswordFields() {
            ['field-current-pass', 'field-new-pass', 'field-confirm-pass'].forEach(id => document.getElementById(id).value = '');
            document.getElementById('password-error').classList.add('hidden');
        }

        /* ── Eye toggle ───────────────────────────── */
        const eyeOpen = `<svg class="input-eye-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`;
        const eyeClosed = `<svg class="input-eye-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>`;

        function toggleVisibility(fieldId, btn) {
            const field = document.getElementById(fieldId);
            const isPass = field.type === 'password';
            field.type = isPass ? 'text' : 'password';
            btn.innerHTML = isPass ? eyeClosed : eyeOpen;
        }

        /* ── Avatar preview ───────────────────────── */
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => { document.getElementById('avatar-preview').src = e.target.result; };
                reader.readAsDataURL(input.files[0]);
            }
        }

        /* ── Toast ────────────────────────────────── */
        function showToast(msg) {
            const t = document.createElement('div');
            t.className = 'toast';
            t.textContent = msg;
            document.body.appendChild(t);
            setTimeout(() => { t.style.opacity = '0'; setTimeout(() => t.remove(), 300); }, 2500);
        }
    </script>


@endsection
