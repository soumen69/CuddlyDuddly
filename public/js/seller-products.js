let timer;
let currentSearch = '';
let currentStatus = '';
let suggestionTimer;

// ✅ Get active tab from UI (Blade applied class)
let activeTab = document.querySelector('#active_tab')?.value
    || document.querySelector('.tab-btn.bg-black')?.getAttribute('data-tab')
    || 'orders'; // fallback

// ✅ Reusable function to update UI
function updateActiveTabUI() {
    $('.tab-btn')
        .removeClass('bg-black text-white bg-transparent text-black')
        .addClass('bg-transparent text-black');

    $(`.tab-btn[data-tab="${activeTab}"]`)
        .removeClass('bg-transparent text-black')
        .addClass('bg-black text-white');

    $('#active_tab').val(activeTab);
}



// ✅ Fetch products
function fetchProducts(query = '', page = 1, status = '') {
    $.ajax({
        url: searchUrl,
        type: "GET",
        data: {
            search: query,
            page: page,
            status: status,
            active_tab: activeTab
        },
        success: function (data) {
            $('#product-container').html(data);

            // 🔥 Reapply active tab after AJAX (Blade override fix)
            updateActiveTabUI();
        },
        error: function () {
            console.error('Failed to fetch products.');
        }
    });
}

// 🎯 Tab click
$(document).on('click', '.tab-btn', function (e) {
    e.preventDefault();

    activeTab = $(this).attr('data-tab');

    updateActiveTabUI(); // instant UI change

    fetchProducts(currentSearch, 1, currentStatus);
});

// ✅ Ensure correct tab on page load (optional safety)
$(document).ready(function () {
    updateActiveTabUI();
});



const searchInput = document.getElementById('search');
const searchSuggestions = document.getElementById('searchSuggestions');

function renderSearchSuggestions(items = []) {
    if (!searchSuggestions) return;

    if (!items.length || !currentSearch.trim()) {
        searchSuggestions.classList.add('hidden');
        searchSuggestions.innerHTML = '';
        return;
    }

    searchSuggestions.innerHTML = items.map(item => `
        <button type="button"
            class="w-full flex items-center gap-3 px-3 py-2 text-left hover:bg-gray-50 border-b border-black/5 last:border-b-0 search-suggestion"
            data-tab="${item.tab}"
            data-name="${String(item.name).replace(/"/g, '&quot;')}">
            <div class="h-10 w-10 rounded-md overflow-hidden bg-gray-100 flex-none border border-black/10">
                ${item.image ? `<img src="${item.image}" class="h-full w-full object-cover">` : '<div class="h-full w-full flex items-center justify-center text-xs text-gray-400">No image</div>'}
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-sm font-medium text-black truncate">${item.name}</div>
                <div class="text-xs text-gray-500">₹${Number(item.price || 0).toFixed(2)}${item.stock !== null && item.stock !== undefined ? ` • Stock ${item.stock}` : ''}</div>
            </div>
        </button>
    `).join('');

    searchSuggestions.classList.remove('hidden');
}

function fetchSearchSuggestions(query) {
    if (!searchSuggestions) return;
    clearTimeout(suggestionTimer);

    if (!query.trim()) {
        renderSearchSuggestions([]);
        return;
    }

    suggestionTimer = setTimeout(() => {
        $.ajax({
            url: searchUrl,
            type: 'GET',
            dataType: 'json',
            data: {
                search: query,
                suggestions: 1
            },
            success: function (data) {
                renderSearchSuggestions(data.items || []);
            },
            error: function () {
                renderSearchSuggestions([]);
            }
        });
    }, 250);
}

$('#search').on('input', function () {
    clearTimeout(timer);
    currentSearch = $(this).val();
    fetchSearchSuggestions(currentSearch);
});

$(document).on('click', '.search-suggestion', function () {
    const tab = $(this).data('tab');
    const name = $(this).data('name');

    currentSearch = name;
    $('#search').val(name);
    activeTab = String(tab);
    updateActiveTabUI();
    renderSearchSuggestions([]);
    fetchProducts(currentSearch, 1, currentStatus);
});

document.addEventListener('click', function (e) {
    if (!searchSuggestions) return;
    if (searchSuggestions.contains(e.target) || e.target === searchInput) return;
    searchSuggestions.classList.add('hidden');
});


// // ✅ Status checkbox filter
// $(document).on('change', '.status-checkbox', function () {
//
//     // allow only one checkbox at a time
//     $('.status-checkbox').not(this).prop('checked', false);
//
//     if ($(this).is(':checked')) {
//         currentStatus = $(this).val();
//     } else {
//         currentStatus = '';
//     }
//
//     fetchProducts(currentSearch, 1, currentStatus);
// });


