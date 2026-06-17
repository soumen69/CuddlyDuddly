const cdCsrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
const cdCsrfToken = cdCsrfTokenMeta ? cdCsrfTokenMeta.getAttribute("content") : "";
/* ═══════════════════════════════════
   STATE
═══════════════════════════════════ */
let cdMobileNumber = "";
let cdCountdownTimer = null;
let cdSecondsLeft = 30;
let cdGstLookupLast = null;
let cdGstLookupTimer = null;
let cdPanFromGst = null;
let cdPanLookupLast = null;
let cdPanLookupTimer = null;
let cdPanLookupResult = null;
let cdCaptchaLoaded = false;
let cdPincodeLast = null;
let cdPincodeTimer = null;
/* ═══════════════════════════════════
   SCREEN 1 — PHONE FORM
═══════════════════════════════════ */

function cdOnMobileInput(el) {
    const prefixEl = document.getElementById("cd-phone-prefix");
    const emailIconEl = document.getElementById("cd-email-icon");
    const raw = el.value.trimStart();
    const isMobileMode = /^[0-9]*$/.test(raw);

    if (isMobileMode) {
        el.value = raw.slice(0, 10);
        if (prefixEl) prefixEl.style.display = el.value.length ? "inline-block" : "none";
        if (emailIconEl) emailIconEl.style.display = "none";
    } else {
        el.value = raw;
        if (prefixEl) prefixEl.style.display = "none";
        if (emailIconEl) emailIconEl.style.display = "inline-flex";
    }

    el.placeholder = isMobileMode
        ? "Enter mobile number"
        : "Enter email address";

    cdValidateForm();
}

function cdValidateForm() {
    const cdMobileInput = document.getElementById("cd-login-input");
    const cdTermsCheckbox = document.getElementById("cd-terms-checkbox");
    const cdSendBtn = document.getElementById("cd-send-otp-btn");
    if (!cdMobileInput || !cdTermsCheckbox || !cdSendBtn) return;

    const cdMobileVal = cdMobileInput.value.trim();
    const cdTermsVal = cdTermsCheckbox.checked;
    const isMobile = /^[0-9]{10}$/.test(cdMobileVal);
    const isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(cdMobileVal);

    const isValid = (isMobile || isEmail) && cdTermsVal;
    cdSendBtn.disabled = !isValid;

    const prefixEl = document.getElementById("cd-phone-prefix");
    const emailIconEl = document.getElementById("cd-email-icon");
    if (prefixEl) {
        prefixEl.style.display = isMobile ? "inline-block" : "none";
    }
    if (emailIconEl) {
        emailIconEl.style.display = isEmail ? "inline-flex" : "none";
    }
}

function cdShowToast(cdId, cdMessage, cdType) {
    const cdToastEl = document.getElementById(cdId);
    cdToastEl.textContent = cdMessage;
    cdToastEl.className = "cd-toast cd-toast--" + cdType;
    clearTimeout(cdToastEl._timer);
    cdToastEl._timer = setTimeout(() => {
        cdToastEl.className = "cd-toast";
    }, 3500);
}

function cdHandleSendOtp() {
    const inputEl = document.getElementById("cd-login-input");
    const termsEl = document.getElementById("cd-terms-checkbox");
    const btn = document.getElementById("cd-send-otp-btn");

    const input = inputEl.value.trim();
    const termsChecked = termsEl.checked;

    const isMobile = /^[0-9]{10}$/.test(input);
    const isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input);

    if (!input) {
        cdShowToast("cd-toast", "Please enter mobile number or email.", "error");
        return;
    }

    if (!isMobile && !isEmail) {
        cdShowToast("cd-toast", "Enter valid mobile number or email.", "error");
        return;
    }

    if (!termsChecked) {
        cdShowToast("cd-toast", "Please agree to Terms & Conditions.", "error");
        return;
    }

    btn.disabled = true;
    const originalText = btn.innerText;
    btn.innerText = "Sending...";

    fetch('/seller/send-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
        body: JSON.stringify({
            login: input
        })
    })
        .then(async (res) => {
            const data = await res.json();

            if (!res.ok) {
                throw new Error(data.message || "Request failed");
            }

            return data;
        })
        .then(data => {
            if (data.status) {
                if (data.otp) {
                    console.log("Otp for testing:", data.otp);
                }
                cdShowToast("cd-toast", "OTP sent successfully!", "success");

                cdMobileNumber = input;
                window.cdLoginValue = input;

                setTimeout(() => {
                    cdSwitchToOtp();
                }, 500);

            } else {
                cdShowToast("cd-toast", data.message, "error");
            }
        })
        .catch(error => {
            cdShowToast(
                "cd-toast",
                error.message || "Something went wrong.",
                "error"
            );
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerText = originalText;
        });
}


