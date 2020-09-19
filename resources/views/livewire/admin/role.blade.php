<div>
    <div class="p-6 sm:px-20 bg-white">
        <div class="text-2xl">
            Create New Role
        </div>
        <div class="mt-6 text-gray-500">
            <x-jet-validation-errors class="my-4" />
            <div class="grid grid-flow-row md:grid-flow-col gap-4">
                <div class="relative">
                    <x-jet-label>Role Name</x-jet-label>
                    <x-jet-input class="w-full" wire:model.lazy="role.name"></x-jet-input>
                </div>
                <div class="relative">
                    <x-jet-label>Guard Name</x-jet-label>
                    <select class="form-select w-full" wire:model.lazy="role.guard_name">
                        @foreach (config("auth.guards") as $key => $val)
                        <option value="{{ $key }}">{{ $key }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-1 place-self-end w-full">
                    <x-jet-button wire:click="createRole" type="submit" class="w-full leading-6 justify-center">Save
                    </x-jet-button>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex flex-wrap gap-2 mt-2" x-data="{ full: false }">
                    <label class="inline-flex text-left text-green-500 items-center">
                        <input class="form-checkbox" x-on:click="{full = !full}" type="checkbox" wire:model="full">
                        <span class="pl-2 font-semibold">Full Authority</span>
                    </label>
                    @foreach ($permissions as $permission)
                    <label class="inline-flex text-left items-center">
                        <input class="form-checkbox" :class="{'text-gray-300': full}" type="checkbox"
                            wire:model="role.permissions" value="{{ $permission }}" x-bind:disabled="full">
                        <span class="pl-2" :class="{'text-gray-300': full}">{{ $permission }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col mt-4">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200">
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
                                    Guard
                                </th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Assigned Permissions
                                </th>
                                <th class="px-6 py-3 bg-gray-50"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($roles as $role)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    {{ $role->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    {{ $role->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    {{ $role->guard_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $role->permissions_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $role->permissions_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button
                                            class="outline-none flex items-center justify-center h-6 w-6 bg-indigo-100 hover:bg-indigo-300 text-indigo-800 rounded-full">Edit</button>
                                        <button wire:click="deleteRole({{ $role->id }})"
                                            class="outline-none flex items-center justify-center h-6 w-6 bg-red-100 hover:bg-red-300 text-red-800 rounded-full">&times;</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="my-4">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
