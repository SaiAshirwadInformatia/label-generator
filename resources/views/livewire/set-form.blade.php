<x-container>
    <div class="flex justify-between">
        <div class="grow">
            <x-label class="font-bold">Set Name</x-label>
            <x-input wire:model.debounce.500ms="set.name" type="text" class="w-10/12" />
        </div>
        <div class="grow">
            <x-label class="font-bold">Different Page</x-label>
            <x-select wire:model="set.settings.differentPage" :options="$columns"></x-select>
        </div>
        <div class="grow">
            <x-label class="font-bold">Set Type</x-label>
            <x-select wire:model="set.type" :options="['1' => 'Single', '2' => 'Grouped']" class="w-10/12" />
        </div>
        @if ($set->type == '2')
            <div class="grow">
                <x-label class="font-bold">Group Column Name</x-label>
                <x-select wire:model="set.columnName" :options="$columns" />
            </div>
        @endif
        <div class="shrink text-right">
            <x-small-button class="mt-3" wire:click="previewPDF">
                <x-icon.eye class="w-3 h-3"></x-icon.eye>
                Preview PDF
            </x-small-button>
            <x-small-button class="mt-3" wire:click="generatePDF">
                <x-icon.document class="w-3 h-3">
                    </x-icon.eye>
                    Generate PDF
            </x-small-button>
            <x-small-button class="mt-3" wire:click="addField">
                <x-icon.hashtag class="w-3 h-3">
                    </x-icon.eye>
                    Add Field
            </x-small-button>
            <x-small-button class="mt-3" wire:click="destroy">
                <x-icon.trash class="w-3 h-3">
                    </x-icon.eye>
                    Delete Set
            </x-small-button>
        </div>
    </div>
    <hr class="my-8" />
    @if ($set->fields->count())
        @foreach ($set->fields as $field_index => $field)
            @livewire('field-form', ['field' => $field], key($field->id))
        @endforeach
    @else
        <div class="flex">
            <h3>No Fields Added</h3>
        </div>
    @endif
</x-container>
