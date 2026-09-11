@php($nav = [
    ['label' => 'Home',            'route' => 'home'],
    ['label' => 'About',           'route' => 'about'],
    ['label' => 'The Committee',   'route' => 'committee'],
    ['label' => 'News & Events',   'route' => 'news'],
    ['label' => 'Contact',         'route' => 'contact'],
])
<header class="site-header">
    <div class="wrap">
        <a href="{{ route('home') }}" class="brand" aria-label="{{ config('association.name') }} home">
            <img src="{{ asset('images/logo-256.png') }}" alt="{{ config('association.name') }} crest" class="brand__crest">
            <span class="brand__text">
                <span class="brand__name">Dutugemunu College</span>
                <span class="brand__sub">Old Boys' Association &middot; Buttala</span>
            </span>
        </a>

        <button class="nav-toggle" aria-label="Menu" aria-expanded="false" aria-controls="primary-nav">
            <span></span>
        </button>

        <nav class="nav" id="primary-nav" aria-label="Primary">
            @foreach ($nav as $item)
                <a href="{{ route($item['route']) }}"
                   @if (request()->routeIs($item['route']) || ($item['route'] === 'news' && request()->routeIs('news.show'))) aria-current="page" @endif>
                    {{ $item['label'] }}
                </a>
            @endforeach
            <a href="{{ route('committee') }}#membership" class="btn btn--primary nav__cta">Become a Member</a>
        </nav>
    </div>
</header>
