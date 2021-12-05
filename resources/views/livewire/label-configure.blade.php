<div>
    <x-container>
        <div class="flex justify-between">
            <h1>Label Sets</h1>
            <div>
                <x-button wire:click="saveFields">
                    @include('icons.save')
                    Save Fields
                </x-button>
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
                    <x-label>Set Name</x-label>
                    <x-input wire:model.debounce.500ms="sets.{{ $index }}.name" type="text"
                        class="w-10/12" />
                </div>
                <div class="w-2/6">
                    <x-label>Set Type</x-label>
                    <x-select wire:model="sets.{{ $index }}.type" :options="['1' => 'Single', '2' => 'Grouped']"
                        class="w-10/12" />
                </div>
                @if ($sets[$index]['type'] == '2')
                    <div class="w-1/6">
                        <x-label>Group Column Name</x-label>
                        <x-select wire:model="sets.{{ $index }}.columnName" :options="$columns" />
                    </div>
                @endif
                <div class="w-2/6 text-right">
                    <x-button class="mt-4" wire:click="addField({{ $set->id }})">Add New Field</x-button>
                    <x-button class="mt-4" wire:click="removeSet({{ $index }})">Delete Set</x-button>
                </div>
            </div>
            @isset($fields[$set->id])
                @foreach ($fields[$set->id] as $field_index => $field)
                    <div class="flex mt-2">
                        <div class="w-3/12">
                            <x-label>Field Name</x-label>
                            <x-input wire:model.debounce.500ms="fields.{{ $set->id }}.{{ $field_index }}.name"
                                type="text" class="w-10/12" />
                        </div>
                        <div class="w-3/12">
                            <x-label>Display Name</x-label>
                            <x-input
                                wire:model.debounce.500ms="fields.{{ $set->id }}.{{ $field_index }}.display_name"
                                type="text" class="w-10/12" />
                        </div>
                        <div class="w-3/12">
                            <x-label>Field Type</x-label>
                            <x-select wire:model.debounce.500ms="fields.{{ $set->id }}.{{ $field_index }}.type"
                                :options="$fieldTypes" class="w-10/12" />
                        </div>
                        <div class="w-3/12">
                            <x-label>Default Value</x-label>
                            <x-input wire:model.debounce.500ms="fields.{{ $set->id }}.{{ $field_index }}.default"
                                type="text" class="w-10/12" />
                        </div>
                        <div class="w-3/12">
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
