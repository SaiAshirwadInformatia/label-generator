<div>
    <x-container>
        <div class="flex justify-between">
            <h1>Label Sets</h1>
            <div>
                <x-button wire:click="addNewSet">
                    @include('icons.add')
                    Add New Set
                </x-button>
            </div>
        </div>
    </x-container>

    @foreach ($label->sets as $index => $set)
        <x-container>
            <div class="flex">
                <div class="w-2/6">
                    <x-label class="font-bold">Set Name</x-label>
                    <x-input wire:model.debounce.500ms="label.sets.{{ $index }}.name" type="text"
                        class="w-10/12" />
                </div>
                <div class="w-2/6">
                    <x-label class="font-bold">Set Type</x-label>
                    <x-select wire:model="label.sets.{{ $index }}.type"
                        :options="['1' => 'Single', '2' => 'Grouped']" class="w-10/12" />
                </div>
                @if ($label->sets[$index]['type'] == '2')
                    <div class="w-1/6">
                        <x-label class="font-bold">Group Column Name</x-label>
                        <x-select wire:model="label.sets.{{ $index }}.columnName" :options="$columns" />
                    </div>
                @endif
                <div class="w-2/6 text-right">
                    <x-button class="mt-4" wire:click="addField({{ $set->id }})">Add New Field</x-button>
                    <x-button class="mt-4" wire:click="removeSet({{ $index }})">Delete Set</x-button>
                </div>
            </div>
            <hr class="my-8" />
            @isset($fields[$set->id])
                @foreach ($fields[$set->id] as $field_index => $field)
                    <div class="flex justify-between mt-2">
                        <div class="w-3/12">
                            <x-label>#{{ $field_index + 1 }} Field Name</x-label>
                            <x-select wire:model.debounce.500ms="fields.{{ $set->id }}.{{ $field_index }}.name"
                                :options="$label['settings']['columns']" type="text" class="w-10/12" />
                        </div>
                        <div class="w-3/12">
                            <x-label>Display Name</x-label>
                            <x-input
                                wire:model.debounce.500ms="fields.{{ $set->id }}.{{ $field_index }}.display_name"
                                type="text" class="w-10/12" />
                        </div>
                        <div class="w-2/12">
                            <x-label>Field Font</x-label>
                            <select wire:model="fields.{{ $set->id }}.{{ $field_index }}.settings.font"
                                class="w-10/12 select">
                                @foreach ($fontsConfig as $fontKey => $font)
                                    <option value="{{ $fontKey }}">{{ $font['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-2/12">
                            <x-label>Font Weight</x-label>
                            <select wire:model="fields.{{ $set->id }}.{{ $field_index }}.settings.weight"
                                class="w-10/12 select">
                                @foreach ($fontsConfig[$fields[$set->id][$field_index]['settings']['font']]['weight'] as $weightKey => $weightValue)
                                    <option value="{{ $weightKey }}">{{ $weightValue }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-1/12">
                            <x-label>Font Size</x-label>
                            <x-input
                                wire:model.debouce.500ms="fields.{{ $set->id }}.{{ $field_index }}.settings.size"
                                type="number" step="1" min="6" class="w-10/12" />
                        </div>
                        <div class="w-2/12">
                            <x-label>Field Type</x-label>
                            <x-select wire:model="fields.{{ $set->id }}.{{ $field_index }}.type"
                                :options="$fieldTypes" class="w-10/12" />
                        </div>
                        @if ($fields[$set->id][$field_index]['type'] == 'Static')
                            <div class="w-2/12">
                                <x-label>Static Value</x-label>
                                <x-input
                                    wire:model.debounce.500ms="fields.{{ $set->id }}.{{ $field_index }}.default"
                                    type="text" class="w-10/12" />
                            </div>
                        @else
                            <div class="w-2/12"></div>
                        @endif
                        <div class="w-1/12">
                            <x-button class="mt-6"
                                wire:click="removeField({{ $set->id }}, {{ $field_index }})">Delete
                            </x-button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="flex">
                    <h3>No Fields Added</h3>
                </div>
            @endisset
        </x-container>
    @endforeach
</div>
