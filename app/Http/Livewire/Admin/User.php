<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use App\Models\User as ModelsUser;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class User extends Component
{
    use WithPagination;

    public $search;
    public $perPage = 10;
    public $role;

    public $user = [
        "name" => null,
        "email" => null,
        "password" => null,
        "password_confirmation" => null,
    ];

    public $editUser = [
        "id" => null,
        "name" => null,
        "email" => null,
        "password" => null,
        "password_confirmation" => null,
        "email_verified_at" => false,
        "roles" => []
    ];

    public $userRole = [];
    public $isVerified = false;

    public $createModal = false;
    public $editModal = false;

    public function render()
    {
        abort_if(Gate::denies("user_access"), 403);

        $users = ModelsUser::with("roles")
            ->when($this->search, function ($query) {
                $query->where("name", "like", "%" . $this->search . "%")
                    ->orWhere("email", "like", "%" . $this->search . "%");
            })
            ->when($this->role, fn ($query) => $query->role($this->role))
            ->paginate($this->perPage);

        return view('livewire.admin.user', [
            "users" => $users,
            "roles" => Role::pluck("name")
        ]);
    }

    public function showCreateModal()
    {
        abort_if(Gate::denies("user_create"), 403);
        $this->createModal = true;
    }

    public function showEditModal($id)
    {
        abort_if(Gate::denies("user_edit"), 403);

        $user = ModelsUser::findOrFail($id);

        if ($user->hasRole("admin")) {
            abort_if(Gate::denies("admin_user_edit"), 403);
        }

        $this->editUser["id"] = $user->id;
        $this->editUser["name"] = $user->name;
        $this->editUser["email"] = $user->email;
        $this->editUser["password"] = "";
        $this->editUser["email_verified_at"] = $user->email_verified_at !== null ? true : false;
        $this->editUser["roles"] = $user->getRoleNames()->toArray();
        $this->editModal = true;
    }

    public function createUser()
    {
        abort_if(Gate::denies("user_create"), 403);

        $validated = $this->validate([
            'user.name' => ['required', 'string', 'max:255'],
            'user.email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'user.password' => ["required", "string", "same:user.password_confirmation"],
        ]);

        if ($this->userRole && in_array("admin", $this->userRole)) {
            abort_if(Gate::denies("create_admin_user"), 403);
        }

        $user = ModelsUser::create([
            "name" => $validated["user"]["name"],
            "email" => $validated["user"]["email"],
            "password" => Hash::make($validated["user"]["password"]),
            "email_verified_at" => $this->isVerified ? now() : null
        ]);

        $this->createModal = false;

        if ($this->userRole) {
            $user->assignRole($this->userRole);
        }

        $this->user = [
            "name" => null,
            "email" => null,
            "password" => null,
            "password_confirmation" => null,
        ];

        $this->userRole = "";
    }

    public function updateUser()
    {
        abort_if(Gate::denies("user_edit"), 403);

        $user = ModelsUser::findOrFail($this->editUser["id"]);

        if ($user->hasRole("admin")) {
            abort_if(Gate::denies("admin_user_edit"), 403);
        }

        $this->validate([
            'editUser.name' => ['required', 'string', 'max:255'],
            'editUser.email' => [
                'required', 'max:255',
                ["email" => Rule::unique('users')->ignore($user->id, "email")]
            ],
            'editUser.password' => ["string", "same:editUser.password_confirmation"],
        ]);

        $user->name = $this->editUser["name"];
        $user->email = $this->editUser["email"];

        if ($this->editUser["password"] !== "" && $this->editUser["password"] !== null) {
            $user->password = Hash::make($this->editUser["password"]);
        }

        $this->editUser["email_verified_at"]
            ? $user->email_verified_at = now()
            : $user->email_verified_at = null;

        $user->save();

        $user->syncRoles($this->editUser["roles"]);

        $this->editModal = false;
    }

    public function deleteUser($id)
    {
        abort_if(Gate::denies("user_delete"), 403);

        $user = ModelsUser::find($id);

        if ($user->hasRole("admin")) {
            abort_if(Gate::denies("admin_user_delete"), 403);
        }

        $user->hasRole("admin") ? dd("Bu arkadaşı silemezsin kardeş...") : dd("Silebilirsin kardeş...");
    }
}
