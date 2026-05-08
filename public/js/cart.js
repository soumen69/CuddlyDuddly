window.Cart = {

    add: function ({
        productId,
        variantId = null,
        qty = 1,
        buyNow = false,
        isLoggedIn = true,
        loginUrl = null,
        button = null
    }) {

        if (!isLoggedIn && buyNow) {
            if (loginUrl) window.location.href = loginUrl;
            return;
        }

        let originalText = null;

        if (button) {
            button.disabled = true;
            button.dataset.originalText = button.innerText;
            button.innerText = "Processing...";
        }

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_id: productId,
                variant_id: variantId,
                qty: qty,
                buy_now: buyNow
            })
        })
            .then(res => res.json())
            .then(data => {

                if (!data.success) {
                    showToast({
                        title: "Error",
                        message: data.message || "Something went wrong",
                        type: "error"
                    });
                    return;
                }

                if (buyNow && data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    showToast({
                        title: "Cart",
                        message: "Added to cart",
                        type: "success"
                    });

                    window.dispatchEvent(new CustomEvent("cart:updated", {
                        detail: {
                            cart: {
                                count: data.cart?.count ?? 0
                            }
                        }
                    }));
                }

            })
            .catch(() => {
                showToast({
                    title: "Error",
                    message: "Network error",
                    type: "error"
                });
            })
            .finally(() => {
                if (button) {
                    button.disabled = false;
                    button.innerText = button.dataset.originalText || "Add to Cart";
                }
            });
    }
};