<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate a New Labels PDF') }}
        </h2>
    </x-slot>
    <livewire:label-create />
</x-app-layout>