function cdBindSellerRegistrationForm() {
    const cdForm = document.getElementById("cd-seller-registration-form");
    if (!cdForm) return;

    cdForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const cdSub3 = document.getElementById("cd-sub-3");
        if (cdSub3 && cdSub3.classList.contains("cd-screen--hidden")) return;
        cdStep4Submit();
    });
}


function cdInitRegistrationForm() {
    cdValidateForm();
    cdBindSellerRegistrationForm();

    const cdGstEl = document.getElementById("cd-gst-number");
    if (cdGstEl) {
        cdGstEl.addEventListener("input", () => {
            clearTimeout(cdGstLookupTimer);
            cdGstLookupTimer = setTimeout(cdLookupGstIfNeeded, 450);
        });
        cdGstEl.addEventListener("blur", cdLookupGstIfNeeded);
    }

    const cdPanEl = document.getElementById("cd-pan");
    if (cdPanEl) {
        cdPanEl.addEventListener("input", () => {
            clearTimeout(cdPanLookupTimer);
            cdPanLookupTimer = setTimeout(cdLookupPanIfNeeded, 350);
        });
        cdPanEl.addEventListener("blur", cdLookupPanIfNeeded);
    }

    const cdPinEl = document.getElementById("cd-p-pincode");
    if (cdPinEl) {
        const cdSchedulePincodeLookup = () => {
            clearTimeout(cdPincodeTimer);
            cdPincodeTimer = setTimeout(initPincodeLookup, 300);
        };
        cdPinEl.addEventListener("input", cdSchedulePincodeLookup);
        cdPinEl.addEventListener("keyup", cdSchedulePincodeLookup);
        cdPinEl.addEventListener("change", initPincodeLookup);
        cdPinEl.addEventListener("blur", initPincodeLookup);
        cdPinEl.dataset.pincodeBound = "1";
    }
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", cdInitRegistrationForm);
} else {
    cdInitRegistrationForm();
}

document.addEventListener("input", (e) => {
    if (!e.target || e.target.id !== "cd-p-pincode") return;
    clearTimeout(cdPincodeTimer);
    cdPincodeTimer = setTimeout(initPincodeLookup, 300);
});

/* ═══════════════════════════════════
   SCREEN TRANSITION
═══════════════════════════════════ */

function cdSwitchToOtp() {
    const loginValue = (window.cdLoginValue || cdMobileNumber || "").trim();
    const isMobile = /^[0-9]{10}$/.test(loginValue);
    const displayValue = isMobile ? `+91 ${loginValue}` : loginValue;
    const targetIconEl = document.getElementById("cd-otp-target-icon");

    document
        .getElementById("cd-screen-phone")
        .classList.add("cd-screen--hidden");
    document
        .getElementById("cd-screen-otp")
        .classList.remove("cd-screen--hidden");

    /* Show phone number in subheading */
    document.getElementById("cd-otp-phone-display").textContent = displayValue;
    if (targetIconEl) {
        targetIconEl.style.display = isMobile ? "none" : "inline-flex";
    }

    /* Clear any previous OTP inputs */
    cdClearOtpBoxes();

    /* Start countdown */
    cdStartCountdown();

    /* Focus first box */
    document.querySelectorAll(".cd-otp-box")[0].focus();
}

function cdGoBack() {
    document.getElementById("cd-screen-otp").classList.add("cd-screen--hidden");
    document.getElementById("cd-screen-phone").classList.remove("cd-screen--hidden");

    // document.getElementById("cd-categories").classList.add("cd-screen--hidden");
    clearInterval(cdCountdownTimer);
    /* Re-validate phone form state */
    cdValidateForm();
}

/* ═══════════════════════════════════
   OTP INPUTS BEHAVIOUR
═══════════════════════════════════ */

