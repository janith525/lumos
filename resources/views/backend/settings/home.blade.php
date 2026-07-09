@extends('backend.layout')

@section('admin_css')
    <link href="https://cdn.jsdelivr.net/npm/filepond@4.30.6/dist/filepond.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/filepond-plugin-image-preview@4.6.11/dist/filepond-plugin-image-preview.min.css" rel="stylesheet">
    <style>
        .form-label {
            font-size: 11px;
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
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: var(--color-blue);
            background: rgba(255, 255, 255, 0.04);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            outline: none;
            color: #ffffff;
        }
        .text-muted, .form-text {
            color: #f1f5f9 !important; /* Extremely high contrast for dark backgrounds */
            font-weight: 500;
            font-size: 13px;
            margin-top: 6px;
            display: block;
        }
        
        /* Premium CMS Slide Styling */
        .cms-card {
            background: rgba(13, 20, 35, 0.6);
            border: 1px solid rgba(59, 130, 246, 0.15);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            margin-bottom: 30px;
            overflow: hidden;
        }
        .cms-card-header {
            background: rgba(59, 130, 246, 0.05);
            border-bottom: 1px solid rgba(59, 130, 246, 0.15);
            padding: 20px 24px;
        }
        .text-blue-custom {
            color: #3b82f6 !important;
            font-weight: 700;
        }
        
        .slide-item {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 16px;
            transition: all 0.3s ease;
        }
        .slide-item:hover {
            background: rgba(59, 130, 246, 0.03);
            border-color: rgba(59, 130, 246, 0.2);
            transform: translateY(-2px);
        }
        .slide-thumb {
            width: 100%;
            height: 100px;
            object-fit: contain;
            background: rgba(0,0,0,0.2);
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .badge-ratio {
            font-size: 10px;
            padding: 4px 8px;
            border-radius: 6px;
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.2);
            display: inline-block;
            margin-top: 6px;
        }
    </style>
@endsection

