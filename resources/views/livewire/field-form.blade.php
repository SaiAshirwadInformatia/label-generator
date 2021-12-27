<div class="flex justify-between mt-2">
    <div class="w-3/12">
        <x-label>Field Name</x-label>
        <x-select wire:model.debounce.500ms="field.name" :options="$columns" type="text"
            class="w-10/12" />
    </div>
    <div class="w-3/12">
        <x-label>Display Name</x-label>
        <x-input wire:model.debounce.500ms="field.display_name" type="text" class="w-10/12" />
    </div>
    <div class="w-2/12">
        <x-label>Field Font</x-label>
        <select wire:model="field.settings.font" class="w-10/12 select">
            @foreach ($fontsConfig as $fontKey => $font)
                <option value="{{ $fontKey }}">{{ $font['name'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="w-2/12">
        <x-label>Font Weight</x-label>
        <select wire:model="field.settings.type" class="w-10/12 select">
            @foreach ($fontsConfig[$field->settings['font']]['weight'] as $weightKey => $weightValue)
                <option value="{{ $weightKey }}">{{ $weightValue }}</option>
            @endforeach
        </select>
    </div>
    <div class="w-1/12">
        <x-label>Font Size</x-label>
        <x-input wire:model.debouce.500ms="field.settings.size" type="number" step="1" min="6" class="w-10/12" />
    </div>
    <div class="w-2/12">
        <x-label>Field Type</x-label>
        <x-select wire:model="field.type" :options="$fieldTypes" class="w-10/12" />
    </div>
    @if ($field['type'] == 'Static')
        <div class="w-2/12">
            <x-label>Static Value</x-label>
            <x-input wire:model.debounce.500ms="field.default" type="text" class="w-10/12" />
        </div>
    @else
        <div class="w-2/12"></div>
    @endif
    <div class="w-1/12">
        <x-button class="mt-6" wire:click="destroy">
            @include('icons.trash')
            Delete
        </x-button>
    </div>
</div>