document.addEventListener("DOMContentLoaded", () => {
    const cdBoxes = document.querySelectorAll(".cd-otp-box");

    cdBoxes.forEach((cdBox, cdIdx) => {
        /* Only digits */
        cdBox.addEventListener("input", (e) => {
            cdBox.value = cdBox.value.replace(/\D/g, "").slice(-1);

            if (cdBox.value) {
                cdBox.classList.add("cd-otp-box--filled");
                /* Move to next */
                if (cdIdx < cdBoxes.length - 1) {
                    cdBoxes[cdIdx + 1].focus();
                }
            } else {
                cdBox.classList.remove("cd-otp-box--filled");
            }

            cdValidateOtp();
        });

        /* Backspace — go to previous */
        cdBox.addEventListener("keydown", (e) => {
            if (e.key === "Backspace" && !cdBox.value && cdIdx > 0) {
                cdBoxes[cdIdx - 1].focus();
                cdBoxes[cdIdx - 1].value = "";
                cdBoxes[cdIdx - 1].classList.remove("cd-otp-box--filled");
                cdValidateOtp();
            }
        });

        /* Handle paste across all boxes */
        cdBox.addEventListener("paste", (e) => {
            e.preventDefault();
            const cdPasted = (e.clipboardData || window.clipboardData)
                .getData("text")
                .replace(/\D/g, "")
                .slice(0, 6);
            cdPasted.split("").forEach((cdChar, cdI) => {
                if (cdBoxes[cdI]) {
                    cdBoxes[cdI].value = cdChar;
                    cdBoxes[cdI].classList.add("cd-otp-box--filled");
                }
            });
            const cdNext = Math.min(cdPasted.length, cdBoxes.length - 1);
            cdBoxes[cdNext].focus();
            cdValidateOtp();
        });
    });
});

function cdClearOtpBoxes() {
    document.querySelectorAll(".cd-otp-box").forEach((cdBox) => {
        cdBox.value = "";
        cdBox.classList.remove("cd-otp-box--filled");
    });
    document.getElementById("cd-submit-btn").disabled = true;
}

function cdValidateOtp() {
    const cdBoxes = document.querySelectorAll(".cd-otp-box");
    const cdFull = [...cdBoxes].every((b) => b.value.length === 1);
    document.getElementById("cd-submit-btn").disabled = !cdFull;
}

function cdGetOtpValue() {
    return [...document.querySelectorAll(".cd-otp-box")]
        .map((b) => b.value)
        .join("");
}

/* ═══════════════════════════════════
   COUNTDOWN & RESEND
═══════════════════════════════════ */

function cdStartCountdown() {
    clearInterval(cdCountdownTimer);
    cdSecondsLeft = 30;

    const cdTimerEl = document.getElementById("cd-resend-timer");
    const cdCountEl = document.getElementById("cd-countdown");
    const cdResendBtn = document.getElementById("cd-resend-btn");

    if (!cdTimerEl || !cdCountEl || !cdResendBtn) return;

    cdTimerEl.classList.remove("hidden");
    cdResendBtn.classList.remove("cd-resend-btn--visible");
    cdCountEl.textContent = cdSecondsLeft;

    cdCountdownTimer = setInterval(() => {
        cdSecondsLeft--;
        cdCountEl.textContent = cdSecondsLeft;

        if (cdSecondsLeft <= 0) {
            clearInterval(cdCountdownTimer);
            cdTimerEl.classList.add("hidden");
            cdResendBtn.classList.add("cd-resend-btn--visible");
        }
    }, 1000);
}


