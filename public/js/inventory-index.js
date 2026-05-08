document.addEventListener("DOMContentLoaded", () => {
    const adjustModal = new bootstrap.Modal(document.getElementById('adjustStockModal'));
    const form = document.getElementById('adjustStockForm');

    const inventoryIdInput = document.getElementById('inventory_id');
    const currentQuantityInput = document.getElementById('current_quantity');
    const currentReservedInput = document.getElementById('current_reserved');

    const quantityInput = document.getElementById('adjust_quantity');
    const actionSelect = document.getElementById('adjust_action');
    const remarksInput = document.getElementById('adjust_remarks');
    const errorDiv = document.getElementById('adjust_error');

    // Open modal
    document.querySelectorAll(".adjust-stock-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const row = btn.closest("tr");
            const id = btn.dataset.id;
            const qty = parseInt(row.querySelector("td:nth-child(5)").innerText.trim());
            const reserved = parseInt(row.querySelector("td:nth-child(6)").innerText.trim());

            inventoryIdInput.value = id;
            currentQuantityInput.value = qty;
            currentReservedInput.value = reserved;

            quantityInput.value = '';
            remarksInput.value = '';
            actionSelect.value = 'added';
            errorDiv.innerText = '';

            adjustModal.show();
        });
    });

    // Submit adjustment
    form.addEventListener("submit", e => {
        e.preventDefault();
        const id = inventoryIdInput.value;
        const payload = {
            action: actionSelect.value,
            quantity: quantityInput.value ? parseInt(quantityInput.value) : 0,
            remarks: remarksInput.value || undefined
        };

        fetch(`/admin/inventory/${id}/adjust`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(payload)
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) location.reload();
                else errorDiv.innerText = data.error || "Something went wrong!";
            })
            .catch(err => {
                console.error(err);
                errorDiv.innerText = "Something went wrong!";
            });
    });
});
