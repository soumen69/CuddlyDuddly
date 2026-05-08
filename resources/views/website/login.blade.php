<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cuddly Duddly – Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <!-- Tailwind CDN -->
</head>

<body class="bg-white max-[1200px]:overflow-y-auto contact">
    <!-- Logo -->
    <div class="flex justify-center pt-5 pb-5">
        <img src="{{ asset('storage/WebsiteImages/companylogoContact.webp') }}" alt="Cuddly Duddly"
            class="max-w-[280px] md:max-w-[380px]">
    </div>

    <!-- Card -->
    <div class="px-4 pb-10">
        <div class="main relative contact-main">

            <!-- Progress Bar -->
            <div id="progress-container" class="progress-container">
                <div class="progress-bar"></div>
            </div>

            <!-- Left Image -->
            <div class="contact-left hidden md:block">
                <img src="{{ asset('storage/WebsiteImages/motherandchildContact.png') }}" alt="Mother and baby">
            </div>

            <!-- Right Content -->
            <div class="contact-right">

                <!-- Slider -->
                <div id="slider" class="flex w-full transition-transform duration-500 ease-in-out">

                    <!-- Signin -->
                    <div class="w-full h-full shrink-0 flex flex-col justify-center min-w-0">
                        <div class="w-full px-6 md:px-12">
                            <h2 class="contact-heading">Sign in or Create an Account</h2>
                            <p class="contact-subtext">Let’s get you started.</p>

                            {{-- <label class="contact-label">Enter your Email-Id or Mobile No</label> --}}
                            <div class="contact-input-wrapper">
                                {{-- <span class="contact-country-code">+91</span> --}}
                                <input id="identifierInput" type="text"
                                    placeholder="Enter your Email-Id or Mobile No" required>
                            </div>
                            <p id="identifierError" class="text-red-500 text-sm mt-1 hidden"></p>

                            <p class="contact-text">
                                By continuing, you agree to Cuddly Duddly’s
                                <a href="#" class="text-pink-600 font-medium hover:underline">Terms of use</a>
                                and
                                <a href="#" class="text-pink-600 font-medium hover:underline">Privacy Policy</a>.
                            </p>

                            <button id="continueBtn" class="contact-primary-btn">
                                <span class="btn-text">Continue →</span>
                                <span class="btn-loader hidden">Sending...</span>
                            </button>
                            <a href="{{ route('google.login') }}" class="contact-secondary-btn">
                                <img src="{{ asset('storage/WebsiteImages/google.png') }}" class="w-5 h-5">
                                Continue with Google
                            </a>
                            <div class="flex items-center gap-4 my-6">
                                <div class="flex-1 h-px bg-gray-200"></div>
                                <span class="text-sm text-gray-400">or</span>
                                <div class="flex-1 h-px bg-gray-200"></div>
                            </div>

                            <!-- Seller -->
                            <p class="text-[18px] text-gray-700">
                                Become a seller?
                            </p>
                            <a href="#" class="text-pink-600 text-[18px] font-medium underline mt-1">
                                Create a free Seller account
                            </a>

                        </div>
                    </div>

                    <!-- OTP -->
                    <div class="w-full shrink-0 flex flex-col justify-center min-w-0">
                        <div class="w-full px-6 md:px-12 ">
                            <label class="contact-label inline-block w-full">Enter OTP</label>
                            <div class="contact-input-wrapper">
                                <input id="otpInput" type="text" maxlength="6" placeholder="Enter 6-digit OTP">
                            </div>
                            <p id="otpError" class="text-red-500 text-sm mt-1 hidden"></p>
                            <div class="mt-3 text-sm text-gray-500">
                                <span id="resendText">Didn't receive OTP?</span>
                                <button id="resendBtn" class="text-pink-600 font-medium ml-1 hidden">Resend</button>
                                <span id="resendTimer" class="mt-2"></span>
                            </div>
                            <button id="verifyBtn" class="contact-primary-btn">
                                <span class="btn-text">Verify →</span>
                                <span class="btn-loader hidden">Verifying...</span>
                            </button>
                            <button id="backBtn" class="contact-secondary-btn">← Back</button>
                        </div>
                    </div>

                    <!-- Profile -->
                    <div class="w-full shrink-0 flex flex-col justify-center min-w-0">
                        <div class="w-full px-6 md:px-12">
                            <label class="contact-label inline-block w-full">Your Name</label>
                            <div class="contact-input-wrapper">
                                <input id="nameInput" type="text" placeholder="Enter your full name">
                            </div>

                            <label id="secondaryLabel" class="contact-label mt-4 inline-block w-full">Email /
                                Mobile</label>
                            <div class="contact-input-wrapper">
                                <input id="secondaryInput" type="text" placeholder="">
                            </div>
                            <button id="saveProfileBtn" class="contact-primary-btn">
                                <span class="btn-text">Continue →</span>
                                <span class="btn-loader hidden">Saving...</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <footer class="contact-footer">
        <div class="wrapper">
            <div class="text-center">
            </div>
        </div>
    </footer>
    {{-- <script>
        /* ------------------ ELEMENTS ------------------ */
        const slider = document.getElementById("slider");
        const continueBtn = document.getElementById("continueBtn");
        const verifyBtn = document.getElementById("verifyBtn");
        const backBtn = document.getElementById("backBtn");
        const saveProfileBtn = document.getElementById("saveProfileBtn");

        const progressContainer = document.getElementById("progress-container");
        const progressBar = document.querySelector(".progress-bar");

        const identifierInput = document.getElementById("identifierInput");
        const otpInput = document.getElementById("otpInput");
        const nameInput = document.getElementById("nameInput");
        const secondaryInput = document.getElementById("secondaryInput");

        const identifierError = document.getElementById("identifierError");
        const otpError = document.getElementById("otpError");
        const secondaryLabel = document.getElementById("secondaryLabel");

        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        let currentSlide = 0;

        /* -------- GLOBAL STATE (IMPORTANT FIX) -------- */
        let identifierGlobal = "";
        let identifierTypeGlobal = "";

        /* ------------------ SLIDER ------------------ */
        function goToSlide(index) {
            currentSlide = index;
            slider.style.transform = `translateX(-${index * 100}%)`;
        }

        /* ------------------ HELPERS ------------------ */
        function showError(el, msg) {
            el.innerText = msg;
            el.classList.remove("hidden");
        }

        function clearError(el) {
            el.innerText = "";
            el.classList.add("hidden");
        }

        /* ------------------ PROGRESS ------------------ */
        function showProgress() {
            progressContainer.classList.add("visible");
            progressBar.style.transition = "none";
            progressBar.style.width = "0%";

            setTimeout(() => {
                progressBar.style.transition = "width linear";
                progressBar.style.width = "90%"; // stays until response
            }, 50);
        }

        function hideProgress() {
            progressBar.style.transition = "width 0.3s ease-out";
            progressBar.style.width = "100%";

            setTimeout(() => {
                progressContainer.classList.remove("visible");
                progressBar.style.width = "0%";
                progressBar.style.transition = "none";
            }, 350);
        }

        /* ------------------ CONTINUE CLICK ------------------ */
        continueBtn.addEventListener("click", async () => {
            let identifier = identifierInput.value.trim();
            if (!identifier) {
                showError(identifierError, "Please enter email or phone");
                return;
            }
            clearError(identifierError);

            identifierGlobal = identifier;
            identifierTypeGlobal = identifier.includes("@") ? "email" : "phone";

            continueBtn.disabled = true;
            showProgress();

            try {
                const res = await fetch('/auth/send-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({
                        identifier
                    })
                });

                const data = await res.json();

                if (!res.ok) {
                    showError(identifierError, data.message || "Failed");
                    return;
                }

                goToSlide(1);
                setTimeout(() => otpInput.focus(), 250);

            } catch (err) {
                console.error(err);
                showError(identifierError, "Network error");
            } finally {
                hideProgress();
                continueBtn.disabled = false;
            }
        });

        /* ------------------ VERIFY CLICK ------------------ */
        verifyBtn.addEventListener("click", async () => {
            const otp = otpInput.value.trim();
            if (otp.length !== 6) {
                showError(otpError, "Enter valid OTP");
                return;
            }
            clearError(otpError);

            verifyBtn.disabled = true;
            backBtn.disabled = true;
            showProgress();

            try {
                const res = await fetch('/auth/verify-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({
                        identifier: identifierGlobal,
                        otp: otp
                    })
                });

                const data = await res.json();

                if (!res.ok) {
                    showError(otpError, data.message || "OTP Failed");
                    return;
                }

                if (data.is_new) {
                    if (identifierTypeGlobal === "email") {
                        secondaryLabel.innerText = "Mobile Number";
                        secondaryInput.placeholder = "Enter mobile number";
                    } else {
                        secondaryLabel.innerText = "Email Address";
                        secondaryInput.placeholder = "Enter email address";
                    }
                    goToSlide(2);
                    setTimeout(() => nameInput.focus(), 250);
                } else if (data.redirect) {
                    window.location.href = data.redirect;
                }

            } catch (err) {
                console.error(err);
                showError(otpError, "Network error");
            } finally {
                hideProgress();
                verifyBtn.disabled = false;
                backBtn.disabled = false;
            }
        });

        /* ------------------ PROFILE SAVE ------------------ */
        saveProfileBtn.addEventListener("click", async () => {
            const name = nameInput.value.trim();
            const secondary = secondaryInput.value.trim();

            if (!name) return showError(otpError, "Enter name");
            if (!secondary) return showError(otpError, "Enter required field");

            saveProfileBtn.disabled = true;
            showProgress();

            try {
                const res = await fetch('/auth/complete-profile', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({
                        identifier: identifierGlobal,
                        identifier_type: identifierTypeGlobal,
                        name,
                        secondary
                    })
                });

                const data = await res.json();
                if (data.redirect) window.location.href = data.redirect;

            } catch (err) {
                console.error(err);
                showError(otpError, "Network error");
            } finally {
                hideProgress();
                saveProfileBtn.disabled = false;
            }
        });

        /* ------------------ BACK CLICK ------------------ */
        backBtn.addEventListener("click", () => {
            otpInput.value = "";
            clearError(otpError);
            goToSlide(0);
        });

        /* ------------------ CLEAR OTP ERROR ------------------ */
        otpInput.addEventListener("input", () => clearError(otpError));
    </script> --}}

    <script>
        /* ================== ELEMENTS ================== */
        const slider = document.getElementById("slider");

        const continueBtn = document.getElementById("continueBtn");
        const verifyBtn = document.getElementById("verifyBtn");
        const backBtn = document.getElementById("backBtn");
        const saveProfileBtn = document.getElementById("saveProfileBtn");
        const resendBtn = document.getElementById("resendBtn");

        const identifierInput = document.getElementById("identifierInput");
        const otpInput = document.getElementById("otpInput");
        const nameInput = document.getElementById("nameInput");
        const secondaryInput = document.getElementById("secondaryInput");

        const identifierError = document.getElementById("identifierError");
        const otpError = document.getElementById("otpError");
        const secondaryLabel = document.getElementById("secondaryLabel");

        const progressContainer = document.getElementById("progress-container");
        const progressBar = document.querySelector(".progress-bar");
        const resendTimer = document.getElementById("resendTimer");

        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        /* ================== STATE ================== */
        let currentSlide = 0;
        let identifierGlobal = "";
        let identifierTypeGlobal = "";
        let resendInterval = null;

        /* ================== HELPERS ================== */
        const goToSlide = (index) => {
            currentSlide = index;
            slider.style.transform = `translateX(-${index * 100}%)`;
        };

        const showError = (el, msg) => {
            el.innerText = msg;
            el.classList.remove("hidden");
        };

        const clearError = (el) => {
            el.innerText = "";
            el.classList.add("hidden");
        };

        const toggleLoading = (btn, isLoading, text = "Processing...") => {
            const textEl = btn.querySelector(".btn-text");
            const loaderEl = btn.querySelector(".btn-loader");

            if (isLoading) {
                btn.disabled = true;
                textEl.classList.add("hidden");
                loaderEl.classList.remove("hidden");
                loaderEl.innerText = text;
            } else {
                btn.disabled = false;
                textEl.classList.remove("hidden");
                loaderEl.classList.add("hidden");
            }
        };

        const showProgress = () => {
            progressContainer.classList.add("visible");
            progressBar.style.width = "0%";
            setTimeout(() => progressBar.style.width = "90%", 50);
        };

        const hideProgress = () => {
            progressBar.style.width = "100%";
            setTimeout(() => {
                progressContainer.classList.remove("visible");
                progressBar.style.width = "0%";
            }, 300);
        };

        const isEmail = (val) => /\S+@\S+\.\S+/.test(val);
        const isPhone = (val) => /^[0-9]{10,15}$/.test(val.replace(/\D/g, ''));

        /* ================== API HELPER ================== */
        const apiCall = async (url, body) => {
            const res = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrf
                },
                body: JSON.stringify(body)
            });

            const data = await res.json();
            if (!res.ok) throw data;
            return data;
        };

        /* ================== RESEND TIMER ================== */
        const startResendTimer = (seconds = 30) => {
            resendBtn.classList.add("hidden");

            let time = seconds;
            resendTimer.innerText = `(${time}s)`;

            resendInterval = setInterval(() => {
                time--;
                resendTimer.innerText = `(${time}s)`;

                if (time <= 0) {
                    clearInterval(resendInterval);
                    resendTimer.innerText = "";
                    resendBtn.classList.remove("hidden");
                }
            }, 1000);
        };

        /* ================== EVENTS ================== */

        // ENTER KEY SUPPORT
        identifierInput.addEventListener("keypress", e => e.key === "Enter" && continueBtn.click());
        otpInput.addEventListener("keypress", e => e.key === "Enter" && verifyBtn.click());
        nameInput.addEventListener("keypress", e => e.key === "Enter" && saveProfileBtn.click());

        // CONTINUE (SEND OTP)
        continueBtn.addEventListener("click", async () => {
            const identifier = identifierInput.value.trim();

            if (!identifier)
                return showError(identifierError, "Enter email or mobile");

            if (!isEmail(identifier) && !isPhone(identifier))
                return showError(identifierError, "Invalid email or mobile");

            clearError(identifierError);

            identifierGlobal = identifier;
            identifierTypeGlobal = isEmail(identifier) ? "email" : "phone";

            toggleLoading(continueBtn, true, "Sending OTP...");
            showProgress();

            try {
                await apiCall('/auth/send-otp', {
                    identifier,
                    is_resend: false
                });

                goToSlide(1);
                startResendTimer();
                setTimeout(() => otpInput.focus(), 200);

            } catch (err) {
                showError(identifierError, err.message || "Failed");
            } finally {
                hideProgress();
                toggleLoading(continueBtn, false);
            }
        });

        // VERIFY OTP
        verifyBtn.addEventListener("click", async () => {
            const otp = otpInput.value.trim();

            if (!/^\d{6}$/.test(otp))
                return showError(otpError, "Enter valid 6-digit OTP");

            clearError(otpError);

            toggleLoading(verifyBtn, true, "Verifying...");
            backBtn.disabled = true;
            showProgress();

            try {
                const data = await apiCall('/auth/verify-otp', {
                    identifier: identifierGlobal,
                    otp
                });

                if (data.is_new) {
                    secondaryLabel.innerText =
                        identifierTypeGlobal === "email" ? "Mobile Number" : "Email Address";

                    secondaryInput.placeholder =
                        identifierTypeGlobal === "email" ?
                        "Enter mobile number" :
                        "Enter email address";

                    goToSlide(2);
                    setTimeout(() => nameInput.focus(), 200);

                } else if (data.redirect) {
                    window.location.href = data.redirect;
                }

            } catch (err) {
                showError(otpError, err.message || "Invalid OTP");
            } finally {
                hideProgress();
                toggleLoading(verifyBtn, false);
                backBtn.disabled = false;
            }
        });

        resendBtn.addEventListener("click", async () => {
            otpInput.value = ""; // 🔥 clear old OTP
            clearError(otpError);

            startResendTimer();

            try {
                await apiCall('/auth/send-otp', {
                    identifier: identifierGlobal,
                    is_resend: true
                });
            } catch (err) {
                showError(otpError, err.message || "Failed to resend OTP");
            }
        });

        // SAVE PROFILE
        saveProfileBtn.addEventListener("click", async () => {
            const name = nameInput.value.trim();
            const secondary = secondaryInput.value.trim();

            if (!name) return showError(otpError, "Enter your name");
            if (!secondary) return showError(otpError, "Enter required field");

            toggleLoading(saveProfileBtn, true, "Saving...");
            showProgress();

            try {
                const data = await apiCall('/auth/complete-profile', {
                    identifier: identifierGlobal,
                    name,
                    secondary
                });

                if (data.redirect) window.location.href = data.redirect;

            } catch (err) {
                showError(otpError, err.message || "Failed");
            } finally {
                hideProgress();
                toggleLoading(saveProfileBtn, false);
            }
        });

        // BACK
        backBtn.addEventListener("click", () => {
            otpInput.value = "";
            clearError(otpError);
            goToSlide(0);
        });

        // CLEAR ERROR ON INPUT
        otpInput.addEventListener("input", () => clearError(otpError));
        identifierInput.addEventListener("input", () => clearError(identifierError));
    </script>
</body>

</html>
