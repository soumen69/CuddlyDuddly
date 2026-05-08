@extends('admin.layouts.admin')

@section('title', 'Home Page')

@section('content')
    <div class="container-fluid home-canvas">

        {{-- Header --}}
        <div class="page-header">
            <h1>Home Page Sections</h1>
            <p>Arrange and control how sections appear on your website’s home page.</p>
        </div>

        {{-- Canvas --}}
        <div id="homeSectionList" class="section-canvas">

            @foreach ($sections as $index => $section)
                <div class="section-block {{ !$section->is_active ? 'is-disabled' : '' }}" data-id="{{ $section->id }}">

                    {{-- Drag --}}
                    <div class="order-rail">
                        <span class="order-number">{{ $index + 1 }}</span>
                        <span class="drag-handle">
                            <i class="bi bi-grip-vertical"></i>
                        </span>
                    </div>

                    {{-- Content --}}
                    <div class="section-main">

                        {{-- Meta --}}
                        <div class="section-meta-bar">
                            <div>
                                <div class="section-name">
                                    {{ ucwords(str_replace('_', ' ', $section->key)) }}
                                </div>
                                <div class="section-desc">
                                    key: {{ $section->key }} •
                                    {{ is_array($section->data) ? count($section->data) : 'Configured' }} items
                                </div>
                            </div>

                            <div class="section-controls">
                                <span class="status-pill {{ $section->is_active ? 'live' : 'off' }}">
                                    {{ $section->is_active ? 'Live' : 'Hidden' }}
                                </span>

                                <a href="{{ route('admin.website.home.edit', $section) }}" class="btn-action primary">
                                    Edit
                                </a>

                                <button class="btn-action ghost toggle-status" data-id="{{ $section->id }}">
                                    {{ $section->is_active ? 'Hide' : 'Show' }}
                                </button>
                            </div>
                        </div>

                        {{-- Preview --}}
                        @php
                            $previewView = 'website.home.sections.' . $section->key;
                        @endphp

                        @if (view()->exists($previewView))
                            <div class="section-preview-viewport">
                                <iframe src="{{ route('admin.website.home.preview', $section) }}"
                                    class="section-preview-iframe" loading="lazy">
                                </iframe>
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection


@push('styles')
    <style>
        .section-preview-iframe {
            width: 100%;
            height: 360px;
            border: none;
            border-radius: 12px;
            background: #ffffff;
        }


        /* CANVAS */
        .home-canvas {
            background: #f4f6f8;
            min-height: 100vh;
            padding-bottom: 40px;
        }

        /* HEADER */
        .page-header {
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-size: 1.7rem;
            font-weight: 600;
        }

        .page-header p {
            color: #6b7280;
            font-size: 0.9rem;
        }

        /* SECTION STACK */
        .section-canvas {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* SECTION BLOCK */
        .section-block {
            display: grid;
            grid-template-columns: 64px 1fr;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        }

        .section-block.is-disabled {
            opacity: 0.55;
        }

        /* ORDER RAIL */
        .order-rail {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 18px;
            gap: 10px;
        }

        .order-number {
            font-size: 0.75rem;
            color: #9ca3af;
        }

        .drag-handle {
            cursor: grab;
            font-size: 1.6rem;
            color: #9ca3af;
        }

        /* MAIN */
        .section-main {
            padding: 16px 18px 20px;
        }

        /* META BAR */
        .section-meta-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .section-name {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .section-desc {
            font-size: 0.75rem;
            color: #6b7280;
        }

        /* CONTROLS */
        .section-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* STATUS */
        .status-pill {
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .status-pill.live {
            background: #e7f7ee;
            color: #137333;
        }

        .status-pill.off {
            background: #f1f3f5;
            color: #6b7280;
        }

        /* BUTTONS */
        .btn-action {
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 0.75rem;
            border: none;
        }

        .btn-action.primary {
            background: #2563eb;
            color: #fff;
        }

        .btn-action.ghost {
            background: transparent;
            border: 1px solid #d1d5db;
        }

        /* PREVIEW VIEWPORT */
        .section-preview-viewport {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            padding: 16px;
        }

        /* SCALE WRAPPER */
        .section-preview-scale {
            transform: scale(0.8);
            /* 👈 global shrink */
            transform-origin: top left;
            width: 125%;
            /* 👈 compensate scale */
        }

        /* REAL CONTENT */
        .section-preview-inner {
            pointer-events: none;
        }

        /* Optional: soften background overflow */
        .section-preview-inner>* {
            max-width: 100%;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.toggle-status').forEach(btn => {
                btn.addEventListener('click', function() {
                    fetch(`{{ url('admin/website/home') }}/${this.dataset.id}/toggle`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    }).then(() => location.reload());
                });
            });

            new Sortable(document.getElementById('homeSectionList'), {
                handle: '.drag-handle',
                animation: 200,
                onEnd() {
                    const positions = [];
                    document.querySelectorAll('.section-block').forEach(el => {
                        positions.push(el.dataset.id);
                    });

                    fetch(`{{ route('admin.website.home.reorder') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            positions
                        })
                    });
                }
            });

        });
    </script>
@endpush
