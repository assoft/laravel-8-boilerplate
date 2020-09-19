<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends Component
{
    use WithPagination;

    public $permission = [
        "name" => "",
        "guard_name" => "web",
    ];

    public $isCrud = false;

    protected $rules = [
        'permission.name' => 'required|alpha_dash',
        'permission.guard_name' => 'required|alpha_dash',
    ];

    public function render()
    {
        abort_if(Gate::denies("permission_access"), 403);

        return view('livewire.admin.permission', [
            "permissions" => ModelsPermission::withCount("roles")->paginate()
        ]);
    }

    public function createPermission()
    {
        abort_if(Gate::denies("role_create"), 403);

        $this->validate();

        if ($this->isCrud) {
            ModelsPermission::insert([
                [
                    "name" => $this->permission["name"] . "_access",
                    "guard_name" => $this->permission["guard_name"]
                ],
                [
                    "name" => $this->permission["name"] . "_create",
                    "guard_name" => $this->permission["guard_name"]
                ],
                [
                    "name" => $this->permission["name"] . "_update",
                    "guard_name" => $this->permission["guard_name"]
                ],
                [
                    "name" => $this->permission["name"] . "_delete",
                    "guard_name" => $this->permission["guard_name"]
                ]
            ]);
        } else {
            ModelsPermission::create([
                "name" => $this->permission["name"],
                "guard_name" => $this->permission["guard_name"]
            ]);
        }

        $this->reset("permission", "isCrud");
    }

    public function deletePermission($id)
    {
        abort_if(Gate::denies("role_delete"), 403);

        $permission = ModelsPermission::find($id);
        $permission->roles->count() > 0 ? dd("Bu arkadaşı silmeniz tavsiye edilmez!") : dd("Silebilirsin kardeş..");
    }
}
