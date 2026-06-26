@extends('backend.layout')

@section('admin_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <style>
        /* Modern Dark Glassmorphic DataTables Custom Styling */
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
        
        /* Search Filter Overrides */
        .dataTables_filter {
            margin-bottom: 20px !important;
        }
        .dataTables_filter label {
            color: #94a3b8 !important;
            font-weight: 600;
            font-size: 14px;
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
            background: rgba(255, 255, 255, 0.05) !important;
        }
        
        /* Length Menu Overrides */
        .dataTables_length {
            margin-bottom: 20px !important;
        }
        .dataTables_length label {
            color: #94a3b8 !important;
            font-weight: 600;
            font-size: 14px;
        }
        .dataTables_length select {
            background: #090d16 !important;
            border: 1.5px solid rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
            border-radius: 10px !important;
            padding: 8px 14px !important;
            outline: none !important;
            margin: 0 8px !important;
            cursor: pointer;
        }
        
        /* Pagination Overrides */
        .dataTables_paginate {
            padding-top: 15px !important;
        }
        .dataTables_paginate .paginate_button {
            border-radius: 10px !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            background: rgba(255, 255, 255, 0.02) !important;
            color: #94a3b8 !important;
            margin: 0 4px !important;
            padding: 8px 16px !important;
            transition: all 0.3s !important;
            font-weight: 600 !important;
        }
        .dataTables_paginate .paginate_button:hover {
            border-color: var(--color-blue) !important;
            background: rgba(59, 130, 246, 0.1) !important;
            color: var(--color-blue) !important;
        }
        .dataTables_paginate .paginate_button.current, .dataTables_paginate .paginate_button.current:hover {
            background: linear-gradient(135deg, var(--color-blue) 0%, var(--color-blue-dark) 100%) !important;
            color: #ffffff !important;
            border: 1px solid var(--color-blue) !important;
            box-shadow: 0 4px 15px var(--color-blue-glow) !important;
        }
        .dataTables_paginate .paginate_button.disabled, .dataTables_paginate .paginate_button.disabled:hover {
            background: rgba(255, 255, 255, 0.01) !important;
            color: #475569 !important;
            border-color: rgba(255, 255, 255, 0.03) !important;
        }
        .dataTables_info {
            color: #94a3b8 !important;
            font-size: 13px !important;
            padding-top: 20px !important;
        }

        /* Permission checkboxes in modal */
        .perm-group-block {
            margin-bottom: 22px;
        }
        .perm-group-title {
            font-size: 11px;
            font-weight: 700;
            color: var(--color-blue);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid rgba(59, 130, 246, 0.15);
        }
        .perm-checkboxes {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .perm-check-item {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.02);
            border: 1.5px solid rgba(255,255,255,0.07);
            border-radius: 10px;
            padding: 8px 14px;
            cursor: pointer;
            transition: all 0.25s;
        }
        .perm-check-item:hover {
            border-color: rgba(59, 130, 246, 0.3);
            background: rgba(59, 130, 246, 0.04);
        }
        .perm-check-item input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: var(--color-blue);
            cursor: pointer;
        }
        .perm-check-item label {
            font-size: 13px;
            color: #cbd5e0;
            cursor: pointer;
            margin: 0;
            text-transform: capitalize;
        }
        .perm-check-item input:checked + label {
            color: #ffffff;
            font-weight: 600;
        }
        .select-all-group {
            font-size: 10px;
            font-weight: 700;
            color: #94a3b8;
            cursor: pointer;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            float: right;
            transition: color 0.2s;
        }
        .select-all-group:hover { color: var(--color-blue); }
    </style>
@endsection

