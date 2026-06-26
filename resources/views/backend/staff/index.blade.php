@extends('backend.layout')

@section('admin_css')
    <!-- jQuery & DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    
    <style>
        .form-group-admin .form-control::placeholder {
            color: #888888 !important;
            opacity: 1 !important;
        }
        
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
        
        /* Custom close button styling */
        .btn-close-custom {
            opacity: 0.7;
            transition: all 0.3s;
            cursor: pointer;
        }
        .btn-close-custom:hover {
            opacity: 1;
            transform: scale(1.1);
        }
        
        /* Custom Checkbox */
        .form-check-inline {
            transition: all 0.3s ease;
        }
        .form-check-inline:hover {
            border-color: var(--color-blue) !important;
            background: rgba(59, 130, 246, 0.05) !important;
        }
        .form-check-input:checked {
            background-color: var(--color-blue) !important;
            border-color: var(--color-blue) !important;
        }
        
        /* Custom input group for password */
        .input-group .form-control {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }
        .btn-outline-blue {
            border: 1.5px solid rgba(59, 130, 246, 0.4) !important;
            color: var(--color-blue) !important;
            background: transparent !important;
            font-weight: 700;
            padding: 12px 18px !important;
            font-size: 13px !important;
            transition: all 0.3s;
        }
        .btn-outline-blue:hover {
            background: rgba(59, 130, 246, 0.1) !important;
            border-color: var(--color-blue) !important;
        }
    </style>
@endsection

