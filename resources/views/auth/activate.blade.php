<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            <h2 class="font-bold text-xl">{{ __('Activate your account') }}</h2>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('activation.store', ['user' => $user->ott]) }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input readonly class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required autofocus />
            </div>
            <!-- Create Password -->
            <div class="mt-2">
                <x-label for="password" :value="__('Create Password')" />

                <x-input type="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Activate') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
