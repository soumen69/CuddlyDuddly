@extends('admin.layouts.admin')

@section('title', 'Product Details')

@push('styles')
    <style>
        .pdp-wrap {
            max-width: 1300px;
            margin: auto;
        }

        .pdp-left {
            max-width: 520px;
        }

        .pdp-card {
            border: 1px solid #eceef2;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 10px;
            background: #fff;
        }

        .pdp-title {
            font-size: 15px;
            font-weight: 700;
        }

        .pdp-meta {
            font-size: 12px;
            color: #777;
        }

        .price {
            font-size: 15px;
            font-weight: 700;
        }

        .stock {
            font-size: 11px;
            color: #666;
        }

        .preview-wrap {
            background: #f5f6f9;
            border-radius: 12px;
            padding: 12px;
            position: sticky;
            top: 18px;
        }

        .preview-box {
            height: 520px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .media-strip {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 8px;
        }

        .media-strip img {
            width: 54px;
            height: 54px;
            border-radius: 8px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .media-strip img:hover {
            border-color: #111;
        }

        .attr-title {
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #555;
        }

        .attr-row {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .visual-pill {
            padding: 4px 12px;
            font-size: 11px;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
        }

        .spec-pill {
            padding: 4px 10px;
            font-size: 11px;
            border-radius: 20px;
            background: #f1f2f6;
        }

        .spec-disabled {
            opacity: .35;
        }
    </style>
@endpush

@section('content')

    @php
        $hasVariants = $product->active_variants_count > 0;
        $hasGallery = $baseImages->count() > 0;
    @endphp

    <div class="container-fluid pdp-wrap">
        <div class="row g-3">

            {{-- LEFT --}}
            <div class="col-lg-5 pdp-left">

                <div class="pdp-card">
                    <div class="pdp-title">{{ $product->name }}</div>
                    <div class="pdp-meta">Seller: {{ $product->seller->name ?? '—' }}</div>

                    <div class="d-flex justify-content-between mt-2">
                        <div class="price">
                            @if ($hasVariants)
                                @if ($product->min_variant_price == $product->max_variant_price)
                                    ₹{{ number_format($product->min_variant_price, 2) }}
                                @else
                                    ₹{{ number_format($product->min_variant_price, 2) }}
                                    →
                                    ₹{{ number_format($product->max_variant_price, 2) }}
                                @endif
                            @else
                                ₹{{ number_format($product->price, 2) }}
                            @endif
                        </div>

                        <div class="stock">
                            Stock:
                            <span id="variantStock">
                                {{ $initialStock }}
                            </span>
                        </div>
                    </div>

                </div>

                @if ($hasVariants)
                    <div class="pdp-card">

                        @foreach ($attributeGroups as $attrId => $group)
                            <div class="mb-2">
                                <div class="attr-title">{{ $group['name'] }}</div>

                                <div class="attr-row">
                                    @foreach ($group['values'] as $id => $label)
                                        @if ($group['is_visual'])
                                            <button class="btn btn-dark visual-pill" data-attr="{{ $attrId }}"
                                                data-id="{{ $id }}">
                                                {{ $label }}
                                            </button>
                                        @else
                                            <span class="spec-pill" data-attr="{{ $attrId }}"
                                                data-id="{{ $id }}">
                                                {{ $label }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>

                            </div>
                        @endforeach

                    </div>
                @endif

                @if ($hasVariants || $hasGallery)
                    <div class="pdp-card">

                        @if ($hasVariants)
                            <div class="attr-title">Variant Media</div>
                            <div id="variantStrip" class="media-strip"></div>
                        @endif

                        @if ($hasGallery)
                            <div class="attr-title mt-2">Product Gallery</div>
                            <div class="media-strip">
                                @foreach ($baseImages as $img)
                                    <img src="{{ Storage::url($img) }}" onclick="switchMain(this)">
                                @endforeach
                            </div>
                        @endif

                    </div>
                @endif
                @if ($hasVariants)
                    <div class="pdp-card">

                        <div class="attr-title mb-2 d-flex justify-content-between">
                            <span>Variants</span>
                            <span class="badge bg-info">
                                {{ $product->active_variants_count }}
                            </span>
                        </div>

                        <div style="max-height: 240px; overflow:auto;">
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
            </div>

            {{-- RIGHT --}}
            <div class="col-lg-7">

                <div class="preview-wrap">
                    <div class="preview-box">
                        <img id="mainImage" src="{{ $hasGallery ? Storage::url($baseImages[0]) : '' }}">
                    </div>
                </div>

            </div>

        </div>
    </div>
    @push('scripts')

        <script>
            function switchMain(el) {
                const main = document.getElementById('mainImage');
                if (main) main.src = el.src;
            }
        </script>

        @if ($hasVariants)
            <script>
                const VARIANT_INDEX = @json($variantPayload);
                const VISUAL_INDEX = @json($visualPayload);
                const VALUE_TO_VARIANTS = @json($valueToVariants);
                const VARIANT_GRAPH = @json($variantGraph);

                let selectedVisual = {};

                const mainImage = document.getElementById('mainImage');
                const strip = document.getElementById('variantStrip');

                document.querySelectorAll('.visual-pill').forEach(btn => {
                    btn.onclick = function() {

                        const attr = this.dataset.attr;
                        const val = Number(this.dataset.id);

                        selectedVisual[attr] = val;

                        document.querySelectorAll(`[data-attr="${attr}"]`)
                            .forEach(b => b.classList.remove('active'));

                        this.classList.add('active');

                        applyConstraints();
                        switchMedia(val);
                    };
                });

                function switchMedia(val) {

                    const images = VISUAL_INDEX[val] || [];

                    strip.innerHTML = '';

                    images.forEach((img, i) => {
                        const url = "/storage/" + img;
                        const el = document.createElement('img');
                        el.src = url;
                        el.onclick = () => mainImage.src = url;
                        strip.appendChild(el);
                        if (i === 0) mainImage.src = url;
                    });
                }

                function applyConstraints() {

                    let valid = null;

                    Object.values(selectedVisual).forEach(val => {
                        const variants = VALUE_TO_VARIANTS[val] || [];

                        if (valid === null) valid = new Set(variants);
                        else valid = new Set(variants.filter(v => valid.has(v)));
                    });

                    if (!valid) return;

                    const allowed = new Set();

                    valid.forEach(v => {
                        VARIANT_GRAPH[v].forEach(val => allowed.add(val));
                    });

                    document.querySelectorAll('.spec-pill').forEach(el => {
                        const id = Number(el.dataset.id);

                        if (allowed.has(id)) {
                            el.classList.remove('spec-disabled');
                        } else {
                            el.classList.add('spec-disabled');
                        }
                    });
                }
            </script>
        @endif
    @endpush

@endsection
