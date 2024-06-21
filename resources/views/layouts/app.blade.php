<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
        {{-- Font Awesome --}}
        <script src="https://kit.fontawesome.com/68697ef03c.js" crossorigin="anonymous"></script>

        {{-- 独自のCSS --}}
        <link href="{{ asset('css/hikkoshi-pro.css') }}" rel="stylesheet"></head>

    {{-- <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body> --}}

    <body>
        <div id="app">
            @component('components.header')
            @endcomponent

            <main class="py-1" style="min-height: calc(100vh - 9.6rem);">
                @yield('content')
            </main>

            @component('components.footer')
            @endcomponent
        </div>
    </body>
</html>
