let timer;
let currentSearch = '';
let currentStatus = '';
let activeTab = 'products'; // Default tab

// Fetch products with search + status + pagination
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
        },
        error: function () {
            console.error('Failed to fetch products.');
        }
    });
}

// 🎯 Tab switching
$(document).on('click', '.tab-btn', function () {
    activeTab = $(this).data('tab');

    // Update UI
    $('.tab-btn').removeClass('border-black').addClass('border-transparent');
    $(this).removeClass('border-transparent').addClass('border-black');

    // Fetch data
    fetchProducts(currentSearch, 1, currentStatus);
});


// 🔍 Search input
$('#search').on('input', function () {
    clearTimeout(timer);
    currentSearch = $(this).val();

    timer = setTimeout(function () {
        fetchProducts(currentSearch, 1, currentStatus);
    }, 300);
});


// ✅ Status checkbox filter
$(document).on('change', '.status-checkbox', function () {

    // allow only one checkbox at a time
    $('.status-checkbox').not(this).prop('checked', false);

    if ($(this).is(':checked')) {
        currentStatus = $(this).val();
    } else {
        currentStatus = '';
    }

    fetchProducts(currentSearch, 1, currentStatus);
});


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


// ⚙ Action dropdown (edit/delete)
document.addEventListener("click", (e) => {
    const actionBtn = e.target.closest(".action-btn");

    document.querySelectorAll(".action-dropdown").forEach(dropdown => {
        if (actionBtn && dropdown === actionBtn.nextElementSibling) {
            dropdown.style.display =
                dropdown.style.display === "block" ? "none" : "block";
        } else {
            dropdown.style.display = "none";
        }
    });
});


// 🎯 Filter dropdown UI
const filterBtn = document.getElementById('filterBtn');
const dropdownMenu = document.getElementById('dropdownMenu');
const wrapper = document.getElementById('filterDropdown');

if (filterBtn) {
    filterBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdownMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!wrapper.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
}
