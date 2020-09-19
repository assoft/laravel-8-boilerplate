<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permissions
        $permissions = collect([
            ["name" => "dashboard_access", "guard_name" => "web", "role" => ["admin", "moderator"]],
            ["name" => "setting_access", "guard_name" => "web", "role" => ["admin", "moderator"]],
            ["name" => "setting_create", "guard_name" => "web", "role" => ["admin", "moderator"]],
            ["name" => "setting_edit", "guard_name" => "web", "role" => ["admin", "moderator"]],
            ["name" => "setting_delete", "guard_name" => "web", "role" => ["admin", "moderator"]],
            ["name" => "user_access", "guard_name" => "web", "role" => ["admin", "moderator"]],
            ["name" => "user_create", "guard_name" => "web", "role" => ["admin", "moderator"]],
            ["name" => "user_edit", "guard_name" => "web", "role" => ["admin", "moderator"]],
            ["name" => "user_delete", "guard_name" => "web", "role" => ["admin", "moderator"]],
            ["name" => "admin_user_access", "guard_name" => "web", "role" => ["admin"]],
            ["name" => "admin_user_create", "guard_name" => "web", "role" => ["admin"]],
            ["name" => "admin_user_edit", "guard_name" => "web", "role" => ["admin"]],
            ["name" => "admin_user_delete", "guard_name" => "web", "role" => ["admin"]],
            ["name" => "role_access", "guard_name" => "web", "role" => ["admin"]],
            ["name" => "role_create", "guard_name" => "web", "role" => ["admin"]],
            ["name" => "role_edit", "guard_name" => "web", "role" => ["admin"]],
            ["name" => "role_delete", "guard_name" => "web", "role" => ["admin"]],
            ["name" => "permission_access", "guard_name" => "web", "role" => ["admin"]],
            ["name" => "permission_create", "guard_name" => "web", "role" => ["admin"]],
            ["name" => "permission_edit", "guard_name" => "web", "role" => ["admin"]],
            ["name" => "permission_delete", "guard_name" => "web", "role" => ["admin"]],
        ]);

        $permissions->map(function ($perm) {
            Permission::firstOrCreate(["name" => $perm["name"], "guard_name" => $perm["guard_name"]]);
        });

        // Roles
        $roles = collect([
            ["name" => "admin", "guard_name" => "web"],
            ["name" => "moderator", "guard_name" => "web"],
            ["name" => "author", "guard_name" => "web"],
        ]);

        $roles->map(function ($role) use ($permissions) {
            $role = Role::firstOrCreate($role);
            $role_permissions = collect($permissions)->filter(function ($perm) use ($role) {
                return in_array($role["name"], $perm["role"]);
            })->all();
            foreach ($role_permissions as $role_perm) {
                $role->givePermissionTo($role_perm["name"]);
            }
        });
    }
}
