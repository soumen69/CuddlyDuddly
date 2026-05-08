<div class="container-fluid product-card-intel">

    <div class="row g-3">

        {{-- IMAGE GALLERY --}}
        <div class="col-lg-5">

            @php
                // Decide source dynamically
                $images = $product->has_visual_variants ? $product->visualImages : $product->images;

                // Pick primary
                $primary = $images->firstWhere('is_primary', 1) ?? $images->first();
            @endphp

            <div class="pc-main-image-wrapper mb-2">
                @if ($primary)
                    <img id="pcMainImage" src="{{ Storage::url($primary->image_path) }}" class="img-fluid rounded">
                @else
                    <div class="text-muted small text-center py-5">No images</div>
                @endif
            </div>

            <div class="pc-thumb-row d-flex gap-2 flex-wrap">
                @foreach ($images as $img)
                    <img src="{{ Storage::url($img->image_path) }}" class="pc-thumb" onclick="pcSwitchImage(this)">
                @endforeach
            </div>

        </div>

        {{-- PRODUCT INTEL --}}
        <div class="col-lg-7">

            <div class="d-flex justify-content-between align-items-start mb-1">

                <div class="me-2">

                    <h5 class="mb-0 d-inline">

                        {{ $product->name }}

                        <a target="__blank" href="/admin/products/{{ $product->id }}"
                            class="pc-open-full ms-1 align-baseline" title="Open full product page">
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>

                    </h5>

                </div>

                <div class="d-flex gap-1 flex-shrink-0">
                    @if ($product->featured)
                        <span class="badge bg-warning text-dark">Featured</span>
                    @endif

                    @if ($product->is_approved)
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-danger">Pending</span>
                    @endif
                </div>
            </div>

            <p class="text-muted small mb-2">
                {{ $product->description ?: 'No description provided.' }}
            </p>

            {{-- PRICE + STOCK ROW --}}
            <div class="row mb-2">

                <div class="col-md-6">
                    <div class="pc-stat-box">
                        <small class="text-muted">Price</small>
                        <div class="fw-semibold fs-5">

                            @if ($product->active_variants_count > 0)
                                ₹{{ number_format($product->min_variant_price, 2) }}
                                @if ($product->min_variant_price != $product->max_variant_price)
                                    → ₹{{ number_format($product->max_variant_price, 2) }}
                                @endif
                            @else
                                ₹{{ number_format($product->price, 2) }}
                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    @php
                        $stock = $product->active_variants_count ? $product->total_variant_stock : $product->stock;
                    @endphp

                    <div class="pc-stat-box">
                        <small class="text-muted">Stock</small>
                        <div class="fw-semibold fs-5">
                            <span
                                class="badge {{ $stock > 10 ? 'bg-success' : ($stock > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ $stock }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- VARIANT TABLE --}}
            @if ($product->active_variants_count > 0)

                <div class="pc-variant-box">

                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <strong class="small">Variants</strong>
                        <span class="badge bg-info">
                            {{ $product->active_variants_count }}
                        </span>
                    </div>

                    <div class="pc-variant-table-wrapper">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Attributes</th>
                                    <th>SKU</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($product->variants as $v)
                                    <tr>
                                        <td>
                                            @foreach ($v->values as $val)
                                                <span class="badge bg-secondary me-1">
                                                    {{ $val->attribute->name }}:
                                                    {{ $val->value }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="small">{{ $v->sku }}</td>
                                        <td>₹{{ number_format($v->price, 2) }}</td>
                                        <td>
                                            <span class="badge {{ $v->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $v->stock }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>

            @endif

            {{-- SELLER --}}
            <div class="mt-2 small text-muted">
                Seller: {{ $product->seller->name ?? '—' }}
            </div>

            {{-- ACTIONS --}}
            <div class="d-flex justify-content-end gap-2 mt-3">

                @canAccess('admin.products.approve')
                <button class="btn btn-success btn-sm btn-approve" data-id="{{ $product->id }}">
                    <i class="bi bi-check2-circle"></i>
                </button>
                @endcanAccess

                @canAccess('admin.products.feature')
                <button class="btn btn-warning btn-sm btn-feature" data-id="{{ $product->id }}">
                    <i class="bi bi-star"></i>
                </button>
                @endcanAccess

                @canAccess('admin.products.edit')
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-info btn-sm">
                    <i class="bi bi-pencil"></i>
                </a>
                @endcanAccess

                @canAccess('admin.products.delete')
                <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $product->id }}">
                    <i class="bi bi-trash"></i>
                </button>
                @endcanAccess

            </div>

        </div>

    </div>

</div>