@section('admin_content')
    <div class="admin-header">
        <div>
            <h2 class="admin-title">Home Page CMS</h2>
            <p class="admin-subtitle">Customize the landing page hero slider slides, sorting order, and content sections.</p>
        </div>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated',
                    text: "{{ session('success') }}",
                    background: '#090d16',
                    color: '#ffffff',
                    confirmButtonColor: '#3b82f6'
                });
            });
        </script>
    @endif

    <form id="cmsForm" action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <!-- SECTION 1: HERO CAROUSEL -->
        <div class="card cms-card">
            <div class="cms-card-header d-flex justify-content-between align-items-center">
                <h5 class="text-blue-custom mb-0">Section 1: Hero Carousel Slides</h5>
                <button type="button" class="btn btn-blue btn-sm" onclick="openSlideModal()">
                    + Add New Slide
                </button>
            </div>
            <div class="card-body p-4 bg-dark">
                <div id="slides-container" class="mb-3">
                    <!-- Rendered via JavaScript -->
                </div>
                
                <!-- Hidden Slides Payload Input -->
                <input type="hidden" name="slides" id="slides_input" value="{{ json_encode($slides) }}">
            </div>
        </div>

        <!-- SECTION 2: WHY CHOOSE US & SERVICES PREVIEW TEXTS -->
        <div class="card cms-card">
            <div class="cms-card-header">
                <h5 class="text-blue-custom mb-0">Section 2: Services Preview Section</h5>
            </div>
            <div class="card-body p-4 bg-dark">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Services Eyebrow</label>
                        <input type="text" name="home_services_eyebrow" class="form-control" value="{{ old('home_services_eyebrow', $settings['home_services_eyebrow'] ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Services Title</label>
                        <input type="text" name="home_services_title" class="form-control" value="{{ old('home_services_title', $settings['home_services_title'] ?? '') }}">
                        <span class="text-muted">Wrap emphasis text in ## (e.g. Solutions For ##Every## Need)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: ABOUT SECTION -->
        <div class="card cms-card">
            <div class="cms-card-header">
                <h5 class="text-blue-custom mb-0">Section 3: About Lumos Section</h5>
            </div>
            <div class="card-body p-4 bg-dark">
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">About Eyebrow</label>
                            <input type="text" name="home_about_eyebrow" class="form-control" value="{{ old('home_about_eyebrow', $settings['home_about_eyebrow'] ?? 'About Lumos') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">About Title</label>
                            <input type="text" name="home_about_title" class="form-control" value="{{ old('home_about_title', $settings['home_about_title'] ?? 'Lumos: Sri Lanka\'s Pioneer Luxury Nursery Design & Kids Interior Studio') }}">
                            <span class="text-muted">Wrap emphasis text in ##</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">About Description</label>
                            <textarea name="home_about_desc" class="form-control" rows="4">{{ old('home_about_desc', $settings['home_about_desc'] ?? 'Lumos is a dedicated interior design studio based in Sri Lanka, specializing exclusively in nursery and baby room aesthetics. We are the first of our kind in the country, committed to creating "tiny dreams" for your little ones.') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">About Section Image</label>
                        @if(isset($settings['home_about_image']) && $settings['home_about_image'])
                            <div class="mb-3 p-2 border rounded-3 text-center bg-black border-secondary">
                                <img src="{{ asset('storage/' . $settings['home_about_image']) }}" class="img-fluid rounded" style="max-height: 120px;" />
                            </div>
                        @endif
                        <input type="file" class="filepond-about-img" name="home_about_image" accept="image/*">
                        <div class="form-text text-muted" style="color: #94a3b8 !important;">Recommended 800x1000 px (4:5 vertical aspect ratio).</div>
                    </div>
                </div>

                <h6 class="text-white border-bottom border-secondary pb-2 mt-4 mb-3">✦ Impact Stats (Numbers)</h6>
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="p-3 border border-secondary rounded-3 bg-black">
                            <label class="form-label text-white">Stat 1 Value</label>
                            <input type="text" name="home_stat1_value" class="form-control mb-2" value="{{ old('home_stat1_value', $settings['home_stat1_value'] ?? '100%') }}">
                            <label class="form-label text-white">Stat 1 Label</label>
                            <input type="text" name="home_stat1_label" class="form-control mb-2" value="{{ old('home_stat1_label', $settings['home_stat1_label'] ?? 'Quality Assurance') }}">
                            <label class="form-label text-white">Stat 1 Tooltip</label>
                            <input type="text" name="home_stat1_tooltip" class="form-control" value="{{ old('home_stat1_tooltip', $settings['home_stat1_tooltip'] ?? 'All products undergo strict quality control processes.') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border border-secondary rounded-3 bg-black">
                            <label class="form-label text-white">Stat 2 Value</label>
                            <input type="text" name="home_stat2_value" class="form-control mb-2" value="{{ old('home_stat2_value', $settings['home_stat2_value'] ?? '20') }}">
                            <label class="form-label text-white">Stat 2 Label</label>
                            <input type="text" name="home_stat2_label" class="form-control mb-2" value="{{ old('home_stat2_label', $settings['home_stat2_label'] ?? 'Years Warranty') }}">
                            <label class="form-label text-white">Stat 2 Tooltip</label>
                            <input type="text" name="home_stat2_tooltip" class="form-control" value="{{ old('home_stat2_tooltip', $settings['home_stat2_tooltip'] ?? 'Up to 20 years warranty on specialized cladding and roofing coatings.') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border border-secondary rounded-3 bg-black">
                            <label class="form-label text-white">Stat 3 Value</label>
                            <input type="text" name="home_stat3_value" class="form-control mb-2" value="{{ old('home_stat3_value', $settings['home_stat3_value'] ?? '12m') }}">
                            <label class="form-label text-white">Stat 3 Label</label>
                            <input type="text" name="home_stat3_label" class="form-control mb-2" value="{{ old('home_stat3_label', $settings['home_stat3_label'] ?? 'Max Sheet Length') }}">
                            <label class="form-label text-white">Stat 3 Tooltip</label>
                            <input type="text" name="home_stat3_tooltip" class="form-control" value="{{ old('home_stat3_tooltip', $settings['home_stat3_tooltip'] ?? 'Maximum transport length for custom roofing sheets and steel purlins.') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border border-secondary rounded-3 bg-black">
                            <label class="form-label text-white">Stat 4 Value</label>
                            <input type="text" name="home_stat4_value" class="form-control mb-2" value="{{ old('home_stat4_value', $settings['home_stat4_value'] ?? 'AZ200') }}">
                            <label class="form-label text-white">Stat 4 Label</label>
                            <input type="text" name="home_stat4_label" class="form-control mb-2" value="{{ old('home_stat4_label', $settings['home_stat4_label'] ?? 'Coating Class') }}">
                            <label class="form-label text-white">Stat 4 Tooltip</label>
                            <input type="text" name="home_stat4_tooltip" class="form-control" value="{{ old('home_stat4_tooltip', $settings['home_stat4_tooltip'] ?? 'Highest coating class available for superior corrosion resistance.') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 4: WHY CHOOSE US DETAILS -->
        <div class="card cms-card">
            <div class="cms-card-header">
                <h5 class="text-blue-custom mb-0">Section 4: "Why Choose Us" & Features</h5>
            </div>
            <div class="card-body p-4 bg-dark">
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Why Choose Eyebrow</label>
                            <input type="text" name="home_why_choose_eyebrow" class="form-control" value="{{ old('home_why_choose_eyebrow', $settings['home_why_choose_eyebrow'] ?? 'Why Choose Lumos') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Why Choose Title</label>
                            <input type="text" name="home_why_choose_title" class="form-control" value="{{ old('home_why_choose_title', $settings['home_why_choose_title'] ?? 'Dedicated to Your ##Baby\'s## First Room') }}">
                            <span class="text-muted">Wrap emphasis text in ##</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Why Choose Description</label>
                            <textarea name="home_why_choose_desc" class="form-control" rows="3">{{ old('home_why_choose_desc', $settings['home_why_choose_desc'] ?? 'As Sri Lanka\'s only specialized nursery design studio, we understand that a baby\'s room is more than just furniture—it\'s a sanctuary for growth, sleep, and dreams.') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Why Choose Section Image</label>
                        @if(isset($settings['home_why_choose_image']) && $settings['home_why_choose_image'])
                            <div class="mb-3 p-2 border rounded-3 text-center bg-black border-secondary">
                                <img src="{{ asset('storage/' . $settings['home_why_choose_image']) }}" class="img-fluid rounded" style="max-height: 120px;" />
                            </div>
                        @endif
                        <input type="file" class="filepond-why-img" name="home_why_choose_image" accept="image/*">
                        <div class="form-text text-muted" style="color: #94a3b8 !important;">Recommended 800x1000 px (4:5 vertical aspect ratio).</div>
                    </div>
                </div>

                <h6 class="text-white border-bottom border-secondary pb-2 mt-4 mb-3">✦ Floating Badge Details</h6>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Badge Value</label>
                        <input type="text" name="home_why_choose_badge_value" class="form-control" value="{{ old('home_why_choose_badge_value', $settings['home_why_choose_badge_value'] ?? '100%') }}">
                    </div>
                    <div class="col-md-9">
                        <label class="form-label">Badge Text</label>
                        <input type="text" name="home_why_choose_badge_text" class="form-control" value="{{ old('home_why_choose_badge_text', $settings['home_why_choose_badge_text'] ?? 'Highest quality guaranteed on every steel and roofing product.') }}">
                    </div>
                </div>

                <h6 class="text-white border-bottom border-secondary pb-2 mt-4 mb-3">✦ Core Features list</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 border border-secondary rounded-3 bg-black mb-3">
                            <label class="form-label text-white">Feature 1 Title</label>
                            <input type="text" name="home_feat1_title" class="form-control mb-2" value="{{ old('home_feat1_title', $settings['home_feat1_title'] ?? 'Quality Assurance') }}">
                            <label class="form-label text-white">Feature 1 Description</label>
                            <textarea name="home_feat1_desc" class="form-control" rows="2">{{ old('home_feat1_desc', $settings['home_feat1_desc'] ?? 'All products undergo strict quality control processes before delivery.') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border border-secondary rounded-3 bg-black mb-3">
                            <label class="form-label text-white">Feature 2 Title</label>
                            <input type="text" name="home_feat2_title" class="form-control mb-2" value="{{ old('home_feat2_title', $settings['home_feat2_title'] ?? 'Innovation') }}">
                            <label class="form-label text-white">Feature 2 Description</label>
                            <textarea name="home_feat2_desc" class="form-control" rows="2">{{ old('home_feat2_desc', $settings['home_feat2_desc'] ?? 'We continuously develop advanced construction materials and methods.') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border border-secondary rounded-3 bg-black">
                            <label class="form-label text-white">Feature 3 Title</label>
                            <input type="text" name="home_feat3_title" class="form-control mb-2" value="{{ old('home_feat3_title', $settings['home_feat3_title'] ?? 'Reliability') }}">
                            <label class="form-label text-white">Feature 3 Description</label>
                            <textarea name="home_feat3_desc" class="form-control" rows="2">{{ old('home_feat3_desc', $settings['home_feat3_desc'] ?? 'Consistent product quality and dependable supply for all scale projects.') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border border-secondary rounded-3 bg-black">
                            <label class="form-label text-white">Feature 4 Title</label>
                            <input type="text" name="home_feat4_title" class="form-control mb-2" value="{{ old('home_feat4_title', $settings['home_feat4_title'] ?? 'Sustainability') }}">
                            <label class="form-label text-white">Feature 4 Description</label>
                            <textarea name="home_feat4_desc" class="form-control" rows="2">{{ old('home_feat4_desc', $settings['home_feat4_desc'] ?? 'Eco-friendly products designed to reduce environmental impact.') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 5: SEO & META -->
        <div class="card cms-card">
            <div class="cms-card-header">
                <h5 class="text-blue-custom mb-0">Section 5: SEO &amp; Meta</h5>
            </div>
            <div class="card-body p-4 bg-dark">
                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="home_meta_title" class="form-control" value="{{ old('home_meta_title', $settings['home_meta_title'] ?? '') }}" placeholder="Home page title | Lumos Nursery Studio">
                </div>

                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea name="home_meta_description" class="form-control" rows="3" placeholder="Short description for search engines (max 155 chars)">{{ old('home_meta_description', $settings['home_meta_description'] ?? '') }}</textarea>
                </div>

                <div class="mb-0">
                    <label class="form-label">OG Image (Social Preview)</label>
                    @if(isset($settings['home_og_image']) && $settings['home_og_image'])
                        <div class="mb-3 p-2 border rounded-3 text-center bg-black border-secondary" style="max-width: 200px;">
                            <img src="{{ asset('storage/' . $settings['home_og_image']) }}" class="img-fluid rounded" style="max-height: 120px;" />
                        </div>
                    @endif
                    <input type="file" class="filepond-og-home" name="home_og_image" accept="image/*">
                    <span class="text-muted" style="color: rgba(148, 163, 184, 0.45) !important; font-size: 12px; margin-top: 0.5rem; font-weight: 500;">Upload an image for social sharing preview. Recommended 1200x630 px (1.91:1 aspect ratio).</span>
                </div>
            </div>
        </div>

        <!-- SECTION 6: HOMEPAGE SHOWCASE GALLERY -->
        <div class="card cms-card mt-4">
            <div class="cms-card-header">
                <h5 class="text-blue-custom mb-0">Section 6: Homepage Showcase Gallery Selection</h5>
            </div>
            <div class="card-body p-4 bg-dark">
                <p class="text-muted mb-3" style="font-size: 13px;">Select which gallery showcase items will appear in the homepage grid. The home page displays up to 10 selected items.</p>
                
                <div class="row g-3">
                    @foreach($galleryItems as $item)
                        <div class="col-md-6 col-lg-4">
                            <div class="p-3 border border-secondary rounded-3 bg-black d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    @if($item->image)
                                        <img src="{{ $item->primaryImageUrl() }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;" />
                                    @endif
                                    <div>
                                        <div class="text-white fw-bold" style="font-size: 13px;">{{ $item->title }}</div>
                                        <div class="text-muted" style="font-size: 11px;">{{ ucfirst($item->category) }} • {{ ucfirst($item->type) }}</div>
                                    </div>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="homepage_gallery[]" value="{{ $item->id }}" id="gallery-item-{{ $item->id }}" {{ $item->show_on_home ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-blue py-3 px-5">Save Configuration</button>
        </div>
    </form>
@endsection

@section('admin_modals')
<!-- SLIDE MODAL -->
<div class="modal fade" id="slideModal" tabindex="-1" aria-labelledby="slideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark border-secondary text-white" style="border-radius: 20px;">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-blue" id="slideModalTitle">Add Slide</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="slide_index" value="-1">
                <input type="hidden" id="slide_id" value="">

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-blue fw-bold">Slide Kicker / Subtitle</label>
                        <input type="text" id="slide_kicker" class="form-control bg-black text-white border-secondary p-3" placeholder="e.g. Since 2019">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label text-blue fw-bold">Slide Title</label>
                        <input type="text" id="slide_title" class="form-control bg-black text-white border-secondary p-3" placeholder="e.g. Lumos Nursery Space Design">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-blue fw-bold">Subtext / Description</label>
                    <textarea id="slide_subtext" class="form-control bg-black text-white border-secondary p-3" rows="3" placeholder="Tell us your vision..."></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-blue fw-bold">Button Text</label>
                        <input type="text" id="slide_button_text" class="form-control bg-black text-white border-secondary p-3" placeholder="e.g. Our Products">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-blue fw-bold">Button Link</label>
                        <input type="text" id="slide_button_link" class="form-control bg-black text-white border-secondary p-3" placeholder="e.g. /products">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-blue fw-bold">Desktop Image (16:9)</label>
                        <input type="file" id="slide_image_file" class="form-control bg-black text-white border-secondary mb-2" accept="image/*" onchange="previewDesktopImage(this)">
                        <input type="hidden" id="slide_image_base64">
                        <div class="position-relative mt-2" style="border-radius: 12px; overflow: hidden; border: 1px dashed rgba(59,130,246,0.3); background: rgba(0,0,0,0.2); min-height: 160px; display: flex; align-items: center; justify-content: center;">
                            <img id="slide_image_preview" class="w-100" style="max-height: 150px; object-fit: contain; display: none;">
                            <div id="slide_image_placeholder" class="text-center p-3 text-muted" style="font-size: 12px;">
                                <span>No Desktop Image Selected</span><br>
                                <span class="badge-ratio">Recommended 1920x1080 px</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-blue fw-bold">Mobile Image</label>
                        <input type="file" id="slide_mobile_image_file" class="form-control bg-black text-white border-secondary mb-2" accept="image/*" onchange="previewMobileImage(this)">
                        <input type="hidden" id="slide_mobile_image_base64">
                        <div class="position-relative mt-2" style="border-radius: 12px; overflow: hidden; border: 1px dashed rgba(59,130,246,0.3); background: rgba(0,0,0,0.2); min-height: 160px; display: flex; align-items: center; justify-content: center;">
                            <img id="slide_mobile_image_preview" class="w-100" style="max-height: 150px; object-fit: contain; display: none;">
                            <div id="slide_mobile_image_placeholder" class="text-center p-3 text-muted" style="font-size: 12px;">
                                <span>No Mobile Image Selected</span><br>
                                <span class="badge-ratio">Recommended 800x1000 px</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-outline-secondary px-3 text-white" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-blue px-4 text-white fw-bold" onclick="saveSlide()">Apply Slide</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('admin_scripts')
    <script src="{{ asset('js/common-uploader.js') }}"></script>
    <script>
        let slidesData = [];

        document.addEventListener('DOMContentLoaded', function() {
            FilePond.registerPlugin(FilePondPluginImagePreview);

            const aboutImg = document.querySelector('.filepond-about-img');
            if (aboutImg) {
                window.initCommonUploader(aboutImg);
            }

            const whyImg = document.querySelector('.filepond-why-img');
            if (whyImg) {
                window.initCommonUploader(whyImg);
            }

            const ogHomeImg = document.querySelector('.filepond-og-home');
            if (ogHomeImg) {
                window.initCommonUploader(ogHomeImg);
            }

            try {
                slidesData = JSON.parse(document.getElementById('slides_input').value || '[]');
            } catch (e) {
                console.error('Failed to parse slides data:', e);
                slidesData = [];
            }
            renderSlides();
        });

        function renderSlides() {
            const container = document.getElementById('slides-container');
            container.innerHTML = '';

            if (slidesData.length === 0) {
                container.innerHTML = `
                    <div class="text-center p-5 text-muted border border-secondary" style="border-radius: 14px; background: rgba(0,0,0,0.1);">
                        <p class="mb-0">No active Hero slides. Click "+ Add New Slide" to configure your first homepage slide.</p>
                    </div>
                `;
                return;
            }

            slidesData.forEach((slide, index) => {
                const slidePreview = slide.image ? `<img src="${slide.image}" class="slide-thumb">` : `<div class="d-flex align-items-center justify-content-center bg-black text-muted" style="height:100px; border-radius:8px;">No image</div>`;
                const mobileSlidePreview = slide.mobile_image ? `<img src="${slide.mobile_image}" class="slide-thumb">` : `<div class="d-flex align-items-center justify-content-center bg-black text-muted" style="height:100px; border-radius:8px;">No mobile image</div>`;

                const card = document.createElement('div');
                card.className = 'slide-item';
                card.innerHTML = `
                    <div class="row align-items-center">
                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="row g-2">
                                <div class="col-6">
                                    ${slidePreview}
                                    <div class="text-center" style="font-size: 9px;"><span class="badge-ratio">Desktop</span></div>
                                </div>
                                <div class="col-6">
                                    ${mobileSlidePreview}
                                    <div class="text-center" style="font-size: 9px;"><span class="badge-ratio">Mobile</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 mb-md-0">
                            <span class="badge bg-primary mb-1 text-uppercase">${escapeHtml(slide.kicker || 'Slide')}</span>
                            <h6 class="text-white mb-1" style="font-family: inherit; font-size:16px;">${escapeHtml(slide.title || 'Untitled Slide')}</h6>
                            <p class="text-muted small mb-2" style="max-height: 40px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${escapeHtml(slide.subtext || 'No description.')}</p>
                            ${slide.button_text ? `<span class="badge bg-secondary me-2">${escapeHtml(slide.button_text)} &rarr; ${escapeHtml(slide.button_link || '#')}</span>` : ''}
                        </div>
                        <div class="col-md-3 text-md-end">
                            <div class="d-inline-flex gap-1">
                                ${index > 0 ? `<button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2.5 text-white" onclick="moveSlideUp(${index})">↑</button>` : ''}
                                ${index < slidesData.length - 1 ? `<button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2.5 text-white" onclick="moveSlideDown(${index})">↓</button>` : ''}
                                <button type="button" class="btn btn-sm btn-outline-primary py-1 px-3 text-white" onclick="editSlide(${index})">Edit</button>
                                <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2 text-danger" onclick="removeSlide(${index})">&times;</button>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });

            // Sync payload to hidden input
            document.getElementById('slides_input').value = JSON.stringify(slidesData);
        }

        function openSlideModal() {
            document.getElementById('slide_index').value = -1;
            document.getElementById('slide_id').value = '';
            document.getElementById('slide_kicker').value = '';
            document.getElementById('slide_title').value = '';
            document.getElementById('slide_subtext').value = '';
            document.getElementById('slide_button_text').value = '';
            document.getElementById('slide_button_link').value = '';
            
            document.getElementById('slide_image_file').value = '';
            document.getElementById('slide_image_base64').value = '';
            document.getElementById('slide_image_preview').style.display = 'none';
            document.getElementById('slide_image_placeholder').style.display = 'block';

            document.getElementById('slide_mobile_image_file').value = '';
            document.getElementById('slide_mobile_image_base64').value = '';
            document.getElementById('slide_mobile_image_preview').style.display = 'none';
            document.getElementById('slide_mobile_image_placeholder').style.display = 'block';

            document.getElementById('slideModalTitle').innerText = 'Add Slide';
            new bootstrap.Modal(document.getElementById('slideModal')).show();
        }

        function editSlide(index) {
            const slide = slidesData[index];
            
            document.getElementById('slide_index').value = index;
            document.getElementById('slide_id').value = slide.id || '';
            document.getElementById('slide_kicker').value = slide.kicker || '';
            document.getElementById('slide_title').value = slide.title || '';
            document.getElementById('slide_subtext').value = slide.subtext || '';
            document.getElementById('slide_button_text').value = slide.button_text || '';
            document.getElementById('slide_button_link').value = slide.button_link || '';

            document.getElementById('slide_image_file').value = '';
            document.getElementById('slide_image_base64').value = slide.image || '';

            if (slide.image) {
                document.getElementById('slide_image_preview').src = slide.image;
                document.getElementById('slide_image_preview').style.display = 'block';
                document.getElementById('slide_image_placeholder').style.display = 'none';
            } else {
                document.getElementById('slide_image_preview').style.display = 'none';
                document.getElementById('slide_image_placeholder').style.display = 'block';
            }

            document.getElementById('slide_mobile_image_file').value = '';
            document.getElementById('slide_mobile_image_base64').value = slide.mobile_image || '';

            if (slide.mobile_image) {
                document.getElementById('slide_mobile_image_preview').src = slide.mobile_image;
                document.getElementById('slide_mobile_image_preview').style.display = 'block';
                document.getElementById('slide_mobile_image_placeholder').style.display = 'none';
            } else {
                document.getElementById('slide_mobile_image_preview').style.display = 'none';
                document.getElementById('slide_mobile_image_placeholder').style.display = 'block';
            }

            document.getElementById('slideModalTitle').innerText = 'Edit Slide';
            new bootstrap.Modal(document.getElementById('slideModal')).show();
        }

        function saveSlide() {
            const index = parseInt(document.getElementById('slide_index').value);
            const id = document.getElementById('slide_id').value;
            const kicker = document.getElementById('slide_kicker').value;
            const title = document.getElementById('slide_title').value;
            const subtext = document.getElementById('slide_subtext').value;
            const button_text = document.getElementById('slide_button_text').value;
            const button_link = document.getElementById('slide_button_link').value;
            const image = document.getElementById('slide_image_base64').value;
            const mobile_image = document.getElementById('slide_mobile_image_base64').value;

            if (!image) {
                alert('Slide Desktop image is required!');
                return;
            }

            const dataObj = { id, kicker, title, subtext, button_text, button_link, image, mobile_image };

            if (index === -1) {
                slidesData.push(dataObj);
            } else {
                slidesData[index] = dataObj;
            }

            renderSlides();
            
            const modalEl = document.getElementById('slideModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
        }

        function removeSlide(index) {
            if (confirm('Are you sure you want to remove this slide?')) {
                slidesData.splice(index, 1);
                renderSlides();
            }
        }

        function moveSlideUp(index) {
            if (index > 0) {
                const temp = slidesData[index];
                slidesData[index] = slidesData[index - 1];
                slidesData[index - 1] = temp;
                renderSlides();
            }
        }

        function moveSlideDown(index) {
            if (index < slidesData.length - 1) {
                const temp = slidesData[index];
                slidesData[index] = slidesData[index + 1];
                slidesData[index + 1] = temp;
                renderSlides();
            }
        }

        function previewDesktopImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('slide_image_base64').value = e.target.result;
                    document.getElementById('slide_image_preview').src = e.target.result;
                    document.getElementById('slide_image_preview').style.display = 'block';
                    document.getElementById('slide_image_placeholder').style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewMobileImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('slide_mobile_image_base64').value = e.target.result;
                    document.getElementById('slide_mobile_image_preview').src = e.target.result;
                    document.getElementById('slide_mobile_image_preview').style.display = 'block';
                    document.getElementById('slide_mobile_image_placeholder').style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    </script>
@endsection
