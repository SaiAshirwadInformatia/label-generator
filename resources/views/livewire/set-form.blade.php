<x-container>
    <div class="flex">
        <div class="w-2/6">
            <x-label class="font-bold">Set Name</x-label>
            <x-input wire:model.debounce.500ms="set.name" type="text" class="w-10/12" />
        </div>
        <div class="w-1/6">
            <x-label class="font-bold">Set Type</x-label>
            <x-select wire:model="set.type" :options="['1' => 'Single', '2' => 'Grouped']" class="w-10/12" />
        </div>
        @if ($set->type == '2')
            <div class="w-1/6">
                <x-label class="font-bold">Group Column Name</x-label>
                <x-select wire:model="set.columnName" :options="$columns" />
            </div>
        @endif
        <div class="w-3/6 text-right">
            <x-button class="mt-3" wire:click="generateExcel">
                @include('icons.document-download')
                Generate PDF
            </x-button>
            <x-button class="mt-3" wire:click="addField">
                @include('icons.hashtag')
                Add Field
            </x-button>
            <x-button class="mt-3" wire:click="destroy">
                @include('icons.trash')
                Delete Set
            </x-button>
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
