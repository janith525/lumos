<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * All backend permissions grouped by module.
     *
     * @var array<string, list<string>>
     */
    private const PERMISSIONS = [
        'Dashboard' => [
            'view dashboard',
        ],
        'Staff Management' => [
            'view staff',
            'create staff',
            'edit staff',
            'delete staff',
            'reset staff passwords',
        ],
        'Roles & Permissions' => [
            'manage roles',
        ],
        'Products' => [
            'view products',
            'create products',
            'edit products',
            'delete products',
        ],
        'Services' => [
            'view services',
            'create services',
            'edit services',
            'delete services',
        ],
        'Quotes' => [
            'view quotes',
            'edit quotes',
            'delete quotes',
        ],
        'Settings' => [
            'manage settings',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create all permissions (idempotent)
        foreach (self::PERMISSIONS as $group => $names) {
            foreach ($names as $name) {
                Permission::firstOrCreate(
                    ['name' => $name, 'guard_name' => 'web'],
                    ['group' => $group]
                );
            }
        }

        // 2. Create Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $staffRole = Role::firstOrCreate(['name' => 'Staff', 'guard_name' => 'web']);

        // Super Admin gets all permissions
        $superAdminRole->syncPermissions(Permission::all());

        // Admin: everything except roles management
        $adminRole->syncPermissions(
            Permission::whereNotIn('name', ['manage roles'])->get()
        );

        // Staff: view-only access
        $staffRole->syncPermissions(
            Permission::whereIn('name', [
                'view dashboard',
                'view staff',
                'view products',
                'view services',
                'view quotes',
            ])->get()
        );

        // 3. Create seed users
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@lumos.lk'],
            [
                'name' => 'Lumos Admin',
                'password' => Hash::make('password123'),
                'phone' => '771234567',
            ]
        );
        $superAdmin->syncRoles([$superAdminRole]);

        $staff = User::firstOrCreate(
            ['email' => 'staff@lumos.lk'],
            [
                'name' => 'Lumos Staff',
                'password' => Hash::make('password123'),
                'phone' => '779876543',
            ]
        );
        $staff->syncRoles([$staffRole]);
    }
}
