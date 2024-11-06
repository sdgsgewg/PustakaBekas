<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PustakaBekas | {{ $title }}</title>

    @include('vendors.index')
</head>

<body>
    @include('vendors.icons')

    @include('partials.theme')

    @include('partials.navbar')

    <main>
        <div class="{{ Request::is('/') ? 'container-fluid' : 'container' }} {{ Request::is('/') ? '' : 'mt-4' }}"
            style="min-height: 100vh;">
            @yield('container')
        </div>
    </main>

    @include('partials.footer')
</body>

</html>
