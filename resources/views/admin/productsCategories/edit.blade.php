@extends('admin.layouts.admin')

@section('title', 'Edit Product Category')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/report-sales-revenue.css') }}">
        <style>
            .attribute-card {
                cursor: pointer;
                transition: all .15s ease;
            }

            .attribute-card:hover {
                background: #f8fafc;
                border-color: #d1d5db;
            }

            .attribute-hint {
                position: absolute;
                bottom: 6px;
                right: 10px;
                font-size: 11px;
                opacity: 0;
                pointer-events: none;
            }

            .attribute-card:hover .attribute-hint {
                opacity: .7;
            }
        </style>
    @endpush

    <div class="settings-right-inner">

        {{-- Header --}}
        <div class="settings-section card mb-2">
            <div class="card-body py-2">
                <h3 class="settings-section-title mb-0">
                    <i class="bi bi-diagram-3 me-2"></i> Edit Product Category
                    <div class="settings-section-subtitle">
                        Modify product structure and attribute blueprint.
                    </div>
                </h3>
            </div>
        </div>
        <form action="{{ route('admin.product-categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                {{-- LEFT SIDE --}}
                <div class="col-lg-4">

                    <div class="card shadow-sm border-0">
                        <div class="card-body">

                            <h6 class="mb-3">Category Details</h6>

                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" name="category_name" class="form-control form-control-sm"
                                    value="{{ $category->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select form-select-sm">
                                    <option value="1" {{ $category->status ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$category->status ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <hr>

                            {{-- SUB CATEGORY BUILDER --}}
                            <h6 class="mb-2">Sub Categories</h6>

                            <div class="input-group input-group-sm mb-2">
                                <input type="text" id="subCategoryInput" class="form-control"
                                    placeholder="Enter sub category">

                                <button type="button" class="btn btn-outline-primary" onclick="addSubCategory()">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>

                            <div id="subCategoryList" class="d-flex flex-wrap gap-2"></div>

                        </div>
                    </div>

                </div>


                {{-- RIGHT SIDE --}}
                <div class="col-lg-8">

                    <div class="card shadow-sm border-0">
                        <div class="card-body py-2">

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Attributes</h6>
                            </div>

                            {{-- ATTRIBUTE BUILDER --}}
                            <div class="border rounded p-2 bg-light mb-3">

                                <div class="row g-2">

                                    <div class="col-md-4">
                                        <input type="text" id="attrName" class="form-control form-control-sm"
                                            placeholder="Attribute Name">
                                    </div>

                                    <div class="col-md-3">
                                        <select id="attrType" class="form-select form-select-sm">
                                            <option value="select">Select</option>
                                            <option value="multi-select">Multi Select</option>
                                            <option value="boolean">Yes / No</option>
                                        </select>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-check mt-1">
                                            <input type="checkbox" id="attrFilter" class="form-check-input">
                                            <label class="form-check-label small">
                                                Filter
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-check mt-1">
                                            <input type="checkbox" id="attrVariant" class="form-check-input">
                                            <label class="form-check-label small">
                                                Variant
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-check mt-1">
                                            <input type="checkbox" id="attrVisual" class="form-check-input">
                                            <label class="form-check-label small">
                                                Visual
                                            </label>
                                        </div>
                                    </div>

                                </div>

                                {{-- VALUE BUILDER --}}
                                <div class="mt-2">

                                    <div class="input-group input-group-sm mb-2">
                                        <input type="text" id="valueInput" class="form-control"
                                            placeholder="Enter value">

                                        <button type="button" class="btn btn-outline-secondary" onclick="addValueChip()">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>

                                    <div id="valueList" class="d-flex flex-wrap gap-2"></div>

                                </div>

                                <div class="text-end mt-2">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="finalizeAttribute()">

                                        <i class="bi bi-check-circle me-1"></i>
                                        Add Attribute

                                    </button>
                                </div>

                            </div>

                            {{-- FINAL ATTRIBUTE LIST --}}
                            <div id="attributeList"></div>

                        </div>
                    </div>

                </div>

            </div>


            {{-- Submit --}}
            <div class="text-end mt-3">

                <a href="{{ route('admin.product-categories.index') }}" class="btn btn-secondary">
                    Cancel
                </a>

                <button type="submit" class="btn btn-success px-4">

                    Update Product Category

                </button>

            </div>

        </form>
    </div>

    @push('scripts')
        <script>
            const subCategoryInput = document.getElementById('subCategoryInput');
            const subCategoryList = document.getElementById('subCategoryList');

            const attrName = document.getElementById('attrName');
            const attrType = document.getElementById('attrType');
            const attrFilter = document.getElementById('attrFilter');
            const attrVariant = document.getElementById('attrVariant');
            const attrVisual = document.getElementById('attrVisual');

            const valueInput = document.getElementById('valueInput');
            const valueList = document.getElementById('valueList');

            const attributeList = document.getElementById('attributeList');

            let subCategories = @json($category->subCategories->pluck('name'));
            let attributes = @json($attributesData);

            let currentValues = [];
            let attributeUID = attributes.length;

            let dragIndex = null;


            document.addEventListener("DOMContentLoaded", () => {

                renderSubCategories();
                renderAttributes();

            });


            /* --------------------------------
               SUB CATEGORIES
            -------------------------------- */

            function addSubCategory() {
                const value = subCategoryInput.value.trim();
                if (!value) return;
                if (subCategories.includes(value)) return;
                subCategories.push(value);
                subCategoryInput.value = '';
                renderSubCategories();
            }

            function removeSubCategory(index) {
                subCategories.splice(index, 1);
                renderSubCategories();
            }

            function renderSubCategories() {
                subCategoryList.innerHTML = '';
                const frag = document.createDocumentFragment();
                subCategories.forEach((sub, index) => {
                    const span = document.createElement('span');
                    span.className = "badge bg-light border text-dark px-3 py-2";
                    span.innerHTML = `
                    ${sub}
                    <i class="bi bi-x ms-2 text-danger remove-sub" data-index="${index}" style="cursor:pointer"></i>
                    <input type="hidden" name="sub_categories[]" value="${sub}">`;
                    frag.appendChild(span);
                });
                subCategoryList.appendChild(frag);
            }


            /* --------------------------------
               VALUE CHIPS
            -------------------------------- */

            function addValueChip() {
                const value = valueInput.value.trim();
                if (!value) return;
                if (currentValues.includes(value)) return;
                currentValues.push(value);
                valueInput.value = '';
                renderValueChips();
            }

            function removeValue(index) {
                currentValues.splice(index, 1);
                renderValueChips();
            }

            function renderValueChips() {
                valueList.innerHTML = '';
                const frag = document.createDocumentFragment();
                currentValues.forEach((val, index) => {
                    const span = document.createElement('span');
                    span.className = "badge bg-secondary px-3 py-2";
                    span.innerHTML =
                        `${val}
                     <i class="bi bi-x ms-2 text-light remove-value" data-index="${index}" style="cursor:pointer"></i>`;
                    frag.appendChild(span);
                });
                valueList.appendChild(frag);

            }


            /* --------------------------------
               ATTRIBUTE BUILDER
            -------------------------------- */

            function finalizeAttribute() {
                const name = attrName.value.trim();
                const type = attrType.value;
                const filter = attrFilter.checked;
                const variant = attrVariant.checked;
                const visual = attrVisual.checked;
                if (!name) return;
                if ((type === 'select' || type === 'multi-select') && currentValues.length === 0) return;
                attributes.push({
                    uid: attributeUID++,
                    name,
                    type,
                    filter,
                    variant,
                    visual,
                    values: [...currentValues]
                });
                resetBuilder();
                renderAttributes();
            }

            function resetBuilder() {
                attrName.value = '';
                attrType.value = 'select';
                attrFilter.checked = false;
                attrVariant.checked = false;
                attrVisual.checked = false;
                currentValues = [];
                renderValueChips();
            }


            /* --------------------------------
               ATTRIBUTE EDIT
            -------------------------------- */

            function editAttribute(uid) {
                const attr = attributes.find(a => a.uid === uid);
                if (!attr) return;
                attrName.value = attr.name;
                attrType.value = attr.type;
                attrFilter.checked = attr.filter;
                attrVariant.checked = attr.variant;
                attrVisual.checked = attr.visual;
                currentValues = [...attr.values];
                renderValueChips();
                attributes = attributes.filter(a => a.uid !== uid);
                renderAttributes();
            }

            function removeAttribute(uid) {
                attributes = attributes.filter(a => a.uid !== uid);
                renderAttributes();
            }


            /* --------------------------------
               ATTRIBUTE RENDER
            -------------------------------- */

            function renderAttributes() {
                attributeList.innerHTML = '';
                const frag = document.createDocumentFragment();
                attributes.forEach((attr, index) => {
                    const valuesHTML = attr.values.map(v =>
                        `<span class="badge bg-light border text-dark me-1">${v}</span>`
                    ).join('');
                    const div = document.createElement('div');
                    div.className = "border rounded p-2 mb-2 bg-white shadow-sm attribute-card position-relative";
                    div.style.cursor = "grab";
                    div.draggable = true;
                    div.dataset.uid = attr.uid;
                    div.dataset.index = index;
                    div.innerHTML = `
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>${attr.name}</strong>
                                <small class="text-muted ms-2">(${attr.type})</small>
                                ${attr.filter ? '<span class="badge bg-info ms-2">Filter</span>' : ''}
                                ${attr.variant ? '<span class="badge bg-warning ms-1">Variant</span>' : ''}
                                ${attr.visual ? '<span class="badge bg-primary ms-1">Visual</span>' : ''}
                                <div class="mt-1">${valuesHTML}</div>
                            </div>
                            <i class="bi bi-x text-danger remove-attr" data-uid="${attr.uid}" style="cursor:pointer"></i>
                        </div>
                        ${generateHiddenInputs(attr,index)}
                        <small class="attribute-hint text-muted">
                            click to edit
                        </small>`;
                    frag.appendChild(div);
                });
                attributeList.appendChild(frag);
            }

            attributeList.addEventListener('dragstart', e => {
                const card = e.target.closest('.attribute-card');
                if (!card) return;
                dragIndex = Number(card.dataset.index);
            });

            attributeList.addEventListener('dragover', e => {
                e.preventDefault();
            });

            attributeList.addEventListener('drop', e => {
                const card = e.target.closest('.attribute-card');
                if (!card) return;
                const dropIndex = Number(card.dataset.index);
                const dragged = attributes.splice(dragIndex, 1)[0];
                attributes.splice(dropIndex, 0, dragged);
                renderAttributes();
            });


            /* --------------------------------
               GLOBAL EVENT DELEGATION
            -------------------------------- */

            document.addEventListener('click', e => {
                if (e.target.classList.contains('remove-sub')) {
                    removeSubCategory(Number(e.target.dataset.index));
                }

                if (e.target.classList.contains('remove-value')) {
                    removeValue(Number(e.target.dataset.index));
                }

                if (e.target.classList.contains('remove-attr')) {
                    e.stopPropagation();
                    removeAttribute(Number(e.target.dataset.uid));
                    return;
                }

                const card = e.target.closest('.attribute-card');

                if (card) {
                    editAttribute(Number(card.dataset.uid));
                }

            });

            valueInput.addEventListener('keypress', e => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addValueChip();
                }

            });

            function generateHiddenInputs(attr, index) {
                let inputs = `
                    <input type="hidden" name="attributes[${index}][name]" value="${attr.name}">
                    <input type="hidden" name="attributes[${index}][input_type]" value="${attr.type}">
                    <input type="hidden" name="attributes[${index}][is_filterable]" value="${attr.filter ? 1 : 0}">
                    <input type="hidden" name="attributes[${index}][is_variant]" value="${attr.variant ? 1 : 0}">
                    <input type="hidden" name="attributes[${index}][is_visual]" value="${attr.visual ? 1 : 0}">`;
                attr.values.forEach(v => {
                    inputs += `<input type="hidden" name="attributes[${index}][values][]" value="${v}">`;
                });
                return inputs;
            }
        </script>
    @endpush

@endsection
