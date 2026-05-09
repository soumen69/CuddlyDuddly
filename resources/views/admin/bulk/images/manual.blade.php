@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid py-3">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-3">

                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">

                    <div>

                        <h4 class="fw-bold mb-1">

                            Smart Product Image Upload

                        </h4>

                        <div class="small text-muted">

                            Upload high-quality catalog images for products & visual variants.

                        </div>

                    </div>

                    <div class="badge rounded-pill px-3 py-2 border bg-light text-dark">

                        Enterprise Bulk Media System

                    </div>

                </div>

                <div class="row g-3 align-items-end">

                    <div class="col-lg-6">

                        <label class="form-label small fw-semibold">

                            Product / Variant

                        </label>

                        <select id="productSelect" class="form-select form-select-sm">

                            <option value=""selected disabled>
                                Select Product
                            </option>

                            @foreach ($products as $product)
                                <option value="{{ $product['product_id'] }}"
                                    data-attr="{{ $product['attribute_value_id'] }}" data-type="{{ $product['type'] }}">

                                    {{ $product['label'] }}

                                </option>
                            @endforeach

                        </select>

                    </div>

                    <div class="guideCard mb-3">

                        <div class="guideGlow"></div>

                        <div class="d-flex align-items-start gap-3 position-relative">

                            <div class="guideIcon">

                                <i class="bi bi-stars"></i>

                            </div>

                            <div>

                                <div class="guideTitle">

                                    Image Upload Guide

                                </div>

                                <div class="guideText">

                                    • Upload minimum 4 images for better catalog quality

                                    <br>

                                    • Click any uploaded image to make it the primary/banner image

                                    <br>

                                    • The highlighted image inside the left frame becomes the product thumbnail

                                    <br>

                                    • Use clean backgrounds & consistent product angles for best results

                                    <br>

                                    • JPG, PNG & WEBP supported • Max 5MB each

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="selectionBox" id="selectionBadge">

                            <i class="bi bi-box-seam me-2"></i>

                            No Product Selected

                        </div>

                    </div>

                </div>



                <div class="uploadWrapper mt-3">

                    <div class="dropZone" id="dropZone">

                        <input type="file" id="imageInput" multiple hidden accept=".jpg,.jpeg,.png,.webp">

                        <div class="zoneLayout">

                            {{-- PRIMARY FRAME --}}
                            <div class="primaryFrame" id="primaryFrame">

                                <div class="primaryLabel">

                                    PRIMARY

                                </div>

                                <div class="primaryPlaceholder" id="primaryPlaceholder">

                                    <i class="bi bi-image"></i>

                                    <div class="small mt-2">

                                        Drop here for primary

                                    </div>

                                </div>

                                <img id="primaryPreview" class="primaryPreview d-none">

                            </div>

                            {{-- NORMAL ZONE --}}
                            <div class="normalZone">

                                <div class="zonePlaceholder">

                                    <i class="bi bi-cloud-arrow-up"></i>

                                    <div class="fw-semibold mt-2">

                                        Drop Images Here

                                    </div>

                                    <div class="small text-muted">

                                        Drag & drop or click to browse

                                    </div>

                                    <div class="small text-muted">

                                        Minimum 4 images required

                                    </div>

                                </div>

                                <div class="previewGrid" id="previewGrid"></div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="d-flex gap-2 mt-3">

                    <button class="btn btn-success btn-sm px-4" id="uploadBtn" disabled>

                        Upload Images

                    </button>

                    <button class="btn btn-outline-secondary btn-sm" id="clearBtn" disabled>

                        Clear All

                    </button>

                </div>

                <div id="uploadStatus" class="mt-3"></div>

            </div>

        </div>

    </div>
@endsection


