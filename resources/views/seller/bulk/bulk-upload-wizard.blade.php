<div class="modal fade" id="bulkUploadWizard" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">

            <div class="modal-header py-2">
                <h6 class="modal-title fw-bold">
                    Bulk Catalog Upload
                </h6>

                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-3">

                <!-- PRODUCT DOMAINS -->
                <div class="mb-4">
                    <label class="fw-semibold small mb-2">
                        What kind of products are you uploading?
                    </label>

                    <div class="compact-grid" id="categoryGrid">
                        @foreach ($categories as $cat)
                            <label class="compact-check">
                                <input type="checkbox" value="{{ $cat->id }}">
                                <span>{{ $cat->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- PRODUCT TYPES -->
                <div class="mb-4 d-none" id="subcategorySection">

                    <label class="fw-semibold small mb-2">
                        Choose Specific Product Types
                    </label>

                    <div class="compact-grid" id="subcategoryGrid"></div>

                </div>

                <!-- FINAL CONFIG -->
                <div class="row g-3 d-none" id="finalConfig">

                    <!-- BRAND MODE -->
                    <div class="col-md-6">
                        <label class="small fw-semibold mb-1">
                            Brand Strategy
                        </label>

                        <select id="brandMode" class="form-select form-select-sm">
                            <option value="">Select Brand Strategy</option>
                            <option value="single">Single Brand Upload</option>
                            <option value="multiple">Multiple Brand Upload</option>
                        </select>
                    </div>

                    <!-- BRAND -->
                    <div class="col-md-6 d-none" id="brandWrap">
                        <label class="small fw-semibold mb-1">
                            Select Brand
                        </label>

                        <select id="brandSelect" class="form-select form-select-sm">
                            <option value="">Select Brand</option>

                            @foreach ($brands as $b)
                                <option value="{{ $b->id }}">
                                    {{ $b->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- VOLUME -->
                    <div class="col-12">
                        <label class="small fw-semibold mb-1">
                            Estimated Upload Size
                        </label>

                        <select id="uploadVolume" class="form-select form-select-sm">
                            <option value="">Select Upload Volume</option>
                            <option value="100">Under 100 Products</option>
                            <option value="500">100 – 500 Products</option>
                            <option value="2000">500 – 2000 Products</option>
                            <option value="5000">2000+ Products</option>
                        </select>
                    </div>

                </div>

            </div>

            <div class="modal-footer py-2">

                <button id="generateTemplate" class="btn btn-sm btn-primary d-none">

                    Prepare Excel Template

                </button>

            </div>

        </div>
    </div>
</div>
<style>
    .compact-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 4px;
        max-height: 180px;
        overflow-y: auto;
    }

    .compact-check {
        font-size: 12px;
        display: flex;
        gap: 4px;
        align-items: center;
    }

    .chip {
        padding: 4px 10px;
        border-radius: 15px;
        border: 1px solid #ddd;
        font-size: 12px;
        cursor: pointer;
    }

    .chip.active {
        background: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
</style>
