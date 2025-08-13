<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
  
        <title>{{ $title ?? 'Kedai Jagat Kopi' }} | Kedai Jabat Kopi</title>
        <link rel="icon" href="{{ asset('img/icon/icon.png') }}">
        
        {{-- FONT --}}
        <link href="https://fonts.cdnfonts.com/css/amiri" rel="stylesheet">
        <link href="https://fonts.cdnfonts.com/css/calistoga-2" rel="stylesheet">

        {{-- ICON --}}
        <script src="https://kit.fontawesome.com/d7833bfda5.js" crossorigin="anonymous"></script>

        {{-- DAISY UI --}}
        <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

        {{-- ALPINE JS --}}
        <script src="//unpkg.com/alpinejs" defer></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-amiri antialiased overflow-x-hidden bg-greenJagat">
        @include('customer.partials.navbar')
        @yield('container')
        @include('customer.partials.footer')
        @stack('scripts')
        <script type="module" src="{{ asset('resources/js/app.js') }}"></script> 
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

        <script defer src="https://js.stripe.com/v3/"></script>
        <script defer src="https://m.servedby-buysellads.com/monetization.js" type="text/javascript"></script>
        
        <script>
            function storeClosedAlert() {
                Swal.fire({
                    icon: 'info',
                    title: 'Store Closed',
                    text: 'Sorry, we are currently closed. Please check our operating hours.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#2E6342'
                });
            }
        </script>
    </body>
</html>