{{-- $title, $subtitle, optional $crumb (label of current page) --}}
<section class="page-hero">
    <div class="wrap page-hero__inner">
        <div class="crumbs">
            <a href="{{ route('home') }}">Home</a><span>/</span>{{ $crumb ?? $title }}
        </div>
        <h1>{{ $title }}</h1>
        @isset($subtitle)
            <p>{{ $subtitle }}</p>
        @endisset
    </div>
</section>
