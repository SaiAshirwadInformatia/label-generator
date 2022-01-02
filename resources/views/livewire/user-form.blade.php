<div>
    <x-container>
        <form wire:submit.prevent="submitForm" method="post">

            <div class="mb-2">
                <label class="px-1 text-lg">Name</label>
                <x-input wire:model.defer="user.name" class="w-full border p-1 mt-0"></x-input>
            </div>
            <div class="mb-2">
                <label class="px-1 text-lg">Company</label>
                <x-input wire:model.defer="user.company" class="w-full border p-1 mt-0"></x-input>
            </div>
            <div class="mb-2">
                <label class="px-1 text-lg">Email</label>
                <x-input wire:model.defer="user.email" class="w-full border p-1 mt-0"></x-input>
            </div>
            <div class="mb-2">
                <label class="px-1 text-lg">Level</label>
                <x-select wire:model.defer="user.level" class="w-full border p-1 mt-0" :options="$levels"></x-select>
            </div>
            <x-button class="mt-4">
                <svg wire:loading class="animate-spin mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Submit
            </x-button>
        </form>
    </x-container>
</div>
