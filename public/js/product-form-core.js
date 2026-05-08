/* ================================
   PRODUCT FORM CORE (PHASE-1 SAFE)
   Shared pure engines only
================================ */

/* -------------------------------
   SELECT2 INIT
-------------------------------- */
function initCategorySelect2() {
    $('#categorySelect').select2({
        placeholder: "Search and select categories",
        width: '100%'
    });
}

/* -------------------------------
   CATEGORY → SUBCATEGORY LOADER
-------------------------------- */
function bindCategorySubcategoryLoader(categorySelect, subCategorySelect, tree) {
    categorySelect.on('change', function () {
        const categoryId = this.value;
        subCategorySelect.html('<option value="">Select Sub Category</option>');
        if (!categoryId) return;

        const category = tree.find(c => c.id == categoryId);
        if (!category) return;

        category.sub_categories.forEach(sub => {
            if (!sub.status) return;
            subCategorySelect.append(
                `<option value="${sub.id}">${sub.name}</option>`
            );
        });
    });
}

/* -------------------------------
   CARTESIAN PRODUCT
-------------------------------- */
function cartesianProduct(arr) {
    return arr.reduce((a, b) =>
        a.flatMap(d => b.map(e => [...d, e])), [[]]
    );
}

/* -------------------------------
   TOGGLE BASIC STOCK
-------------------------------- */
function toggleBasicStockField(selectedVariantAttributes, basicStockField) {
    const hasVariants = Object.values(selectedVariantAttributes)
        .some(arr => arr.length);

    basicStockField.toggle(!hasVariants);
}

/* -------------------------------
   SKU GENERATOR
-------------------------------- */
function generateVariantSku(productNameInput, combo) {
    const productName = productNameInput.val() || 'PRD';

    const prefix = productName
        .split(' ')
        .map(w => w.charAt(0))
        .join('')
        .toUpperCase();

    const variantCode = combo
        .map(v => v.label
            .replace(/[^a-zA-Z0-9]/g, '')
            .substring(0, 3)
            .toUpperCase())
        .join('-');

    return `${prefix}-${variantCode}`;
}

/* -------------------------------
   BASE PRICE AUTO FILL
-------------------------------- */
function bindBasePriceAutofill(basePriceInput, variantTable) {
    basePriceInput.on('input', function () {
        const base = $(this).val();

        variantTable.find('tbody tr').each(function () {
            const priceInput = $(this).find('input[name$="[price]"]');
            if (!priceInput.val()) {
                priceInput.val(base);
            }
        });
    });
}

/* -------------------------------
   PRODUCT NAME → SKU AUTO UPDATE
-------------------------------- */
function bindProductNameSkuAuto(productNameInput, variantTable, variantState, skuGenerator) {
    productNameInput.on('input', function () {

        variantTable.find('tbody tr').each(function () {

            const row = $(this);
            const key = row.data('key');

            if (!variantState[key]) return;

            const combo = key.split('-').map(id => {
                const label = row.find(`input[value="${id}"]`)
                    .parent()
                    .text()
                    .trim();

                return { label };
            });

            const newSku = skuGenerator(combo);
            const skuInput = row.find('input[name$="[sku]"]');

            if (!skuInput.data('manual')) {
                skuInput.val(newSku);
                variantState[key].sku = newSku;
            }

        });

    });
}

// ===============================
// VARIANT ATTRIBUTE CORE
// ===============================

function buildSelectedVariantAttributes(variantAttributesContainer) {

    const selected = {};

    variantAttributesContainer
        .find('input[type="checkbox"]:checked')
        .each(function () {

            const attrId = this.name.match(/\d+/)[0];

            if (!selected[attrId]) {
                selected[attrId] = [];
            }

            selected[attrId].push({
                id: this.value,
                label: $(this).next('label').text()
            });

        });

    return selected;
}

function cartesianProductVariant(arr) {
    return arr.reduce(
        (a, b) => a.flatMap(d => b.map(e => [...d, e])),
        [[]]
    );
}

function toggleBasicStockField(selectedVariantAttributes, basicStockField) {

    const hasVariants = Object.values(selectedVariantAttributes)
        .some(arr => arr.length);

    basicStockField.toggle(!hasVariants);
}