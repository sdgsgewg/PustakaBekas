<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PustakaBekas | {{ $title }}</title>

    @include('links.index.css')
    @include('links.index.js')
</head>

<body>
    @include('vendors.icons')

    @include('partials.theme')

    @include('partials.navbar')

    @yield('css')

    <main>
        <div class="content container-fluid px-0">
            @yield('container')
        </div>
    </main>

    @yield('js')

    @include('partials.footer')
</body>

</html>
