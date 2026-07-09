@extends('backend.layout')

@section('admin_css')
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
        .form-control::placeholder {
            color: rgba(148, 163, 184, 0.35);
            opacity: 1;
        }
        .form-text {
            color: rgba(148, 163, 184, 0.45) !important;
            font-size: 12px;
        }
        .text-muted {
            color: #cbd5e1 !important;
        }
    </style>
@endsection

@section('admin_content')
    <div class="admin-header">
        <div>
            <h2 class="admin-title">About Page CMS</h2>
            <p class="admin-subtitle">Configure page banner title, legacy story paragraphs, and director quotes.</p>
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

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <div class="row g-4">
            <div class="col-md-8">
                
                {{-- Section 1: Page Story Details & Images --}}
                <div class="card border-0 p-4 mb-4" style="background:rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07) !important; border-radius: 16px;">
                    <h5 class="text-blue mb-4" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ Section 1: Page Story Details &amp; Images</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Banner Page Title</label>
                        <input type="text" name="about_banner_title" class="form-control" value="{{ old('about_banner_title', $settings['about_banner_title'] ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Banner Background Image</label>
                        @if(isset($settings['about_banner_image']) && $settings['about_banner_image'])
                            <div class="mb-2 p-2 border rounded text-center bg-black border-secondary" style="max-width: 250px;">
                                <img src="{{ asset('storage/' . $settings['about_banner_image']) }}" class="img-fluid rounded" style="max-height: 100px;" />
                            </div>
                        @endif
                        <input type="file" class="filepond-banner" name="about_banner_image" accept="image/*">
                        <div class="form-text text-muted">Upload a banner image. Recommended aspect ratio 16:9 or 21:9.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Story Eyebrow</label>
                        <input type="text" name="about_story_eyebrow" class="form-control" value="{{ old('about_story_eyebrow', $settings['about_story_eyebrow'] ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Story Title</label>
                        <input type="text" name="about_story_title" class="form-control" value="{{ old('about_story_title', $settings['about_story_title'] ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Story Lead Intro</label>
                        <textarea name="about_story_lead" class="form-control" rows="2">{{ old('about_story_lead', $settings['about_story_lead'] ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Story Body Paragraph 1</label>
                        <textarea name="about_story_body1" class="form-control" rows="3">{{ old('about_story_body1', $settings['about_story_body1'] ?? '') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Story Body Paragraph 2</label>
                        <textarea name="about_story_body2" class="form-control" rows="3">{{ old('about_story_body2', $settings['about_story_body2'] ?? '') }}</textarea>
                    </div>

                    <h6 class="text-white border-top border-secondary pt-4 pb-2 mb-3" style="font-size:13px; font-weight:700; text-transform:uppercase;">✦ Story Section Images</h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Story Image 1 (Bespoke Crib Design)</label>
                            @if(isset($settings['about_story_image1']) && $settings['about_story_image1'])
                                <div class="mb-3 p-2 border rounded-3 text-center bg-black border-secondary" style="max-width: 200px;">
                                    <img src="{{ str_starts_with($settings['about_story_image1'], 'http') ? $settings['about_story_image1'] : asset('storage/' . $settings['about_story_image1']) }}" class="img-fluid rounded" style="max-height: 120px;" />
                                </div>
                            @endif
                            <input type="file" class="filepond-story1" name="about_story_image1" accept="image/*">
                            <div class="form-text text-muted">Recommended 800x1000 px (4:5 vertical aspect ratio).</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Story Image 2 (Nursery Details)</label>
                            @if(isset($settings['about_story_image2']) && $settings['about_story_image2'])
                                <div class="mb-3 p-2 border rounded-3 text-center bg-black border-secondary" style="max-width: 200px;">
                                    <img src="{{ str_starts_with($settings['about_story_image2'], 'http') ? $settings['about_story_image2'] : asset('storage/' . $settings['about_story_image2']) }}" class="img-fluid rounded" style="max-height: 120px;" />
                                </div>
                            @endif
                            <input type="file" class="filepond-story2" name="about_story_image2" accept="image/*">
                            <div class="form-text text-muted">Recommended 800x1000 px (4:5 vertical aspect ratio).</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-0">
                            <label class="form-label">Story Image 3 (Magic Lighting)</label>
                            @if(isset($settings['about_story_image3']) && $settings['about_story_image3'])
                                <div class="mb-3 p-2 border rounded-3 text-center bg-black border-secondary" style="max-width: 200px;">
                                    <img src="{{ str_starts_with($settings['about_story_image3'], 'http') ? $settings['about_story_image3'] : asset('storage/' . $settings['about_story_image3']) }}" class="img-fluid rounded" style="max-height: 120px;" />
                                </div>
                            @endif
                            <input type="file" class="filepond-story3" name="about_story_image3" accept="image/*">
                            <div class="form-text text-muted">Recommended 800x1000 px (4:5 vertical aspect ratio).</div>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Executive Signatures & Founder Message --}}
                <div class="card border-0 p-4 mb-4" style="background:rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07) !important; border-radius: 16px;">
                    <h5 class="text-blue mb-4" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ Section 2: Executive Signatures &amp; Founder Message</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Founder/Chairman Name</label>
                            <input type="text" name="about_founder_sig_text" class="form-control" value="{{ old('about_founder_sig_text', $settings['about_founder_sig_text'] ?? '') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Founder Designation Label</label>
                            <input type="text" name="about_founder_sig_lbl" class="form-control" value="{{ old('about_founder_sig_lbl', $settings['about_founder_sig_lbl'] ?? '') }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Founder Quote / Message</label>
                        <textarea name="about_founder_quote" class="form-control" rows="3" placeholder="Founder quote or message...">{{ old('about_founder_quote', $settings['about_founder_quote'] ?? '') }}</textarea>
                    </div>

                    <h6 class="text-white border-top border-secondary pt-4 pb-2 mb-3" style="font-size:13px; font-weight:700; text-transform:uppercase;">✦ Founder Photograph</h6>

                    <div class="row">
                        <div class="col-md-6 mb-0">
                            <label class="form-label">Founder Image</label>
                            @if(isset($settings['about_founder_image']) && $settings['about_founder_image'])
                                <div class="mb-3 p-2 border rounded-3 text-center bg-black border-secondary" style="max-width: 200px;">
                                    <img src="{{ str_starts_with($settings['about_founder_image'], 'http') ? $settings['about_founder_image'] : asset('storage/' . $settings['about_founder_image']) }}" class="img-fluid rounded" style="max-height: 120px;" />
                                </div>
                            @endif
                            <input type="file" class="filepond-founder" name="about_founder_image" accept="image/*">
                            <div class="form-text text-muted">Recommended 800x1000 px (4:5 aspect ratio).</div>
                        </div>
                    </div>
                </div>

                {{-- Section 3: SEO & Meta --}}
                <div class="card border-0 p-4 mb-3" style="background:rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07) !important; border-radius: 16px;">
                    <h5 class="text-blue mb-4" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ Section 3: SEO &amp; Meta</h5>

                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="about_meta_title" class="form-control" value="{{ old('about_meta_title', $settings['about_meta_title'] ?? '') }}" placeholder="About us | Lumos Nursery Studio">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="about_meta_description" class="form-control" rows="3" placeholder="Short description for search engines (max 155 chars)">{{ old('about_meta_description', $settings['about_meta_description'] ?? '') }}</textarea>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">OG Image (Social Preview)</label>
                        @if(isset($settings['about_og_image']) && $settings['about_og_image'])
                            <div class="mb-3 p-2 border rounded-3 text-center bg-black border-secondary" style="max-width: 200px;">
                                <img src="{{ asset('storage/' . $settings['about_og_image']) }}" class="img-fluid rounded" style="max-height: 120px;" />
                            </div>
                        @endif
                        <input type="file" class="filepond-og-about" name="about_og_image" accept="image/*">
                        <div class="form-text text-muted">Upload an image for social sharing preview. Recommended 1200x630 px (1.91:1 aspect ratio).</div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-blue py-3 px-4">Save Configuration</button>
        </div>
    </form>
@endsection

@section('admin_scripts')
    <script src="{{ asset('js/common-uploader.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ogAboutImg = document.querySelector('.filepond-og-about');
            if (ogAboutImg) {
                window.initCommonUploader(ogAboutImg);
            }
            const bannerImg = document.querySelector('.filepond-banner');
            if (bannerImg) {
                window.initCommonUploader(bannerImg);
            }
            const story1 = document.querySelector('.filepond-story1');
            if (story1) {
                window.initCommonUploader(story1);
            }
            const story2 = document.querySelector('.filepond-story2');
            if (story2) {
                window.initCommonUploader(story2);
            }
            const story3 = document.querySelector('.filepond-story3');
            if (story3) {
                window.initCommonUploader(story3);
            }
            const founderImg = document.querySelector('.filepond-founder');
            if (founderImg) {
                window.initCommonUploader(founderImg);
            }
        });
    </script>
@endsection
