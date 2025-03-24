<!DOCTYPE html>
<html {!! locale_attributes() !!}>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? '' }} | {{ config('app.name', 'Fadgram starter kit') }}</title>
    <meta name="description" content="{{ $description ?? config('app.description') }}">
    {{-- 
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600" rel="stylesheet" />
    --}}
    <link rel="stylesheet" href="{{ asset('assets/fonts/poppins/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
    @stack('styles')
    @stack('scripts')
</head>

<body>
    {{ $slot }}
    @if (config('eruda.enabled'))
        <script src="{{ asset('assets/eruda/eruda.js') }}"></script>
        <script>
            eruda.init();
        </script>
    @endif

</body>

</html>
