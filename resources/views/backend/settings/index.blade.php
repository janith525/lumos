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
        .text-muted, .form-text {
            color: #94a3b8 !important;
            font-size: 13px;
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
            <h2 class="admin-title">General & SEO Settings</h2>
            <p class="admin-subtitle">Configure basic site variables, logos, contact details, and search engine metadata.</p>
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
                <h5 class="text-blue mb-3" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ Site Details</h5>
                
                <div class="mb-3">
                    <label class="form-label">Site Name *</label>
                    <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $settings['site_name'] ?? 'Lumos Nursery Studio') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Email *</label>
                        <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $settings['contact_email'] ?? 'hello@lumos.lk') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Company Address</label>
                    <textarea name="address" class="form-control" rows="3">{{ old('address', $settings['address'] ?? '') }}</textarea>
                </div>

                <h5 class="text-blue mt-4 mb-3" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ SEO Configurations</h5>

                <div class="mb-3">
                    <label class="form-label">SEO Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $settings['meta_title'] ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">SEO Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="col-md-4">
                <h5 class="text-blue mb-3" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ Media Assets</h5>

                <div class="mb-4">
                    <label class="form-label">Website Logo</label>
                    @if(isset($settings['logo']) && $settings['logo'])
                        <div class="mb-3 p-3 border rounded-3 text-center" style="background: rgba(255,255,255,0.01); border-color: rgba(255,255,255,0.05);">
                            <img src="{{ asset('storage/' . $settings['logo']) }}" class="img-fluid" style="max-height: 80px;" />
                        </div>
                    @endif
                    <input type="file" class="filepond-logo" name="logo" accept="image/*">
                </div>

                <div class="mb-4 border-top border-secondary pt-3">
                    <h5 class="text-blue mb-3" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ Page Banners</h5>
                </div>

                <div class="mb-4">
                    <label class="form-label">Gallery Page Banner</label>
                    @if(isset($settings['gallery_banner_image']) && $settings['gallery_banner_image'])
                        <div class="mb-3 p-3 border rounded-3 text-center" style="background: rgba(255,255,255,0.01); border-color: rgba(255,255,255,0.05);">
                            <img src="{{ asset('storage/' . $settings['gallery_banner_image']) }}" class="img-fluid" style="max-height: 80px;" />
                        </div>
                    @endif
                    <input type="file" class="filepond-gallery-banner" name="gallery_banner_image" accept="image/*">
                </div>

                <div class="mb-4">
                    <label class="form-label">Services Page Banner</label>
                    @if(isset($settings['services_banner_image']) && $settings['services_banner_image'])
                        <div class="mb-3 p-3 border rounded-3 text-center" style="background: rgba(255,255,255,0.01); border-color: rgba(255,255,255,0.05);">
                            <img src="{{ asset('storage/' . $settings['services_banner_image']) }}" class="img-fluid" style="max-height: 80px;" />
                        </div>
                    @endif
                    <input type="file" class="filepond-services-banner" name="services_banner_image" accept="image/*">
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
            FilePond.registerPlugin(FilePondPluginImagePreview);

            const logoElement = document.querySelector('.filepond-logo');
            if (logoElement) {
                window.initCommonUploader(logoElement);
            }

            const galleryBannerElement = document.querySelector('.filepond-gallery-banner');
            if (galleryBannerElement) {
                window.initCommonUploader(galleryBannerElement);
            }

            const servicesBannerElement = document.querySelector('.filepond-services-banner');
            if (servicesBannerElement) {
                window.initCommonUploader(servicesBannerElement);
            }
        });
    </script>
@endsection
