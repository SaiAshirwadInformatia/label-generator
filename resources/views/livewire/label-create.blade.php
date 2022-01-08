<div>
    <x-container>
        <form wire:submit.prevent="submitForm" method="post">

            <div class="flex space-x-4 mt-2">

                <div class="w-4/12 mt-2">
                    <x-label for="path" :value="__('Select Excel')" />
                    <x-input wire:model.debounce.500ms="path" class="block border p-1 mt-1 w-full" type="file"
                        required />
                    @error('path')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-8/12 mt-2">
                    <x-label for="name" :value="__('Name')" />
                    <x-input wire:model.defer="name" class="block mt-1 w-full" type="text" required autofocus />
                    @if ($errors->has('name'))
                        <span class="error">{{ $errors->name }}</span>
                    @endif
                </div>
            </div>

            <div class="flex space-x-4 mt-2">
                <div class="w-4/12 ">
                    <x-label for="size" :value="__('Page Size')" />
                    <x-select wire:model.defer="size" id="size" class="block mt-1 w-full" :options="$pageOptions" />
                    @error('size')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-4/12">
                    <x-label for="orientation" :value="__('Page Orientation')" />
                    <x-select wire:model.defer="orientation" id="orientation" class="block mt-1 w-full"
                        :options="$pageOrientations" />
                    @error('orientation')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-4/12">
                    <x-label for="numbers" :value="__('Page Number')" />
                    <x-select wire:model.defer="numbers" id="numbers" class="block mt-1 w-full"
                        :options="['0' => 'No', '1' => 'Yes']" />
                    @error('numbers')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-4/12">
                    <x-label for="column_nos" :value="__('Page Columns')" />
                    <x-select wire:model.defer="column_nos" id="column_nos" class="block mt-1 w-full"
                        :options="[1 => 1, 2 => 2, 3 => 3, 4 => 4]" />
                    @error('column_nos')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            @isset($templateList)
                <div class="flex mt-2">
                    <div class="w-1/3">
                        <x-label for="template_id" :value="__('Create from Template')" />
                        <x-select wire:model.defer="template_id" :options="$templateList"></x-select>
                    </div>
                </div>
            @endisset
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
