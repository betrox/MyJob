<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ is_array($seo) ? ($seo['title'] ?? 'MyJob Portal') : 'MyJob Portal' }}</title>

    <meta name="description" content="{{ is_array($seo) ? ($seo['description'] ?? 'A professional recruitment and job-seeking platform') : 'A professional recruitment and job-seeking platform' }}">

    <meta name="keywords" content="{{ is_array($seo) ? ($seo['keywords'] ?? 'recruitment, jobs, career opportunities, job search') : 'recruitment, jobs, career opportunities, job search' }}">

    <link rel="canonical" href="{{ is_array($seo) ? ($seo['canonical'] ?? url()->current()) : url()->current() }}">

    
    <!-- Structured Data -->
    @if(isset($structuredData))
    <script type="application/ld+json">
        {!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif

    
    <!-- CSS Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

</head>

<body>

    <!-- Header Navigation -->
    @include('partials.header')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('partials.footer')
    
    <!-- JavaScript -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    <!-- Page-specific Scripts -->
    @yield('scripts')

</body>

</html>