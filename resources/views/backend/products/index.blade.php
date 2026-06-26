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
            <h2 class="admin-title">Products Management</h2>
            <p class="admin-subtitle">Add, edit, remove, and manage all corporate security products.</p>
        </div>
        <div>
            <a href="{{ route('admin.products.create') }}" class="btn btn-blue">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="me-2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Add Product
            </a>
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
        <table id="products-table" class="table">
            <thead>
                <tr>
                    <th width="60px">Image</th>
                    <th>Product Name</th>
                    <th>Slug</th>
                    <th>On Home</th>
                    <th>Status</th>
                    <th width="150px">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('admin_scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.products') }}",
                columns: [
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'slug', name: 'slug' },
                    { data: 'show_on_home', name: 'show_on_home', orderable: false, searchable: false },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[1, 'asc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search products…",
                    lengthMenu: "Show _MENU_ records",
                }
            });
        });

        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Delete Product?',
                text: `Are you sure you want to delete the product "${name}"?`,
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
