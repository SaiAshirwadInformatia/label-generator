<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Configure your Label Generation : ' . $label->name) }}
            </h2>
            @livewire('save-template', ['label' => $label], key($label->id))
        </div>
    </x-slot>
    @livewire('label-configure', ['label' => $label], key($label->id))
</x-app-layout>
