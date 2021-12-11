<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configure your Label Generation : ' . $label->name) }}
        </h2>
    </x-slot>
    <livewire:label-configure :label="$label" :fontsConfig="$fontsConfig" />
</x-app-layout>
