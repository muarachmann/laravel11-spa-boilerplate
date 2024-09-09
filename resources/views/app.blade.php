<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" translate="no" dir="{{ page_direction() }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="{{ config('app.name') }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <link rel="shortcut icon" type="image/x-icon"
          href="{{ config('app.shortcut_icon') ?: asset('favicon/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('favicon/safari-pinned-tab.svg') }}" color="#427c8c">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <meta name="description" content="{{ config('app.description') }}">
    <meta name="keywords" content="{{ config('app.keywords') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/js/app.js')
    @inertiaHead
    <script type="text/javascript">
        window.app_name = "{{ config('app.name') }}";
        window.default_locale = "{{ config('app.locale') }}";
        window.fallback_locale = "{{ config('app.fallback_locale') }}";
    </script>
    @auth()
        @if(auth()->user()->hasRole('owner|admin'))
            @routes(['guest', 'admin'])
        @else
            @routes(['guest'])
        @endif
    @endauth
    @guest()
        @routes(['guest'])
    @endguest
</head>
<body class="flex flex-col overflow-scroll-container font-catamaran">
@inertia
</body>
</html>
