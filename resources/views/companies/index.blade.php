<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seo['title'] ?? 'Company List' }}</title>
    <meta name="description" content="{{ $seo['description'] ?? 'Browse top companies and discover more career opportunities' }}">
    <meta name="keywords" content="{{ $seo['keywords'] ?? 'company list, corporate recruitment, employer branding' }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ $seo['canonical'] ?? url('/companies') }}">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Structured Data -->
    @if(isset($structuredData['jsonLd']))
        <script type="application/ld+json">
            {!! json_encode($structuredData['jsonLd']) !!}
        </script>
    @endif
</head>
<body>
    <!-- Header Navigation -->
    @include('partials.header')

    <!-- Breadcrumb Navigation -->
    <section class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(is_array($breadcrumbs))
                        @foreach($breadcrumbs as $crumb)
                            <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                                @if(!$loop->last)
                                    <a href="{{ $crumb['url'] ?? '' }}">{{ $crumb['name'] ?? '' }}</a>
                                @else
                                    {{ $crumb['name'] ?? '' }}
                                @endif
                            </li>
                        @endforeach
                    @else
                        <!-- Breadcrumb data error, show default navigation -->
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Company List</li>
                    @endif
                </ol>
            </nav>
        </div>
    </section>

    <!-- Main Content for Company List -->
    <main class="companies-page">
        <div class="container">
            <div class="row">
                <!-- Sidebar Filters -->
                <div class="col-lg-3">
                    <div class="filter-sidebar">
                        <h4>Filter Options</h4>
                        
                        <!-- Search Box -->
                        <div class="filter-group">
                            <label for="search">Search Company</label>
                            <input type="text" id="search" name="q" value="{{ $searchParams['q'] ?? '' }}" 
                                   placeholder="Enter company name..." class="form-control">
                        </div>
                        
                        <!-- Industry Filter -->
                        @if(!empty($industries) && is_array($industries))
                            <div class="filter-group">
                                <label for="industry">Industry</label>
                                <select id="industry" name="industry" class="form-control">
                                    <option value="">All Industries</option>
                                    @foreach($industries as $industry)
                                        <option value="{{ $industry['id'] ?? $industry['value'] ?? '' }}" 
                                                {{ ($searchParams['industry'] ?? '') == ($industry['id'] ?? $industry['value'] ?? '') ? 'selected' : '' }}>
                                            {{ $industry['name'] ?? $industry['text'] ?? 'Unknown Industry' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        
                        <!-- Location Filter -->
                        <div class="filter-group">
                            <label for="location">Location</label>
                            <input type="text" id="location" name="location" value="{{ $searchParams['location'] ?? '' }}" 
                                   placeholder="Enter location..." class="form-control">
                        </div>
                        
                        <!-- Filter Buttons -->
                        <button type="button" class="btn btn-primary btn-block" onclick="applyFilters()">
                            Apply Filters
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-block mt-2" onclick="resetFilters()">
                            Reset Filters
                        </button>
                    </div>
                </div>
                
                <!-- Company List -->
                <div class="col-lg-9">
                    <div class="companies-header">
                        <h1>Company List</h1>
                        <p class="text-muted">Discover top companies and start a new career chapter</p>
                    </div>
                    
                    @if(!empty($companies) && is_array($companies))
                        <div class="companies-grid">
                            @foreach($companies as $company)
                                @if(is_array($company))
                                    <div class="company-card">
                                        <div class="company-logo">
                                            @if(!empty($company['logo']))
                                                <img src="{{ $company['logo'] }}" alt="{{ $company['name'] ?? 'Company' }}" 
                                                     onerror="this.src='{{ asset('assets/images/default-company.png') }}'">
                                            @else
                                                <div class="default-logo">
                                                    <i class="fa fa-building"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="company-info">
                                            <h3>
                                                <a href="{{ route('companies.show', ['slug' => $company['slug'] ?? $company['id'] ?? '']) }}">
                                                    {{ $company['name'] ?? 'Unknown Company' }}
                                                </a>
                                            </h3>
                                            
                                            <p class="company-industry">
                                                <i class="fa fa-industry"></i>
                                                {{ $company['industry'] ?? 'Uncategorized' }}
                                            </p>
                                            
                                            <p class="company-location">
                                                <i class="fa fa-map-marker"></i>
                                                {{ $company['location'] ?? 'Location Unknown' }}
                                            </p>
                                            
                                            @if(!empty($company['description']))
                                                <p class="company-description">
                                                    {{ Str::limit(strip_tags($company['description']), 120) }}
                                                </p>
                                            @endif
                                            
                                            <div class="company-stats">
                                                @if(!empty($company['employee_count']))
                                                    <span class="stat">
                                                        <i class="fa fa-users"></i>
                                                        {{ $company['employee_count'] }} Employees
                                                    </span>
                                                @endif
                                                
                                                @if(!empty($company['job_count']))
                                                    <span class="stat">
                                                        <i class="fa fa-briefcase"></i>
                                                        {{ $company['job_count'] }} Jobs
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        @if(isset($pagination) && is_array($pagination) && ($pagination['last_page'] ?? 1) > 1)
                            <div class="pagination-wrapper">
                                @include('components.pagination', ['pagination' => $pagination])
                            </div>
                        @endif
                        
                    @else
                        <div class="no-companies">
                            <div class="text-center">
                                <i class="fa fa-building-o fa-3x text-muted"></i>
                                <h3>No Company Data</h3>
                                <p class="text-muted">No matching companies found for the current filter</p>
                                <button class="btn btn-primary" onclick="resetFilters()">Reset Filter Options</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- JavaScript -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    <script>
        function applyFilters() {
            const search = document.getElementById('search').value;
            const industry = document.getElementById('industry').value;
            const location = document.getElementById('location').value;
            
            const params = new URLSearchParams();
            
            if (search) params.append('q', search);
            if (industry) params.append('industry', industry);
            if (location) params.append('location', location);
            
            window.location.href = '{{ route("companies.index") }}?' + params.toString();
        }
        
        function resetFilters() {
            window.location.href = '{{ route("companies.index") }}';
        }
        
        // Enter key triggers search
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        applyFilters();
                    }
                });
            }
        });
    </script>
</body>
</html>