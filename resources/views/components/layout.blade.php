<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap-5.css') }}">

    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <livewire:styles />
    
    @stack('styles')
</head>

<body>
    @include('layouts.navbar')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-4">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <livewire:scripts />

    @stack('scripts')
</body>

</html>
