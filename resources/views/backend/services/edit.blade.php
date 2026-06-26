@extends('backend.layout')

@section('admin_css')
    <link href="https://cdn.jsdelivr.net/npm/filepond@4.30.6/dist/filepond.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/filepond-plugin-image-preview@4.6.11/dist/filepond-plugin-image-preview.min.css" rel="stylesheet">
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
        .filepond--drop-label {
            color: #94a3b8;
        }
    </style>
@endsection

@section('admin_content')
    <div class="admin-header">
        <div>
            <h2 class="admin-title">Edit Service: {{ $service->name }}</h2>
            <p class="admin-subtitle">Modify service parameters, testimonials, and crib associations.</p>
        </div>
    </div>

    <form action="{{ route('admin.services.update', $service->slug) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Left Panel -->
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label">Service Name *</label>
                    <input type="text" name="name" id="service-name" class="form-control" value="{{ old('name', $service->name) }}" required>
                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" id="service-slug" class="form-control" value="{{ old('slug', $service->slug) }}">
                    <div class="form-text text-muted">Leave empty to auto-generate from name.</div>
                    @error('slug') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Category *</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category', $service->category) }}" required>
                    @error('category') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Subtitle (Tagline)</label>
                    <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $service->subtitle) }}">
                    @error('subtitle') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $service->description) }}</textarea>
                    @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                {{-- Specifications & Timeline --}}
                <div class="card border-0 p-4 mb-3" style="background:rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07) !important; border-radius: 16px; margin-top: 1.5rem;">
                    <h5 class="text-blue mb-3" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ Specifications & Timeline</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Project Timeline (e.g. 3-4 Weeks)</label>
                            <input type="text" name="project_timeline" class="form-control" value="{{ old('project_timeline', $service->project_timeline) }}" placeholder="Timeline">
                            @error('project_timeline') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Consultation Fee (e.g. LKR 15,000)</label>
                            <input type="text" name="consultation_fee" class="form-control" value="{{ old('consultation_fee', $service->consultation_fee) }}" placeholder="Fee">
                            @error('consultation_fee') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- Package Inclusions --}}
                <div class="card border-0 p-4 mb-3" style="background:rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07) !important; border-radius: 16px; margin-top: 1.5rem;">
                    <h5 class="text-blue mb-3" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ Package Inclusions</h5>
                    <div id="inclusions-list" class="mb-2">
                        @php
                            $inclusions = old('inclusions', $service->inclusions ?? []);
                            if (empty($inclusions)) { $inclusions = ['']; }
                        @endphp
                        @foreach($inclusions as $inclusion)
                            <div class="d-flex align-items-center gap-2 mb-2 inclusion-row">
                                <input type="text" name="inclusions[]" class="form-control py-2" value="{{ $inclusion }}" placeholder="e.g. 3D Floor Plan Rendering">
                                <button type="button" class="btn btn-outline-danger" onclick="removeInclusion(this)" style="border-radius: 8px; width: 38px; height: 38px; padding: 0;">×</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addInclusionRow()">+ Add Inclusion</button>
                </div>

                <!-- Multiple Reviews Section -->
                <h5 class="text-blue mt-4 mb-3" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ Client Reviews / Testimonials</h5>
                <div id="reviews-container">
                    @php $reviews = old('reviews', $service->reviews ?? []); @endphp
                    @forelse($reviews as $index => $rev)
                        <div class="review-row mb-3 p-3 border rounded-3" style="background: rgba(255, 255, 255, 0.01); border-color: rgba(255,255,255,0.05);">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label" style="font-size: 11px;">Parent Name</label>
                                    <input type="text" name="reviews[{{ $index }}][name]" class="form-control py-2" value="{{ $rev['name'] ?? '' }}" placeholder="e.g. Dilani S. (Colombo 07)">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="form-label" style="font-size: 11px;">Stars</label>
                                    <select name="reviews[{{ $index }}][stars]" class="form-control py-2" style="background: #1e2738; color:#fff; border: 1.5px solid rgba(255,255,255,0.08);">
                                        <option value="5" {{ ($rev['stars'] ?? 5) == 5 ? 'selected' : '' }}>5 Stars</option>
                                        <option value="4" {{ ($rev['stars'] ?? 5) == 4 ? 'selected' : '' }}>4 Stars</option>
                                        <option value="3" {{ ($rev['stars'] ?? 5) == 3 ? 'selected' : '' }}>3 Stars</option>
                                        <option value="2" {{ ($rev['stars'] ?? 5) == 2 ? 'selected' : '' }}>2 Stars</option>
                                        <option value="1" {{ ($rev['stars'] ?? 5) == 1 ? 'selected' : '' }}>1 Star</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2 d-flex align-items-end justify-content-end">
                                    <button type="button" class="btn btn-outline-danger btn-sm py-2 px-3 remove-review-btn" onclick="this.closest('.review-row').remove()">Remove</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <label class="form-label" style="font-size: 11px;">Review Description</label>
                                    <textarea name="reviews[{{ $index }}][text]" class="form-control py-2" rows="2" placeholder="Write parents review here...">{{ $rev['text'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="review-row mb-3 p-3 border rounded-3" style="background: rgba(255, 255, 255, 0.01); border-color: rgba(255,255,255,0.05);">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label" style="font-size: 11px;">Parent Name</label>
                                    <input type="text" name="reviews[0][name]" class="form-control py-2" placeholder="e.g. Dilani S. (Colombo 07)">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="form-label" style="font-size: 11px;">Stars</label>
                                    <select name="reviews[0][stars]" class="form-control py-2" style="background: #1e2738; color:#fff; border: 1.5px solid rgba(255,255,255,0.08);">
                                        <option value="5">5 Stars</option>
                                        <option value="4">4 Stars</option>
                                        <option value="3">3 Stars</option>
                                        <option value="2">2 Stars</option>
                                        <option value="1">1 Star</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2 d-flex align-items-end justify-content-end">
                                    <button type="button" class="btn btn-outline-danger btn-sm py-2 px-3 remove-review-btn" onclick="this.closest('.review-row').remove()">Remove</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <label class="form-label" style="font-size: 11px;">Review Description</label>
                                    <textarea name="reviews[0][text]" class="form-control py-2" rows="2" placeholder="Write parents review here..."></textarea>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm mb-4" onclick="addReviewRow()">+ Add Review</button>

                <h5 class="text-blue mt-4 mb-3" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ Link Products</h5>
                <div class="mb-3">
                    <label class="form-label">Select Associated Cribs &amp; Pieces</label>
                    <div class="row g-2">
                        @foreach($allProducts as $prod)
                            <div class="col-md-4">
                                <div class="form-check p-3 border rounded-3" style="background:rgba(255,255,255,0.01); border-color:rgba(255,255,255,0.05);">
                                    <input class="form-check-input" type="checkbox" name="products[]" value="{{ $prod->id }}" id="prod_{{ $prod->id }}"
                                        {{ in_array($prod->id, $selectedProductIds) ? 'checked' : '' }}>
                                    <label class="form-check-label text-white ms-1" for="prod_{{ $prod->id }}">{{ $prod->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- SEO / Meta --}}
                <div class="card border-0 p-4 mb-3" style="background:rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07) !important; border-radius: 16px; margin-top: 2rem;">
                    <h5 class="text-blue mb-3" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ SEO &amp; Meta</h5>

                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $service->meta_title) }}" placeholder="Service name | Lumos Kids Room Designers">
                        @error('meta_title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3" placeholder="Short description for search engines (max 155 chars)">{{ old('meta_description', $service->meta_description) }}</textarea>
                        @error('meta_description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label">OG Image (Social Preview)</label>
                        @if($service->og_image)
                            <div class="mb-2">
                                <img src="{{ $service->ogImageUrl() }}" class="img-fluid rounded" style="max-height: 120px;" />
                            </div>
                        @endif
                        <input type="file" class="filepond-og" name="og_image" accept="image/*">
                        <div class="form-text text-muted">Upload an image for social sharing preview. Leave blank to keep existing or fallback to the service's primary image.</div>
                        @error('og_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- Right Panel -->
            <div class="col-md-4">
                <div class="card border-0 p-4 mb-4" style="background:rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07) !important; border-radius: 16px;">
                    <h5 class="text-blue mb-3" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ Settings</h5>

                    <div class="mb-4">
                        <label class="form-label" for="status">Publication Status</label>
                        <select name="status" id="status" class="form-control" style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255, 255, 255, 0.08); color: #ffffff; border-radius: 12px; padding: 14px 18px; font-size: 15px; outline: none; transition: all 0.3s; width: 100%;">
                            <option value="published" {{ old('status', $service->status) === 'published' ? 'selected' : '' }} style="background: #1e2738; color: #ffffff;">Published</option>
                            <option value="draft" {{ old('status', $service->status) === 'draft' ? 'selected' : '' }} style="background: #1e2738; color: #ffffff;">Draft</option>
                        </select>
                        <div class="form-text text-muted mt-2">Draft services are hidden from the public website lists and detail pages.</div>
                        @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured', $service->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label text-white" for="is_featured">Featured Service</label>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $service->sort_order) }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Primary Image</label>
                    @if($service->image)
                        <div class="mb-2">
                            <img src="{{ $service->primaryImageUrl() }}" class="img-fluid rounded" style="max-height: 150px;" />
                        </div>
                    @endif
                    <input type="file" class="filepond-primary" name="image" accept="image/*">
                </div>

                <div class="mb-4">
                    <label class="form-label">Gallery Images</label>
                    @if($service->images && count($service->images) > 0)
                        <div class="mb-3">
                            <span class="text-white-50 small d-block mb-2">Check to KEEP existing gallery images:</span>
                            <div class="row g-2">
                                @foreach($service->images as $img)
                                    <div class="col-4 position-relative">
                                        <img src="{{ \App\Models\Service::resolveImageUrl($img) }}" class="img-fluid rounded" />
                                        <div class="position-absolute top-0 start-0 p-1">
                                            <input class="form-check-input" type="checkbox" name="keep_images[]" value="{{ $img }}" checked>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <input type="file" class="filepond-gallery" name="images[]" accept="image/*" multiple>
                </div>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.services') }}" class="btn btn-outline-secondary py-3 px-4" style="border-radius: 12px;">Cancel</a>
            <button type="submit" class="btn btn-blue py-3 px-4">Update Service</button>
        </div>
    </form>
@endsection

@section('admin_scripts')
    <script src="{{ asset('js/common-uploader.js') }}"></script>
    <script>
        let reviewIndex = {{ count($reviews) ?: 1 }};
        function addReviewRow() {
            const container = document.getElementById('reviews-container');
            const row = document.createElement('div');
            row.className = 'review-row mb-3 p-3 border rounded-3';
            row.style.background = 'rgba(255, 255, 255, 0.01)';
            row.style.borderColor = 'rgba(255,255,255,0.05)';
            
            row.innerHTML = `
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label" style="font-size: 11px;">Parent Name</label>
                        <input type="text" name="reviews[${reviewIndex}][name]" class="form-control py-2" placeholder="e.g. Parent Name">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label" style="font-size: 11px;">Stars</label>
                        <select name="reviews[${reviewIndex}][stars]" class="form-control py-2" style="background: #1e2738; color:#fff; border: 1.5px solid rgba(255,255,255,0.08);">
                            <option value="5">5 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="2">2 Stars</option>
                            <option value="1">1 Star</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2 d-flex align-items-end justify-content-end">
                        <button type="button" class="btn btn-outline-danger btn-sm py-2 px-3 remove-review-btn" onclick="this.closest('.review-row').remove()">Remove</button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <label class="form-label" style="font-size: 11px;">Review Description</label>
                        <textarea name="reviews[${reviewIndex}][text]" class="form-control py-2" rows="2" placeholder="Write review..."></textarea>
                    </div>
                </div>
            `;
            container.appendChild(row);
            reviewIndex++;
        }

        function addInclusionRow() {
            const list = document.getElementById('inclusions-list');
            const row = document.createElement('div');
            row.className = 'd-flex align-items-center gap-2 mb-2 inclusion-row';
            row.innerHTML = `
                <input type="text" name="inclusions[]" class="form-control py-2" placeholder="e.g. New Inclusion Item">
                <button type="button" class="btn btn-outline-danger" onclick="removeInclusion(this)" style="border-radius: 8px; width: 38px; height: 38px; padding: 0;">×</button>
            `;
            list.appendChild(row);
            row.querySelector('input').focus();
        }

        function removeInclusion(btn) {
            const row = btn.closest('.inclusion-row');
            const list = document.getElementById('inclusions-list');
            if (list.querySelectorAll('.inclusion-row').length > 1) {
                row.remove();
            } else {
                row.querySelector('input').value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            FilePond.registerPlugin(FilePondPluginImagePreview);

            const primaryElement = document.querySelector('.filepond-primary');
            if (primaryElement) {
                window.initCommonUploader(primaryElement);
            }

            const galleryElement = document.querySelector('.filepond-gallery');
            if (galleryElement) {
                window.initCommonUploader(galleryElement, { allowMultiple: true });
            }

            const ogElement = document.querySelector('.filepond-og');
            if (ogElement) {
                window.initCommonUploader(ogElement);
            }

            // Auto-slug from name
            const nameField = document.getElementById('service-name');
            const slugField = document.getElementById('service-slug');
            if (slugField && slugField.value !== '') {
                slugField.dataset.edited = 'true';
            }
            if (nameField) {
                nameField.addEventListener('input', function () {
                    const slugField = document.getElementById('service-slug');
                    if (slugField && !slugField.dataset.edited) {
                        slugField.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                    }
                });
            }
            if (slugField) {
                slugField.addEventListener('input', function () {
                    this.dataset.edited = 'true';
                });
            }
        });
    </script>
@endsection