@push('styles')
    <style>
        .guideCard {

            position: relative;

            overflow: hidden;

            border-radius: 18px;

            padding: 18px;

            background:
                linear-gradient(135deg,
                    #111827,
                    #1e293b);

            color: #fff;
        }

        .guideGlow {

            position: absolute;

            width: 220px;

            height: 220px;

            border-radius: 50%;

            background:
                rgba(99, 102, 241, .25);

            top: -80px;

            right: -80px;

            filter: blur(20px);
        }

        .guideIcon {

            width: 54px;

            height: 54px;

            border-radius: 16px;

            background:
                rgba(255, 255, 255, .12);

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 24px;

            flex-shrink: 0;
        }

        .guideTitle {

            font-size: 16px;

            font-weight: 700;

            margin-bottom: 6px;
        }

        .guideText {

            font-size: 13px;

            line-height: 1.7;

            color:
                rgba(255, 255, 255, .82);
        }

        .selectionBox {

            height: 38px;

            border-radius: 12px;

            border: 1px solid #e5e7eb;

            background: #fff;

            display: flex;

            align-items: center;

            padding: 0 14px;

            font-size: 13px;

            color: #475569;

            overflow: hidden;

            text-overflow: ellipsis;

            white-space: nowrap;
        }

        .previewItem {

            cursor: pointer;
        }

        .previewItem:hover {

            transform: translateY(-2px);

            box-shadow:
                0 8px 18px rgba(0, 0, 0, .08);
        }

        .dropZone {

            box-shadow:
                inset 0 1px 2px rgba(0, 0, 0, .03);
        }

        .dropZone {

            position: relative;

            border: 2px dashed #dbe2ea;

            border-radius: 18px;

            background: #fcfcfd;

            padding: 14px;

            min-height: 260px;

            cursor: pointer;

            transition: .2s ease;
        }

        .dropZone.dragging {

            border-color: #6366f1;

            background: #eef2ff;
        }

        .zoneLayout {

            display: grid;

            grid-template-columns: 180px 1fr;

            gap: 14px;
        }

        .primaryFrame {

            border: 2px dashed #cbd5e1;

            border-radius: 16px;

            background: #fff;

            position: relative;

            overflow: hidden;

            min-height: 220px;

            display: flex;

            align-items: center;

            justify-content: center;
        }

        .primaryLabel {

            position: absolute;

            top: 8px;

            left: 8px;

            background: #16a34a;

            color: #fff;

            font-size: 11px;

            padding: 4px 10px;

            border-radius: 20px;

            z-index: 5;
        }

        .primaryPreview {

            width: 100%;

            height: 220px;

            object-fit: cover;
        }

        .primaryPlaceholder {

            text-align: center;

            color: #94a3b8;
        }

        .primaryPlaceholder i {

            font-size: 42px;
        }

        .normalZone {

            position: relative;

            min-height: 220px;
        }

        .zonePlaceholder {

            position: absolute;

            inset: 0;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            opacity: .10;

            pointer-events: none;
        }

        .zonePlaceholder i {

            font-size: 56px;
        }

        .previewGrid {

            display: grid;

            grid-template-columns:
                repeat(auto-fill, minmax(110px, 1fr));

            gap: 10px;

            position: relative;

            z-index: 2;
        }

        .previewItem {

            position: relative;

            border-radius: 14px;

            overflow: hidden;

            border: 2px solid transparent;

            background: #fff;

            transition: .2s ease;
        }

        .previewItem.active {

            border-color: #16a34a;
        }

        .previewItem img {

            width: 100%;

            height: 110px;

            object-fit: cover;

            display: block;
        }

        .removeBtn {

            position: absolute;

            top: 6px;

            right: 6px;

            width: 26px;

            height: 26px;

            border: none;

            border-radius: 50%;

            background: rgba(0, 0, 0, .7);

            color: #fff;

            z-index: 5;
        }

        .primaryMini {

            position: absolute;

            left: 6px;

            bottom: 6px;

            background: #16a34a;

            color: #fff;

            font-size: 10px;

            padding: 2px 8px;

            border-radius: 20px;
        }

        @media(max-width:991px) {

            .zoneLayout {

                grid-template-columns: 1fr;
            }

            .primaryFrame {

                height: 220px;
            }
        }
    </style>
@endpush


@push('scripts')
    <script>
        $(function() {

            let files = [];

            let primaryIndex = 0;

            let selectedProduct = null;

            let selectedAttr = null;

            const input =
                $('#imageInput')[0];

            $('#productSelect').change(function() {

                let option =
                    $(this).find(':selected');

                selectedProduct =
                    option.val();

                selectedAttr =
                    option.data('attr');

                let type =
                    option.data('type');

                if (!selectedProduct) {

                    $('#selectionBadge').html(
                        'No Selection'
                    );

                    $('#uploadBtn,#clearBtn')
                        .prop('disabled', true);

                    return;
                }

                $('#selectionBadge').html(`

                    <i class="bi bi-check-circle-fill text-success me-2"></i>

                    ${option.text()}
                `);
                $('#uploadBtn,#clearBtn')
                    .prop('disabled', false);

                files = [];

                primaryIndex = 0;

                render();
            });

            $('#dropZone').on(
                'click',
                function(e) {

                    if (
                        $(e.target).closest(
                            '.removeBtn,.previewItem'
                        ).length
                    ) {
                        return;
                    }

                    if (!selectedProduct) {
                        return;
                    }

                    input.click();
                }
            );

            $('#dropZone').on(
                'dragover',
                function(e) {

                    e.preventDefault();

                    $(this).addClass('dragging');
                }
            );

            $('#dropZone').on(
                'dragleave',
                function() {

                    $(this).removeClass('dragging');
                }
            );

            $('#dropZone').on(
                'drop',
                function(e) {

                    e.preventDefault();

                    $(this).removeClass('dragging');

                    if (!selectedProduct) {
                        return;
                    }

                    appendFiles(
                        Array.from(
                            e.originalEvent.dataTransfer.files
                        )
                    );
                }
            );

            $('#imageInput').change(function() {

                appendFiles(
                    Array.from(this.files)
                );
            });

            function appendFiles(newFiles) {

                newFiles.forEach(file => {

                    files.push(file);
                });

                render();
            }

            function render() {

                const grid =
                    $('#previewGrid');

                grid.html('');

                if (files.length) {

                    $('#primaryPreview')

                        .attr(
                            'src',
                            URL.createObjectURL(
                                files[primaryIndex]
                            )
                        )

                        .removeClass('d-none');

                    $('#primaryPlaceholder')
                        .addClass('d-none');

                } else {

                    $('#primaryPreview')
                        .addClass('d-none');

                    $('#primaryPlaceholder')
                        .removeClass('d-none');
                }

                files.forEach((file, index) => {

                    grid.append(`

                <div
                    class="previewItem ${index===primaryIndex ? 'active' : ''}"
                    data-index="${index}"
                >

                    <button
                        type="button"
                        class="removeBtn"
                        data-index="${index}"
                    >

                        <i class="bi bi-x-lg"></i>

                    </button>

                    <img
                        src="${URL.createObjectURL(file)}"
                    >

                    ${
                        index===primaryIndex
                        ? `
                                                            <div class="primaryMini">
                                                                Primary
                                                            </div>
                                                        `
                        : ''
                    }

                </div>
            `);
                });
            }

            $(document).on(
                'click',
                '.removeBtn',
                function(e) {

                    e.stopPropagation();

                    const index =
                        $(this).data('index');

                    files.splice(index, 1);

                    if (primaryIndex >= files.length) {

                        primaryIndex = 0;
                    }

                    render();
                }
            );

            $(document).on(
                'click',
                '.previewItem',
                function(e) {

                    if (
                        $(e.target).closest(
                            '.removeBtn'
                        ).length
                    ) {
                        return;
                    }

                    primaryIndex =
                        $(this).data('index');

                    render();
                }
            );

            $('#clearBtn').click(function() {

                files = [];

                primaryIndex = 0;

                render();
            });


            $('#uploadBtn').click(function() {

                if (!selectedProduct) {

                    showStatus(
                        'Select a product first.',
                        'danger'
                    );

                    return;
                }

                if (files.length < 4) {

                    showStatus(
                        'Minimum 4 images required.',
                        'danger'
                    );

                    return;
                }

                let btn =
                    $(this);

                let formData =
                    new FormData();

                formData.append(
                    'product_id',
                    selectedProduct
                );

                if (selectedAttr) {

                    formData.append(
                        'attribute_value_id',
                        selectedAttr
                    );
                }

                files.forEach(function(file) {

                    formData.append(
                        'images[]',
                        file
                    );
                });

                btn.prop(
                    'disabled',
                    true
                );

                btn.html(`

        <span class="spinner-border spinner-border-sm me-2"></span>

        Uploading...
    `);

                $.ajax({

                    url: '{{ route('admin.bulk.images.ajax.upload') }}',

                    method: 'POST',

                    data: formData,

                    processData: false,

                    contentType: false,

                    headers: {

                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                    success: function(response) {

                        showStatus(
                            response.message ??
                            'Images uploaded successfully.',
                            'success'
                        );

                        $('#productSelect option:selected')
                            .remove();

                        $('#productSelect')
                            .prop(
                                'selectedIndex',
                                0
                            );

                        $('#selectionBadge').html(`

                <i class="bi bi-box-seam me-2"></i>

                No Product Selected
            `);

                        files = [];

                        primaryIndex = 0;

                        selectedProduct = null;

                        selectedAttr = null;

                        render();

                        $('#uploadBtn,#clearBtn')
                            .prop(
                                'disabled',
                                true
                            );

                        btn.html(
                            'Upload Images'
                        );
                    },

                    error: function(xhr) {

                        let message =
                            'Upload failed.';

                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message =
                                xhr.responseJSON.message;
                        }

                        showStatus(
                            message,
                            'danger'
                        );

                        btn.prop(
                            'disabled',
                            false
                        );

                        btn.html(
                            'Upload Images'
                        );
                    }
                });
            });

            function showStatus(
                message,
                type = 'success'
            ) {

                $('#uploadStatus').html(`

        <div class="alert alert-${type} border-0 shadow-sm rounded-4 py-2 px-3 mb-0">

            ${message}

        </div>
    `);
            }

        });
    </script>
@endpush
