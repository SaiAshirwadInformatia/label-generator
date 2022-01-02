<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users') }}
            </h2>
            <form action="{{ route('users.create') }}">
                <x-button>
                    <x-icon.add class="w-6 h-6 mr-1"></x-icon.add>
                    Add New User
                </x-button>
            </form>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:users-table />
        </div>
    </div>
</x-app-layout>
