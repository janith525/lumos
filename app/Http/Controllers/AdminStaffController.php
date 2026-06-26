<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Quote;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Yajra\DataTables\Facades\DataTables;

class AdminStaffController extends Controller
{
    /**
     * Display the CMS Admin Dashboard
     */
    public function dashboard(): View
    {
        $productsCount = Product::count();
        $servicesCount = Service::count();
        $quotesCount = Quote::count();
        $staffCount = User::role(['Super Admin', 'Admin', 'Staff'])->count();

        $recentQuotes = Quote::latest()->take(5)->get();

        return view('backend.dashboard', [
            'productsCount' => $productsCount,
            'servicesCount' => $servicesCount,
            'quotesCount' => $quotesCount,
            'staffCount' => $staffCount,
            'recentQuotes' => $recentQuotes,
            'title' => 'CMS Dashboard | Lumos',
        ]);
    }

    /**
     * Display the list of staff and role management panel
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = User::whereHas('roles', function ($q) {
                $q->whereIn('name', ['Admin', 'Staff']);
            })->with('roles')->latest();

            return DataTables::of($query)
                ->addColumn('role', function ($member) {
                    $roles = $member->getRoleNames();
                    $badges = '';
                    foreach ($roles as $role) {
                        $badgeStyle = '';
                        if ($role === 'Admin') {
                            $badgeStyle = 'background: rgba(59, 130, 246, 0.15); color: #3b82f6;';
                        } else {
                            $badgeStyle = 'background: rgba(155, 89, 182, 0.15); color: #9b59b6;';
                        }
                        $badges .= '<span class="badge rounded-pill me-1 mb-1" style="font-size: 10px; font-weight: 700; padding: 5px 12px; text-transform: uppercase; '.$badgeStyle.'">'.$role.'</span>';
                    }

                    return $badges ?: '<span class="badge rounded-pill bg-secondary">Staff</span>';
                })
                ->addColumn('action', function ($member) {
                    $editBtn = '<button type="button" class="btn btn-outline-primary btn-sm px-3 py-1.5 me-2 edit-staff-btn" style="border-radius: 8px; font-size: 12px; border: 1px solid rgba(59,130,246,0.3); color: var(--color-blue); background: transparent;"
                        data-id="'.$member->id.'"'
                        .' data-name="'.htmlspecialchars($member->name, ENT_QUOTES).'"'
                        .' data-email="'.htmlspecialchars($member->email, ENT_QUOTES).'"'
                        .' data-phone="'.htmlspecialchars($member->phone ?? '', ENT_QUOTES).'"'
                        .' data-roles="'.htmlspecialchars(json_encode($member->getRoleNames()), ENT_QUOTES).'">'
                        .' Edit Info'
                        .'</button>';

                    $resetBtn = '<button type="button" class="btn btn-outline-info btn-sm px-3 py-1.5 me-2" style="border-radius: 8px; font-size: 12px; border: 1px solid rgba(52,132,240,0.3); color: #3498db; background: transparent;" onclick="confirmResetPassword('.$member->id.', \''.addslashes($member->name).'\', \'staff\')">Reset</button>';

                    $deleteBtn = '';
                    if (Auth::user()->id !== $member->id) {
                        $deleteBtn = '<button type="button" class="btn btn-outline-danger btn-sm px-3 py-1.5" style="border-radius: 8px; font-size: 12px; border: 1px solid rgba(231,76,60,0.3); color: #e74c3c; background: transparent;" onclick="confirmRevoke('.$member->id.', \''.addslashes($member->name).'\')">Revoke</button>'
                            .'<form id="delete-form-'.$member->id.'" action="'.route('admin.staff.delete', $member->id).'" method="POST" style="display:none;">'
                            .csrf_field()
                            .method_field('DELETE')
                            .'</form>';
                    }

                    return '<div class="d-flex">'.$editBtn.$resetBtn.$deleteBtn.'</div>';
                })
                ->filterColumn('role', function ($query, $keyword) {
                    $query->whereHas('roles', fn ($q) => $q->where('name', 'like', "%{$keyword}%"));
                })
                ->rawColumns(['role', 'action'])
                ->make(true);
        }

        $roles = Role::whereIn('name', ['Admin', 'Staff'])->get();

        return view('backend.staff.index', [
            'roles' => $roles,
            'title' => 'Staff Management | Lumos',
        ]);
    }

    /**
     * Export all filtered staff results as CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $search = $request->input('search', '');
        $role = $request->input('role', '');

        $query = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['Admin', 'Staff']);
        })->with('roles');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($role) {
            $query->whereHas('roles', fn ($q) => $q->where('name', 'like', "%{$role}%"));
        }

        $members = $query->orderBy('name')->get();

        $filename = 'staff-export-'.now()->format('Y-m-d-His').'.csv';

        return response()->streamDownload(function () use ($members) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Full Name', 'Email Address', 'Phone', 'Roles']);
            foreach ($members as $member) {
                fputcsv($handle, [
                    $member->name,
                    $member->email,
                    $member->phone ?? '',
                    $member->getRoleNames()->implode(', '),
                ]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    /**
     * Handle creating a new staff member securely
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'roles' => 'required|array',
                'roles.*' => 'string|in:Admin,Staff',
                'phone' => 'nullable|string',
            ]);
        } catch (ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors(),
                ], 422);
            }

            return back()->withErrors($e->validator)->withInput()->with('open_modal', 'create');
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
        ]);

        $user->syncRoles($request->input('roles'));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'New staff member registered successfully!',
            ], 201);
        }

        return back()->with('success', 'New staff member registered successfully!');
    }

    /**
     * Handle updating staff details and roles
     */
    public function update(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $user = User::findOrFail($id);

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
                'roles' => 'required|array',
                'roles.*' => 'string|in:Admin,Staff',
                'phone' => 'nullable|string',
            ]);
        } catch (ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors(),
                ], 422);
            }

            return back()->withErrors($e->validator)->withInput()->with('open_modal', 'edit')->with('edit_member_id', $id);
        }

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        $user->syncRoles($request->input('roles'));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Staff details updated successfully!',
            ], 200);
        }

        return back()->with('success', 'Staff details updated successfully!');
    }

    /**
     * Handle deleting a staff member
     */
    public function destroy(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        if ($user->id === $request->user()->id) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return back()->with('success', 'Staff account deleted successfully!');
    }

    /**
     * Reset staff password.
     */
    public function resetPassword(Request $request, int $id): JsonResponse
    {
        if (! $request->user()->can('reset staff passwords')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized to reset staff passwords.'], 403);
        }

        $user = User::findOrFail($id);

        $status = Password::broker()->sendResetLink(
            ['email' => $user->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset link sent to '.$user->email,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __($status),
        ], 400);
    }
}
