@extends('backend.layout')

@section('admin_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
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
            letter-spacing: 1px !important;
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
            font-weight: 700;
            color: #ffffff;
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
        .dataTables_filter input:focus {
            border-color: var(--color-blue) !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        }
        .dataTables_paginate .paginate_button {
            border-radius: 10px !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            background: rgba(255, 255, 255, 0.02) !important;
            color: #94a3b8 !important;
            margin: 0 4px !important;
            padding: 8px 16px !important;
            transition: all 0.3s !important;
        }
        .dataTables_paginate .paginate_button:hover {
            border-color: var(--color-blue) !important;
            background: rgba(59, 130, 246, 0.1) !important;
            color: var(--color-blue) !important;
        }
        .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, var(--color-blue) 0%, var(--color-blue-dark) 100%) !important;
            color: #ffffff !important;
            border: 1px solid var(--color-blue) !important;
        }
    </style>
@endsection

@section('admin_content')
    <div class="admin-header">
        <div>
            <h2 class="admin-title">Quotes & Inquiries</h2>
            <p class="admin-subtitle">View and manage client quote inquiries received through the website.</p>
        </div>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted',
                    text: "{{ session('success') }}",
                    background: '#090d16',
                    color: '#ffffff',
                    confirmButtonColor: '#3b82f6'
                });
            });
        </script>
    @endif

    <div class="table-responsive">
        <table id="quotes-table" class="table">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Email Address</th>
                    <th>Phone</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th width="100px">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('admin_modals')
    <!-- View Quote Modal -->
    <div class="modal fade" id="viewQuoteModal" tabindex="-1" aria-labelledby="viewQuoteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="background: #090d16; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; color: #ffffff;">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="viewQuoteModalLabel" style="font-size: 20px;">Inquiry & Quote Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="small text-muted fw-semibold text-uppercase tracking-wider">Client Name</label>
                            <p id="view-name" class="fs-5 fw-bold text-white mb-0 mt-1"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted fw-semibold text-uppercase tracking-wider">Submit Date</label>
                            <p id="view-date" class="fs-6 text-light mb-0 mt-1"></p>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="small text-muted fw-semibold text-uppercase tracking-wider">Email Address</label>
                            <p class="mb-0 mt-1">
                                <a id="view-email-link" href="" class="text-primary hover-underline fs-6" style="text-decoration: none; color: #3b82f6;"></a>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted fw-semibold text-uppercase tracking-wider">Phone Number</label>
                            <p id="view-phone" class="fs-6 text-light mb-0 mt-1"></p>
                        </div>

                        <div class="col-12" id="view-products-container">
                            <label class="small text-muted fw-semibold text-uppercase tracking-wider">Products of Interest</label>
                            <div id="view-products-list" class="d-flex flex-wrap gap-2 mt-2"></div>
                        </div>

                        <div class="col-12">
                            <label class="small text-muted fw-semibold text-uppercase tracking-wider">Message Content</label>
                            <div class="p-3 rounded-3 mt-2" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255,255,255,0.05); max-height: 250px; overflow-y: auto;">
                                <p id="view-message" class="mb-0 text-light small" style="white-space: pre-wrap; line-height: 1.6;"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <a id="view-reply-btn" href="" class="btn btn-primary px-4 py-2" style="border-radius: 8px; font-weight: 600; background-color: #3b82f6; border-color: #3b82f6;">
                        Reply via Email
                    </a>
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600; border-color: rgba(255,255,255,0.15); color: #94a3b8; background: transparent;">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin_scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#quotes-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.quotes') }}",
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone', defaultContent: '-' },
                    { data: 'message', name: 'message', orderable: false },
                    { data: 'created_at', name: 'created_at', render: function(data) {
                        return new Date(data).toLocaleDateString();
                    }},
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[4, 'desc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search inquiries…",
                    lengthMenu: "Show _MENU_ records",
                }
            });
        });

        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Delete Quote Request?',
                text: `Are you sure you want to delete the quote inquiry from ${name}?`,
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

        function showQuoteDetails(data) {
            document.getElementById('view-name').textContent = data.name;
            document.getElementById('view-date').textContent = new Date(data.created_at).toLocaleString();
            
            const emailLink = document.getElementById('view-email-link');
            emailLink.textContent = data.email;
            emailLink.href = 'mailto:' + data.email;
            
            document.getElementById('view-phone').textContent = data.phone;
            
            const productsContainer = document.getElementById('view-products-container');
            const productsList = document.getElementById('view-products-list');
            productsList.innerHTML = '';
            
            if (data.product_titles && data.product_titles.length > 0) {
                productsContainer.classList.remove('d-none');
                data.product_titles.forEach(title => {
                    const badge = document.createElement('span');
                    badge.className = 'badge bg-primary text-white px-3 py-2 fw-semibold';
                    badge.style.borderRadius = '20px';
                    badge.style.fontSize = '12px';
                    badge.textContent = title;
                    productsList.appendChild(badge);
                });
            } else {
                productsContainer.classList.add('d-none');
            }
            
            document.getElementById('view-message').textContent = data.message;
            document.getElementById('view-reply-btn').href = 'mailto:' + data.email + '?subject=' + encodeURIComponent('Response regarding Blue Ridge Inquiry');

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('viewQuoteModal'));
            modal.show();
        }
    </script>
@endsection
