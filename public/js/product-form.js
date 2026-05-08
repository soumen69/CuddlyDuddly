$(function () {

    const productForm = $('#productForm');
    const categorySelect = $('#productCategory');
    const subCategorySelect = $('#productSubCategory');
    const attributeContainer = $('#attributeContainer');

    const variantAttributes = $('#variantAttributes');
    const variantTable = $('#variantTable');
    const basicStockField = $('#basicStockField');

    const productNameInput = $('input[name="name"]');
    const basePriceInput = $('input[name="price"]');

    let selectedVariantAttributes = {};
    let variantIndexCounter = 0;
    // let visualAttributeId = null;
    let visualAttributes = {};
    let visualImageFiles = {};

    $('#categorySelect').select2({
        placeholder: "Search and select categories",
        width: '100%',
    });

    categorySelect.on('change', function () {
        const categoryId = this.value;
        subCategorySelect.html('<option value="">Select Sub Category</option>');
        if (!categoryId) return;
        const category = productCategoryTree.find(c => c.id == categoryId);
        if (!category) return;
        category.sub_categories.forEach(sub => {
            if (!sub.status) return;
            subCategorySelect.append(
                `<option value="${sub.id}">${sub.name}</option>`
            );
        });
    });

    subCategorySelect.on('change', function () {
        selectedVariantAttributes = {};
        const categoryId = categorySelect.val();
        if (!categoryId) return;
        attributeContainer.html('<div class="text-muted">Loading attributes...</div>');
        variantAttributes.html('');
        variantTable.html('');
        const attributeUrl = window.attributeUrlTemplate.replace(':id', categoryId);
        $.get(attributeUrl).done(function (data) {

            attributeContainer.empty();

            if (!data.length) {
                attributeContainer.html('<div class="text-muted">No attributes available</div>');
                return;
            }

            visualAttributes = {};
            $('#visualVariantTitle').text('Variant Images'); // reset first

            data.forEach(attr => {

                if (attr.is_visual) {
                    visualAttributes[attr.id] = attr.name;
                }
                let html = `
            <div class="variant-check-zone mb-3">
                <label class="block">${attr.name}</label>`;
                attr.values.forEach(val => {
                    html += `
                <div class="form-check form-check-inline">
                    <input class="form-check-input"
                        type="checkbox"
                        name="attributes[${attr.id}][]"
                        data-variant="${attr.is_variant}"
                        value="${val.id}">
                    <label class="form-check-label">${val.value}</label>
                </div>
            `;
                });

                html += `</div>`;

                if (attr.is_variant) {
                    variantAttributes.append(html);
                } else {
                    attributeContainer.append(html);
                }

            });

        })
            .fail(function () {
                attributeContainer.html('<div class="text-danger">Failed to load attributes</div>');
            });
    });

    $(document).on('change', '#variantAttributes input[type="checkbox"]', function () {
        syncVariantStateFromDOM();
        selectedVariantAttributes = {};
        $('#variantAttributes input[type="checkbox"]:checked').each(function () {
            const attrId = this.name.match(/\d+/)[0];
            if (!selectedVariantAttributes[attrId]) {
                selectedVariantAttributes[attrId] = [];
            }
            selectedVariantAttributes[attrId].push({
                id: this.value,
                label: $(this).next('label').text()
            });
        });
        variantState = Object.fromEntries(
            Object.entries(variantState).filter(([key]) =>
                key.split('-').every(id =>
                    $('#variantAttributes input[value="' + id + '"]').is(':checked')
                )
            )
        );
        generateVariants();
        toggleBasicStock();
        generateVisualVariantBlocks();
        toggleStaticDropzoneUI();
    });

    function generateVisualVariantBlocks() {

        const card = $('#visualVariantCard');
        const container = $('#visualVariantImageContainer');

        // DO NOT WIPE STATE — only UI
        container.children().detach();

        const checkedVisualValues = [];

        Object.keys(visualAttributes).forEach(attrId => {

            $(`input[name="attributes[${attrId}][]"]:checked`)
                .each(function () {

                    checkedVisualValues.push({
                        attrId,
                        valueId: $(this).val(),
                        label: $(this).next('label').text()
                    });

                });

        });

        if (!checkedVisualValues.length) {
            card.hide();
            toggleStaticDropzoneUI();
            return;
        }

        card.show();

        toggleStaticDropzoneUI(); // ✅ unified control

        allFiles = [];
        updatePreviews();

        // if (Object.values(visualImageFiles).some(f => f.length > 0)) {
        //     allFiles = [];
        //     updatePreviews();
        // }

        checkedVisualValues.forEach(v => {

            if (!visualImageFiles[v.valueId])
                visualImageFiles[v.valueId] = [];

            const block = $(`
            <div class="visual-variant-block mb-4" data-attr="${v.valueId}">
                <div class="fw-semibold mb-2">
                    ${visualAttributes[v.attrId]} : ${v.label}
                </div>

                <div class="visual-dropzone dropzone-area text-center" data-attr="${v.valueId}">
                    <div class="dropzone-content">
                        <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>
                        <p class="mt-2 mb-1 fw-semibold">
                            Drag & Drop Images Here or Click to Browse
                        </p>
                        <small class="text-muted">
                            Minimum 4 images required for each variant (JPEG, PNG, max 500KB).
                        </small>
                    </div>

                    <div class="preview-container mt-3"></div>

                    <div class="upload-progress mt-3 d-none">
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                        <small>
                            Uploading:
                            <span class="upload-count">0</span> /
                            <span class="total-count">0</span>
                        </small>
                    </div>
                </div>
            </div>
        `);

            container.append(block);
            setTimeout(() => {
                initCreateVisualDropzone(block, v.valueId);
            }, 0);
        });
    }

    $(document).on('click', '.visual-dropzone .preview-remove', function () {
        const value = $(this).data('value');
        const index = $(this).data('index');
        visualImageFiles[value].splice(index, 1);
        generateVisualVariantBlocks();
    });

    let variantState = {};

    function syncVariantStateFromDOM() {
        $('#variantTable tbody tr').each(function () {
            const row = $(this);
            const key = row.data('key');
            if (!variantState[key]) return;
            variantState[key] = {
                sku: row.find('input[name$="[sku]"]').val(),
                price: row.find('input[name$="[price]"]').val(),
                stock: row.find('input[name$="[stock]"]').val(),
                enabled: row.find('input[name$="[enabled]"]').is(':checked')
            };
        });
    }

    $(document).on('change', '#variantTable input[name$="[enabled]"]', function () {
        syncVariantStateFromDOM();
        const usedValues = new Set();
        $('#variantTable tbody tr').each(function () {
            const row = $(this);
            const enabled = row.find('input[name$="[enabled]"]').is(':checked');
            if (!enabled) return;
            row.find('input[name$="[values][]"]').each(function () {
                usedValues.add($(this).val());
            });
        });

        let changed = false;

        $('#variantAttributes input[type="checkbox"]').each(function () {
            const val = $(this).val();
            if (!usedValues.has(val) && $(this).is(':checked')) {
                $(this).prop('checked', false);
                changed = true;
            }
        });
        if (changed) {
            $('#variantAttributes input[type="checkbox"]').first().trigger('change');
        }
    });

    function generateVariants() {
        const attrs = Object.values(selectedVariantAttributes);
        if (!attrs.length) {
            variantTable.html('');
            variantState = {};
            basicStockField.show();
            return;
        }
        const combinations = cartesianProduct(attrs);
        syncVariantStateFromDOM();
        variantIndexCounter = 0;
        updateVariantRows(combinations);
    }

    function toggleBasicStock() {
        const hasVariants = Object.values(selectedVariantAttributes).some(arr => arr.length);
        basicStockField.toggle(!hasVariants);
    }

    function cartesianProduct(arr) {
        return arr.reduce((a, b) =>
            a.flatMap(d => b.map(e => [...d, e])), [[]]
        );
    }

    function generateSku(combo) {
        const productName = productNameInput.val() || 'PRD';
        const prefix = productName
            .split(' ')
            .map(w => w.charAt(0))
            .join('')
            .toUpperCase();
        const variantCode = combo
            .map(v => v.label.replace(/[^a-zA-Z0-9]/g, '').substring(0, 3).toUpperCase())
            .join('-');
        return `${prefix}-${variantCode}`;
    }

    function updateVariantRows(combinations) {

        const basePrice = basePriceInput.val() || '';

        if (!variantTable.find('table').length) {

            variantTable.html(`
        <div class="card mt-4">
         <div class="card-header fw-semibold">Product Variants</div>
          <div class="card-body table-responsive">
           <table class="table table-bordered align-middle">
            <thead>
             <tr>
              <th>Enable</th>
              <th>Variant</th>
              <th>SKU</th>
              <th>Price</th>
              <th>Stock</th>
             </tr>
            </thead>
            <tbody></tbody>
           </table>
          </div>
        </div>
        `);
        }

        const tbody = variantTable.find('tbody');
        tbody.empty();

        const newState = {};

        combinations.forEach(combo => {

            const key = combo.map(v => v.id).join('-');
            const label = combo.map(v => v.label).join(' / ');
            const valueIds = combo.map(v => v.id);

            const prev = variantState[key] || {};

            const rowIndex = variantIndexCounter++;

            const sku = prev.sku || generateSku(combo);
            const price = prev.price || basePrice;
            const stock = prev.stock || '';
            const enabled = prev.enabled !== false;

            newState[key] = { sku, price, stock, enabled };

            const row = `
            <tr data-key="${key}">
                <td>
                    <input type="hidden" name="variants[${rowIndex}][enabled]" value="0">
                    <input type="checkbox"
                        name="variants[${rowIndex}][enabled]"
                        value="1"
                        ${enabled ? 'checked' : ''}>
                </td>

                <td>
                    ${label}
                    ${valueIds.map(v =>
                `<input type="hidden" name="variants[${rowIndex}][values][]" value="${v}">`
            ).join('')}
                </td>

                <td>
                    <input type="text"
                        name="variants[${rowIndex}][sku]"
                        class="form-control"
                        value="${sku}">
                </td>

                <td>
                    <input type="number"
                        step="0.01"
                        name="variants[${rowIndex}][price]"
                        class="form-control"
                        value="${price}">
                </td>

                <td>
                    <input type="number"
                        name="variants[${rowIndex}][stock]"
                        class="form-control"
                        value="${stock}">
                </td>
            </tr>
            `;

            tbody.append(row);

        });

        variantState = newState;

    }

    $(document).on('input change', '#variantTable input', function () {
        const row = $(this).closest('tr');
        const key = row.data('key');
        if (!variantState[key]) return;
        variantState[key].sku = row.find('input[name$="[sku]"]').val();
        variantState[key].price = row.find('input[name$="[price]"]').val();
        variantState[key].stock = row.find('input[name$="[stock]"]').val();
        variantState[key].enabled = row.find('input[name$="[enabled]"]').is(':checked');

        if ($(this).attr('name').includes('[sku]')) {
            $(this).data('manual', true);
        }
    });

    basePriceInput.on('input', function () {
        const base = $(this).val();
        $('#variantTable tbody tr').each(function () {
            const priceInput = $(this).find('input[name$="[price]"]');
            if (!priceInput.val()) {
                priceInput.val(base);
            }
        });
    });

    productNameInput.on('input', function () {
        $('#variantTable tbody tr').each(function () {
            const row = $(this);
            const key = row.data('key');
            if (!variantState[key]) return;
            const combo = key.split('-').map(id => {
                const label = row.find(`input[value="${id}"]`).parent().text().trim();
                return { label };
            });
            const newSku = generateSku(combo); const skuInput = row.find('input[name$="[sku]"]');
            if (!skuInput.data('manual')) {
                skuInput.val(newSku);
                variantState[key].sku = newSku;
            }
        });
    });

    const dropZone = $('#dropZone')[0];
    const previews = $('#imagePreviews')[0];
    const input = $('#imageInput')[0];
    const progressBox = $('#uploadProgress')[0];
    const bar = progressBox.querySelector('.progress-bar');
    const count = progressBox.querySelector('.upload-count');
    const total = progressBox.querySelector('.total-count');
    const errorBox = $('#errorMessage')[0];
    let allFiles = [];
    let uploading = false;

    const showError = (msg, type = 'danger', duration = 4000) => {
        errorBox.innerHTML = `<div class="alert alert-${type} py-2 mb-0">${msg}</div>`;
        errorBox.classList.remove('d-none');
        setTimeout(() => {
            errorBox.classList.add('fade');
            errorBox.style.opacity = '0';
            setTimeout(() => {
                errorBox.classList.add('d-none');
                errorBox.innerHTML = '';
                errorBox.classList.remove('fade');
                errorBox.style.opacity = '1';
            }, 400);
        }, duration);
    };


    const handleFiles = files => {
        const hasVisualVariants =
            Object.keys(visualImageFiles).length > 0 &&
            Object.values(visualImageFiles).some(files => files && files.length > 0);
        if (hasVisualVariants) {
            showError('Remove variant images first to upload normal images.', 'warning');
            return;
        }
        if (uploading)
            return showError('Please wait for current upload to complete');
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        let valid = [], large = 0, wrongType = 0;
        [...files].forEach(f => {
            if (!allowedTypes.includes(f.type)) {
                wrongType++;
                return;
            }
            if (f.size > 512000) {
                large++;
                return;
            }
            if (!allFiles.some(x => x.name === f.name && x.size === f.size))
                valid.push(f);
        });

        if (wrongType)
            showError(`${wrongType} file(s) not added — only JPG, JPEG, PNG allowed.`, 'warning');
        if (large)
            showError(`${large} image(s) exceeded 500KB.`, 'warning');
        if (!valid.length) return;
        allFiles.push(...valid);
        updatePreviews();

        if (!uploading) {
            simulateUpload();
        }
    };

    const updatePreviews = () => {
        previews.innerHTML = '';
        allFiles.forEach((f, i) => {
            const r = new FileReader();
            r.onload = e => {
                const item = document.createElement('div');
                item.className = 'preview-item';
                item.innerHTML = `
                <img src="${e.target.result}">
                <button type="button"
                class="preview-remove"
                data-index="${i}">
                <i class="bi bi-trash-fill"></i>
                </button>`;
                previews.appendChild(item);
            };
            r.readAsDataURL(f);
        });
        previews.classList.toggle('d-none', !allFiles.length);
    };


    const simulateUpload = () => {
        if (!allFiles.length || uploading) return;
        uploading = true;
        progressBox.classList.remove('d-none');
        bar.style.width = '0%';
        count.textContent = '0';
        total.textContent = allFiles.length;
        let uploaded = 0;
        const totalFiles = allFiles.length;
        const interval = setInterval(() => {
            uploaded++;
            const percent = Math.min((uploaded / totalFiles) * 100, 100);
            bar.style.width = `${percent}%`;
            count.textContent = uploaded;
            if (uploaded >= totalFiles) {
                clearInterval(interval);
                setTimeout(() => {
                    progressBox.classList.add('d-none');
                    uploading = false;
                }, 500);
            }
        }, 200);
    };

    previews.addEventListener('click', e => {
        const btn = e.target.closest('.preview-remove');
        if (!btn) return;
        e.stopPropagation();
        if (uploading)
            return showError('Please wait until upload completes');
        const idx = +btn.dataset.index;
        allFiles.splice(idx, 1);
        updatePreviews();
    });


    dropZone.addEventListener('click', (e) => {
        if ($('#dropZone').hasClass('disabled-dropzone')) return;
        if (e.target.closest('.preview-remove')) return;
        input.click();
    });

    ['dragover', 'dragleave', 'drop'].forEach(evt => {
        dropZone.addEventListener(evt, e => {
            if ($('#dropZone').hasClass('disabled-dropzone')) return;
            e.preventDefault();
            if (evt === 'dragover')
                dropZone.classList.add('dragover');
            else if (evt === 'dragleave')
                dropZone.classList.remove('dragover');
            else {
                dropZone.classList.remove('dragover');
                handleFiles(e.dataTransfer.files);
            }
        });
    });
    input.addEventListener('change', () => handleFiles(input.files));


    function initCreateVisualDropzone(block, valueId) {
        const zone = block.find('.visual-dropzone');
        const preview = block.find('.preview-container');
        const progress = block.find('.upload-progress');
        const bar = progress.find('.progress-bar');
        const count = progress.find('.upload-count');
        const total = progress.find('.total-count');
        if (!visualImageFiles[valueId])
            visualImageFiles[valueId] = [];
        function render() {
            preview.empty();
            const has = visualImageFiles[valueId].length > 0;
            if (has) {
                zone.addClass('has-images');
                zone.find('.dropzone-content')
                    .css({ opacity: .15, pointerEvents: 'none' });
            } else {
                zone.removeClass('has-images');
                zone.find('.dropzone-content')
                    .css({ opacity: 1, pointerEvents: 'auto' });
            }
            visualImageFiles[valueId].forEach((file, i) => {
                const reader = new FileReader();
                const node = $(`
                <div class="preview-item new">
                    <img>
                    <button type="button"
                        class="preview-remove"
                        data-value="${valueId}"
                        data-index="${i}">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </div>
            `);
                preview.append(node);
                reader.onload = e => node.find('img').attr('src', e.target.result);
                reader.readAsDataURL(file);
            });
        }

        function simulate() {
            progress.removeClass('d-none');
            let i = 0;
            const t = visualImageFiles[valueId].length;
            total.text(t);
            const int = setInterval(() => {
                i++;
                bar.css('width', (i / t * 100) + '%');
                count.text(i);

                if (i >= t) {
                    clearInterval(int);
                    setTimeout(() => progress.addClass('d-none'), 600);
                }
            }, 250);
        }

        zone.on('dragover', e => {
            e.preventDefault();
            zone.addClass('dragover');
        });

        zone.on('dragleave', () => zone.removeClass('dragover'));

        zone.on('drop', e => {
            e.preventDefault();
            zone.removeClass('dragover');

            [...e.originalEvent.dataTransfer.files].forEach(file => {
                if (!file.type.match('image.*')) return;
                if (file.size > 500 * 1024) return;

                const dup = visualImageFiles[valueId]
                    .some(f => f.name === file.name && f.size === file.size);

                if (!dup) visualImageFiles[valueId].push(file);
            });

            render();
            simulate();
        });

        zone.on('click', function (e) {

            if ($(e.target).closest('.preview-remove').length) return;

            const input = $('<input type="file" multiple accept="image/*" hidden>');
            $('body').append(input);

            input.on('change', function () {

                [...this.files].forEach(file => {
                    if (!file.type.match('image.*')) return;
                    if (file.size > 500 * 1024) return;

                    const dup = visualImageFiles[valueId]
                        .some(f => f.name === file.name && f.size === file.size);

                    if (!dup) visualImageFiles[valueId].push(file);
                });

                render();
                simulate();
            });

            input.trigger('click');
        });
        render();
    }

    function toggleStaticDropzoneUI() {
        const hasVisual = Object.keys(visualAttributes).some(attrId =>
            $(`input[name="attributes[${attrId}][]"]:checked`).length > 0
        );

        const dropZone = $('#dropZone');
        const input = $('#imageInput');

        if (hasVisual) {
            dropZone.addClass('disabled-dropzone');

            dropZone.css({
                opacity: 0.5,
                cursor: 'not-allowed'
            });

            input.prop('disabled', true);

        } else {
            dropZone.removeClass('disabled-dropzone');

            dropZone.css({
                opacity: 1,
                cursor: 'pointer'
            });

            input.prop('disabled', false);
        }
    }

    productForm.on('submit', function (e) {
        e.preventDefault();
        const form = this;
        const submitBtn = $(form).find('button[type="submit"]');
        if (submitBtn.prop('disabled')) return;
        const hasVisualVariants =
            Object.keys(visualImageFiles).length > 0 &&
            Object.values(visualImageFiles).some(files => files && files.length > 0);
        if (hasVisualVariants) {
            for (let attrId in visualImageFiles) {
                if (visualImageFiles[attrId].length < 4) {
                    showError('Each visual variant must have at least 4 images.');
                    return;
                }
            }
        } else {
            if (allFiles.length < 4) {
                showError('At least 4 product images are required.');
                return;
            }
        }
        if (uploading) {
            showError('Please wait until upload completes.', 'info');
            return;
        }

        const fd = new FormData(form);
        fd.delete('images[]');

        if (!hasVisualVariants) {
            allFiles.forEach(file => {
                fd.append('images[]', file);
            });
        }

        if (hasVisualVariants) {

            let totalFiles = 0;

            Object.entries(visualImageFiles).forEach(([attrId, files]) => {
                if (!Array.isArray(files) || files.length === 0) return;
                files.forEach(file => {
                    fd.append(`visual_images[${attrId}][]`, file);
                    totalFiles++;
                });

            });
            if (totalFiles === 0) {
                showError('No variant images found.');
                return;
            }
        }

        submitBtn.prop('disabled', true);
        submitBtn.html(`<span class="spinner-border spinner-border-sm me-2"></span>Uploading...`);

        fetch(form.getAttribute('action'), {
            method: form.method || 'POST',
            body: fd,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        })
            .then(async res => {
                const data = await res.json();

                if (!res.ok) {

                    // 🔥 HANDLE VALIDATION ERRORS PROPERLY
                    if (data.errors) {
                        const messages = Object.values(data.errors)
                            .flat()
                            .join('<br>• ');
                        showError('• ' + messages);
                    } else {
                        showError(data.message || 'Something went wrong');
                    }

                    throw new Error('Validation failed');
                }

                return data;
            })
            .then(data => {
                if (data.success && data.redirect) {
                    window.location.href = data.redirect;
                }
            })
            .catch(err => {
                console.error(err);
            })
            .finally(() => {
                // 🔥 ALWAYS RESET BUTTON
                submitBtn.prop('disabled', false);
                submitBtn.html(`<i class="bi bi-plus-circle me-1"></i> Add Product`);
            });
    });
});
