document.addEventListener("DOMContentLoaded", () => {

    // =====================================================
    // ⚙️ GLOBAL HELPERS
    // =====================================================
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const defaultImage = `${window.location.origin}/storage/images/no-image.png`;

    const safeImage = (path) => {
        if (!path) return defaultImage;
        return `${window.location.origin}/storage/${path}`;
    };

    const safeFetch = async (url, options = {}) => {
        try {
            const res = await fetch(url, options);
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            return await res.json();
        } catch (err) {
            console.error("Fetch error:", err);
            return { success: false };
        }
    };

    // =====================================================
    // 🧍 VIEW SUPPORT DETAILS
    // =====================================================
    document.querySelectorAll(".view-btn").forEach(btn => {
        btn.addEventListener("click", async () => {
            const support = JSON.parse(btn.dataset.support);

            const setVal = (id, val) => {
                const el = document.getElementById(id);
                if (el) el.value = val || '';
            };

            // Seller Info
            setVal("sellerName", support.seller?.name);
            setVal("sellerEmail", support.seller?.email);
            setVal("phone", support.seller?.phone);

            // Bank Info (view + edit)
            const bank = support.seller || {};
            const textFields = {
                bankNameText: bank.bank_name || '—',
                bankAccountText: bank.bank_account_number || '—',
                ifscCodeText: bank.ifsc_code || '—',
                upiIdText: bank.upi_id || '—'
            };
            for (const [id, val] of Object.entries(textFields)) {
                const el = document.getElementById(id);
                if (el) el.textContent = val;
            }

            const editFields = {
                bankNameInput: bank.bank_name,
                bankAccountInput: bank.bank_account_number,
                ifscCodeInput: bank.ifsc_code,
                upiIdInput: bank.upi_id
            };
            for (const [id, val] of Object.entries(editFields)) setVal(id, val);

            const saveBankBtn = document.getElementById("saveBankBtn");
            if (saveBankBtn) saveBankBtn.dataset.sellerId = bank.id;

            // Product Info
            setVal("productName", support.product?.name);
            setVal("supportMessage", support.message);
            const desc = document.getElementById("productDescription");
            if (desc) desc.textContent = support.product?.description || 'No description available.';

            const imgEl = document.getElementById("productImage");
            if (imgEl) {
                imgEl.src = safeImage(support.product?.primary_image?.image_path);
                imgEl.onerror = () => (imgEl.src = defaultImage);
            }

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById("viewSupportModal"));
            modal.show();

            // Load product reviews
            if (support.product?.id) loadProductReviews(support.product.id);
        });
    });

    // =====================================================
    // 🏦 BANK INFO EDIT / SAVE / CANCEL
    // =====================================================
    const editBtn = document.getElementById('editBankBtn');
    const viewDiv = document.getElementById('bankInfoView');
    const editDiv = document.getElementById('bankInfoEdit');
    const saveBtn = document.getElementById('saveBankBtn');
    const cancelBtn = document.getElementById('cancelBankBtn');

    editBtn?.addEventListener('click', () => {
        viewDiv.classList.add('d-none');
        editDiv.classList.remove('d-none');
    });

    cancelBtn?.addEventListener('click', () => {
        editDiv.classList.add('d-none');
        viewDiv.classList.remove('d-none');
    });

    saveBtn?.addEventListener('click', async () => {
        const sellerId = saveBtn.dataset.sellerId;
        const updated = {
            bank_name: document.getElementById('bankNameInput').value,
            bank_account_number: document.getElementById('bankAccountInput').value,
            ifsc_code: document.getElementById('ifscCodeInput').value,
            upi_id: document.getElementById('upiIdInput').value
        };

        // Update visible instantly
        document.getElementById("bankNameText").textContent = updated.bank_name || '—';
        document.getElementById("bankAccountText").textContent = updated.bank_account_number || '—';
        document.getElementById("ifscCodeText").textContent = updated.ifsc_code || '—';
        document.getElementById("upiIdText").textContent = updated.upi_id || '—';

        const result = await safeFetch(`seller/${sellerId}/bankinfo`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify(updated)
        });

        alert(result.success ? '✅ Bank information updated successfully!' : '❌ Failed to save bank info.');

        editDiv.classList.add('d-none');
        viewDiv.classList.remove('d-none');
    });

    // =====================================================
    // 🗑 DELETE SUPPORT TICKET
    // =====================================================
    document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", async () => {
            if (!confirm("Are you sure you want to delete this ticket?")) return;
            const res = await safeFetch(`/admin/seller-supports/${btn.dataset.id}`, {
                method: "DELETE",
                headers: { "X-CSRF-TOKEN": csrfToken, "Accept": "application/json" }
            });
            if (res.success) btn.closest('tr').remove();
            else alert("Failed to delete.");
        });
    });

    // =====================================================
    // 🧾 PRODUCT REVIEWS HANDLING
    // =====================================================
    let allReviews = [];
    const reviewList = document.getElementById("reviewList");
    const reviewSearch = document.getElementById("reviewSearch");

    async function loadProductReviews(productId) {
        reviewList.innerHTML = `<p class="text-muted text-center">Loading reviews...</p>`;
        const res = await safeFetch(`seller/${productId}/productreview`);
        allReviews = res.reviews || [];
        renderReviews(allReviews.length ? [allReviews[0]] : []);
    }

    function renderReviews(reviews) {
        if (!reviews.length) {
            reviewList.innerHTML = `<p class="text-muted text-center">No reviews available.</p>`;
            return;
        }

        reviewList.innerHTML = reviews.map(r => {
            const stars = "⭐".repeat(r.rating || 0);
            const date = r.created_at ? new Date(r.created_at).toLocaleDateString() : "";
            const imageUrl = safeImage(r.product_image);
            return `
                <div class="border rounded p-2 mb-3 shadow-sm">
                    <div class="d-flex align-items-center mb-2">
                        <img src="${imageUrl}" width="50" height="50" class="rounded me-3 border" onerror="this.src='${defaultImage}'">
                        <div>
                            <strong>${r.customer_name || 'Anonymous'}</strong><br>
                            <small class="text-muted">${r.customer_email || 'No email provided'}</small>
                        </div>
                        <div class="ms-auto text-end">
                            <span class="small text-muted">${date}</span><br>
                            <span class="text-warning small">${stars}</span>
                        </div>
                    </div>
                    <p class="mb-2 small text-muted">${r.comment || ''}</p>
                </div>`;
        }).join("");
    }

    reviewSearch?.addEventListener("input", (e) => {
        const q = e.target.value.toLowerCase();
        const filtered = q
            ? allReviews.filter(r =>
                r.customer_name?.toLowerCase().includes(q) ||
                r.comment?.toLowerCase().includes(q))
            : [allReviews[0]];
        renderReviews(filtered || []);
    });

    window.loadProductReviews = loadProductReviews;

    // =====================================================
    // 📨 MESSAGES + ATTACHMENTS
    // =====================================================
    const messageList = document.getElementById("messageList");
    const messageForm = document.getElementById("messageForm");
    const ticketInput = document.getElementById("ticketId");
    const trixEditor = document.querySelector("trix-editor");
    const attachmentPreviewArea = document.getElementById("attachmentPreviewArea");

    async function loadMessages(ticketId) {
        if (!ticketId) {
            messageList.innerHTML = `<p class="text-muted text-center">No ticket selected.</p>`;
            return;
        }

        messageList.innerHTML = `<p class="text-muted text-center">Loading...</p>`;
        const res = await safeFetch(`seller/${ticketId}/messages`);
        if (!res || !res.length) {
            messageList.innerHTML = `<p class="text-muted text-center">No messages yet.</p>`;
            return;
        }

        messageList.innerHTML = res.map(msg => {
            const isAdmin = msg.sender_type === "admin";
            const name = isAdmin ? (msg.sender?.name || "Admin")
                : (msg.sender?.shop_name || msg.sender?.name || "Seller");
            const align = isAdmin ? "text-end" : "text-start";
            const bubble = isAdmin ? "bg-primary text-white" : "bg-light border";

            let attachmentsHTML = "";
            if (Array.isArray(msg.attachment) && msg.attachment.length) {
                attachmentsHTML = msg.attachment.map(fileUrl => {
                    const ext = fileUrl.split('.').pop().toLowerCase();
                    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                        return `<div class="mt-2">
                            <img src="${fileUrl}" class="img-fluid rounded shadow-sm preview-trigger" data-file="${fileUrl}" data-type="image" style="max-width:200px;max-height:150px;object-fit:cover;cursor:pointer;">
                        </div>`;
                    } else {
                        return `<div class="mt-2">
                            <button class="btn btn-sm btn-outline-light preview-trigger" data-file="${fileUrl}" data-type="document">
                                <i class="bi bi-paperclip"></i> View File
                            </button>
                        </div>`;
                    }
                }).join("");
            }

            return `
                <div class="mb-3 ${align}">
                    <div class="d-inline-block p-3 rounded-4 shadow-sm ${bubble}">
                        <div class="fw-bold small">${name}</div>
                        <div>${msg.message || ""}</div>
                        ${attachmentsHTML}
                        <div class="text-muted small mt-1">${new Date(msg.created_at).toLocaleString()}</div>
                    </div>
                </div>`;
        }).join("");

        messageList.scrollTo({ top: messageList.scrollHeight, behavior: "smooth" });
    }

    document.addEventListener("trix-file-accept", (event) => {
        event.preventDefault();
        const file = event.file;
        const fileURL = URL.createObjectURL(file);
        const ext = file.name.split('.').pop().toLowerCase();
        let previewHTML = "";

        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
            previewHTML = `
                <div class="position-relative">
                    <img src="${fileURL}" class="rounded shadow-sm" style="width:100px;height:80px;object-fit:cover;">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-attachment"><i class="bi bi-x"></i></button>
                </div>`;
        } else {
            previewHTML = `
                <div class="border rounded px-3 py-2 bg-light d-flex align-items-center gap-2 position-relative">
                    <i class="bi bi-file-earmark-text"></i> ${file.name}
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-attachment"><i class="bi bi-x"></i></button>
                </div>`;
        }

        const wrapper = document.createElement("div");
        wrapper.classList.add("attachment-wrapper", "position-relative");
        wrapper.dataset.fileName = file.name;
        wrapper.file = file;
        wrapper.innerHTML = previewHTML;
        attachmentPreviewArea.appendChild(wrapper);
    });

    attachmentPreviewArea.addEventListener("click", (e) => {
        if (e.target.closest(".remove-attachment")) e.target.closest(".attachment-wrapper").remove();
    });

    messageForm?.addEventListener("submit", async (e) => {
        e.preventDefault();
        const ticketId = ticketInput.value;
        if (!ticketId) return alert("⚠️ No ticket selected!");

        const messageHTML = trixEditor.editor.getDocument().toString().trim();
        const attachments = [...attachmentPreviewArea.querySelectorAll(".attachment-wrapper")];
        if (!messageHTML && !attachments.length) return;

        const sendBtn = messageForm.querySelector("button");
        sendBtn.disabled = true;
        sendBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span> Sending...`;

        const formData = new FormData();
        formData.append("message", messageHTML);
        attachments.forEach(w => w.file && formData.append("attachment[]", w.file));

        const data = await safeFetch(`seller/${ticketId}/messages`, {
            method: "POST",
            headers: { "X-CSRF-TOKEN": csrfToken },
            body: formData
        });

        if (data.success) {
            attachmentPreviewArea.innerHTML = "";
            trixEditor.editor.loadHTML("");
            await loadMessages(ticketId);
        }

        sendBtn.disabled = false;
        sendBtn.innerHTML = `<i class="bi bi-send"></i> Send`;
    });

    // =====================================================
    // 👁️ OPEN TICKET
    // =====================================================
    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".view-btn");
        if (!btn) return;

        const support = JSON.parse(btn.dataset.support);
        ticketInput.value = support.id;

        const ticketIdSpan = document.getElementById("modalTicketId");
        if (ticketIdSpan) ticketIdSpan.textContent = `#${support.id}`;

        const ticketStatusSpan = document.getElementById("modalTicketStatus");
        if (ticketStatusSpan) {
            const colors = { open: 'success', pending: 'warning', closed: 'secondary', reopened: 'primary' };
            const color = colors[support.status] || 'secondary';
            ticketStatusSpan.className = `badge bg-${color} ms-2`;
            ticketStatusSpan.textContent = support.status ? support.status[0].toUpperCase() + support.status.slice(1) : '—';
        }

        loadMessages(support.id);
        const modalEl = document.getElementById("viewSupportModal");
        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        modalEl.addEventListener("hidden.bs.modal", () => location.reload());
    });

    // =====================================================
    // 🖼️ ATTACHMENT PREVIEW MODAL
    // =====================================================
    document.addEventListener("click", (e) => {
        const previewEl = e.target.closest(".preview-trigger");
        if (!previewEl) return;

        const fileUrl = previewEl.dataset.file;
        const fileType = previewEl.dataset.type;
        const modal = new bootstrap.Modal(document.getElementById("attachmentPreviewModal"));
        const previewContent = document.getElementById("previewContent");

        previewContent.innerHTML = `<p class="text-muted">Loading preview...</p>`;
        previewContent.innerHTML = fileType === "image"
            ? `<img src="${fileUrl}" class="img-fluid rounded shadow-sm">`
            : `<iframe src="${fileUrl}" class="w-100 border rounded shadow-sm" style="height:80vh;"></iframe>`;
        modal.show();
    });

    // =====================================================
    // 🔄 UPDATE TICKET STATUS
    // =====================================================
    function updateTicketStatus(status) {
        const map = {
            open: { color: 'success', icon: 'bi-unlock' },
            pending: { color: 'warning', icon: 'bi-hourglass-split' },
            processing: { color: 'info', icon: 'bi-gear' },
            close: { color: 'secondary', icon: 'bi-lock' }
        };
        const { color, icon } = map[status] || { color: 'secondary', icon: 'bi-question-circle' };
        const btn = document.getElementById('ticketStatusBtn');
        if (btn) {
            btn.className = `btn btn-sm btn-${color} rounded-pill shadow-sm px-3`;
            btn.innerHTML = `<i class="bi ${icon} me-1"></i><span class="fw-semibold text-capitalize">${status}</span>`;
        }
    }

    document.querySelectorAll('.status-btn').forEach(button => {
        button.addEventListener('click', async function () {
            const status = this.dataset.status;
            const ticketId = ticketInput?.value;
            if (!ticketId) return alert('⚠️ Please open a ticket first.');

            this.disabled = true;
            const original = this.innerHTML;
            this.innerHTML = '<i class="bi bi-hourglass-split"></i> Updating...';

            const res = await safeFetch(`seller/${ticketId}/updatestatus`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ status })
            });

            if (res.success) {
                document.querySelectorAll('.status-btn').forEach(b => b.classList.remove('active', 'btn-primary'));
                this.classList.add('active', 'btn-primary');
                alert(`✅ Ticket #${ticketId} updated to "${res.status}".`);
            } else {
                alert('❌ Failed to update status.');
            }

            this.disabled = false;
            this.innerHTML = original;
        });
    });
});
