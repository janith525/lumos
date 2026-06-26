<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Yajra\DataTables\Facades\DataTables;

class AdminRolesController extends Controller
{
    /** Roles that cannot be edited or deleted through the UI. */
    private const PROTECTED_ROLES = ['Super Admin'];

    /**
     * Display the roles & permissions management page.
     */
    public function index(Request $request): View|JsonResponse
    {
        Gate::authorize('manage-roles');

        if ($request->ajax()) {
            $query = Role::whereNotIn('name', self::PROTECTED_ROLES)->withCount('users');

            return DataTables::of($query)
                ->addColumn('users_count', fn (Role $role) => $role->users_count.' user'.($role->users_count !== 1 ? 's' : ''))
                ->addColumn('action', function (Role $role) {
                    $permsJson = htmlspecialchars(json_encode($role->permissions->pluck('name')), ENT_QUOTES);
                    $editBtn = '<button type="button" class="btn btn-outline-primary btn-sm px-3 py-1.5 me-2 btn-role-edit-tbl" style="border-radius: 8px; font-size: 12px; border: 1px solid rgba(59,130,246,0.3); color: var(--color-blue); background: transparent;"'
                        .' data-id="'.$role->id.'"'
                        .' data-name="'.htmlspecialchars($role->name, ENT_QUOTES).'"'
                        .' data-permissions="'.$permsJson.'"'
                        .' onclick="openEditRoleModal(this)">Edit</button>';
                    $delBtn = '<button type="button" class="btn btn-outline-danger btn-sm px-3 py-1.5 btn-role-delete-tbl" style="border-radius: 8px; font-size: 12px; border: 1px solid rgba(231,76,60,0.3); color: #e74c3c; background: transparent;" onclick="confirmDeleteRole('.$role->id.',\''.addslashes($role->name).'\','.$role->users_count.')">Delete</button>';

                    return '<div class="d-flex">'.$editBtn.$delBtn.'</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $roles = Role::whereNotIn('name', self::PROTECTED_ROLES)->with('permissions')->get();
        $permissions = Permission::orderBy('group')->orderBy('name')->get()->groupBy('group');

        return view('backend.roles.index', [
            'roles' => $roles,
            'permissions' => $permissions,
            'title' => 'Roles & Permissions | Lumos CMS',
        ]);
    }

    /**
     * Export all filtered roles as CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        Gate::authorize('manage-roles');

        $search = $request->input('search', '');

        $query = Role::whereNotIn('name', self::PROTECTED_ROLES)->with('permissions');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $roles = $query->orderBy('name')->get();
        $filename = 'roles-export-'.now()->format('Y-m-d-His').'.csv';

        return response()->streamDownload(function () use ($roles) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Role Name', 'Permissions', 'Users Assigned']);
            foreach ($roles as $role) {
                fputcsv($handle, [
                    $role->name,
                    $role->permissions->pluck('name')->implode(', '),
                    $role->users()->count(),
                ]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        Gate::authorize('manage-roles');

        try {
            $request->validate([
                'name' => 'required|string|max:100|unique:roles,name',
            ]);
        } catch (ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'errors' => $e->errors()], 422);
            }

            return back()->withErrors($e->validator)->withInput();
        }

        Role::create(['name' => $request->input('name'), 'guard_name' => 'web']);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Role created successfully!'], 201);
        }

        return back()->with('success', 'Role created successfully!');
    }

    /**
     * Update a role's name and sync its permissions.
     */
    public function update(Request $request, int $id): JsonResponse|RedirectResponse
    {
        Gate::authorize('manage-roles');

        $role = Role::findOrFail($id);

        if (in_array($role->name, self::PROTECTED_ROLES)) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'This role is protected and cannot be modified.'], 403);
            }

            return back()->with('error', 'This role is protected and cannot be modified.');
        }

        try {
            $request->validate([
                'name' => 'required|string|max:100|unique:roles,name,'.$role->id,
                'permissions' => 'nullable|array',
                'permissions.*' => 'string|exists:permissions,name',
            ]);
        } catch (ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'errors' => $e->errors()], 422);
            }

            return back()->withErrors($e->validator)->withInput();
        }

        $role->update(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permissions', []));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Role updated successfully!'], 200);
        }

        return back()->with('success', 'Role updated successfully!');
    }

    /**
     * Delete a role.
     */
    public function destroy(Request $request, int $id): JsonResponse|RedirectResponse
    {
        Gate::authorize('manage-roles');

        $role = Role::findOrFail($id);

        if (in_array($role->name, self::PROTECTED_ROLES)) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'This role is protected and cannot be deleted.'], 403);
            }

            return back()->with('error', 'This role is protected and cannot be deleted.');
        }

        if ($role->users()->count() > 0) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Cannot delete a role that has staff members assigned to it.'], 409);
            }

            return back()->with('error', 'Cannot delete a role that has staff members assigned to it.');
        }

        $role->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Role deleted successfully!'], 200);
        }

        return back()->with('success', 'Role deleted successfully!');
    }
}
