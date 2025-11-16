<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{ is_array($seo) ? ($seo['title'] ?? 'Job Search - ' . ($site['site_name'] ?? 'MyJob Portal')) : 'Job Search - ' . ($site['site_name'] ?? 'MyJob Portal') }}</title>

    <meta name="description" content="{{ is_array($seo) ? ($seo['description'] ?? 'Search for the latest job opportunities') : 'Search for the latest job opportunities' }}">
    <meta name="keywords" content="{{ is_array($seo) ? ($seo['keywords'] ?? 'job search, recruitment, employment, career opportunities') : 'job search, recruitment, employment, career opportunities' }}">
    <link rel="canonical" href="{{ is_array($seo) ? ($seo['canonical'] ?? url()->current()) : url()->current() }}">

    
    <!-- Open Graph -->
    <meta property="og:type" content="{{ is_array($seo) ? ($seo['og_type'] ?? 'website') : 'website' }}">
    <meta property="og:title" content="{{ is_array($seo) ? ($seo['title'] ?? 'Job Search - ' . ($site['site_name'] ?? 'MyJob Portal')) : 'Job Search - ' . ($site['site_name'] ?? 'MyJob Portal') }}">
    <meta property="og:description" content="{{ is_array($seo) ? ($seo['description'] ?? 'Search for the latest job opportunities') : 'Search for the latest job opportunities' }}">
    <meta property="og:url" content="{{ is_array($seo) ? ($seo['canonical'] ?? url()->current()) : url()->current() }}">
    <meta property="og:image" content="{{ is_array($seo) ? ($seo['og_image'] ?? asset('assets/images/logo.svg')) : asset('assets/images/logo.svg') }}">

    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="{{ is_array($seo) ? ($seo['twitter_card'] ?? 'summary') : 'summary' }}">
    <meta name="twitter:title" content="{{ is_array($seo) ? ($seo['title'] ?? 'Job Search - ' . ($site['site_name'] ?? 'MyJob Portal')) : 'Job Search - ' . ($site['site_name'] ?? 'MyJob Portal') }}">
    <meta name="twitter:description" content="{{ is_array($seo) ? ($seo['description'] ?? 'Search for the latest job opportunities') : 'Search for the latest job opportunities' }}">
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

    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">

</head>

<body>

    <!-- Header Section -->
    @include('partials.header')


    <!-- Job Search Section -->
    <section class="job-search-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{ __('messages.job_search') }}</h1>
                    <p>{{ __('messages.find_suitable_jobs') }}</p>
                    
                    <!-- Search Form -->
                    <div class="job-search">
                        <form action="{{ route('jobs.index') }}" method="get">
                            <div class="search-inputs">
                                <div class="search-input">
                                    <input type="text" name="keyword" placeholder="{{ __('messages.job_title_keyword_company') }}" value="{{ request('keyword') }}">
                                </div>
                                <div class="search-input">
                                    <input type="text" name="location" placeholder="{{ __('messages.city_province_remote') }}" value="{{ request('location') }}">
                                </div>
                                <div class="search-input">
                                    <select name="category">
                                        <option value="">{{ __('messages.all_categories') }}</option>
                                        @if(isset($categories) && is_array($categories))
                                            @foreach($categories as $category)
                                                @if(isset($category) && is_array($category) && isset($category['id']) && isset($category['name']))
                                                <option value="{{ $category['id'] }}" {{ request('category') == $category['id'] ? 'selected' : '' }}>{{ $category['name'] }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <button type="submit" class="search-button">
                                    <i class="fa fa-search"></i> {{ __('messages.search_jobs') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Job Listings Section -->
    <section class="job-listings-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Search Results Info -->
                    <div class="search-results-info">
                        <h2>{{ __('messages.search_results') }}</h2>
                        <p>{{ __('messages.found_jobs', ['count' => isset($pagination) && is_array($pagination) && isset($pagination['total']) ? $pagination['total'] : count($jobs)]) }}</p>
                    </div>
                    
                    <!-- Job Listings -->
                    <div class="job-listings">
                        @if(!empty($jobs))
                            @foreach($jobs as $job)
                            <div class="job-listing">
                                <div class="job-listing-content">
                                    <div class="job-company-logo">
                                        <img src="{{ $job['company_logo'] ?? asset('assets/images/company-logos/company1.svg') }}" alt="{{ $job['company_name'] }}">
                                    </div>
                                    <div class="job-info">
                                        <h3 class="job-title"><a href="{{ route('jobs.show', $job['slug'] ?? $job['id']) }}">{{ $job['name'] ?? $job['title'] }}</a></h3>
                                        <div class="job-meta">
                                            <span class="company-name">{{ $job['company_name'] }}</span>
                                            <span class="job-location">{{ $job['location'] ?? __('messages.location_undetermined') }}</span>
                                            <span class="job-type">{{ $job['employment_type'] ?? __('messages.full_time') }}</span>
                                            @if(isset($job['salary_min']) || isset($job['salary_max']))
                                            <span class="job-salary">
                                                {{ $job['salary_min'] ?? '' }}{{ isset($job['salary_min']) && isset($job['salary_max']) ? '-' : '' }}{{ $job['salary_max'] ?? '' }}{{ $job['salary_currency'] ?? 'CNY' }}/month
                                            </span>
                                            @endif
                                        </div>
                                        <div class="job-description">
                                            <p>{{ Str::limit(strip_tags($job['description'] ?? ''), 200) }}</p>
                                        </div>
                                        <div class="job-posted-date">
                                            {{ __('messages.posted') }}: {{ $job['created_at'] ? date('Y-m-d', strtotime($job['created_at'])) : __('messages.unknown') }}
                                        </div>
                                    </div>
                                    <div class="job-actions">
                                        <a href="https://myjob.one/jobs/{{ $job['slug'] ?? $job['id'] }}" class="button" target="_blank">Apply Now</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="no-results">
                                <h3>{{ __('messages.no_results') }}</h3>
                                <p>{{ __('messages.try_again') }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Pagination -->
                    @if(isset($pagination) && is_array($pagination) && $pagination['total'] > $pagination['per_page'])
                    <div class="pagination-container">
                        @include('components.pagination', ['pagination' => $pagination])
                    </div>
                    @endif
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
                        <p>{{ $site['site_description'] ?? __('messages.connect_talent_opportunities') }}</p>
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
                        <h3>{{ __('messages.quick_links') }}</h3>
                        <ul class="footer-links">
                            <li><a href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                            <li><a href="{{ route('jobs.index') }}">{{ __('messages.browse_jobs') }}</a></li>
                            <li><a href="{{ route('about') }}">{{ __('messages.about_us') }}</a></li>
                            <li><a href="{{ route('contact') }}">{{ __('messages.contact_us') }}</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Newsletter -->
                <div class="col-md-4">
                    <div class="footer-widget">
                        <h3>{{ __('messages.newsletter') }}</h3>
                        <p>{{ __('messages.subscribe_newsletter') }}</p>
                        <form class="newsletter-form">
                            <input type="email" placeholder="{{ __('messages.your_email_address') }}" required>
                            <button type="submit">{{ __('messages.subscribe') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-12">
                        <p>&copy; {{ date('Y') }} {{ $site['site_name'] ?? 'MyJob Portal' }}. {{ __('messages.all_rights_reserved') }}</p>
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