@section('admin_content')
    <div class="admin-header">
        <div>
            <h2 class="admin-title">Staff Management</h2>
            <p class="admin-subtitle">Add, edit, assign roles, and manage administrative backend crew access securely.</p>
        </div>
        <div class="d-flex gap-3 flex-wrap">
            <button id="btn-export-staff" class="btn btn-blue px-4 py-3" style="background: rgba(59, 130, 246, 0.12) !important; border: 1.5px solid rgba(59, 130, 246, 0.4) !important; color: var(--color-blue) !important; box-shadow: none !important;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="me-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Download CSV
            </button>
            <button class="btn btn-blue px-4 py-3" data-bs-toggle="modal" data-bs-target="#createStaffModal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="me-2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Register Staff
            </button>
        </div>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Access Granted',
                    text: "{{ session('success') }}",
                    background: '#090d16',
                    color: '#ffffff',
                    confirmButtonColor: '#3b82f6'
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'System Alert',
                    text: "{{ session('error') }}",
                    background: '#090d16',
                    color: '#ffffff',
                    confirmButtonColor: '#3b82f6'
                });
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let errHtml = '<ul class="text-start mb-0" style="list-style-type: none; padding-left: 0;">';
                @foreach ($errors->all() as $error)
                    errHtml += '<li class="mb-2 text-danger">⚠️ {{ $error }}</li>';
                @endforeach
                errHtml += '</ul>';
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Errors',
                    html: errHtml,
                    background: '#090d16',
                    color: '#ffffff',
                    confirmButtonColor: '#3b82f6'
                });
            });
        </script>
    @endif

    <!-- Staff Yajra DataTable Container -->
    <div class="table-responsive">
        <table id="staff-table" class="table">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>Phone</th>
                    <th>Roles</th>
                    <th width="170px">Actions</th>
                </tr>
                <tr class="column-search-row">
                    <th><input type="text" class="col-search-input" placeholder="Search name…"></th>
                    <th><input type="text" class="col-search-input" placeholder="Search email…"></th>
                    <th><input type="text" class="col-search-input" placeholder="Search phone…"></th>
                    <th><input type="text" class="col-search-input" placeholder="Search role…"></th>
                    <th></th>
                </tr>
            </thead>
        </table>
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
        $(document).ready(function() {
            var staffTable = $('#staff-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.staff') }}",
                columns: [
                    { data: 'name',   name: 'name' },
                    { data: 'email',  name: 'email' },
                    { data: 'phone',  name: 'phone', defaultContent: '<span style="color: #64748b;">Not Set</span>' },
                    { data: 'role',   name: 'role', orderable: false, searchable: true },
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

            $('#staff-table thead tr.column-search-row th').each(function (i) {
                var $input = $(this).find('input.col-search-input');
                if ($input.length) {
                    var timer;
                    $input.on('keyup change clear', function () {
                        clearTimeout(timer);
                        var val = this.value;
                        timer = setTimeout(function () {
                            if (staffTable.column(i).search() !== val) {
                                staffTable.column(i).search(val).draw();
                            }
                        }, 400);
                    });
                }
            });

            $('#btn-export-staff').on('click', function () {
                var searchVal  = staffTable.search();
                var roleSearch = staffTable.column(3).search();
                var url = "{{ route('admin.staff.export') }}"
                    + '?search=' + encodeURIComponent(searchVal)
                    + '&role='   + encodeURIComponent(roleSearch);
                window.location.href = url;
            });

            $('#register-staff-form').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');
                submitBtn.prop('disabled', true).html('Granting Access...');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        submitBtn.prop('disabled', false).html('Grant CMS Access');
                        const modalEl = document.getElementById('createStaffModal');
                        bootstrap.Modal.getInstance(modalEl).hide();
                        form[0].reset();
                        $('#staff-table').DataTable().ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Access Granted',
                            text: response.message || 'New staff member registered successfully!',
                            background: '#090d16',
                            color: '#ffffff',
                            confirmButtonColor: '#3b82f6'
                        });
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html('Grant CMS Access');
                        let title = 'System Alert';
                        let errHtml = 'An unexpected error occurred.';
                        
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            title = 'Validation Errors';
                            errHtml = '<ul class="text-start mb-0" style="list-style-type: none; padding-left: 0;">';
                            $.each(xhr.responseJSON.errors, function(key, errors) {
                                $.each(errors, function(i, error) {
                                    errHtml += `<li class="mb-2 text-danger">⚠️ ${error}</li>`;
                                });
                            });
                            errHtml += '</ul>';
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errHtml = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: title,
                            html: errHtml,
                            background: '#090d16',
                            color: '#ffffff',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                });
            });

            $('#edit-staff-form').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');
                submitBtn.prop('disabled', true).html('Updating Access...');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        submitBtn.prop('disabled', false).html('Update CMS Access');
                        const modalEl = document.getElementById('editStaffModal');
                        bootstrap.Modal.getInstance(modalEl).hide();
                        $('#staff-table').DataTable().ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Staff Updated',
                            text: response.message || 'Staff details updated successfully!',
                            background: '#090d16',
                            color: '#ffffff',
                            confirmButtonColor: '#3b82f6'
                        });
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html('Update CMS Access');
                        let title = 'System Alert';
                        let errHtml = 'An unexpected error occurred.';
                        
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            title = 'Validation Errors';
                            errHtml = '<ul class="text-start mb-0" style="list-style-type: none; padding-left: 0;">';
                            $.each(xhr.responseJSON.errors, function(key, errors) {
                                $.each(errors, function(i, error) {
                                    errHtml += `<li class="mb-2 text-danger">⚠️ ${error}</li>`;
                                });
                            });
                            errHtml += '</ul>';
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errHtml = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: title,
                            html: errHtml,
                            background: '#090d16',
                            color: '#ffffff',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                });
            });

            $(document).on('click', '.edit-staff-btn', function() {
                const btn = $(this);
                const id    = btn.attr('data-id');
                const name  = btn.attr('data-name');
                const email = btn.attr('data-email');
                const phone = btn.attr('data-phone');
                let roles = [];
                try {
                    roles = JSON.parse(btn.attr('data-roles'));
                } catch (e) {
                    roles = [];
                }
                openEditModal({ id, name, email, phone }, roles);
            });
        });

        function confirmResetPassword(id, name, module) {
            Swal.fire({
                title: 'Reset Password?',
                text: `Are you sure you want to reset the password for ${name}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#718096',
                confirmButtonText: 'Yes, Reset',
                cancelButtonText: 'Cancel',
                background: '#090d16', color: '#ffffff'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/' + module + '/' + id + '/reset-password',
                        type: 'POST',
                        data: {
                            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Link Sent',
                                html: res.message,
                                background: '#090d16', color: '#ffffff', confirmButtonColor: '#3b82f6'
                            });
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

        function openEditModal(member, currentRoles) {
            document.getElementById('edit_name').value  = member.name;
            document.getElementById('edit_email').value = member.email;
            document.getElementById('edit_phone').value = member.phone || '';

            document.querySelectorAll('.edit-role-checkbox').forEach(cb => cb.checked = false);

            if (Array.isArray(currentRoles)) {
                currentRoles.forEach(roleName => {
                    const cb = document.querySelector(`.edit-role-checkbox[value="${roleName}"]`);
                    if (cb) { cb.checked = true; }
                });
            }

            document.getElementById('edit-staff-form').action = `/admin/staff/${member.id}`;

            const modalEl = document.getElementById('editStaffModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        }

        function confirmRevoke(id, name) {
            Swal.fire({
                title: 'Revoke CMS Access?',
                text: `Are you sure you want to revoke administrative access for ${name}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#718096',
                confirmButtonText: 'Yes, Revoke!',
                cancelButtonText: 'Cancel',
                background: '#090d16',
                color: '#ffffff'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }

        function generatePassword(inputId) {
            const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
            let password = '';
            for (let i = 0; i < 14; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById(inputId).value = password;
            Swal.fire({
                toast: true, position: 'top-end', icon: 'info',
                title: 'Password Generated! Click Copy.',
                showConfirmButton: false, timer: 2500,
                background: '#090d16', color: '#ffffff'
            });
        }

        function copyPassword(inputId) {
            const passInput = document.getElementById(inputId);
            if (!passInput.value) {
                Swal.fire({
                    toast: true, position: 'top-end', icon: 'warning',
                    title: 'Generate a password first!',
                    showConfirmButton: false, timer: 2000,
                    background: '#090d16', color: '#ffffff'
                });
                return;
            }
            navigator.clipboard.writeText(passInput.value).then(() => {
                Swal.fire({
                    toast: true, position: 'top-end', icon: 'success',
                    title: 'Password copied to clipboard!',
                    showConfirmButton: false, timer: 2000,
                    background: '#090d16', color: '#ffffff'
                });
            }).catch(() => {
                passInput.select();
                document.execCommand('copy');
                Swal.fire({
                    toast: true, position: 'top-end', icon: 'success',
                    title: 'Password copied!',
                    showConfirmButton: false, timer: 2000,
                    background: '#090d16', color: '#ffffff'
                });
            });
        }

        function forceOpenModal(modalId) {
            if (typeof bootstrap !== 'undefined') {
                const modal = new bootstrap.Modal(document.getElementById(modalId));
                modal.show();
            } else {
                setTimeout(function() {
                    forceOpenModal(modalId);
                }, 50);
            }
        }
        
        function forceOpenEditModal(member, currentRoles) {
            if (typeof bootstrap !== 'undefined' && typeof openEditModal !== 'undefined') {
                openEditModal(member, currentRoles);
            } else {
                setTimeout(function() {
                    forceOpenEditModal(member, currentRoles);
                }, 50);
            }
        }
        
        @if(session('open_modal') === 'create')
            forceOpenModal('createStaffModal');
        @endif

        @if(session('open_modal') === 'edit' && session('edit_member_id'))
            @php
                $editMember = \App\Models\User::find(session('edit_member_id'));
            @endphp
            @if($editMember)
                forceOpenEditModal({!! json_encode($editMember) !!}, {!! json_encode($editMember->getRoleNames()) !!});
            @endif
        @endif
    </script>
@endsection

@section('admin_modals')
    <!-- Register Staff Modal -->
    <div class="modal fade" id="createStaffModal" tabindex="-1" aria-hidden="true" style="background: rgba(0,0,0,0.85);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: #090d16; border: 1.5px solid var(--color-blue); border-radius: 24px; color: #ffffff;">
                <div class="modal-header border-0 pb-0 d-flex justify-content-between align-items-center" style="padding: 24px 32px 10px;">
                    <h4 style="color: var(--color-blue); font-size: 18px; margin: 0; text-transform: uppercase; font-weight: 700;">Register New Staff</h4>
                    <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close" style="background: none; border: none; color: white;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <div class="modal-body" style="padding: 10px 32px 32px;">
                    <form id="register-staff-form" action="{{ route('admin.staff.store') }}" method="POST">
                        @csrf
                        <div class="form-group-admin">
                            <label for="create_name">Full Name</label>
                            <input type="text" id="create_name" name="name" class="form-control w-100" required placeholder="e.g. Suresh Perera">
                        </div>

                        <div class="form-group-admin">
                            <label for="create_email">Email Address</label>
                            <input type="email" id="create_email" name="email" class="form-control w-100" required placeholder="name@lumos.lk">
                        </div>

                        <div class="form-group-admin">
                            <label for="create_password">Secure Password</label>
                            <div class="input-group">
                                <input type="text" id="create_password" name="password" class="form-control" required placeholder="Min 8 characters">
                                <button class="btn btn-outline-blue" type="button" onclick="generatePassword('create_password')">
                                    Generate
                                </button>
                                <button class="btn btn-blue" type="button" onclick="copyPassword('create_password')" style="border-radius: 0 12px 12px 0 !important;">
                                    Copy
                                </button>
                            </div>
                        </div>

                        <div class="form-group-admin">
                            <label for="create_phone">Phone</label>
                            <input type="text" id="create_phone" name="phone" class="form-control w-100" placeholder="771234567">
                        </div>

                        <div class="form-group-admin">
                            <label>CMS Security Roles (Select Multiple)</label>
                            <div class="d-flex flex-wrap gap-3 mt-2">
                                @foreach($roles as $role)
                                    <div class="form-check form-check-inline" style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 10px 18px; margin: 0; display: flex; align-items: center; gap: 8px;">
                                        <input class="form-check-input role-checkbox" type="checkbox" name="roles[]" id="role_{{ $role->id }}" value="{{ $role->name }}" style="cursor: pointer; background-color: #090d16; border-color: rgba(255,255,255,0.2);">
                                        <label class="form-check-label text-white" for="role_{{ $role->id }}" style="margin: 0; cursor: pointer; text-transform: none; font-size: 14px; font-weight: 500;">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-blue w-100 py-3 mt-4" style="justify-content: center;">
                            Grant CMS Access
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Staff Modal -->
    <div class="modal fade" id="editStaffModal" tabindex="-1" aria-hidden="true" style="background: rgba(0,0,0,0.85);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: #090d16; border: 1.5px solid var(--color-blue); border-radius: 24px; color: #ffffff;">
                <div class="modal-header border-0 pb-0 d-flex justify-content-between align-items-center" style="padding: 24px 32px 10px;">
                    <h4 style="color: var(--color-blue); font-size: 18px; margin: 0; text-transform: uppercase; font-weight: 700;">Edit Staff Details</h4>
                    <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close" style="background: none; border: none; color: white;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <div class="modal-body" style="padding: 10px 32px 32px;">
                    <form id="edit-staff-form" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group-admin">
                            <label for="edit_name">Full Name</label>
                            <input type="text" id="edit_name" name="name" class="form-control w-100" required>
                        </div>

                        <div class="form-group-admin">
                            <label for="edit_email">Email Address</label>
                            <input type="email" id="edit_email" name="email" class="form-control w-100" required>
                        </div>

                        <div class="form-group-admin">
                            <label for="edit_phone">Phone</label>
                            <input type="text" id="edit_phone" name="phone" class="form-control w-100">
                        </div>

                        <div class="form-group-admin">
                            <label>CMS Security Roles (Select Multiple)</label>
                            <div class="d-flex flex-wrap gap-3 mt-2">
                                @foreach($roles as $role)
                                    <div class="form-check form-check-inline" style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 10px 18px; margin: 0; display: flex; align-items: center; gap: 8px;">
                                        <input class="form-check-input edit-role-checkbox" type="checkbox" name="roles[]" id="edit_role_{{ $role->id }}" value="{{ $role->name }}" style="cursor: pointer; background-color: #090d16; border-color: rgba(255,255,255,0.2);">
                                        <label class="form-check-label text-white" for="edit_role_{{ $role->id }}" style="margin: 0; cursor: pointer; text-transform: none; font-size: 14px; font-weight: 500;">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-blue w-100 py-3 mt-4" style="justify-content: center;">
                            Update CMS Access
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
