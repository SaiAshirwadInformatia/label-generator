<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Activity Logs') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="mx-auto sm:px-6 lg:px-8">
            <livewire:activity-logs-table />
        </div>
    </div>
</x-app-layout>
