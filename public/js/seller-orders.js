const filterproductBtn = document.getElementById('filterProductBtn');
const dropdownproductMenu = document.getElementById('dropdownProductMenu');
const wrapperorder = document.getElementById('filterProductDropdown');
 
if (filterproductBtn) {
    filterproductBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdownproductMenu.classList.toggle('hidden');
    });
 
    document.addEventListener('click', (e) => {
        if (!wrapperorder.contains(e.target)) {
            dropdownproductMenu.classList.add('hidden');
        }
    });
}