function cdResendOtp() {
    const cdRegistrationResendUrl = window.cdRegistrationOtpResendUrl || "";
    const cdRegistrationMode = cdRegistrationResendUrl !== "";
    const cdResendUrl = cdRegistrationMode ? cdRegistrationResendUrl : "seller/resend-otp";
    const cdBody = cdRegistrationMode
        ? new URLSearchParams({})
        : new URLSearchParams({ mobile: cdMobileNumber });
    const cdToastId = cdRegistrationMode ? (window.cdRegistrationOtpToastId || "cd-otp-toast") : "cd-otp-toast";

    fetch(cdResendUrl, {
        method: "POST",
        credentials: "same-origin",
        headers: {
            "X-CSRF-TOKEN": cdCsrfToken,
            Accept: "application/json",
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: cdBody,
    })
        .then(async (res) => {
            const data = await res.json();
            if (!res.ok) throw data;
            return data;
        })
        .then((data) => {
            if (cdRegistrationMode) {
                if (data.otp) {
                    console.log("Resent registration OTP (DEV):", data.otp);
                }
                const cdOtpInput = document.getElementById("otp");
                if (cdOtpInput) cdOtpInput.value = "";
                cdStartCountdown();
                cdShowToast(cdToastId, data.message || "OTP resent successfully", "success");
                return;
            }

            if (data.otp) {
                console.log("Resent OTP (DEV):", data.otp);
            }

            cdClearOtpBoxes();
            cdStartCountdown();
            cdShowToast(
                cdToastId,
                data.message || ("OTP resent to +91 " + cdMobileNumber),
                "success"
            );

            const cdFirstBox = document.querySelectorAll(".cd-otp-box")[0];
            if (cdFirstBox) cdFirstBox.focus();
        })
        .catch((error) => {
            const cdMessage =
                error && typeof error === "object" && error.message
                    ? error.message
                    : "Failed to resend OTP";
            cdShowToast(cdToastId, cdMessage, "error");
        });
}

/* ═══════════════════════════════════
   SUBMIT OTP
═══════════════════════════════════ */

function cdHandleSubmit() {
    const cdOtpVal = cdGetOtpValue();

    if (cdOtpVal.length !== 6) {
        cdShowToast(
            "cd-otp-toast",
            "Please enter the complete 6-digit OTP.",
            "error",
        );
        return;
    }

    fetch("/seller/verify-otp", {
        method: "POST",
        credentials: "same-origin",
        headers: {
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": cdCsrfToken,
        },
        body: JSON.stringify({
            login: window.cdLoginValue || cdMobileNumber,
            otp: cdOtpVal,
        }),
    })
        .then(async (res) => {
            const data = await res.json();
            if (!res.ok) throw data;
            return data;
        })
        .then((data) => {
            if (data.status) {
                cdShowToast("cd-otp-toast", data.message, "success");
                setTimeout(() => {
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                        return;
                    }
                    if (
                        data.next_step === "business-details" ||
                        data.next_step === "business_details"
                    ) {
                        window.location.href = "/seller/business-details";
                    } else if (data.next_step === "dashboard") {
                        if (data.seller_slug) {
                            window.location.href =
                                "/seller/" + data.seller_slug + "/dashboard";
                            return;
                        }
                        cdSwitchToSuccess();
                    } else {
                        cdSwitchToSuccess();
                    }
                }, 800);
            } else {
                cdShowToast("cd-otp-toast", data.message, "error");
            }
        })
        .catch((err) => {
            console.error("Verify OTP failed:", err);
            const msg =
                err && typeof err === "object" && err.message
                    ? err.message
                    : "Server error. Please try again.";
            cdShowToast("cd-otp-toast", msg, "error");
        });
}

/* ═══════════════════════════════════
   SCREEN 3 — SUCCESS
═══════════════════════════════════ */

function cdSwitchToSuccess() {
    /* Stop countdown */
    clearInterval(cdCountdownTimer);

    /* Hide OTP screen */
    document.getElementById("cd-screen-otp").classList.add("cd-screen--hidden");

    /* Re-trigger CSS animations fresh by cloning */
    const cdSuccessOld = document.getElementById("cd-screen-success");
    const cdSuccessNew = cdSuccessOld.cloneNode(true);
    cdSuccessOld.parentNode.replaceChild(cdSuccessNew, cdSuccessOld);
    cdSuccessNew.classList.remove("cd-screen--hidden");
}




/* ═══════════════════════════════════════════
       SUB-SCREEN MAP
       Each key maps to: { stepperStep, screenId }
    ═══════════════════════════════════════════ */
const CD_SUB_MAP = {
    "1a": { step: 1, id: "cd-sub-1a" },
    "1b": { step: 1, id: "cd-sub-1b" },
    2: { step: 2, id: "cd-sub-2" },
    3: { step: 3, id: "cd-sub-3" },
};

let cdCurrentSub = "1a";

/* ── Show a sub-screen & update stepper ── */
function cdShowSub(cdKey) {
    /* Hide current */
    const cdCurrentTarget = document.getElementById(CD_SUB_MAP[cdCurrentSub].id);
    if (cdCurrentTarget) {
        cdCurrentTarget.classList.add("cd-screen--hidden");
    }

    /* Show target */
    const cdTarget = CD_SUB_MAP[cdKey];
    const cdNextTarget = document.getElementById(cdTarget.id);
    if (cdNextTarget) {
        cdNextTarget.classList.remove("cd-screen--hidden");
    }
    cdCurrentSub = cdKey;

    /* Update stepper */
    cdUpdateStepper(cdTarget.step);

    /* Scroll form to top */
    document.getElementById("cd-form-pane").scrollTop = 0;

    // Auto-fill PAN from GSTIN when moving to PAN screen.
    if (cdKey === "1b" && cdPanFromGst) {
        const cdPanEl = document.getElementById("cd-pan");
        if (cdPanEl && !cdPanEl.value) {
            cdPanEl.value = cdPanFromGst;
        }
    }
}



