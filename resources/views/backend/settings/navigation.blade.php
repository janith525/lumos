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
        .text-muted {
            color: #94a3b8 !important;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }
        
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
        
        .link-item {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 14px 20px;
            margin-bottom: 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .link-item:hover {
            background: rgba(59, 130, 246, 0.03);
            border-color: rgba(59, 130, 246, 0.2);
        }
        .link-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .link-badge {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.2);
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: bold;
        }
        .link-url {
            color: #64748b;
            font-size: 13px;
            font-family: monospace;
        }
    </style>
@endsection

@section('admin_content')
    <div class="admin-header">
        <div>
            <h2 class="admin-title">Header & Footer CMS</h2>
            <p class="admin-subtitle">Customize main website header links, hotline, social platforms, and footer navigation links.</p>
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

    <form id="navigationForm" action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <!-- HEADER SOCIAL & META -->
        <div class="card cms-card">
            <div class="cms-card-header">
                <h5 class="text-blue-custom mb-0">Header Metadata & Socials</h5>
            </div>
            <div class="card-body p-4 bg-dark">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Header Hotline / Phone</label>
                        <input type="text" name="header_hotline" class="form-control" value="{{ old('header_hotline', $settings['header_hotline'] ?? '070 791 7918') }}">
                        <span class="text-muted">Displayed in the top bar and mobile navigation.</span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Header Address / Location</label>
                        <input type="text" name="header_address" class="form-control" value="{{ old('header_address', $settings['header_address'] ?? 'Gampaha, Sri Lanka') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Facebook Link</label>
                        <input type="text" name="header_facebook" class="form-control" value="{{ old('header_facebook', $settings['header_facebook'] ?? '#') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">LinkedIn Link</label>
                        <input type="text" name="header_linkedin" class="form-control" value="{{ old('header_linkedin', $settings['header_linkedin'] ?? '#') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Instagram Link</label>
                        <input type="text" name="header_instagram" class="form-control" value="{{ old('header_instagram', $settings['header_instagram'] ?? '#') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- HEADER MENU LINKS -->
        <div class="card cms-card">
            <div class="cms-card-header d-flex justify-content-between align-items-center">
                <h5 class="text-blue-custom mb-0">Header Navigation Menu Links</h5>
                <button type="button" class="btn btn-blue btn-sm" onclick="openLinkModal('header')">
                    + Add Header Link
                </button>
            </div>
            <div class="card-body p-4 bg-dark">
                <div id="header-links-container">
                    <!-- Rendered via Javascript -->
                </div>
                <input type="hidden" name="header_links" id="header_links_input" value="{{ old('header_links', $settings['header_links'] ?? '') }}">
            </div>
        </div>

        <!-- FOOTER MENU LINKS -->
        <div class="card cms-card">
            <div class="cms-card-header d-flex justify-content-between align-items-center">
                <h5 class="text-blue-custom mb-0">Footer Navigation Menu Links</h5>
                <button type="button" class="btn btn-blue btn-sm" onclick="openLinkModal('footer')">
                    + Add Footer Link
                </button>
            </div>
            <div class="card-body p-4 bg-dark">
                <div id="footer-links-container">
                    <!-- Rendered via Javascript -->
                </div>
                <input type="hidden" name="footer_links" id="footer_links_input" value="{{ old('footer_links', $settings['footer_links'] ?? '') }}">
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-blue py-3 px-5">Save Configurations</button>
        </div>
    </form>
@endsection

@section('admin_modals')
<!-- ADD/EDIT LINK MODAL -->
<div class="modal fade" id="linkModal" tabindex="-1" aria-labelledby="linkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white" style="border-radius: 20px;">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-blue" id="linkModalTitle">Add Navigation Link</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="link_type" value="header">
                <input type="hidden" id="link_index" value="-1">

                <div class="mb-3">
                    <label class="form-label text-blue fw-bold">Link Label / Text</label>
                    <input type="text" id="link_label" class="form-control bg-black text-white border-secondary p-3" placeholder="e.g. Products">
                </div>

                <div class="mb-3">
                    <label class="form-label text-blue fw-bold">Link URL</label>
                    <input type="text" id="link_url" class="form-control bg-black text-white border-secondary p-3" placeholder="e.g. @{{SITE_URL}}/products or https://example.com">
                    <span class="text-muted">Use <code>@{{SITE_URL}}</code> for local routes, or enter full external URL.</span>
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-outline-secondary px-3 text-white" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-blue px-4 text-white fw-bold" onclick="saveLink()">Apply Link</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('admin_scripts')
    <script>
        let headerLinks = [];
        let footerLinks = [];

        const defaultHeader = [
            { label: 'Home', url: '@{{SITE_URL}}/home' },
            { label: 'About', url: '@{{SITE_URL}}/about' },
            { label: 'Services & Products', url: '@{{SITE_URL}}/services' },
            { label: 'Contact', url: '@{{SITE_URL}}/contact' }
        ];

        const defaultFooter = [
            { label: 'Home', url: '@{{SITE_URL}}/home' },
            { label: 'About', url: '@{{SITE_URL}}/about' },
            { label: 'Services & Products', url: '@{{SITE_URL}}/services' },
            { label: 'Contact', url: '@{{SITE_URL}}/contact' }
        ];

        document.addEventListener('DOMContentLoaded', function() {
            try {
                headerLinks = JSON.parse(document.getElementById('header_links_input').value || 'null') || defaultHeader;
            } catch (e) {
                headerLinks = defaultHeader;
            }

            try {
                footerLinks = JSON.parse(document.getElementById('footer_links_input').value || 'null') || defaultFooter;
            } catch (e) {
                footerLinks = defaultFooter;
            }

            renderLinks('header');
            renderLinks('footer');
        });

        function renderLinks(type) {
            const list = type === 'header' ? headerLinks : footerLinks;
            const container = document.getElementById(`${type}-links-container`);
            const input = document.getElementById(`${type}_links_input`);

            container.innerHTML = '';

            if (list.length === 0) {
                container.innerHTML = `
                    <div class="text-center p-4 text-muted border border-secondary" style="border-radius: 12px; background: rgba(0,0,0,0.1);">
                        No links configured. Click "Add Link" to create one.
                    </div>
                `;
                input.value = '[]';
                return;
            }

            list.forEach((item, index) => {
                const row = document.createElement('div');
                row.className = 'link-item';
                row.innerHTML = `
                    <div class="link-info">
                        <span class="link-badge">${escapeHtml(item.label)}</span>
                        <span class="link-url">${escapeHtml(item.url)}</span>
                    </div>
                    <div class="d-inline-flex gap-1 align-items-center">
                        ${index > 0 ? `<button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2.5 text-white" onclick="moveLinkUp('${type}', ${index})">↑</button>` : ''}
                        ${index < list.length - 1 ? `<button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2.5 text-white" onclick="moveLinkDown('${type}', ${index})">↓</button>` : ''}
                        <button type="button" class="btn btn-sm btn-outline-primary py-1 px-3 text-white" onclick="editLink('${type}', ${index})">Edit</button>
                        <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2 text-danger" onclick="removeLink('${type}', ${index})">&times;</button>
                    </div>
                `;
                container.appendChild(row);
            });

            input.value = JSON.stringify(list);
        }

        function openLinkModal(type) {
            document.getElementById('link_type').value = type;
            document.getElementById('link_index').value = -1;
            document.getElementById('link_label').value = '';
            document.getElementById('link_url').value = '';
            document.getElementById('linkModalTitle').innerText = `Add ${type === 'header' ? 'Header' : 'Footer'} Link`;
            new bootstrap.Modal(document.getElementById('linkModal')).show();
        }

        function editLink(type, index) {
            const list = type === 'header' ? headerLinks : footerLinks;
            const item = list[index];

            document.getElementById('link_type').value = type;
            document.getElementById('link_index').value = index;
            document.getElementById('link_label').value = item.label;
            document.getElementById('link_url').value = item.url;
            document.getElementById('linkModalTitle').innerText = `Edit ${type === 'header' ? 'Header' : 'Footer'} Link`;
            new bootstrap.Modal(document.getElementById('linkModal')).show();
        }

        function saveLink() {
            const type = document.getElementById('link_type').value;
            const index = parseInt(document.getElementById('link_index').value);
            const label = document.getElementById('link_label').value.trim();
            const url = document.getElementById('link_url').value.trim();

            if (!label || !url) {
                alert('Both Label and URL are required.');
                return;
            }

            const list = type === 'header' ? headerLinks : footerLinks;
            const item = { label, url };

            if (index === -1) {
                list.push(item);
            } else {
                list[index] = item;
            }

            renderLinks(type);

            const modalEl = document.getElementById('linkModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
        }

        function removeLink(type, index) {
            const list = type === 'header' ? headerLinks : footerLinks;
            if (confirm('Are you sure you want to remove this navigation link?')) {
                list.splice(index, 1);
                renderLinks(type);
            }
        }

        function moveLinkUp(type, index) {
            const list = type === 'header' ? headerLinks : footerLinks;
            if (index > 0) {
                const temp = list[index];
                list[index] = list[index - 1];
                list[index - 1] = temp;
                renderLinks(type);
            }
        }

        function moveLinkDown(type, index) {
            const list = type === 'header' ? headerLinks : footerLinks;
            if (index < list.length - 1) {
                const temp = list[index];
                list[index] = list[index + 1];
                list[index + 1] = temp;
                renderLinks(type);
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
