<div x-data="{ showCreate: false }">
    <div class="px-6 pt-6 sm:px-8 bg-white">
        <div class="flex justify-between">
            <div class="flex-1 flex space-x-8">
                <div class="text-2xl">
                    User List
                </div>
            </div>
            <div>
                <x-jet-button wire:click="showCreateModal">Create User</x-jet-button>
            </div>
        </div>
    </div>
    <div class="flex flex-col mt-4">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200">
                    <div class="bg-gray-800">
                        <div class="flex space-x-4 px-8 py-4">
                            <div class="w-auto md:w-4/12">
                                <x-jet-input class="w-full" placeholder="Search..." wire:model.lazy="search" />
                            </div>
                            <div>
                                <select class="form-select w-full" wire:model="role">
                                    <option selected value="">Any</option>
                                    @foreach ($roles as $role)
                                    @if($role === "admin")
                                    @can("access_admin_user")
                                    <option value="{{ $role }}">{{ title_case($role) }}</option>
                                    @endcan
                                    @else
                                    <option value="{{ $role }}">{{ title_case($role) }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select class="form-select w-full" wire:model="perPage">
                                    <option selected value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    #
                                </th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Roles
                                </th>
                                <th class="px-6 py-3 bg-gray-50"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                            @if($user->hasRole("admin"))
                            @can("admin_user_access")
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    {{ $user->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    <div class="flex items-center">
                                        @if ($user->email_verified_at)
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                        @else
                                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                        @endif
                                        <span class="ml-2">{{ $user->email }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    @foreach ($user->roles as $role)
                                    <span>{{ title_case($role->name) }}</span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        @can("user_edit")
                                        @if($user->hasRole("admin"))
                                        @can("admin_user_edit")
                                        <button wire:click="showEditModal({{ $user->id }})"
                                            class="outline-none flex items-center justify-center h-6 w-6">
                                            <div class="text-indigo-500 w-4 h-4">
                                                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M20.71 7.04c.39-.39.39-1.04 0-1.41l-2.34-2.34c-.37-.39-1.02-.39-1.41 0l-1.84 1.83 3.75 3.75 1.84-1.83zM3 17.25V21h3.75L17.81 9.93l-3.75-3.75L3 17.25z" />
                                            </div>
                                        </button>
                                        @endcan
                                        @else
                                        <button wire:click="showEditModal({{ $user->id }})"
                                            class="outline-none flex items-center justify-center h-6 w-6">
                                            <div class="text-indigo-500 w-4 h-4">
                                                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M20.71 7.04c.39-.39.39-1.04 0-1.41l-2.34-2.34c-.37-.39-1.02-.39-1.41 0l-1.84 1.83 3.75 3.75 1.84-1.83zM3 17.25V21h3.75L17.81 9.93l-3.75-3.75L3 17.25z" />
                                            </div>
                                        </button>
                                        @endif
                                        @endcan

                                        @can("user_delete")
                                        @if($user->hasRole("admin"))
                                        @can("admin_user_delete")
                                        <button wire:click="deleteUser({{ $user->id }})"
                                            class="outline-none flex items-center justify-center h-6 w-6">
                                            <div class="text-red-500 w-4 h-4">
                                                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M20 6.91L17.09 4 12 9.09 6.91 4 4 6.91 9.09 12 4 17.09 6.91 20 12 14.91 17.09 20 20 17.09 14.91 12 20 6.91z" />
                                                </svg>
                                            </div>
                                        </button>
                                        @endcan
                                        @else
                                        <button wire:click="deleteUser({{ $user->id }})"
                                            class="outline-none flex items-center justify-center h-6 w-6">
                                            <div class="text-red-500 w-4 h-4">
                                                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M20 6.91L17.09 4 12 9.09 6.91 4 4 6.91 9.09 12 4 17.09 6.91 20 12 14.91 17.09 20 20 17.09 14.91 12 20 6.91z" />
                                                </svg>
                                            </div>
                                        </button>
                                        @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endcan
                            @else
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    {{ $user->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    <div class="flex items-center">
                                        @if ($user->email_verified_at)
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                        @else
                                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                        @endif
                                        <span class="ml-2">{{ $user->email }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    @foreach ($user->roles as $role)
                                    <span>{{ title_case($role->name) }}</span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        @can("user_edit")
                                        @if($user->hasRole("admin"))
                                        @can("admin_user_edit")
                                        <button wire:click="showEditModal({{ $user->id }})"
                                            class="outline-none flex items-center justify-center h-6 w-6">
                                            <div class="text-indigo-500 w-4 h-4">
                                                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M20.71 7.04c.39-.39.39-1.04 0-1.41l-2.34-2.34c-.37-.39-1.02-.39-1.41 0l-1.84 1.83 3.75 3.75 1.84-1.83zM3 17.25V21h3.75L17.81 9.93l-3.75-3.75L3 17.25z" />
                                            </div>
                                        </button>
                                        @endcan
                                        @else
                                        <button wire:click="showEditModal({{ $user->id }})"
                                            class="outline-none flex items-center justify-center h-6 w-6">
                                            <div class="text-indigo-500 w-4 h-4">
                                                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M20.71 7.04c.39-.39.39-1.04 0-1.41l-2.34-2.34c-.37-.39-1.02-.39-1.41 0l-1.84 1.83 3.75 3.75 1.84-1.83zM3 17.25V21h3.75L17.81 9.93l-3.75-3.75L3 17.25z" />
                                            </div>
                                        </button>
                                        @endif
                                        @endcan

                                        @can("user_delete")
                                        @if($user->hasRole("admin"))
                                        @can("admin_user_delete")
                                        <button wire:click="deleteUser({{ $user->id }})"
                                            class="outline-none flex items-center justify-center h-6 w-6">
                                            <div class="text-red-500 w-4 h-4">
                                                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M20 6.91L17.09 4 12 9.09 6.91 4 4 6.91 9.09 12 4 17.09 6.91 20 12 14.91 17.09 20 20 17.09 14.91 12 20 6.91z" />
                                                </svg>
                                            </div>
                                        </button>
                                        @endcan
                                        @else
                                        <button wire:click="deleteUser({{ $user->id }})"
                                            class="outline-none flex items-center justify-center h-6 w-6">
                                            <div class="text-red-500 w-4 h-4">
                                                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M20 6.91L17.09 4 12 9.09 6.91 4 4 6.91 9.09 12 4 17.09 6.91 20 12 14.91 17.09 20 20 17.09 14.91 12 20 6.91z" />
                                                </svg>
                                            </div>
                                        </button>
                                        @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="bg-gray-100 mt-4 px-6 py-3 align-middle inline-block min-w-full">
            {{ $users->links() }}
        </div>
    </div>
    <x-jet-dialog-modal wire:model="createModal">
        <x-slot name="title">Create User</x-slot>
        <x-slot name="content">
            @error("user.*")
            <x-jet-validation-errors class="my-4" />
            @enderror
            <div class="w-full grid grid-flow-row gap-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="w-full">
                        <x-jet-label>Name</x-jet-label>
                        <x-jet-input class="w-full z-10" wire:model.lazy="user.name" />
                    </div>
                    <div class="w-full">
                        <x-jet-label>Email</x-jet-label>
                        <x-jet-input type="email" class="w-full z-10" wire:model.lazy="user.email" />
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-full">
                        <x-jet-label>Password</x-jet-label>
                        <x-jet-input type="password" class="w-full z-10" wire:model.lazy="user.password" />
                    </div>
                    <div class="w-full">
                        <x-jet-label>Password Confirmation</x-jet-label>
                        <x-jet-input type="password" class="w-full z-10" wire:model.lazy="user.password_confirmation" />
                    </div>
                </div>
                <div class="w-full flex flex-col">
                    <x-jet-label>Roles</x-jet-label>
                    <div class="text-sm mt-2 flex flex-wrap items-center gap-x-4 gap-y-2">
                        @foreach ($roles as $role)
                        @if($role === 'admin')
                        @can("admin_user_create")
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="form-checkbox h-5 w-5" value="{{ $role }}"
                                wire:model="userRole">
                            <span>{{ title_case($role) }}</span>
                        </label>
                        @endcan
                        @else
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="form-checkbox h-5 w-5" value="{{ $role }}"
                                wire:model="userRole">
                            <span>{{ title_case($role) }}</span>
                        </label>
                        @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div>
                    <x-jet-label class="flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox h-5 w-5" wire:model="user.email_verified_at">
                        <span>Is Verified</span>
                    </x-jet-label>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('createModal')" wire:loading.attr="disabled">
                Cancel
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="createUser" wire:loading.attr="disabled">
                Create
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
    <x-jet-dialog-modal wire:model="editModal">
        <x-slot name="title">Edit User</x-slot>
        <x-slot name="content">
            @error("editUser.*")
            <x-jet-validation-errors class="my-4" />
            @enderror
            <div class="w-full grid grid-flow-row gap-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="w-full">
                        <x-jet-label>Name</x-jet-label>
                        <x-jet-input class="w-full z-10" wire:model.lazy="editUser.name" />
                    </div>
                    <div class="w-full">
                        <x-jet-label>Email</x-jet-label>
                        <x-jet-input type="email" class="w-full z-10" wire:model.lazy="editUser.email" />
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-full">
                        <x-jet-label>Password</x-jet-label>
                        <x-jet-input type="password" class="w-full z-10" wire:model.lazy="editUser.password" />
                    </div>
                    <div class="w-full">
                        <x-jet-label>Password Confirmation</x-jet-label>
                        <x-jet-input type="password" class="w-full z-10"
                            wire:model.lazy="editUser.password_confirmation" />
                    </div>
                </div>
                <div class="w-full flex flex-col">
                    <x-jet-label>Roles</x-jet-label>
                    <div class="text-sm mt-2 flex flex-wrap items-center gap-x-4 gap-y-2">
                        @foreach ($roles as $role)
                        @if($role === 'admin')
                        @can("admin_user_create")
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="form-checkbox h-5 w-5" value="{{ $role }}"
                                wire:model="editUser.roles">
                            <span>{{ title_case($role) }}</span>
                        </label>
                        @endcan
                        @else
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="form-checkbox h-5 w-5" value="{{ $role }}"
                                wire:model="editUser.roles">
                            <span>{{ title_case($role) }}</span>
                        </label>
                        @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div>
                    <x-jet-label class="flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox h-5 w-5" wire:model="editUser.email_verified_at">
                        <span>Is Verified</span>
                    </x-jet-label>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('editModal')" wire:loading.attr="disabled">
                Cancel
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="updateUser" wire:loading.attr="disabled">
                Update
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
