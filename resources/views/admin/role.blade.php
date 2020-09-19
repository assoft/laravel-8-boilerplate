<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Roles & Permissions
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div x-data="{current: 0}">
                    <div class="tabs flex justify-between items-center bg-indigo-500 text-white font-semibold">
                        <div class="flex">
                            <div @click="current = 0"
                                class="inline-flex cursor-pointer px-4 py-4 outline-none hover:bg-indigo-600"
                                :class="{'font-bold bg-indigo-600': current === 0}">Roles</div>
                            <div @click="current = 1"
                                class="inline-flex cursor-pointer px-4 py-4 outline-none hover:bg-indigo-600"
                                :class="{'font-bold bg-indigo-600': current === 1}">Permissions</div>
                        </div>
                    </div>
                    <div class="tabs-content">
                        <div x-show="current === 0" class="py-4">
                            @livewire('admin.role')
                        </div>
                        <div x-show="current === 1" class="py-4">
                            @livewire('admin.permission')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>
