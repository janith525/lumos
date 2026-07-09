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
    </style>
@endsection

@section('admin_content')
    <div class="admin-header">
        <div>
            <h2 class="admin-title">Contact Page CMS</h2>
            <p class="admin-subtitle">Configure banner headers, lead intros, phone numbers, and operational hours.</p>
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
                <h5 class="text-blue mb-3" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ Banner & Lead Details</h5>
                
                <div class="mb-3">
                    <label class="form-label">Contact Banner Title</label>
                    <input type="text" name="contact_banner_title" class="form-control" value="{{ old('contact_banner_title', $settings['contact_banner_title'] ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Banner Background Image</label>
                    @if(isset($settings['contact_banner_image']) && $settings['contact_banner_image'])
                        <div class="mb-2 p-2 border rounded text-center bg-black border-secondary" style="max-width: 250px;">
                            <img src="{{ asset('storage/' . $settings['contact_banner_image']) }}" class="img-fluid rounded" style="max-height: 100px;" />
                        </div>
                    @endif
                    <input type="file" class="filepond-banner" name="contact_banner_image" accept="image/*">
                    <div class="form-text text-muted">Upload a banner image. Recommended aspect ratio 16:9 or 21:9.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Eyebrow</label>
                    <input type="text" name="contact_eyebrow" class="form-control" value="{{ old('contact_eyebrow', $settings['contact_eyebrow'] ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Title</label>
                    <input type="text" name="contact_title" class="form-control" value="{{ old('contact_title', $settings['contact_title'] ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Lead Narrative</label>
                    <textarea name="contact_lead" class="form-control" rows="2">{{ old('contact_lead', $settings['contact_lead'] ?? '') }}</textarea>
                </div>

                <h5 class="text-blue mt-4 mb-3" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ Office Desk Configurations</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sales Hotline Label</label>
                        <input type="text" name="contact_sales_lbl" class="form-control" value="{{ old('contact_sales_lbl', $settings['contact_sales_lbl'] ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sales Phone Number</label>
                        <input type="text" name="contact_sales_phone" class="form-control" value="{{ old('contact_sales_phone', $settings['contact_sales_phone'] ?? '') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sales Hours Info</label>
                    <input type="text" name="contact_sales_hours" class="form-control" value="{{ old('contact_sales_hours', $settings['contact_sales_hours'] ?? '') }}">
                </div>

                <div class="row mt-2">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Technical Support Label</label>
                        <input type="text" name="contact_support_lbl" class="form-control" value="{{ old('contact_support_lbl', $settings['contact_support_lbl'] ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Technical Support Phone</label>
                        <input type="text" name="contact_support_phone" class="form-control" value="{{ old('contact_support_phone', $settings['contact_support_phone'] ?? '') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Technical Support Hours</label>
                    <input type="text" name="contact_support_hours" class="form-control" value="{{ old('contact_support_hours', $settings['contact_support_hours'] ?? '') }}">
                </div>

                {{-- Location Maps & Addresses --}}
                <div class="card border-0 p-4 mb-3" style="background:rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07) !important; border-radius: 16px; margin-top: 2rem;">
                    <h5 class="text-blue mb-3" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ Factory Location Settings</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Factory Badge Label</label>
                            <input type="text" name="contact_factory_badge" class="form-control" value="{{ old('contact_factory_badge', $settings['contact_factory_badge'] ?? 'Design Studio') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Factory Title</label>
                            <input type="text" name="contact_factory_title" class="form-control" value="{{ old('contact_factory_title', $settings['contact_factory_title'] ?? 'Colombo 03, Sri Lanka') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Factory Full Address</label>
                        <textarea name="contact_factory_address" class="form-control" rows="3">{{ old('contact_factory_address', $settings['contact_factory_address'] ?? "No. 15, Galle Road,\nColombo 03,\nSri Lanka") }}</textarea>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Factory Google Map Embed URL</label>
                        <textarea name="contact_factory_map" class="form-control" rows="3" placeholder="https://www.google.com/maps/embed?...">{{ old('contact_factory_map', $settings['contact_factory_map'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.7!2d79.8499!3d6.9271!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2593f55555555%3A0x1!2sColombo+03!5e0!3m2!1sen!2slk!4v1700000000000') }}</textarea>
                        <span class="text-muted">Enter the raw <code>src</code> attribute link of the Google Maps iframe embed code.</span>
                    </div>
                </div>

                <div class="card border-0 p-4 mb-3" style="background:rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07) !important; border-radius: 16px; margin-top: 2rem;">
                    <h5 class="text-blue mb-3" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ Branch Location Settings</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Branch Badge Label</label>
                            <input type="text" name="contact_branch_badge" class="form-control" value="{{ old('contact_branch_badge', $settings['contact_branch_badge'] ?? 'Main Workshop') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Branch Title</label>
                            <input type="text" name="contact_branch_title" class="form-control" value="{{ old('contact_branch_title', $settings['contact_branch_title'] ?? 'Katana, Gampaha') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Branch Full Address</label>
                        <textarea name="contact_branch_address" class="form-control" rows="3">{{ old('contact_branch_address', $settings['contact_branch_address'] ?? "No. 81/B, Kaluwarippuwa,\nKatana, Gampaha,\nSri Lanka") }}</textarea>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Branch Google Map Embed URL</label>
                        <textarea name="contact_branch_map" class="form-control" rows="3" placeholder="https://www.google.com/maps/embed?...">{{ old('contact_branch_map', $settings['contact_branch_map'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.6!2d79.9862!3d7.1124!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2f8ae7adc3f31%3A0x1!2sKatana%2C+Gampaha!5e0!3m2!1sen!2slk!4v1700000000001') }}</textarea>
                        <span class="text-muted">Enter the raw <code>src</code> attribute link of the Google Maps iframe embed code.</span>
                    </div>
                </div>

                {{-- QR Code Settings --}}
                <div class="card border-0 p-4 mb-3" style="background:rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07) !important; border-radius: 16px; margin-top: 2rem;">
                    <h5 class="text-blue mb-3" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ QR Code Config</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">QR Card Title</label>
                            <input type="text" name="contact_qr_title" class="form-control" value="{{ old('contact_qr_title', $settings['contact_qr_title'] ?? 'Scan to Call') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">QR Data/Action</label>
                            <input type="text" name="contact_qr_data" class="form-control" value="{{ old('contact_qr_data', $settings['contact_qr_data'] ?? 'tel:+94771234567') }}">
                            <span class="text-muted">Target link or text. Fallback dynamic QR code uses this data (e.g. <code>tel:+94771234567</code>).</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">QR Description</label>
                        <input type="text" name="contact_qr_desc" class="form-control" value="{{ old('contact_qr_desc', $settings['contact_qr_desc'] ?? 'Quickly reach our design studio from your mobile device.') }}">
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Upload Custom QR Image (Optional)</label>
                        @if(isset($settings['contact_qr_image']) && $settings['contact_qr_image'])
                            <div class="mb-3 p-2 border rounded-3 text-center bg-black border-secondary" style="max-width: 200px;">
                                <img src="{{ asset('storage/' . $settings['contact_qr_image']) }}" class="img-fluid rounded" style="max-height: 120px;" />
                            </div>
                        @endif
                        <input type="file" class="filepond-qr-contact" name="contact_qr_image" accept="image/*">
                        <div class="form-text text-muted">Upload an image of your custom QR code. Leave blank to automatically generate one from the QR data.</div>
                    </div>
                </div>

                {{-- SEO / Meta --}}
                <div class="card border-0 p-4 mb-3" style="background:rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07) !important; border-radius: 16px; margin-top: 2rem;">
                    <h5 class="text-blue mb-3" style="font-size:14px; font-weight:700; text-transform:uppercase;">✦ SEO &amp; Meta</h5>

                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="contact_meta_title" class="form-control" value="{{ old('contact_meta_title', $settings['contact_meta_title'] ?? '') }}" placeholder="Contact us | Lumos Nursery Studio">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="contact_meta_description" class="form-control" rows="3" placeholder="Short description for search engines (max 155 chars)">{{ old('contact_meta_description', $settings['contact_meta_description'] ?? '') }}</textarea>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">OG Image (Social Preview)</label>
                        @if(isset($settings['contact_og_image']) && $settings['contact_og_image'])
                            <div class="mb-3 p-2 border rounded-3 text-center bg-black border-secondary" style="max-width: 200px;">
                                <img src="{{ asset('storage/' . $settings['contact_og_image']) }}" class="img-fluid rounded" style="max-height: 120px;" />
                            </div>
                        @endif
                        <input type="file" class="filepond-og-contact" name="contact_og_image" accept="image/*">
                        <div class="form-text text-muted">URL of the social sharing preview image.</div>
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
            const ogContactImg = document.querySelector('.filepond-og-contact');
            if (ogContactImg) {
                window.initCommonUploader(ogContactImg);
            }
            const bannerImg = document.querySelector('.filepond-banner');
            if (bannerImg) {
                window.initCommonUploader(bannerImg);
            }
            const qrContactImg = document.querySelector('.filepond-qr-contact');
            if (qrContactImg) {
                window.initCommonUploader(qrContactImg);
            }
        });
    </script>
@endsection
