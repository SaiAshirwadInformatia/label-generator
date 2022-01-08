<div class="flex">

    <x-input wire:model.defer="template.name" class="h-10 border p-1 mr-1" required
        placeholder="Template Name" />
    <x-button wire:click="submit">
        <svg wire:loading class="animate-spin mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
        <x-icon.add wire:loading.remove class="w-6 h-6 mr-1"></x-icon.add>
        @isset($label->template)
            Update Template
        @else
            Save as Template
        @endisset
    </x-button>
</div>
