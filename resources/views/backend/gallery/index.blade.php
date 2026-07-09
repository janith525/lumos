@extends('backend.layout')

@section('admin_css')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/jquery.dataTables.min.css') }}">
    <style>
        .dataTables_wrapper {
            background: rgba(255, 255, 255, 0.01);
            color: #e2e8f0;
            padding: 24px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.04);
        }
        table.dataTable {
            border-collapse: separate !important;
            border-spacing: 0 12px !important;
            margin-top: 15px !important;
            margin-bottom: 20px !important;
            border: none !important;
            background: transparent !important;
            width: 100% !important;
        }
        table.dataTable thead th {
            border: none !important;
            color: #94a3b8 !important;
            font-weight: 700 !important;
            font-size: 12px !important;
            text-transform: uppercase !important;
            padding: 14px 20px !important;
            background: transparent !important;
        }
        table.dataTable tbody tr {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            transition: all 0.3s ease;
        }
        table.dataTable tbody tr:hover {
            background: rgba(59, 130, 246, 0.05) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        table.dataTable tbody td {
            border: none !important;
            padding: 16px 20px !important;
            vertical-align: middle !important;
            color: #e2e8f0;
            background: transparent !important;
        }
        table.dataTable tbody td:first-child {
            border-top-left-radius: 14px !important;
            border-bottom-left-radius: 14px !important;
        }
        table.dataTable tbody td:last-child {
            border-top-right-radius: 14px !important;
            border-bottom-right-radius: 14px !important;
        }
        .dataTables_filter input {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1.5px solid rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
            border-radius: 12px !important;
            padding: 10px 18px !important;
            outline: none !important;
            transition: all 0.3s;
            margin-left: 12px !important;
            font-size: 14px;
            width: 250px !important;
        }
        .dataTables_paginate .paginate_button {
            border-radius: 10px !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            background: rgba(255, 255, 255, 0.02) !important;
            color: #94a3b8 !important;
            margin: 0 4px !important;
            padding: 8px 16px !important;
        }
        .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, var(--color-blue) 0%, var(--color-blue-dark) 100%) !important;
            color: #ffffff !important;
            border: 1px solid var(--color-blue) !important;
        }

        /* Modal Form styling */
        .form-label {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
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
        select.form-control option {
            background-color: #0f172a;
            color: #ffffff;
        }
        .form-text {
            color: rgba(148, 163, 184, 0.45) !important;
            font-size: 11px;
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
            <h2 class="admin-title">Gallery Showcase Management</h2>
            <p class="admin-subtitle">Add, edit, remove, and manage all showcase nursery, furniture, and backdrop images.</p>
        </div>
        <div>
            <button type="button" class="btn btn-blue" onclick="openCreateModal()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="me-2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Add Gallery Item
            </button>
        </div>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "{{ session('success') }}",
                    background: '#090d16',
                    color: '#ffffff',
                    confirmButtonColor: '#3b82f6'
                });
            });
        </script>
    @endif

    <div class="table-responsive">
        <table id="gallery-table" class="table">
            <thead>
                <tr>
                    <th width="60px">Image</th>
                    <th>Item Title</th>
                    <th>Category</th>
                    <th>Show on Home</th>
                    <th>Type</th>
                    <th width="150px">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('admin_modals')
