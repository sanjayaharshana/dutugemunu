<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('association.name')) — {{ config('association.short_name') }}</title>
    <meta name="description" content="@yield('meta_description', 'The official website of the Dutugemunu College Old Boys\' Association, Buttala — news, events, the committee and how to become a member.')">

    <link rel="icon" href="{{ asset('images/favicon-96.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500;1,600&family=Source+Sans+3:wght@400;600;700&family=Noto+Sans+Sinhala:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <noscript><style>.reveal{opacity:1 !important;transform:none !important}</style></noscript>
    @stack('head')
</head>
<body>
<a href="#main" class="sr-only">Skip to content</a>

@include('partials.topbar')
@include('partials.header')

<main id="main">
    @yield('content')
</main>

@include('partials.footer')

<script src="{{ asset('js/site.js') }}" defer></script>
@stack('scripts')
</body>
</html>
