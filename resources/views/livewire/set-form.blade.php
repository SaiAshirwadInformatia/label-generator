<x-container>
    <div class="flex flex-wrap space-x-2">
        <div class="flex-auto">
            <x-label class="font-bold">Set Name</x-label>
            <x-input wire:model.debounce.500ms="set.name" type="text" class="w-10/12" />
        </div>
        <div class="flex-shrink">
            <x-label class="font-bold">Limit</x-label>
            <x-input wire:model="set.limit" type="number" step="1" class="w-6/12" />
        </div>
        <div class="flex-shrink">
            <x-label class="font-bold">Incremental Start</x-label>
            <x-input wire:model="set.incremental" type="number" step="1" class="w-6/12" />
        </div>
        <div class="flex-shrink">
            <x-label class="font-bold">Header Width</x-label>
            <x-input wire:model="set.header_width" type="number" step="1" class="w-6/12" />
        </div>
        <div class="flex-shrink">
            <x-label class="font-bold">Header Font</x-label>
            <x-input wire:model="set.header_font" type="number" step="1" class="w-10/12" />
        </div>
        <div class="flex-auto">
            <x-label class="font-bold">Different Page</x-label>
            <x-select required wire:model="set.settings.differentPage" :options="$columns" class="w-11/12"></x-select>
        </div>
        <div class="flex-auto">
            <x-label class="font-bold">Set Type</x-label>
            <x-select wire:model="set.type" :options="['1' => 'Single', '2' => 'Grouped']" class="w-10/12" />
        </div>
        @if ($set->type == '2')
            <div class="flex-auto">
                <x-label class="font-bold">Group Column Name</x-label>
                <x-select wire:model="set.columnName" :options="$columns" />
            </div>
        @endif
    </div>
    <div class="mt-3 flex flex-wrap space-x-2">

            <x-small-button class="flex-auto" wire:click="previewPDF">
                <x-icon.eye class="w-3 h-3"></x-icon.eye>
                Preview PDF
            </x-small-button>
            <x-small-button class="flex-auto" wire:click="openWebPage">
                <x-icon.eye class="w-3 h-3"></x-icon.eye>
                Open Web Page
            </x-small-button>
            <x-small-button class="flex-auto" wire:click="generatePDF">
                <x-icon.document class="w-3 h-3"></x-icon.document>
                Generate PDF
            </x-small-button>
            <x-small-button class="flex-auto" wire:click="addField">
                <x-icon.hashtag class="w-3 h-3"></x-icon.hashtag>
                Add Field
            </x-small-button>
            <x-small-button class="flex-auto" wire:click="destroy">
                <x-icon.trash class="w-3 h-3"></x-icon.trash>
                Delete Set
            </x-small-button>

    </div>
    <hr class="my-8" />
    @if ($set->fields()->count())
        @foreach ($set->fields()->orderBy('sequence', 'ASC')->get()
    as $field_index => $field)
            @livewire('field-form', [
            'set' => $set,
            'field' => $field,
            'isLast' => $loop->last
            ], key($field->id))
        @endforeach
    @else
        <div class="flex">
            <h3>No Fields Added</h3>
        </div>
    @endif
    {{-- <div x-data="{
        showIFrame: !!@this.get('previewLink'),
        hideIFrame: () => this.showIFrame = false && Livewire.emit('hidePreview')
    }" x-show="showIFrame" class="fixed top-0 left-0 w-full h-screen flex align-center items-center">
        <div class="w-1/2 mx-auto bg-white rounded shadow">
            <div class="flex space-between">
                <h3>Preview</h3>
                <span>
                    <x-icon.close @click="hideIFrame"></x-icon.close>
                </span>
            </div>
            <iframe :src="@this.get('previewLink')" class="absolute inset-0 w-full h-full" frameboder="0"></iframe>
        </div>

    </div> --}}
</x-container>
