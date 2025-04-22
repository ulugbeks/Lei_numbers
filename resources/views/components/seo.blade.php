<!-- Primary Meta Tags -->
<title>{{ isset($page) && $page->meta_title ? $page->meta_title : (isset($page) && $page->title ? $page->title : config('app.name', 'Laravel')) }}</title>
<meta name="title" content="{{ isset($page) && $page->meta_title ? $page->meta_title : (isset($page) && $page->title ? $page->title : config('app.name', 'Laravel')) }}">
@if(isset($page) && $page->meta_description)
<meta name="description" content="{{ $page->meta_description }}">
@endif

<!-- Robots directives -->
@if(isset($page) && (isset($page->no_index) && $page->no_index || isset($page->no_follow) && $page->no_follow))
<meta name="robots" content="{{ (isset($page->no_index) && $page->no_index ? 'noindex' : 'index') }}, {{ (isset($page->no_follow) && $page->no_follow ? 'nofollow' : 'follow') }}">
@endif

<!-- Canonical Link -->
<link rel="canonical" href="{{ isset($page) && method_exists($page, 'getCanonicalUrl') ? $page->getCanonicalUrl() : (isset($page) && isset($page->canonical_url) && $page->canonical_url ? $page->canonical_url : url()->current()) }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ isset($page) && isset($page->og_type) && $page->og_type ? $page->og_type : 'website' }}">
<meta property="og:url" content="{{ isset($page) && isset($page->canonical_url) && $page->canonical_url ? $page->canonical_url : url()->current() }}">
<meta property="og:title" content="{{ isset($page) && isset($page->og_title) && $page->og_title ? $page->og_title : (isset($page) && $page->meta_title ? $page->meta_title : (isset($page) && $page->title ? $page->title : config('app.name', 'Laravel'))) }}">
@if(isset($page) && (isset($page->og_description) && $page->og_description || isset($page->meta_description) && $page->meta_description))
<meta property="og:description" content="{{ isset($page) && isset($page->og_description) && $page->og_description ? $page->og_description : (isset($page) && isset($page->meta_description) ? $page->meta_description : '') }}">
@endif
<meta property="og:image" content="{{ isset($page) && isset($page->og_image) && $page->og_image ? asset('storage/' . $page->og_image) : asset('assets/img/default-og-image.jpg') }}">

<!-- Twitter -->
<meta property="twitter:card" content="{{ isset($page) && isset($page->twitter_card) && $page->twitter_card ? $page->twitter_card : 'summary_large_image' }}">
<meta property="twitter:url" content="{{ isset($page) && isset($page->canonical_url) && $page->canonical_url ? $page->canonical_url : url()->current() }}">
<meta property="twitter:title" content="{{ isset($page) && isset($page->og_title) && $page->og_title ? $page->og_title : (isset($page) && $page->meta_title ? $page->meta_title : (isset($page) && $page->title ? $page->title : config('app.name', 'Laravel'))) }}">
@if(isset($page) && (isset($page->og_description) && $page->og_description || isset($page->meta_description) && $page->meta_description))
<meta property="twitter:description" content="{{ isset($page) && isset($page->og_description) && $page->og_description ? $page->og_description : (isset($page) && isset($page->meta_description) ? $page->meta_description : '') }}">
@endif
<meta property="twitter:image" content="{{ isset($page) && isset($page->og_image) && $page->og_image ? asset('storage/' . $page->og_image) : asset('assets/img/default-og-image.jpg') }}">

<!-- JSON-LD Structured Data -->
@if(isset($page) && isset($page->structured_data) && $page->structured_data)
<script type="application/ld+json">
    {!! json_encode($page->structured_data) !!}
</script>
@endif