@section('admin_content')
    <div class="admin-header">
        <div>
            <h2 class="admin-title">Roles & Permissions</h2>
            <p class="admin-subtitle">Create roles and configure their access to backend modules and features.</p>
        </div>
        <div class="d-flex gap-3 flex-wrap">
            <button id="btn-export-roles" class="btn btn-blue px-4 py-3" style="background: rgba(59, 130, 246, 0.12) !important; border: 1.5px solid rgba(59, 130, 246, 0.4) !important; color: var(--color-blue) !important; box-shadow: none !important;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="me-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Download CSV
            </button>
            <button class="btn btn-blue" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="me-2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Create Role
            </button>
        </div>
    </div>

    <!-- Roles DataTable -->
    <div class="table-responsive">
        <table id="roles-table" class="table">
            <thead>
                <tr>
                    <th>Role Name</th>
                    <th>Users Assigned</th>
                    <th width="170px">Actions</th>
                </tr>
                <tr class="column-search-row">
                    <th><input type="text" class="col-search-input" placeholder="Search role…"></th>
                    <th><input type="text" class="col-search-input" placeholder="Search users…"></th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('admin_modals')
    {{-- Create Role Modal --}}
    <div class="modal fade" id="createRoleModal" tabindex="-1" aria-hidden="true" style="background: rgba(0,0,0,0.85);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: #090d16; border: 1.5px solid var(--color-blue); border-radius: 24px; color: #ffffff;">
                <div class="modal-header border-0 pb-0 d-flex justify-content-between align-items-center" style="padding: 24px 32px 10px;">
                    <h4 style="color: var(--color-blue); font-size: 18px; margin: 0; text-transform: uppercase; font-weight: 700;">Create New Role</h4>
                    <button type="button" data-bs-dismiss="modal" style="background: none; border: none; color: white; cursor: pointer;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <div class="modal-body" style="padding: 10px 32px 32px;">
                    <form id="create-role-form" action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf
                        <div class="form-group-admin">
                            <label for="create_role_name">Role Name</label>
                            <input type="text" id="create_role_name" name="name" class="form-control w-100" required placeholder="e.g. Content Manager">
                        </div>
                        <button type="submit" class="btn btn-blue w-100 py-3 mt-2" style="justify-content: center;">
                            Create Role
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Role & Permissions Modal --}}
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true" style="background: rgba(0,0,0,0.85);">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="background: #090d16; border: 1.5px solid var(--color-blue); border-radius: 24px; color: #ffffff;">
                <div class="modal-header border-0 pb-0 d-flex justify-content-between align-items-center" style="padding: 24px 32px 10px;">
                    <h4 style="color: var(--color-blue); font-size: 18px; margin: 0; text-transform: uppercase; font-weight: 700;">Edit Role: <span id="edit_role_title">—</span></h4>
                    <button type="button" data-bs-dismiss="modal" style="background: none; border: none; color: white; cursor: pointer;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <div class="modal-body" style="padding: 10px 32px 32px; max-height: 75vh; overflow-y: auto;">
                    <form id="edit-role-form" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group-admin mb-4">
                            <label for="edit_role_name">Role Name</label>
                            <input type="text" id="edit_role_name" name="name" class="form-control w-100" required>
                        </div>

                        <div class="perm-group-title mb-3" style="font-size: 13px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">
                            Backend Module Access
                        </div>

                        @foreach($permissions as $group => $groupPerms)
                            <div class="perm-group-block">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="perm-group-title mb-0">{{ $group }}</div>
                                    <span class="select-all-group" data-group="{{ $loop->index }}">Select All</span>
                                </div>
                                <div class="perm-checkboxes" data-group-index="{{ $loop->index }}">
                                    @foreach($groupPerms as $perm)
                                        <div class="perm-check-item">
                                            <input type="checkbox"
                                                name="permissions[]"
                                                id="perm_{{ $perm->id }}"
                                                value="{{ $perm->name }}"
                                                class="perm-checkbox perm-group-{{ $loop->parent->index }}">
                                            <label for="perm_{{ $perm->id }}">{{ $perm->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-blue w-100 py-3 mt-3" style="justify-content: center;">
                            Save Permissions
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin_scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <style>
        .column-search-row th { padding: 0 !important; }
        .col-search-input {
            width: 100%;
            background: rgba(255,255,255,0.04) !important;
            border: 1.5px solid rgba(255,255,255,0.08) !important;
            border-radius: 8px !important;
            color: #fff !important;
            font-size: 12px !important;
            padding: 8px 12px !important;
            outline: none !important;
            transition: border-color 0.2s;
        }
        .col-search-input:focus {
            border-color: var(--color-blue) !important;
            background: rgba(255,255,255,0.07) !important;
        }
        .col-search-input::placeholder { color: #5a6a7e !important; opacity: 1; }
    </style>
    <script>
        function openEditRoleModal(btn) {
            var id = btn.getAttribute('data-id');
            var name = btn.getAttribute('data-name');
            var permissions = JSON.parse(btn.getAttribute('data-permissions') || '[]');

            document.getElementById('edit_role_name').value = name;
            document.getElementById('edit_role_title').innerText = name;
            document.getElementById('edit-role-form').action = "/admin/roles/" + id;

            document.querySelectorAll('.perm-checkbox').forEach(function(cb) {
                cb.checked = false;
            });

            permissions.forEach(function(perm) {
                var cb = document.querySelector('.perm-checkbox[value="' + perm + '"]');
                if (cb) cb.checked = true;
            });

            var modalEl = document.getElementById('editRoleModal');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        }

        function confirmDeleteRole(id, name, usersCount) {
            if (usersCount > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Cannot Delete',
                    text: 'Role "' + name + '" cannot be deleted because ' + usersCount + ' staff members are assigned to it.',
                    background: '#090d16', color: '#ffffff', confirmButtonColor: '#3b82f6'
                });
                return;
            }

            Swal.fire({
                title: 'Delete Role?',
                text: 'Are you sure you want to delete the role "' + name + '"?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#718096',
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel',
                background: '#090d16', color: '#ffffff'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/roles/' + id,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        success: function(res) {
                            Swal.fire({
                                icon: 'success', title: 'Deleted', text: res.message || 'Role deleted successfully.',
                                background: '#090d16', color: '#ffffff', confirmButtonColor: '#3b82f6'
                            });
                            $('#roles-table').DataTable().ajax.reload();
                        },
                        error: function(err) {
                            Swal.fire({
                                icon: 'error', title: 'Error', text: err.responseJSON?.message || 'An error occurred.',
                                background: '#090d16', color: '#ffffff', confirmButtonColor: '#3b82f6'
                            });
                        }
                    });
                }
            });
        }

        $(document).ready(function() {
            $(document).on('click', '.select-all-group', function() {
                let groupIndex = $(this).data('group');
                let checkboxes = $('.perm-group-' + groupIndex);
                let allChecked = checkboxes.length === checkboxes.filter(':checked').length;
                checkboxes.prop('checked', !allChecked);
            });

            $('#create-role-form').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let btn = form.find('button[type="submit"]');
                btn.prop('disabled', true).html('Creating...');
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(res) {
                        btn.prop('disabled', false).html('Create Role');
                        bootstrap.Modal.getInstance(document.getElementById('createRoleModal')).hide();
                        form[0].reset();
                        $('#roles-table').DataTable().ajax.reload();
                        Swal.fire({ icon: 'success', title: 'Success', text: res.message, background: '#090d16', color: '#ffffff', confirmButtonColor: '#3b82f6' });
                    },
                    error: function(err) {
                        btn.prop('disabled', false).html('Create Role');
                        Swal.fire({ icon: 'error', title: 'Error', text: err.responseJSON?.message || 'An error occurred.', background: '#090d16', color: '#ffffff', confirmButtonColor: '#3b82f6' });
                    }
                });
            });

            $('#edit-role-form').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let btn = form.find('button[type="submit"]');
                btn.prop('disabled', true).html('Saving...');
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(res) {
                        btn.prop('disabled', false).html('Save Permissions');
                        bootstrap.Modal.getInstance(document.getElementById('editRoleModal')).hide();
                        $('#roles-table').DataTable().ajax.reload();
                        Swal.fire({ icon: 'success', title: 'Success', text: res.message, background: '#090d16', color: '#ffffff', confirmButtonColor: '#3b82f6' });
                    },
                    error: function(err) {
                        btn.prop('disabled', false).html('Save Permissions');
                        Swal.fire({ icon: 'error', title: 'Error', text: err.responseJSON?.message || 'An error occurred.', background: '#090d16', color: '#ffffff', confirmButtonColor: '#3b82f6' });
                    }
                });
            });

            var roleTable = $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.roles') }}",
                columns: [
                    { data: 'name',   name: 'name' },
                    { data: 'users_count', name: 'users_count' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[0, 'asc']],
                orderCellsTop: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Global search…",
                    lengthMenu: "Show _MENU_ records",
                    paginate: { first: "First", last: "Last", next: "Next", previous: "Prev" }
                }
            });

            $('#roles-table thead tr.column-search-row th').each(function(i) {
                var $input = $(this).find('input.col-search-input');
                if ($input.length) {
                    var timer;
                    $input.on('keyup change clear', function() {
                        clearTimeout(timer);
                        var val = this.value;
                        timer = setTimeout(function() {
                            if (roleTable.column(i).search() !== val) {
                                roleTable.column(i).search(val).draw();
                            }
                        }, 400);
                    });
                }
            });

            $('#btn-export-roles').on('click', function() {
                var globalSearch = roleTable.search();
                var colSearches = [];
                roleTable.columns().every(function(index) {
                    colSearches.push(encodeURIComponent(this.search()));
                });
                var url = "{{ route('admin.roles.export') }}" +
                    '?search=' + encodeURIComponent(globalSearch) +
                    '&role='   + colSearches[0];
                window.location.href = url;
            });
        });
    </script>
@endsection
