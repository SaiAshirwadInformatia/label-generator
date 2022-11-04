<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ url('favicon.ico') }}" />

    <meta property="og:title" content="Label Generator by Sai Ashirwad Informatia" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ url('icon.png') }}" />


    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    @vite('resources/css/app.css')

    @livewireStyles
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>

        <!-- Page Content -->
        <main class="pb-16">
            {{ $slot }}
        </main>
    </div>
    <!-- Scripts -->
    @vite('resources/js/app.js')
    @livewireScripts

    
    <script>
        window.onload = () => {
        @if(session()->has('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session()->get("success") }}',
            icon: 'success',
            confirmButtonText: 'Ok',
            timer: 2000
        })
        @endif
        @if(session()->has('error'))
        Swal.fire({
            title: 'Error!',
            text: '{{ session()->get("error") }}',
            icon: 'error',
            confirmButtonText: 'Ok',
            timer: 3000
        })
        @endif
    };
    </script>
</body>

</html>
