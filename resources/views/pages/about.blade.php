<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{ is_array($seo) ? ($seo['title'] ?? 'About Us - ' . ($site['site_name'] ?? 'MyJob Portal')) : 'About Us - ' . ($site['site_name'] ?? 'MyJob Portal') }}</title>
    <meta name="description" content="{{ is_array($seo) ? ($seo['description'] ?? 'Learn about our mission and values') : 'Learn about our mission and values' }}">
    <meta name="keywords" content="{{ is_array($seo) ? ($seo['keywords'] ?? 'about us, company introduction, team, mission') : 'about us, company introduction, team, mission' }}">
    <link rel="canonical" href="{{ is_array($seo) ? ($seo['canonical'] ?? url()->current()) : url()->current() }}">

    <!-- Open Graph -->
    <meta property="og:type" content="{{ is_array($seo) ? ($seo['og_type'] ?? 'website') : 'website' }}">
    <meta property="og:title" content="{{ is_array($seo) ? ($seo['title'] ?? 'About Us - ' . ($site['site_name'] ?? 'MyJob Portal')) : 'About Us - ' . ($site['site_name'] ?? 'MyJob Portal') }}">
    <meta property="og:description" content="{{ is_array($seo) ? ($seo['description'] ?? 'Learn about our mission and values') : 'Learn about our mission and values' }}">
    <meta property="og:url" content="{{ is_array($seo) ? ($seo['canonical'] ?? url()->current()) : url()->current() }}">
    <meta property="og:image" content="{{ is_array($seo) ? ($seo['og_image'] ?? asset('assets/images/logo.svg')) : asset('assets/images/logo.svg') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="{{ is_array($seo) ? ($seo['twitter_card'] ?? 'summary') : 'summary' }}">
    <meta name="twitter:title" content="{{ is_array($seo) ? ($seo['title'] ?? 'About Us - ' . ($site['site_name'] ?? 'MyJob Portal')) : 'About Us - ' . ($site['site_name'] ?? 'MyJob Portal') }}">
    <meta name="twitter:description" content="{{ is_array($seo) ? ($seo['description'] ?? 'Learn about our mission and values') : 'Learn about our mission and values' }}">
    <meta name="twitter:image" content="{{ is_array($seo) ? ($seo['og_image'] ?? asset('assets/images/logo.svg')) : asset('assets/images/logo.svg') }}">

    <!-- JSON-LD Structured Data -->
    @if(isset($structuredData['website']))
    <script type="application/ld+json">
        {!! json_encode($structuredData['website'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif

    @if(isset($structuredData['organization']))
    <script type="application/ld+json">
        {!! json_encode($structuredData['organization'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif

    @if(isset($structuredData['faq']))
    <script type="application/ld+json">
        {!! json_encode($structuredData['faq'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Header Section -->
    @include('partials.header')

    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(isset($breadcrumbs))
                        @foreach($breadcrumbs as $breadcrumb)
                            @if($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
                            @endif
                        @endforeach
                    @else
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">About Us</li>
                    @endif
                </ol>
            </nav>
        </div>
    </section>

    <!-- About Hero Section -->
    <section class="about-hero-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>About Us</h1>
                    <p>Connecting outstanding talents with the best job opportunities</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Content Section -->
    <section class="about-content-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="about-content">
                        <h2>Our Mission</h2>
                        <p>We are committed to building an efficient and convenient communication platform for job seekers and employers. Through advanced technology and professional services, we help talents find ideal jobs and help companies find the right people.</p>

                        <h2>Our Vision</h2>
                        <p>To become the most trusted recruitment platform, driving digital transformation in the HR industry through technological innovation and contributing to social development.</p>

                        <h2>Our Values</h2>
                        <div class="values-list">
                            <div class="value-item">
                                <h3><i class="fa fa-users"></i> Customer First</h3>
                                <p>Always user-oriented, providing a high-quality service experience.</p>
                            </div>
                            <div class="value-item">
                                <h3><i class="fa fa-lightbulb-o"></i> Innovation Driven</h3>
                                <p>Continuously exploring new technologies, optimizing product functions, and improving service quality.</p>
                            </div>
                            <div class="value-item">
                                <h3><i class="fa fa-shield"></i> Integrity & Reliability</h3>
                                <p>Committed to honest operations, protecting user privacy, and ensuring information security.</p>
                            </div>
                            <div class="value-item">
                                <h3><i class="fa fa-handshake-o"></i> Win-Win Cooperation</h3>
                                <p>Growing together with partners to achieve mutual benefits.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="about-sidebar">
                        <div class="statistics">
                            <h3>Platform Data</h3>
                            <div class="stat-item">
                                <span class="stat-number">10,000+</span>
                                <span class="stat-label">Registered Companies</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">50,000+</span>
                                <span class="stat-label">Active Jobs</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">100,000+</span>
                                <span class="stat-label">Job Seekers</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">95%</span>
                                <span class="stat-label">User Satisfaction</span>
                            </div>
                        </div>

                        <div class="team-info">
                            <h3>Our Team</h3>
                            <p>We have an experienced technical team and a professional customer service team dedicated to providing the best user experience.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- History Section -->
    <section class="history-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Development History</h2>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-year">2020</div>
                            <div class="timeline-content">
                                <h3>Platform Founded</h3>
                                <p>The company was established and began developing the recruitment platform.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2021</div>
                            <div class="timeline-content">
                                <h3>Product Launch</h3>
                                <p>The platform officially went online and gained its first users.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2022</div>
                            <div class="timeline-content">
                                <h3>Rapid Growth</h3>
                                <p>Users grew quickly, and platform features were continuously improved.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2023</div>
                            <div class="timeline-content">
                                <h3>Technological Innovation</h3>
                                <p>Introduced AI technology and optimized the matching algorithm.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2024</div>
                            <div class="timeline-content">
                                <h3>Continuous Improvement</h3>
                                <p>Kept refining products and enhancing user experience.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="footer">
        <div class="container">
            <div class="row">
                <!-- Company Info -->
                <div class="col-md-4">
                    <div class="footer-widget">
                        <h3>{{ $site['site_name'] ?? 'MyJob Portal' }}</h3>
                        <p>{{ $site['site_description'] ?? 'Connecting outstanding talents with the best job opportunities' }}</p>
                        <div class="social-icons">
                            <a href="#" class="social-icon"><i class="fa fa-weibo"></i></a>
                            <a href="#" class="social-icon"><i class="fa fa-wechat"></i></a>
                            <a href="#" class="social-icon"><i class="fa fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-md-4">
                    <div class="footer-widget">
                        <h3>Quick Links</h3>
                        <ul class="footer-links">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('jobs.index') }}">Browse Jobs</a></li>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="col-md-4">
                    <div class="footer-widget">
                        <h3>Newsletter</h3>
                        <p>Subscribe to our mailing list to receive the latest job updates.</p>
                        <form class="newsletter-form">
                            <input type="email" placeholder="Your email address" required>
                            <button type="submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-12">
                        <p>&copy; {{ date('Y') }} {{ $site['site_name'] ?? 'MyJob Portal' }}. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>