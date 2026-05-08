
// Skeleton for children in the left tree
const skeletonTreeItem = `
    <li class="mb-2">
        <div class="skeleton skeleton-text" style="width: 160px;"></div>
    </li>
`;

// Skeleton for product list
const skeletonProduct = `
    <div class="card mb-2 shadow-sm">
        <div class="card-body d-flex">
            <div class="skeleton skeleton-image me-3"></div>
            <div style="flex-grow:1">
                <div class="skeleton skeleton-text" style="width:70%"></div>
                <div class="skeleton skeleton-small" style="width:40%"></div>
                <div class="skeleton skeleton-small" style="width:25%"></div>
            </div>
        </div>
    </div>
`;


/** UTIL */
const fetchJson = (url) =>
    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json());

/** GLOBAL STATE */
let lastParams = {};
let debounceTimer = null;

document.addEventListener("DOMContentLoaded", () => {

    const tree = document.getElementById("category-tree-panel");
    const productList = document.getElementById("product-list");
    const pagination = document.getElementById("product-pagination");
    const searchInput = document.getElementById("product-search");
    const perPage = document.getElementById("per-page");

    /** -------------------------
     * LOAD PRODUCTS
     * ------------------------- */
    async function loadProducts(params = {}) {

        lastParams = { ...lastParams, ...params };
        lastParams.search = searchInput.value;
        lastParams.per_page = perPage.value;

        const qs = new URLSearchParams(lastParams).toString();

        productList.innerHTML =
            skeletonProduct +
            skeletonProduct +
            skeletonProduct +
            skeletonProduct;


        const json = await fetchJson(PRODUCT_URL + "?" + qs);
        renderProducts(json);
    }

    /** -------------------------
     * RENDER PRODUCTS
     * ------------------------- */
    function renderProducts(json) {

        if (!json.data || json.data.length === 0) {
            productList.innerHTML = `<div class='alert alert-info'>No products found.</div>`;
            pagination.innerHTML = "";
            return;
        }

        productList.innerHTML = json.data.map(p => {
            const img = p.images?.[0]
                ? `/storage/${p.images[0].image_path}`
                : `/images/placeholder.png`;

            return `
                <div class="card shadow-sm mb-2">
                    <div class="card-body d-flex">
                        <img src="${img}" class="rounded" style="width:72px;height:72px;object-fit:cover;margin-right:12px;">
                        <div>
                            <strong>${p.name}</strong><br>
                            <small class="text-muted">${p.seller?.name || ""}</small><br>
                            <small class="fw-bold">₹${Number(p.price).toFixed(2)}</small>
                        </div>
                    </div>
                </div>
            `;
        }).join("");

        pagination.innerHTML = `
            ${json.prev_page_url ? `<button class="btn btn-sm btn-outline-primary" data-url="${json.prev_page_url}">Prev</button>` : ""}
            <span class="mx-2">Page ${json.current_page} / ${json.last_page}</span>
            ${json.next_page_url ? `<button class="btn btn-sm btn-outline-primary" data-url="${json.next_page_url}">Next</button>` : ""}
        `;
    }

    /** -------------------------
     * EVENT ▸ PAGINATION
     * ------------------------- */
    pagination.addEventListener("click", (e) => {
        const btn = e.target.closest("button[data-url]");
        if (!btn) return;

        const url = new URL(btn.dataset.url);
        const params = Object.fromEntries(url.searchParams.entries());
        loadProducts(params);
    });

    /** -------------------------
     * EVENT ▸ SEARCH (debounced)
     * ------------------------- */
    searchInput.addEventListener("input", () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => loadProducts(), 350);
    });

    perPage.addEventListener("change", () => loadProducts());

    document.getElementById("clear-filter").addEventListener("click", () => {
        lastParams = {};
        searchInput.value = "";
        productList.innerHTML =
            `<div class="alert alert-info">Select a category to view products.</div>`;
        pagination.innerHTML = "";
    });

    /** -------------------------
     * TREE EXPAND HELPERS
     * ------------------------- */
    const childUrl = (type, id, params = "") =>
        CHILD_URL.replace("TYPE", type) + "/" + id + params;

    /** -------------------------
     * LEFT TREE EVENT DELEGATION
     * ------------------------- */
    tree.addEventListener("click", async (e) => {
        const t = e.target;

        // Expand department
        if (t.classList.contains("expand-dept")) {
            const parent = t.closest("li");
            const list = parent.querySelector(".master-list");
            await lazyLoad(list, childUrl("master_category", t.dataset.dept));
        }

        // Expand master category
        if (t.classList.contains("expand-mc")) {
            const parent = t.closest("li");
            const list = parent.querySelector(".st-list");
            await lazyLoad(
                list,
                childUrl("section_type", t.dataset.mc, `?dept=${t.dataset.dept}`)
            );
        }

        // Expand section type
        if (t.classList.contains("expand-st")) {
            const parent = t.closest("li");
            const list = parent.querySelector(".cat-list");
            await lazyLoad(
                list,
                childUrl(
                    "category",
                    t.dataset.st,
                    `?dept=${t.dataset.dept}&mc=${t.dataset.mc}`
                )
            );
        }

        // Final category selection
        if (t.classList.contains("select-mcs")) {
            loadProducts({
                chain_type: "category",
                mcs_id: t.dataset.mcs
            });
        }
    });

    /** -------------------------
     * LAZY LOAD CHILDREN
     * ------------------------- */
    async function lazyLoad(list, url) {

        if (list.dataset.loaded === "true") {
            list.classList.toggle("d-none");
            return;
        }

        // Insert Skeletons (3 items look premium)
        list.innerHTML = skeletonTreeItem + skeletonTreeItem + skeletonTreeItem;

        const rows = await fetchJson(url);
        list.innerHTML = "";

        rows.forEach(r => {
            const li = document.createElement("li");
            li.innerHTML = r.html;
            list.appendChild(li);
        });

        list.dataset.loaded = "true";
    }
});