/* ── Stepper ── */
function cdUpdateStepper(cdActiveStep) {
    const cdStepIds = [1, 2, 3];

    cdStepIds.forEach((cdN) => {
        const cdCircle = document.getElementById("cd-step-" + cdN);

        if (!cdCircle) return;
        cdCircle.classList.remove("cd-step-circle--active", "cd-step-circle--done");

        if (cdN < cdActiveStep) {
            cdCircle.classList.add("cd-step-circle--done");
            cdCircle.innerHTML = '<i class="fas fa-check text-xs"></i>';
        } else if (cdN === cdActiveStep) {
            cdCircle.classList.add("cd-step-circle--active");
            cdCircle.textContent = cdN;
        } else {
            cdCircle.textContent = cdN;
        }
    });

    /* Connector lines */
    ["cd-line-12", "cd-line-23", "cd-line-34"].forEach((cdId, cdIdx) => {
        const cdLine = document.getElementById(cdId);

        if (!cdLine) return;
        if (cdIdx + 1 < cdActiveStep) {
            cdLine.classList.add("cd-step-line--done");
        } else {
            cdLine.classList.remove("cd-step-line--done");
        }
    });
}


function cdNormalizeName(cdValue) {
    return (cdValue || "")
        .toString()
        .trim()
        .replace(/\s+/g, " ")
        .toLowerCase();
}


async function cdLookupPanIfNeeded() {
    const cdPanEl = document.getElementById("cd-pan");
    if (!cdPanEl) return;

    const pan = (cdPanEl.value || "").trim().toUpperCase();

    // Basic format validation (fail fast)
    if (!/^[A-Z]{5}[0-9]{4}[A-Z]$/.test(pan)) return;

    // Prevent duplicate API calls
    if (cdPanLookupLast === pan) return;
    cdPanLookupLast = pan;

    cdShowToast("cd-toast-1b", "Checking PAN...", "success");

    try {
        // 🔁 Replace with your actual provider
        const res = await fetch(`/api/validate/pan/${encodeURIComponent(pan)}`, {
            method: "GET",
            headers: {
                // API key required for most providers
                // "apikey": "YOUR_API_KEY"
            },
        });

        if (!res.ok) {
            throw new Error("Invalid PAN");
        }

        const data = await res.json();

        // Normalize response (depends on provider)
        const isValid = data?.valid || data?.status === "VALID";

        if (!isValid) {
            throw new Error("Invalid PAN");
        }

        cdPanLookupResult = data;

        // Optional: auto-fill name (only if available)
        if (data?.full_name) {
            const cdPanNameEl = document.getElementById("cd-pan-name");
            if (cdPanNameEl && !cdPanNameEl.value) {
                cdPanNameEl.value = data.full_name;
            }
        }

        cdShowToast(
            "cd-toast-1b",
            data?.full_name
                ? `PAN verified: ${data.full_name}`
                : "PAN verified.",
            "success"
        );

    } catch (err) {
        cdPanLookupLast = null;

        cdShowToast(
            "cd-toast-1b",
            "Invalid PAN. Please check and try again.",
            "error"
        );
    }
}


