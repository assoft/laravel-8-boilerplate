<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends Component
{
    use WithPagination;

    public $role = [
        "name" => "",
        "guard_name" => "web",
        "permissions" => []
    ];

    protected $rules = [
        'role.name' => 'required|alpha_dash',
        'role.guard_name' => 'required|alpha_dash',
        'role.permissions' => 'array',
        'role.permissions.*' => 'exists:permissions,name'
    ];

    public $permCount = 4;
    public $permissions;

    public $full = false;

    public function __construct()
    {
        $this->permissions = Permission::pluck("name");
        $this->permCount = count($this->permissions);
    }

    public function render()
    {
        abort_if(Gate::denies("role_access"), 403);

        return view('livewire.admin.role', [
            "roles" => ModelsRole::withCount("permissions")->paginate(),
            "permissions" => $this->permissions
        ]);
    }

    public function createRole()
    {
        abort_if(Gate::denies("role_create"), 403);

        $this->validate();

        $role = ModelsRole::create([
            "name" => $this->role["name"],
            "guard_name" => $this->role["guard_name"]
        ]);

        foreach ($this->role["permissions"] as $permission) {
            $role->givePermissionTo($permission);
        }

        $this->reset("role", "full");
    }

    public function deleteRole($id)
    {
        abort_if(Gate::denies("role_delete"), 403);

        ModelsRole::find($id)->delete();
    }

    public function updatedRolePermissions()
    {
        abort_if(Gate::denies("role_edit"), 403);

        $role_perm = count($this->role["permissions"]);

        if ($role_perm !== $this->permCount) {
            $this->full = false;
        } else {
            $this->full = true;
        }
    }

    public function updatedFull()
    {
        if ($this->full) {
            $this->role["permissions"] = $this->permissions;
        } else {
            $this->role["permissions"] = [];
        }
    }
}
