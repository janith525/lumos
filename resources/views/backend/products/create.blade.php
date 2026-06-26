@extends('backend.layout')

@section('admin_css')
    <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <style>
        .form-label {
            font-size: 12px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.02);
            border: 1.5px solid rgba(255, 255, 255, 0.08);
            color: #ffffff;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 15px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: var(--color-blue);
            background: rgba(255, 255, 255, 0.04);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            outline: none;
            color: #ffffff;
        }
        .form-control::placeholder {
            color: rgba(148, 163, 184, 0.35);
            opacity: 1;
        }
        .form-text {
            color: rgba(148, 163, 184, 0.45) !important;
            font-size: 12px;
        }
        .filepond--panel-root {
            background-color: rgba(255, 255, 255, 0.02);
            border: 1.5px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
        }
        .filepond--drop-label { color: #94a3b8; }

        .section-card {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
        }
        .section-card-title {
            font-size: 13px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .highlight-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .highlight-row .form-control { flex: 1; padding: 10px 16px; font-size: 14px; }
        .btn-remove-highlight {
            background: rgba(231,76,60,0.12);
            border: 1px solid rgba(231,76,60,0.25);
            color: #e74c3c;
            border-radius: 8px;
            width: 36px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        .btn-remove-highlight:hover { background: rgba(231,76,60,0.25); }
        .btn-add-highlight {
            background: rgba(59,130,246,0.08);
            border: 1px dashed rgba(59,130,246,0.3);
            color: var(--color-blue);
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 4px;
        }
        .btn-add-highlight:hover { background: rgba(59,130,246,0.15); }
        .toggle-switch { display: flex; align-items: center; gap: 12px; }
        .toggle-switch input[type="checkbox"] { width: 20px; height: 20px; accent-color: var(--color-blue); cursor: pointer; }
        .toggle-label { color: #e2e8f0; font-size: 14px; }
        .product-checkbox-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            max-height: 240px;
            overflow-y: auto;
            padding: 4px;
        }
        .product-checkbox-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 8px;
            padding: 10px 12px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .product-checkbox-item:hover { border-color: rgba(59,130,246,0.3); background: rgba(59,130,246,0.05); }
        .product-checkbox-item input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--color-blue); flex-shrink: 0; }
        .product-checkbox-item label { color: #e2e8f0; font-size: 13px; cursor: pointer; margin: 0; line-height: 1.3; }
        /* Quill dark theme overrides */
        .ql-toolbar.ql-snow {
            background: rgba(255,255,255,0.03);
            border: 1.5px solid rgba(255,255,255,0.08) !important;
            border-bottom: 1px solid rgba(255,255,255,0.06) !important;
            border-radius: 12px 12px 0 0;
        }
        .ql-container.ql-snow {
            background: rgba(255,255,255,0.02);
            border: 1.5px solid rgba(255,255,255,0.08) !important;
            border-top: none !important;
            border-radius: 0 0 12px 12px;
            font-size: 15px;
        }
        .ql-editor { color: #e2e8f0; min-height: 200px; }
        .ql-editor.ql-blank::before { color: #64748b; font-style: normal; }
        .ql-snow .ql-stroke { stroke: #94a3b8; }
        .ql-snow .ql-fill { fill: #94a3b8; }
        .ql-snow .ql-picker { color: #94a3b8; }
        .ql-snow .ql-picker-options { background: #1e2738; border-color: rgba(255,255,255,0.1); }
        .ql-snow.ql-toolbar button:hover .ql-stroke,
        .ql-snow .ql-toolbar button:hover .ql-stroke { stroke: #ffffff; }
        .ql-snow.ql-toolbar button.ql-active .ql-stroke { stroke: var(--color-blue); }
        .ql-snow.ql-toolbar button.ql-active { color: var(--color-blue); }
    </style>
@endsection

@section('admin_content')
    <div class="admin-header">
        <div>
            <h2 class="admin-title">Create Product</h2>
            <p class="admin-subtitle">Add a new product to the Lumos catalog.</p>
        </div>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf

        <div class="row g-4">
            {{-- Left Column --}}
            <div class="col-md-8">

                {{-- Basic Info --}}
                <div class="section-card">
                    <div class="section-card-title">Basic Information</div>

                    <div class="mb-3">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" id="product-name" class="form-control" value="{{ old('name') }}" required>
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug (optional)</label>
                        <input type="text" name="slug" id="product-slug" class="form-control" value="{{ old('slug') }}">
                        <div class="form-text text-muted">Leave empty to auto-generate from name.</div>
                        @error('slug') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price (e.g. LKR 125,000)</label>
                        <input type="text" name="price" class="form-control" value="{{ old('price') }}" placeholder="LKR X,XXX">
                        @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Description</label>
                        <div id="product-description-editor" style="min-height: 220px;"></div>
                        <input type="hidden" name="description" id="product-description">
                        @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Specifications --}}
                <div class="section-card">
                    <div class="section-card-title">Nursery Product Specifications</div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dimensions (e.g. 120 x 80 x 90 cm)</label>
                            <input type="text" name="dimensions" class="form-control" value="{{ old('dimensions') }}" placeholder="Dimensions">
                            @error('dimensions') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Material (e.g. Solid Beechwood & organic oils)</label>
                            <input type="text" name="material" class="form-control" value="{{ old('material') }}" placeholder="Material & finish details">
                            @error('material') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Safety Standards (e.g. EN 716-1 safety certified)</label>
                            <input type="text" name="safety_standards" class="form-control" value="{{ old('safety_standards') }}" placeholder="Certified standards">
                            @error('safety_standards') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Age Range (e.g. 0 - 3 Years)</label>
                            <input type="text" name="age_range" class="form-control" value="{{ old('age_range') }}" placeholder="Suitable age groups">
                            @error('age_range') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Lead Time (e.g. 4-6 Weeks)</label>
                        <input type="text" name="lead_time" class="form-control" value="{{ old('lead_time') }}" placeholder="Custom preparation lead time">
                        @error('lead_time') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Highlights --}}
                <div class="section-card">
                    <div class="section-card-title">Highlights (Bullet Points)</div>
                    <div id="highlights-list">
                        @if(old('highlights'))
                            @foreach(old('highlights') as $highlight)
                                <div class="highlight-row">
                                    <input type="text" name="highlights[]" class="form-control" value="{{ $highlight }}" placeholder="e.g. Solid non-toxic hardwood crib with 360 slats">
                                    <button type="button" class="btn-remove-highlight" onclick="removeHighlight(this)" title="Remove">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/></svg>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="highlight-row">
                                <input type="text" name="highlights[]" class="form-control" placeholder="e.g. Solid non-toxic hardwood crib with 360 slats">
                                <button type="button" class="btn-remove-highlight" onclick="removeHighlight(this)" title="Remove">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/></svg>
                                </button>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn-add-highlight" onclick="addHighlight()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/></svg>
                        Add Highlight
                    </button>
                </div>

                {{-- SEO / Meta --}}
                <div class="section-card">
                    <div class="section-card-title text-blue">✦ SEO &amp; Meta</div>

                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}" placeholder="Product name | Lumos Kids Room Designers">
                        @error('meta_title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3" placeholder="Short description for search engines (max 155 chars)">{{ old('meta_description') }}</textarea>
                        @error('meta_description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label">OG Image (Social Preview)</label>
                        <input type="file" class="filepond-og" name="og_image" accept="image/*">
                        <div class="form-text text-muted">Upload an image for social sharing preview. Leave blank to fallback to the product's primary image.</div>
                        @error('og_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Related Products --}}
                @if($allProducts->isNotEmpty())
                    <div class="section-card">
                        <div class="section-card-title">Related Products</div>
                        <p class="text-white-50 small mb-3">Select products to show in the "Related Products" section on this product's page.</p>
                        <div class="product-checkbox-list">
                            @foreach($allProducts as $related)
                                <label class="product-checkbox-item">
                                    <input
                                        type="checkbox"
                                        name="related_products[]"
                                        value="{{ $related->id }}"
                                        {{ in_array($related->id, old('related_products', [])) ? 'checked' : '' }}
                                    >
                                    <span>{{ $related->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right Column --}}
            <div class="col-md-4">

                {{-- Settings --}}
                <div class="section-card">
                    <div class="section-card-title">Settings</div>
                    <div class="mb-4">
                        <label class="form-label" for="status">Publication Status</label>
                        <select name="status" id="status" class="form-control" style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255, 255, 255, 0.08); color: #ffffff; border-radius: 12px; padding: 14px 18px; font-size: 15px; outline: none; transition: all 0.3s; width: 100%;">
                            <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }} style="background: #1e2738; color: #ffffff;">Published</option>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }} style="background: #1e2738; color: #ffffff;">Draft</option>
                        </select>
                        <div class="form-text text-muted mt-2">Draft products are hidden from the public website lists and detail pages.</div>
                        @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="toggle-switch">
                        <input type="hidden" name="show_on_home" value="0">
                        <input type="checkbox" name="show_on_home" id="show_on_home" value="1" {{ old('show_on_home') ? 'checked' : '' }}>
                        <label class="toggle-label" for="show_on_home">Show on Home Page</label>
                    </div>
                    <div class="form-text text-muted mt-2">When enabled, this product appears in the home page products carousel.</div>
                </div>

                {{-- Images --}}
                <div class="section-card">
                    <div class="section-card-title">Images</div>

                    <div class="mb-4">
                        <label class="form-label">Primary Image</label>
                        <input type="file" class="filepond-primary" name="image" accept="image/*">
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Gallery Images</label>
                        <input type="file" class="filepond-gallery" name="images[]" accept="image/*" multiple>
                    </div>
                </div>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary py-3 px-4" style="border-radius: 12px;">Cancel</a>
            <button type="submit" class="btn btn-blue py-3 px-4">Create Product</button>
        </div>
    </form>
@endsection

@section('admin_scripts')
    <script src="{{ asset('js/common-uploader.js') }}"></script>
    <script src="{{ asset('vendor/quill/quill.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // FilePond
            FilePond.registerPlugin(FilePondPluginImagePreview);
            const primaryElement = document.querySelector('.filepond-primary');
            if (primaryElement) { window.initCommonUploader(primaryElement); }
            const galleryElement = document.querySelector('.filepond-gallery');
            if (galleryElement) { window.initCommonUploader(galleryElement, { allowMultiple: true }); }
            const ogElement = document.querySelector('.filepond-og');
            if (ogElement) { window.initCommonUploader(ogElement); }

            // Quill rich text editor
            const quill = new Quill('#product-description-editor', {
                theme: 'snow',
                placeholder: 'Write a detailed product description...',
                modules: {
                    toolbar: [
                        [{ header: [2, 3, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['link', 'clean'],
                    ]
                }
            });

            // Pre-fill from old() if present
            const existingContent = document.getElementById('product-description').value;
            if (existingContent) {
                quill.clipboard.dangerouslyPasteHTML(existingContent);
            }

            // Sync Quill HTML to hidden input before form submit
            document.querySelector('form').addEventListener('submit', function () {
                document.getElementById('product-description').value = quill.getSemanticHTML();
            });

            // Auto-slug from name
            document.getElementById('product-name').addEventListener('input', function () {
                const slugField = document.getElementById('product-slug');
                if (!slugField.dataset.edited) {
                    slugField.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                }
            });
            document.getElementById('product-slug').addEventListener('input', function () {
                this.dataset.edited = 'true';
            });
        });

        function addHighlight() {
            const list = document.getElementById('highlights-list');
            const row = document.createElement('div');
            row.className = 'highlight-row';
            row.innerHTML = `
                <input type="text" name="highlights[]" class="form-control" placeholder="e.g. Handmade with solid wood">
                <button type="button" class="btn-remove-highlight" onclick="removeHighlight(this)" title="Remove">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/></svg>
                </button>`;
            list.appendChild(row);
            row.querySelector('input').focus();
        }

        function removeHighlight(btn) {
            const row = btn.closest('.highlight-row');
            const list = document.getElementById('highlights-list');
            if (list.querySelectorAll('.highlight-row').length > 1) {
                row.remove();
            } else {
                row.querySelector('input').value = '';
            }
        }
    </script>
@endsection
