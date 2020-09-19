<div>
    <div class="p-6 sm:px-20 bg-white">
        <div class="text-2xl">
            Create New Permission
        </div>
        <div class="mt-6 text-gray-500">
            <div class="grid grid-flow-row md:grid-flow-col gap-4">
                <div class="relative" x-data="{ is_crud: false }">
                    <x-jet-label>Permission Name</x-jet-label>
                    <div class="relative">
                        <x-jet-input class="w-full z-10" wire:model.lazy="permission.name"></x-jet-input>
                        <label class="absolute z-0 h-full rounded-r"
                            :class="{'text-white bg-green-500': is_crud, 'text-gray-600 bg-gray-200': !is_crud}"
                            style="top:1px bottom:1px; right:1px">
                            <div class="flex items-center self-center h-full px-4 space-x-2 text-xs">
                                <input type="checkbox" x-model="is_crud" class="form-checkbox text-green-500"
                                    wire:model="isCrud">
                                <span>CRUD</span>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="relative">
                    <x-jet-label>Guard Name</x-jet-label>
                    <select class="form-select w-full" wire:model.lazy="permission.guard_name">
                        @foreach (config("auth.guards") as $key => $val)
                        <option value="{{ $key }}">{{ $key }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="place-self-end w-full">
                    <x-jet-button wire:click="createPermission" type="submit" class="leading-6 justify-center w-full">
                        Save
                    </x-jet-button>
                </div>
            </div>
            <x-jet-validation-errors class="mt-4" />
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
                                    Gived to Roles
                                </th>
                                <th class="px-6 py-3 bg-gray-50"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($permissions as $permission)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    {{ $permission->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    {{ $permission->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    {{ $permission->guard_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $permission->roles_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $permission->roles_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button
                                            class="outline-none flex items-center justify-center h-6 w-6 bg-indigo-100 hover:bg-indigo-300 text-indigo-800 rounded-full">Edit</button>
                                        <button wire:click="deletePermission({{ $permission->id }})"
                                            class="outline-none flex items-center justify-center h-6 w-6 bg-red-100 hover:bg-red-300 text-red-800 rounded-full">&times;</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="my-4">
                        {{ $permissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
