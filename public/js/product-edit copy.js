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
    let variantState = {};
    let variantRowMap = {};
    let variantIndexCounter = 0;
    const existingVariantMap = {};
    let visualAttributes = {};
    let existingVisualMap = {};
    let newVisualFiles = {};
    let removedVisualImages = [];

    if (typeof existingVariants !== 'undefined') {
        existingVariants.forEach(v => {
            const ids = v.values.map(val => parseInt(val.id));
            const key = ids.sort((a, b) => a - b).join('-');
            existingVariantMap[key] = v;
        });
    }

    $('#categorySelect').select2({
        placeholder: "Search and select categories",
        width: '100%'
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
        if (typeof existingVisualImages !== 'undefined') {
            existingVisualImages.forEach(img => {
                const valId = parseInt(img.attribute_value_id);
                if (!existingVisualMap[valId]) {
                    existingVisualMap[valId] = [];
                }
                existingVisualMap[valId].push({
                    id: img.id,
                    path: img.image_path,
                    is_primary: img.is_primary
                });
            });
        }

        $.get(`/admin/product-categories/category-attributes/${categoryId}`)
            .done(function (data) {
                attributeContainer.empty();
                if (!data.length) {
                    attributeContainer.html('<div class="text-muted">No attributes available</div>');
                    return;
                }
                data.forEach(attr => {
                    if (attr.is_visual) {
                        visualAttributes[attr.id] = attr.name;
                    }
                    let html = `
                        <div class="mb-3">
                        <label class="fw-semibold mb-2 d-block">${attr.name}</label>
                        `;
                    attr.values.forEach(val => {
                        let checked = '';
                        if (typeof existingAttributes !== 'undefined') {
                            const found = existingAttributes.find(a => a.attribute_value_id == val.id);
                            if (found) checked = 'checked';
                        }
                        html += `
                            <div class="form-check form-check-inline">
                            <input class="form-check-input"
                            type="checkbox"
                            name="attributes[${attr.id}][]"
                            data-variant="${attr.is_variant}"
                            value="${val.id}"
                            ${checked}>
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
                setTimeout(() => {
                    buildSelectedAttributesFromDOM();
                    generateVariants();
                    toggleBasicStock();
                    syncAttributeCheckboxesFromVariants();
                    generateVisualZones();
                }, 150);
            });
    });

    function generateVisualZones() {
        const card = $('#visualVariantCard');
        const container = $('#visualVariantImageContainer');

        container.empty();

        const checkedVisualValues = [];

        Object.keys(visualAttributes).forEach(attrId => {
            $(`input[name="attributes[${attrId}][]"]:checked`).each(function () {
                checkedVisualValues.push({
                    attrId,
                    valueId: $(this).val(),
                    label: $(this).next('label').text()
                });
            });
        });

        if (!checkedVisualValues.length) {
            card.hide();
            return;
        }

        card.show();

        checkedVisualValues.forEach(v => {

            if (!newVisualFiles[v.valueId]) newVisualFiles[v.valueId] = [];

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
                            Upload images (JPEG, PNG, max 500KB).
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

            initVisualDropzone(block, v.valueId);
        });
    }

    function initVisualDropzone(block, valueId) {

        const zone = block.find('.visual-dropzone');
        const preview = block.find('.preview-container');
        const progress = block.find('.upload-progress');
        const bar = progress.find('.progress-bar');
        const count = progress.find('.upload-count');
        const total = progress.find('.total-count');

        let uploading = false;

        function render() {
            preview.empty();

            const existing = (existingVisualMap[valueId] || [])
                .filter(img => !removedVisualImages.includes(img.id));

            const has = existing.length + newVisualFiles[valueId].length > 0;

            if (has) {
                zone.addClass('has-images');
                zone.find('.dropzone-content')
                    .css({ opacity: .15, pointerEvents: 'none' });
            } else {
                zone.removeClass('has-images');
                zone.find('.dropzone-content')
                    .css({ opacity: 1, pointerEvents: 'auto' });
            }

            existing.forEach(img => {
                preview.append(`
                <div class="preview-item existing">
                    <img src="/storage/${img.path}">
                    <button type="button"
                        class="preview-remove"
                        data-existing-id="${img.id}"
                        data-id="${img.id}">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </div>
            `);
            });

            newVisualFiles[valueId].forEach((file, i) => {
                const reader = new FileReader();
                const node = $(`
                <div class="preview-item new">
                    <img>
                    <button type="button"
                        class="preview-remove"
                        data-file-id="v-${valueId}-${i}"
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
            uploading = true;
            progress.removeClass('d-none');
            let i = 0;
            const t = newVisualFiles[valueId].length;
            total.text(t);

            const int = setInterval(() => {
                i++;
                bar.css('width', (i / t * 100) + '%');
                count.text(i);

                if (i >= t) {
                    clearInterval(int);
                    setTimeout(() => {
                        progress.addClass('d-none');
                        uploading = false;
                    }, 600);
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

            if (uploading) return;

            [...e.originalEvent.dataTransfer.files].forEach(file => {
                if (!file.type.match('image.*')) return;
                if (file.size > 500 * 1024) return;

                const dup = newVisualFiles[valueId]
                    .some(f => f.name === file.name && f.size === file.size);

                if (!dup) newVisualFiles[valueId].push(file);
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

                    const dup = newVisualFiles[valueId]
                        .some(f => f.name === file.name && f.size === file.size);

                    if (!dup) newVisualFiles[valueId].push(file);
                });

                render();
                simulate();
            });

            input.trigger('click');
        });

        render();
    }

    $(document).on('click', '.preview-remove-visual-existing', function () {
        const id = $(this).data('id');
        removedVisualImages.push(id);
        $(this).closest('.preview-item').remove();
    });

    $(document).on('click', '.preview-remove-visual-new', function () {
        const value = $(this).data('value');
        const index = $(this).data('index');
        newVisualFiles[value].splice(index, 1);
        generateVisualZones();
    });

    $(document).on('click', '.visual-dropzone .preview-remove', function () {
        const existingId = $(this).data('existing-id');
        const fileId = $(this).data('file-id');
        if (existingId) {
            removedVisualImages.push(existingId);
        }
        if (fileId) {
            const parts = fileId.split('-');
            const valueId = parts[1];
            const index = parseInt(parts[2]);
            newVisualFiles[valueId].splice(index, 1);
        }
        generateVisualZones();
    });

    function buildSelectedAttributesFromDOM() {
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
    }

    $(document).on('change', '#variantAttributes input[type="checkbox"]', function () {
        buildSelectedAttributesFromDOM();
        generateVariants();
        toggleBasicStock();
        generateVisualZones();
    });

    function cartesianProduct(arr) {
        return arr.reduce((a, b) =>
            a.flatMap(d => b.map(e => [...d, e]))
            , [[]]);
    }

    function buildKey(combo) {
        return combo
            .map(v => parseInt(v.id))
            .sort((a, b) => a - b)
            .join('-');
    }

    function generateVariants() {
        const attrs = Object.values(selectedVariantAttributes);
        if (!attrs.length) {
            variantTable.html('');
            variantState = {};
            variantRowMap = {};
            variantIndexCounter = 0;
            basicStockField.show();
            return;
        }
        const combinations = cartesianProduct(attrs);
        syncVariantStateFromDOM();
        variantIndexCounter = 0;
        updateVariantEngine(combinations);
    }


    function getVariantBody() {
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
        return variantTable.find('tbody');
    }

    function updateVariantEngine(combos) {
        const tbody = getVariantBody();
        tbody.empty();
        variantRowMap = {};
        const newKeys = new Set();
        variantIndexCounter = 0;
        combos.forEach((combo) => {
            const index = variantIndexCounter++;
            const key = buildKey(combo);
            newKeys.add(key);
            const label = combo.map(v => v.label).join(' / ');
            const valueIds = combo.map(v => parseInt(v.id));
            if (!variantState[key]) {
                const existing = existingVariantMap[key];
                variantState[key] = {
                    id: existing ? existing.id : null,
                    sku: existing ? existing.sku : generateSku(combo),
                    price: existing ? existing.price : basePriceInput.val(),
                    stock: existing ? existing.stock : '',
                    enabled: existing ? 1 : isNewAttributeCombination(combo),
                    values: valueIds
                };
            }
            if (!variantRowMap[key]) {
                const row = createRow(index, key, label, variantState[key], valueIds);
                tbody.append(row);
                variantRowMap[key] = row;
            }
        });

        Object.keys(variantRowMap).forEach(key => {
            if (!newKeys.has(key)) {
                variantRowMap[key].remove();
                delete variantRowMap[key];
                delete variantState[key];
            }
        });
    }

    function isNewAttributeCombination(combo) {
        return true;
    }

    function createRow(index, key, label, data, valueIds) {
        return $(`
                <tr data-key="${key}">
                <td>
                <input type="checkbox"
                name="variants[${index}][enabled]"
                value="1"
                ${data.enabled ? 'checked' : ''}>
                <input type="hidden"
                name="variants[${index}][id]"
                value="${data.id ? data.id : ''}">
                </td>
                <td>
                ${label}
                ${valueIds.map(v =>
            `<input type="hidden" name="variants[${index}][values][]" value="${v}">`
        ).join('')}
                </td>
                <td>
                <input type="text"
                name="variants[${index}][sku]"
                class="form-control"
                value="${data.sku}">
                </td>
                <td>
                <input type="number"
                step="0.01"
                name="variants[${index}][price]"
                class="form-control"
                value="${data.price}">
                </td>
                <td>
                <input type="number"
                name="variants[${index}][stock]"
                class="form-control"
                value="${data.stock}">
                </td>
                </tr>`);
    }

    function syncVariantStateFromDOM() {
        $('#variantTable tbody tr').each(function () {
            const row = $(this);
            const key = row.data('key');
            if (!variantState[key]) return;
            variantState[key].sku = row.find('[name$="[sku]"]').val();
            variantState[key].price = row.find('[name$="[price]"]').val();
            variantState[key].stock = row.find('[name$="[stock]"]').val();
            variantState[key].enabled = row.find('[name$="[enabled]"]').is(':checked');
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

        $('#variantAttributes input[type="checkbox"]').each(function () {
            const val = $(this).val();
            if (!usedValues.has(val)) {
                $(this).prop('checked', false);
            }
        });
    });

    function syncAttributeCheckboxesFromVariants() {
        const usedValues = new Set();
        $('#variantTable tbody tr').each(function () {
            const row = $(this);
            const enabled = row.find('input[name$="[enabled]"]').is(':checked');
            if (!enabled) return;
            row.find('input[name$="[values][]"]').each(function () {
                usedValues.add(parseInt($(this).val()));
            });
        });

        $('#variantAttributes input[type="checkbox"]').each(function () {
            const val = parseInt($(this).val());
            $(this).prop('checked', usedValues.has(val));
        });
    }

    $(document).on('change', '#variantTable input[name$="[enabled]"]', function () {
        syncVariantStateFromDOM();
        syncAttributeCheckboxesFromVariants();
    });

    function toggleBasicStock() {
        const hasVariants = Object.values(selectedVariantAttributes).some(arr => arr.length);
        basicStockField.toggle(!hasVariants);
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

    productNameInput.on('input', function () {
        $('#variantTable tbody tr').each(function () {
            const row = $(this);
            const key = row.data('key');
            if (!variantState[key]) return;
            const combo = key.split('-').map(id => {
                const label = row.find(`input[value="${id}"]`).parent().text().trim();
                return { label };
            });
            const newSku = generateSku(combo);
            const skuInput = row.find('input[name$="[sku]"]');
            if (!skuInput.data('manual')) {
                skuInput.val(newSku);
                variantState[key].sku = newSku;
            }
        });
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

    if (subCategorySelect.val()) {
        subCategorySelect.trigger('change');
    }

    const dropZone = document.getElementById('dropZone');
    const dropzoneContent = document.getElementById('dropzoneContent');
    const imagePreviews = document.getElementById('imagePreviews');
    const imageInput = document.getElementById('imageInput');
    const uploadProgress = document.getElementById('uploadProgress');
    const progressBar = uploadProgress.querySelector('.progress-bar');
    const uploadCount = uploadProgress.querySelector('.upload-count');
    const totalCount = uploadProgress.querySelector('.total-count');
    const errorMessage = document.getElementById('errorMessage');
    const removedImagesInput = document.getElementById('removedImages');
    let existingImages = [];
    let allFiles = [];
    let removedImages = [];
    let uploadInProgress = false;
    function uid() {
        return Date.now().toString(36) + Math.random().toString(36).slice(2, 8);
    }

    (function initExisting() {
        const existingNodes = document.querySelectorAll('.preview-item.existing');
        existingNodes.forEach(node => {
            const id = node.dataset.id;
            const img = node.querySelector('img');
            const src = img ? img.getAttribute('src') : '';
            if (id) existingImages.push({ id: id.toString(), src });
        });
        imagePreviews.innerHTML = '';
        renderPreviews();
    })();

    function showError(message, type = 'danger', duration = 4000) {
        errorMessage.innerHTML = `<div class="alert alert-${type} py-2 mb-0">${message}</div>`;
        errorMessage.classList.remove('d-none');
        errorMessage.style.opacity = '1';
        setTimeout(() => {
            errorMessage.classList.add('fade');
            errorMessage.style.opacity = '0';
            setTimeout(() => {
                errorMessage.classList.add('d-none');
                errorMessage.innerHTML = '';
                errorMessage.classList.remove('fade');
                errorMessage.style.opacity = '1';
            }, 400);
        }, duration);
    }

    function syncRemovedInput() {
        removedImagesInput.value = removedImages.join(',');
    }

    function renderPreviews() {
        imagePreviews.innerHTML = '';
        const existingToShow = existingImages.filter(img => !removedImages.includes(String(img.id)));
        const hasImages = (existingToShow.length + allFiles.length) > 0;
        if (hasImages) {
            imagePreviews.classList.remove('d-none');
            dropZone.classList.add('has-images');
            if (dropzoneContent) {
                dropzoneContent.style.opacity = '0.15';
                dropzoneContent.style.pointerEvents = 'none';
            }
        } else {
            imagePreviews.classList.add('d-none');
            dropZone.classList.remove('has-images');
            if (dropzoneContent) {
                dropzoneContent.style.opacity = '1';
                dropzoneContent.style.pointerEvents = 'auto';
            }
        }

        existingToShow.forEach(imgObj => {
            const wrapper = document.createElement('div');
            wrapper.className = 'preview-item existing';
            wrapper.dataset.id = String(imgObj.id);
            wrapper.innerHTML = `
            <img src="${imgObj.src}" alt="Existing Image">
            <button type="button" class="preview-remove" data-existing-id="${imgObj.id}" title="Remove">
                <i class="bi bi-trash-fill"></i>
            </button>
        `;
            imagePreviews.appendChild(wrapper);
        });

        allFiles.forEach(entry => {
            const wrapper = document.createElement('div');
            wrapper.className = 'preview-item new';
            wrapper.dataset.fileId = entry.id;
            const imgEl = document.createElement('img');
            imgEl.alt = 'Preview';
            wrapper.appendChild(imgEl);
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'preview-remove';
            btn.setAttribute('data-file-id', entry.id);
            btn.title = 'Remove';
            btn.innerHTML = '<i class="bi bi-trash-fill"></i>';
            wrapper.appendChild(btn);
            imagePreviews.appendChild(wrapper);
            const reader = new FileReader();
            reader.onload = e => {
                imgEl.src = e.target.result;
            };
            reader.readAsDataURL(entry.file);
        });
        syncRemovedInput();
    }

    function handleFiles(files) {
        if (!files || files.length === 0) return;
        if (uploadInProgress) {
            showError('Please wait for current upload to complete');
            return;
        }
        const validEntries = [];
        let rejectedType = 0;
        let rejectedLarge = 0;

        Array.from(files).forEach(file => {
            const mime = (file.type || '').toLowerCase();
            const ext = (file.name || '').split('.').pop().toLowerCase();
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            const allowedExts = ['jpg', 'jpeg', 'png'];
            const isValidType = allowedTypes.includes(mime) || allowedExts.includes(ext);
            if (!isValidType) {
                rejectedType++;
                return;
            }
            const isDuplicate = allFiles.some(entry => entry.file.name === file.name && entry.file.size === file.size);
            if (isDuplicate) return;
            if (file.size > 500 * 1024) {
                rejectedLarge++;
                return;
            }
            validEntries.push({ id: uid(), file });
        });

        if (rejectedType > 0)
            showError(`${rejectedType} file(s) were not added — only JPG, JPEG, and PNG allowed.`, 'warning');
        if (rejectedLarge > 0)
            showError(`${rejectedLarge} image(s) exceeded 500 KB.`, 'warning');
        if (!validEntries.length) return;
        allFiles = [...allFiles, ...validEntries];
        renderPreviews();
        simulateUploadProgress();
    }

    function simulateUploadProgress() {
        if (allFiles.length === 0) return;
        uploadInProgress = true;
        uploadProgress.classList.remove('d-none');
        progressBar.style.width = '0%';
        uploadCount.textContent = '0';
        totalCount.textContent = allFiles.length;
        let uploaded = 0;
        const total = allFiles.length;
        const interval = setInterval(() => {
            uploaded++;
            const percent = Math.min((uploaded / total) * 100, 100);
            progressBar.style.width = `${percent}%`;
            uploadCount.textContent = uploaded;
            if (uploaded >= total) {
                clearInterval(interval);
                setTimeout(() => {
                    uploadProgress.classList.add('d-none');
                    uploadInProgress = false;
                }, 600);
            }
        }, 250);
    }

    imagePreviews.addEventListener('click', function (e) {
        const btn = e.target.closest('.preview-remove');
        if (!btn) return;
        if (uploadInProgress) {
            showError('Please wait until upload finishes.', 'info');
            return;
        }
        const existingId = btn.getAttribute('data-existing-id');
        const fileId = btn.getAttribute('data-file-id');
        const previewItem = btn.closest('.preview-item');
        previewItem.classList.add('fade-out');
        setTimeout(() => {
            if (existingId) {
                if (!removedImages.includes(String(existingId)))
                    removedImages.push(String(existingId));
                renderPreviews();
                return;
            }

            if (fileId) {
                allFiles = allFiles.filter(entry => entry.id !== fileId);
                renderPreviews();
            }
        }, 160);
    });

    dropZone.addEventListener('click', e => {
        if (!e.target.closest('.preview-remove'))
            imageInput.click();
    });

    dropZone.addEventListener('dragover', e => {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('dragover');
    });

    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        if (e.dataTransfer.files)
            handleFiles(e.dataTransfer.files);
    });

    imageInput.addEventListener('change', () => {
        handleFiles(imageInput.files);
        imageInput.value = '';
    });

    productForm.on('submit', function (e) {
        syncVariantStateFromDOM();
        const submitBtn = $(this).find('button[type="submit"]');
        if (submitBtn.prop('disabled')) {
            e.preventDefault();
            return false;
        }
        const totalImages = (existingImages.length - removedImages.length) + allFiles.length;
        if (totalImages < 3) {
            e.preventDefault();
            showError('At least 3 images are required.');
            return false;
        }

        if (uploadInProgress) {
            e.preventDefault();
            showError('Please wait for upload to finish.');
            return false;
        }

        Object.entries(newVisualFiles).forEach(([valueId, files]) => {
            if (!files.length) return;
            const dt = new DataTransfer();
            files.forEach(file => {
                dt.items.add(file);
            });
            const input = document.createElement('input');
            input.type = 'file';
            input.name = `visual_images_new[${valueId}][]`;
            input.multiple = true;
            input.files = dt.files;
            productForm.append(input);
        });
        const removedInput = document.createElement('input');
        removedInput.type = 'hidden';
        removedInput.name = 'visual_images_removed';
        removedInput.value = JSON.stringify(removedVisualImages);
        productForm.append(removedInput);
        const dt = new DataTransfer();
        allFiles.forEach(entry => dt.items.add(entry.file));
        imageInput.files = dt.files;
        removedImagesInput.value = removedImages.join(',');
        submitBtn.prop('disabled', true);
        submitBtn.data('original-text', submitBtn.html());
        submitBtn.html(`<span class="spinner-border spinner-border-sm me-2"></span>Saving...`);
    });
});