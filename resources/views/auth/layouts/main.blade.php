<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
  
        <title>{{ $title ?? 'Kedai Jagat Kopi' }} | Kedai Jabat Kopi</title>
        <link rel="icon" href="{{ asset('img/icon/icon.png') }}">

        {{-- CDN --}}
        <script src="https://kit.fontawesome.com/d7833bfda5.js" crossorigin="anonymous"></script>

        {{-- FONT --}}
        <link href="https://fonts.cdnfonts.com/css/amiri" rel="stylesheet">
        <link href="https://fonts.cdnfonts.com/css/calistoga-2" rel="stylesheet">

        {{-- ICON --}}
        <script src="https://kit.fontawesome.com/d7833bfda5.js" crossorigin="anonymous"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-amiri antialiased overflow-x-hidden">
        @yield('container')
        @stack('scripts')
        <script type="module" src="{{ asset('resources/js/app.js') }}"></script> 
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    </body>
</html>