// 📄 Pagination
$(document).on('click', '#paginationLinks a', function (e) {
    e.preventDefault();

    let url = new URL($(this).attr('href'), window.location.origin);
    let page = url.searchParams.get('page');

    fetchProducts(currentSearch, page, currentStatus);

    const container = document.getElementById('product-container');
    if (container) {
        window.scrollTo({
            top: container.offsetTop - 100,
            behavior: 'smooth'
        });
    }
});

document.addEventListener("click", (e) => {
    const actionBtn = e.target.closest(".action-btn");

    document.querySelectorAll(".action-dropdown").forEach(dropdown => {
        if (actionBtn && dropdown === actionBtn.nextElementSibling) {
            dropdown.classList.toggle("show");
        } else {
            dropdown.classList.remove("show");
        }
    });
});

document.addEventListener('click', function (e) {
    const priceBtn = e.target.closest('.edit-price-btn');
    if (priceBtn) {
        e.stopPropagation();
        const wrapper = priceBtn.closest('.editable-price');
        wrapper.querySelector('.price-text').classList.add('hidden');
        wrapper.querySelector('.price-input').classList.remove('hidden');
        wrapper.querySelector('.price-input')?.focus();
        wrapper.querySelector('.price-input')?.select?.();
        priceBtn.classList.add('hidden');
        return;
    }

    const stockBtn = e.target.closest('.edit-stock-btn');
    if (stockBtn) {
        e.stopPropagation();
        const wrapper = stockBtn.closest('.editable-stock');
        wrapper.querySelector('.stock-text').classList.add('hidden');
        wrapper.querySelector('.stock-input').classList.remove('hidden');
        wrapper.querySelector('.stock-input')?.focus();
        wrapper.querySelector('.stock-input')?.select?.();
        stockBtn.classList.add('hidden');
        return;
    }
});

function saveInlineField(input) {
    if (!input || input.classList.contains('hidden')) return;

    const wrapper = input.closest('.editable-price, .editable-stock');
    if (!wrapper) return;

    const isPrice = input.classList.contains('price-input');
    const text = wrapper.querySelector(isPrice ? '.price-text' : '.stock-text');
    const button = wrapper.querySelector(isPrice ? '.edit-price-btn' : '.edit-stock-btn');
    const value = input.value;
    const payload = isPrice
        ? { price: value, mode: input.dataset.mode || 'variant' }
        : { stock: value, mode: input.dataset.mode || 'variant' };

    if (!input.dataset.updateUrl) return;

    fetch(input.dataset.updateUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
    });

    if (text) {
        text.innerText = isPrice ? '₹' + parseFloat(value).toFixed(2) : value;
        text.classList.remove('hidden');
    }
    input.classList.add('hidden');
    if (button) button.classList.remove('hidden');
}

document.addEventListener('blur', function (e) {
    if (e.target.matches('.price-input, .stock-input')) {
        saveInlineField(e.target);
    }
}, true);

document.addEventListener('keydown', function (e) {
    if (!e.target.matches('.price-input, .stock-input')) return;
    if (e.key === 'Enter') {
        e.preventDefault();
        e.target.blur();
    }
});

document.addEventListener('change', function (e) {
    const toggle = e.target.closest('.feature-toggle');

    if (!toggle) {
        return;
    }

    const url = toggle.dataset.featureUrl;

    if (!url) {
        toggle.checked = !toggle.checked;
        return;
    }

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            type: toggle.dataset.featureType || 'variant'
        }),
        credentials: 'same-origin'
    })
        .then(res => {
            if (!res.ok) {
                throw new Error('Request failed');
            }

            return res.json();
        })
        .then(() => window.location.reload())
        .catch(() => {
            toggle.checked = !toggle.checked;
            console.error('Failed to toggle featured state.');
        });
});

// // 🎯 Filter dropdown UI
// const filterBtn = document.getElementById('filterBtn');
// const dropdownMenu = document.getElementById('dropdownMenu');
// const wrapper = document.getElementById('filterDropdown');
//
// if (filterBtn) {
//     filterBtn.addEventListener('click', (e) => {
//         e.stopPropagation();
//         dropdownMenu.classList.toggle('hidden');
//     });
//
//     document.addEventListener('click', (e) => {
//         if (!wrapper.contains(e.target)) {
//             dropdownMenu.classList.add('hidden');
//         }
//     });
// }
