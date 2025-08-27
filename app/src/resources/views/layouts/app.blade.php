{{-- resources/views/layouts/app.blade.php --}}
    <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>

    {{-- SEO Meta Tags --}}
    <meta name="description" content="@yield('description', '管理画面ダッシュボード')">
    <meta name="keywords" content="@yield('keywords', 'dashboard,管理画面,Laravel')">

    {{-- External Libraries --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    {{-- Core CSS --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v={{ filemtime(public_path('css/dashboard.css')) }}">
    <link rel="stylesheet"
          href="{{ asset('css/components.css') }}?v={{ filemtime(public_path('css/components.css')) }}">

    {{-- Page Specific CSS --}}
    @stack('styles')
</head>
<body>
{{-- Background Effects --}}
<div class="floating-particles"></div>

{{-- Main Content --}}
<main>
    @yield('content')
</main>

{{-- Core JavaScript --}}
<script src="{{ asset('js/dashboard.js') }}?v={{ filemtime(public_path('js/dashboard.js')) }}"></script>
<script src="{{ asset('js/components.js') }}?v={{ filemtime(public_path('js/components.js')) }}"></script>

{{-- Page Specific JavaScript --}}
@stack('scripts')

{{-- CSRF Token for AJAX --}}
<script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
</script>
</body>
</html>
