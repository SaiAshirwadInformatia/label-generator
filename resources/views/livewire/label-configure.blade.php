<div>
    <x-container>
        <div class="flex justify-between">
            <div class="w-10/12 flex flex-wrap space-x-2">
                <div class="w-1/4 px-2">
                    <x-label for="size" :value="__('Page Size')"/>
                    <x-select wire:model.live="label.settings.size" id="size" class="block mt-1 w-full"
                              :options="$pageOptions"/>
                    @error('size')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/4 px-2">
                    <x-label for="orientation" :value="__('Page Orientation')"/>
                    <x-select wire:model.live="label.settings.orientation" id="orientation" class="block mt-1 w-full"
                              :options="$pageOrientations"/>
                    @error('orientation')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/4 px-2">
                    <x-label for="numbers" :value="__('Page Number')"/>
                    <x-select wire:model.live="label.settings.numbers" id="numbers" class="block mt-1 w-full"
                              :options="['0' => 'No', '1' => 'Yes']"/>
                    @error('numbers')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/5 px-2">
                    <x-label for="column_nos" :value="__('Page Columns')"/>
                    <x-select wire:model.live="label.settings.column_nos" id="column_nos" class="block mt-1 w-full"
                              :options="[1 => 1, 2 => 2, 3 => 3, 4 => 4, 5=>5, 6=>6, 7=>7, 8=>8]"/>
                    @error('column_nos')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="pt-4">
                <x-button wire:click="addNewSet">
                    <x-icon.add class="w-6 h-6 mr-1"></x-icon.add>
                    Add New Set
                </x-button>
            </div>
        </div>
    </x-container>

    @foreach ($label->sets as $index => $set)
        @livewire('set-form', ['set' => $set], key($set->id))
    @endforeach
</div>