/* ── CAPTCHA btn ── */
function cdRequestCaptcha() {
    const cdBtn = document.getElementById("cd-captcha-btn");
    const cdImg = document.getElementById("cd-captcha-img");
    if (!cdBtn || !cdImg) return;

    cdBtn.disabled = true;
    cdBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';

    fetch("captcha", {
        method: "GET",
        credentials: "same-origin",
        headers: {
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then(async (res) => {
            const data = await res.json().catch(() => null);
            if (!res.ok) throw data || { message: "CAPTCHA request failed." };
            return data;
        })
        .then((data) => {
            if (!data || !data.image) {
                throw { message: "Invalid CAPTCHA response." };
            }
            cdImg.src = data.image;
            cdImg.style.display = "";
            cdCaptchaLoaded = true;
            cdShowToast("cd-toast-1b", "CAPTCHA generated. Please type it below.", "success");
        })
        .catch((err) => {
            cdCaptchaLoaded = false;
            const msg =
                err && typeof err === "object" && err.message
                    ? err.message
                    : "Unable to load CAPTCHA. Please try again.";
            cdShowToast("cd-toast-1b", msg, "error");
        })
        .finally(() => {
            cdBtn.disabled = false;
            cdBtn.innerHTML = '<i class="fas fa-shield-alt"></i> Refresh CAPTCHA';
        });
}

/* ═══════════════════════════════════════════
       VALIDATIONS
    ═══════════════════════════════════════════ */

/* Sub-screen 1a: Business Details */
function cdSub1aContinue() {
    const cdLegal = document.getElementById("cd-legal-name").value.trim();
    const cdStore = document.getElementById("cd-store-name").value.trim();
    const cdBizType = document.getElementById("cd-biz-type").value;

    if (!cdLegal)
        return cdShowToast(
            "cd-toast-1a",
            "Please enter Legal Business Name.",
            "error",
        );
    if (!cdStore)
        return cdShowToast(
            "cd-toast-1a",
            "Please enter Store Display Name.",
            "error",
        );
    if (!cdBizType)
        return cdShowToast(
            "cd-toast-1a",
            "Please select Business Type.",
            "error",
        );

    cdShowSub("1b");
}


/* Sub-screen 1b: PAN + Contact + Address */
function cdSub1bContinue() {
    const cdPan = document.getElementById("cd-pan").value.trim();
    const cdPanName = document.getElementById("cd-pan-name").value.trim();
    const cdEmail = document.getElementById("cd-email").value.trim();
    const cdCity = document.getElementById("cd-city").value.trim();
    const cdState = document.getElementById("cd-state").value.trim();
    const cdDist = document.getElementById("cd-district").value.trim();
    const cdPin = document.getElementById("cd-pincode").value.trim();
    const cdBldg = document.getElementById("cd-building").value.trim();
    const cdCaptcha = document.getElementById("cd-captcha-val").value.trim();

    if (!/^[A-Z]{5}[0-9]{4}[A-Z]$/.test(cdPan))
        return cdShowToast(
            "cd-toast-1b",
            "Please enter a valid PAN (e.g. ABCDE1234F).",
            "error",
        );
    if (!cdPanName)
        return cdShowToast(
            "cd-toast-1b",
            "Please enter name as per PAN.",
            "error",
        );

    // If PAN lookup was successful and returned a holder name, enforce match.
    if (
        cdPanLookupResult &&
        cdPanLookupResult.valid &&
        cdPanLookupResult.holder_name &&
        cdPanLookupResult.holder_name !== "Unknown"
    ) {
        if (
            cdNormalizeName(cdPanName) !==
            cdNormalizeName(cdPanLookupResult.holder_name)
        ) {
            return cdShowToast(
                "cd-toast-1b",
                "PAN name does not match PAN holder name.",
                "error",
            );
        }
    }
    if (!cdEmail || !cdEmail.includes("@"))
        return cdShowToast(
            "cd-toast-1b",
            "Please enter a valid email address.",
            "error",
        );
    if (!cdCity || !cdState || !cdDist)
        return cdShowToast(
            "cd-toast-1b",
            "Please fill City, State and District.",
            "error",
        );
    if (cdPin.length !== 6)
        return cdShowToast(
            "cd-toast-1b",
            "Please enter a valid 6-digit pincode.",
            "error",
        );
    if (!cdBldg)
        return cdShowToast(
            "cd-toast-1b",
            "Please enter Building/Floor/Room number.",
            "error",
        );
    if (!cdCaptchaLoaded)
        return cdShowToast(
            "cd-toast-1b",
            "Please request CAPTCHA first.",
            "error",
        );
    if (!cdCaptcha)
        return cdShowToast(
            "cd-toast-1b",
            "Please complete the CAPTCHA.",
            "error",
        );

    const cdContinueBtn = document.getElementById("cd-sub-1b-continue");
    if (cdContinueBtn) cdContinueBtn.disabled = true;

    cdShowToast("cd-toast-1b", "Verifying CAPTCHA...", "success");

    fetch("captcha/verify", {
        method: "POST",
        credentials: "same-origin",
        headers: {
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": cdCsrfToken,
        },
        body: JSON.stringify({ captcha: cdCaptcha }),
    })
        .then(async (res) => {
            const data = await res.json().catch(() => null);
            if (!res.ok) throw data || { message: "CAPTCHA verify failed." };
            return data;
        })
        .then((data) => {
            if (!data || !data.valid) {
                cdShowToast(
                    "cd-toast-1b",
                    data && data.message ? data.message : "Incorrect CAPTCHA.",
                    "error",
                );
                return;
            }
            cdShowSub("2");
        })
        .catch((err) => {
            const msg =
                err && typeof err === "object" && err.message
                    ? err.message
                    : "Unable to verify CAPTCHA. Please try again.";
            cdShowToast("cd-toast-1b", msg, "error");
        })
        .finally(() => {
            if (cdContinueBtn) cdContinueBtn.disabled = false;
        });
}


/* Step 2: Pickup Address */
function cdStep2Continue() {
    const cdAddr1 = document.getElementById("cd-addr1").value.trim();
    const cdAddr2 = document.getElementById("cd-addr2").value.trim();
    const cdPin = document.getElementById("cd-p-pincode").value.trim();
    const cdCity = document.getElementById("cd-p-city").value.trim();
    const cdState = document.getElementById("cd-p-state").value.trim();
    const cdCName = document.getElementById("cd-contact-name").value.trim();
    const cdCMobile = document.getElementById("cd-contact-mobile").value.trim();

    if (!cdAddr1)
        return cdShowToast(
            "cd-toast-2",
            "Please enter Address Line 1.",
            "error",
        );
    if (!cdAddr2)
        return cdShowToast(
            "cd-toast-2",
            "Please enter Address Line 2.",
            "error",
        );
    if (cdPin.length !== 6)
        return cdShowToast(
            "cd-toast-2",
            "Please enter a valid 6-digit pincode.",
            "error",
        );
    if (!cdCity)
        return cdShowToast("cd-toast-2", "Please enter City.", "error");
    if (!cdState)
        return cdShowToast("cd-toast-2", "Please enter State.", "error");
    if (!cdCName)
        return cdShowToast(
            "cd-toast-2",
            "Please enter Contact Person Name.",
            "error",
        );
    if (cdCMobile.length !== 10)
        return cdShowToast(
            "cd-toast-2",
            "Please enter a valid 10-digit mobile number.",
            "error",
        );

    cdShowSub("3");
}

const cdPincodeLookupState = {};

function cdSetFieldValue(id, value) {
    const el = document.getElementById(id);
    if (el && !el.value) el.value = value || "";
}

function cdStartLoader(loaderId) {
    const loader = document.getElementById(loaderId);
    if (loader) loader.style.display = "inline";
}

function cdStopLoader(loaderId) {
    const loader = document.getElementById(loaderId);
    if (loader) loader.style.display = "none";
}

function cdBindPincodeLookup(inputId, options = {}) {
    const pinEl = document.getElementById(inputId);
    if (!pinEl) return;

    const state = cdPincodeLookupState[inputId] || {
        lastPin: null,
        timer: null,
        controller: null,
    };
    cdPincodeLookupState[inputId] = state;

    const lookupUrlTemplate = window.cdPincodeLookupUrl || "/seller/api/validate/pincode/__PIN__";
    const loaderId = options.loaderId || null;
    const targetIds = options.targetIds || [];

    const runLookup = () => {
        const pin = pinEl.value.trim();

        if (pin.length !== 6) {
            if (state.controller) {
                state.controller.abort();
                state.controller = null;
            }
            state.lastPin = null;
            if (loaderId) cdStopLoader(loaderId);
            return;
        }

        if (state.lastPin === pin) return;
        state.lastPin = pin;

        if (state.controller) state.controller.abort();
        state.controller = new AbortController();

        if (loaderId) cdStartLoader(loaderId);

        const url = lookupUrlTemplate.replace("__PIN__", encodeURIComponent(pin));
        fetch(url, {
            signal: state.controller.signal,
            headers: {
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then(async (res) => {
                const data = await res.json().catch(() => null);
                if (!res.ok || !data || data.valid !== true) {
                    throw new Error((data && data.message) || "Invalid pincode");
                }
                return data;
            })
            .then((data) => {
                if (state.controller && state.controller.signal.aborted) return;
                const values = [data.city || data.district || "", data.state || "", data.district || ""];
                targetIds.forEach((id, idx) => cdSetFieldValue(id, values[idx] || values[0]));
            })
            .catch((err) => {
                if (err && err.name === "AbortError") return;
                state.lastPin = null;
                console.error("Invalid pincode", err);
            })
            .finally(() => {
                if (state.controller && !state.controller.signal.aborted) {
                    state.controller = null;
                    if (loaderId) cdStopLoader(loaderId);
                }
            });
    };

    pinEl.addEventListener("input", () => {
        clearTimeout(state.timer);
        state.timer = setTimeout(runLookup, 300);
    });
    pinEl.addEventListener("blur", runLookup);
    pinEl.addEventListener("change", runLookup);
}

function initPincodeLookup() {
    cdBindPincodeLookup("cd-pincode", {
        targetIds: ["cd-city", "cd-state", "cd-district"],
        loaderId: "cd-pincode-loader",
    });
    cdBindPincodeLookup("cd-p-pincode", {
        targetIds: ["cd-p-city", "cd-p-state", "cd-p-district"],
        loaderId: "cd-pincode-loader",
    });
}

window.cdTriggerPickupPincodeLookup = function () {
    const pinEl = document.getElementById("cd-p-pincode");
    if (!pinEl) return;
    pinEl.dispatchEvent(new Event("change", { bubbles: true }));
};

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initPincodeLookup);
} else {
    initPincodeLookup();
}

/* Step 3: Supplier Details */
function cdStep4Submit() {
    const cdCatsEl = document.getElementById("cd-categories");
    const cdCats = cdCatsEl
        ? Array.from(cdCatsEl.selectedOptions || [])
            .map((o) => o.value)
            .filter(Boolean)
        : [];
    const cdCapacity = document.getElementById("cd-capacity").value;
    const cdDispatch = document.getElementById("cd-dispatch").value;

    if (!cdCats || cdCats.length === 0)
        return cdShowToast(
            "cd-toast-3",
            "Please select at least one Product Category.",
            "error",
        );
    if (!cdCapacity)
        return cdShowToast(
            "cd-toast-3",
            "Please select Monthly Order Capacity.",
            "error",
        );
    if (!cdDispatch)
        return cdShowToast(
            "cd-toast-3",
            "Please select Average Dispatch Time.",
            "error",
        );

    const cdForm = document.getElementById("cd-seller-registration-form");
    if (!cdForm) {
        return cdShowToast(
            "cd-toast-3",
            "Form not found. Please refresh and try again.",
            "error",
        );
    }

    const cdToastForField = (cdField) => {
        const cdMap = {
            legal_business_name: "1a",
            store_display_name: "1a",
            business_type: "1a",
            gst_available: "1a",
            gst_number: "1a",
            mobile: "1b",
            pan_number: "1b",
            pan_name: "1b",
            captcha: "1b",
            email: "1b",
            city: "1b",
            state: "1b",
            district: "1b",
            pincode: "1b",
            building_number: "1b",
            street: "1b",
            pickup_address_line1: "2",
            pickup_address_line2: "2",
            pickup_pincode: "2",
            pickup_city: "2",
            pickup_state: "2",
            pickup_landmark: "2",
            contact_person_name: "2",
            contact_mobile: "2",
            alternate_mobile: "2",
            product_categories: "3",
            monthly_order_capacity: "3",
            average_dispatch_time: "3",
        };

        const cdScreen = cdMap[cdField] || "3";
        return { cdScreen, cdToastId: "cd-toast-" + cdScreen };
    };

    const cdBtn = document.querySelector("#cd-sub-3 button.mcp-btn");
    if (cdBtn) cdBtn.disabled = true;

    fetch(cdForm.action, {
        method: "POST",
        credentials: "same-origin",
        headers: {
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": cdCsrfToken,
        },
        body: new FormData(cdForm),
    })
        .then(async (res) => {
            const data = await res.json().catch(() => null);
            if (!res.ok) throw data || { message: "Request failed." };
            return data;
        })
        .then((data) => {
            if (data && data.otp) {
                console.log("Registration OTP (DEV):", data.otp);
            }
            cdShowToast(
                "cd-toast-3",
                data && data.message
                    ? data.message
                    : "Submitted for verification! Our team will review your details.",
                "success",
            );
            if (data && data.redirect_url) {
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 900);
            }
        })
        .catch((err) => {
            if (err && typeof err === "object" && err.redirect_url) {
                window.location.href = err.redirect_url;
                return;
            }
            if (err && typeof err === "object" && err.errors) {
                const cdFirstField = Object.keys(err.errors)[0];
                const cdFirstMsg =
                    err.errors[cdFirstField] && err.errors[cdFirstField][0]
                        ? err.errors[cdFirstField][0]
                        : "Please fix the highlighted fields.";
                const { cdScreen, cdToastId } = cdToastForField(cdFirstField);
                cdShowSub(cdScreen);
                cdShowToast(cdToastId, cdFirstMsg, "error");
                return;
            }

            const cdMsg =
                err && typeof err === "object" && err.message
                    ? err.message
                    : "Server error. Please try again.";
            cdShowToast("cd-toast-3", cdMsg, "error");
        })
        .finally(() => {
            if (cdBtn) cdBtn.disabled = false;
        });
}

/* Init stepper */
cdUpdateStepper(1);