<!-- ADD/EDIT GALLERY CARD MODAL -->
<div class="modal fade" id="galleryItemModal" tabindex="-1" aria-labelledby="galleryItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark border-secondary text-white" style="border-radius: 20px;">
            <form id="gallery-item-form" action="{{ route('admin.gallery.store') }}" method="POST">
                @csrf
                <div id="method-container"></div>

                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-blue" id="galleryModalTitle">Add Gallery Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <!-- Left side inputs -->
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label">Item Title *</label>
                                <input type="text" name="title" id="item-title" class="form-control" required placeholder="e.g. Royal Pastel Nursery">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Subtitle / Location Label</label>
                                <input type="text" name="subtitle" id="item-subtitle" class="form-control" placeholder="e.g. Completed Nursery | Colombo 07">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category *</label>
                                    <select name="category" id="item-category" class="form-control" required>
                                        <option value="" disabled selected>Select Category</option>
                                        <option value="nursery">Baby Nursery</option>
                                        <option value="furniture">Bespoke Furniture</option>
                                        <option value="playroom">Kids Playroom</option>
                                        <option value="backdrop">Backdrop & Decor</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Item Type *</label>
                                    <select name="type" id="item-type" class="form-control" required>
                                        <option value="review">Client Review</option>
                                        <option value="social">Social Showcase</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Review Section --}}
                            <div class="card border-0 p-3 mb-3 bg-black border-secondary" id="review-card" style="border-radius: 12px;">
                                <h6 class="text-blue mb-3" style="font-size:12px; font-weight:700; text-transform:uppercase;">✦ Review details</h6>
                                <div class="row">
                                    <div class="col-md-7 mb-2">
                                        <label class="form-label" style="font-size:11px;">Client Name (Author)</label>
                                        <input type="text" name="review_author" id="item-author" class="form-control py-2" placeholder="e.g. Dilani S.">
                                    </div>
                                    <div class="col-md-5 mb-2">
                                        <label class="form-label" style="font-size:11px;">Star Rating</label>
                                        <select name="stars" id="item-stars" class="form-control py-2" style="background:#1e2738; color:#fff; border: 1.5px solid rgba(255,255,255,0.08);">
                                            <option value="5">5 Stars</option>
                                            <option value="4">4 Stars</option>
                                            <option value="3">3 Stars</option>
                                            <option value="2">2 Stars</option>
                                            <option value="1">1 Star</option>
                                            <option value="0">No Stars</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-0">
                                <label class="form-label" id="desc-label">Review / Caption Copy</label>
                                <textarea name="review_content" id="item-content" class="form-control" rows="3" placeholder="Detail the description or review here..."></textarea>
                            </div>
                        </div>

                        <!-- Right side uploaders and toggles -->
                        <div class="col-md-5">
                            <div class="card border-0 p-3 mb-3 bg-black border-secondary" style="border-radius: 12px;">
                                <h6 class="text-blue mb-2" style="font-size:12px; font-weight:700; text-transform:uppercase;">✦ Status &amp; Sorting</h6>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="show_on_home" value="1" id="item-show-on-home">
                                    <label class="form-check-label text-white ms-2" for="item-show-on-home" style="font-size:12px; font-weight:600;">Show on Home</label>
                                </div>
                                <div>
                                    <label class="form-label" style="font-size:11px;">Sort Order</label>
                                    <input type="number" name="sort_order" id="item-sort-order" class="form-control py-2" value="0" min="0">
                                </div>
                            </div>

                            <div class="card border-0 p-3 mb-0 bg-black border-secondary" style="border-radius: 12px;">
                                <h6 class="text-blue mb-3" style="font-size:12px; font-weight:700; text-transform:uppercase;">✦ Photos</h6>
                                
                                <div class="mb-3">
                                    <label class="form-label" style="font-size:11px;">Primary Image *</label>
                                    <div id="modal-existing-primary" class="mb-2" style="display:none;"></div>
                                    <input type="file" class="filepond-primary" name="image" accept="image/*">
                                </div>

                                <div class="mb-0">
                                    <label class="form-label" style="font-size:11px;">Slider Images</label>
                                    <div id="modal-existing-gallery" class="mb-2" style="display:none;"></div>
                                    <input type="file" class="filepond-gallery" name="images[]" multiple accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary px-3 text-white" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-blue px-4 text-white" id="modal-submit-btn">Save Item</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('admin_scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/common-uploader.js') }}"></script>
    <script>
        let primaryPond = null;
        let galleryPond = null;

        $(document).ready(function() {
            // Initialize DataTable
            $('#gallery-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.gallery') }}",
                columns: [
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'title', name: 'title' },
                    { data: 'category', name: 'category' },
                    { data: 'show_on_home', name: 'show_on_home' },
                    { data: 'type', name: 'type' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[1, 'asc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search gallery items…",
                    lengthMenu: "Show _MENU_ records",
                }
            });

            // Initialize FilePonds
            FilePond.registerPlugin(FilePondPluginImagePreview);

            const primaryElement = document.querySelector('.filepond-primary');
            if (primaryElement) {
                primaryPond = window.initCommonUploader(primaryElement);
            }

            const galleryElement = document.querySelector('.filepond-gallery');
            if (galleryElement) {
                galleryPond = window.initCommonUploader(galleryElement, { allowMultiple: true });
            }

            // Conditional view handling for type select
            const typeSelect = document.getElementById('item-type');
            typeSelect.addEventListener('change', toggleType);
        });

        function toggleType() {
            const typeSelect = document.getElementById('item-type');
            const reviewCard = document.getElementById('review-card');
            const descLabel = document.getElementById('desc-label');

            if (typeSelect.value === 'social') {
                reviewCard.style.display = 'none';
                descLabel.innerText = 'Showcase Caption Description';
            } else {
                reviewCard.style.display = 'block';
                descLabel.innerText = 'Review / Caption Copy';
            }
        }

        function openCreateModal() {
            const form = document.getElementById('gallery-item-form');
            form.action = "{{ route('admin.gallery.store') }}";
            
            // Remove PUT override
            document.getElementById('method-container').innerHTML = '';

            // Reset inputs
            form.reset();
            
            // Clear FilePonds
            if (primaryPond) primaryPond.removeFiles();
            if (galleryPond) galleryPond.removeFiles();

            // Clear previews
            document.getElementById('modal-existing-primary').style.display = 'none';
            document.getElementById('modal-existing-primary').innerHTML = '';
            document.getElementById('modal-existing-gallery').style.display = 'none';
            document.getElementById('modal-existing-gallery').innerHTML = '';

            document.getElementById('galleryModalTitle').innerText = 'Add Gallery Item';
            document.getElementById('modal-submit-btn').innerText = 'Create Item';
            
            toggleType();

            // Open Bootstrap Modal
            var myModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('galleryItemModal'));
            myModal.show();
        }

        function editItem(id) {
            fetch(`/admin/gallery/${id}/edit`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(res => {
                if (res.success) {
                    const item = res.data;
                    const form = document.getElementById('gallery-item-form');
                    form.action = `/admin/gallery/${id}`;

                    // Set PUT override
                    document.getElementById('method-container').innerHTML = '<input type="hidden" name="_method" value="PUT">';

                    // Set field values
                    document.getElementById('item-title').value = item.title;
                    document.getElementById('item-subtitle').value = item.subtitle || '';
                    document.getElementById('item-category').value = item.category;
                    document.getElementById('item-type').value = item.type;
                    document.getElementById('item-author').value = item.review_author || '';
                    document.getElementById('item-stars').value = item.stars || 5;
                    document.getElementById('item-content').value = item.review_content || '';
                    document.getElementById('item-sort-order').value = item.sort_order || 0;
                    document.getElementById('item-show-on-home').checked = !!item.show_on_home;

                    // Clear fileponds
                    if (primaryPond) primaryPond.removeFiles();
                    if (galleryPond) galleryPond.removeFiles();

                    // Render existing primary image preview
                    const primaryContainer = document.getElementById('modal-existing-primary');
                    if (item.primary_image_url) {
                        primaryContainer.innerHTML = `
                            <div class="p-2 border rounded text-center bg-black border-secondary" style="max-width: 150px;">
                                <img src="${item.primary_image_url}" class="img-fluid rounded" style="max-height: 80px;" />
                            </div>
                        `;
                        primaryContainer.style.display = 'block';
                    } else {
                        primaryContainer.style.display = 'none';
                        primaryContainer.innerHTML = '';
                    }

                    // Render existing secondary images keep-grid
                    const galleryContainer = document.getElementById('modal-existing-gallery');
                    if (item.gallery_image_urls && item.gallery_image_urls.length > 0) {
                        let imagesHtml = `
                            <span class="text-white-50 small d-block mb-2">Check to KEEP existing gallery images:</span>
                            <div class="row g-2">
                        `;
                        item.images.forEach(img => {
                            imagesHtml += `
                                <div class="col-4 position-relative">
                                    <img src="/storage/${img}" class="img-fluid rounded" style="height: 50px; width: 100%; object-fit: cover;" />
                                    <div class="position-absolute top-0 start-0 p-1">
                                        <input class="form-check-input" type="checkbox" name="keep_images[]" value="${img}" checked>
                                    </div>
                                </div>
                            `;
                        });
                        imagesHtml += `</div>`;
                        galleryContainer.innerHTML = imagesHtml;
                        galleryContainer.style.display = 'block';
                    } else {
                        galleryContainer.style.display = 'none';
                        galleryContainer.innerHTML = '';
                    }

                    document.getElementById('galleryModalTitle').innerText = 'Edit Gallery Item';
                    document.getElementById('modal-submit-btn').innerText = 'Update Item';
                    
                    toggleType();

                    // Open Bootstrap Modal
                    var myModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('galleryItemModal'));
                    myModal.show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Unable to fetch gallery item details.',
                        background: '#090d16',
                        color: '#ffffff'
                    });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while fetching details.',
                    background: '#090d16',
                    color: '#ffffff'
                });
            });
        }

        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Delete Gallery Item?',
                text: `Are you sure you want to delete the gallery item "${name}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#718096',
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel',
                background: '#090d16',
                color: '#ffffff'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }
    </script>
@endsection
