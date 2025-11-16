@extends('layouts.app')

@section('title', $seo['title'] ?? 'Company Details')
@section('description', $seo['description'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('canonical', $seo['canonical'] ?? '')

@section('structured_data')
    @if(isset($structuredData['jsonLd']))
        <script type="application/ld+json">
            {!! json_encode($structuredData['jsonLd'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endif
    @if(isset($structuredData['breadcrumb']))
        <script type="application/ld+json">
            {!! json_encode($structuredData['breadcrumb'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endif
    @if(isset($structuredData['organization']))
        <script type="application/ld+json">
            {!! json_encode($structuredData['organization'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endif
@endsection

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Breadcrumb Navigation -->
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-2 py-4 text-sm">
                @foreach($breadcrumbs as $index => $crumb)
                    @if($index < count($breadcrumbs) - 1)
                        <a href="{{ $crumb['url'] }}" class="text-blue-600 hover:text-blue-800">{{ $crumb['name'] }}</a>
                        <span class="text-gray-400">/</span>
                    @else
                        <span class="text-gray-600">{{ $crumb['name'] }}</span>
                    @endif
                @endforeach
            </div>
        </div>
    </nav>

    <!-- Company Header Information -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-6">
                <!-- Company Logo -->
                <div class="flex-shrink-0">
                    @if(isset($company['logo']) && $company['logo'])
                        <img src="{{ $company['logo'] }}" 
                             alt="{{ $company['name'] ?? 'Company Logo' }}" 
                             class="w-20 h-20 md:w-24 md:h-24 rounded-lg object-cover border border-gray-200">
                    @else
                        <div class="w-20 h-20 md:w-24 md:h-24 rounded-lg bg-gray-200 flex items-center justify-center">
                            <span class="text-2xl font-bold text-gray-400">{{ substr($company['name'] ?? 'Company', 0, 2) }}</span>
                        </div>
                    @endif
                </div>
                
                <!-- Basic Company Information -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $company['name'] ?? 'Company Name' }}</h1>
                    
                    <div class="flex flex-wrap items-center space-x-4 text-sm text-gray-600 mb-3">
                        @if(isset($company['industry']) && $company['industry'])
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                                </svg>
                                {{ $company['industry'] }}
                            </span>
                        @endif
                        
                        @if(isset($company['location']) && $company['location'])
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                {{ $company['location'] }}
                            </span>
                        @endif
                        
                        @if(isset($company['size']) && $company['size'])
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                </svg>
                                {{ $company['size'] }} employees
                            </span>
                        @endif
                    </div>
                    
                    @if(isset($company['website']) && $company['website'])
                        <a href="{{ $company['website'] }}" target="_blank" rel="noopener noreferrer" 
                           class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"/>
                            </svg>
                            Visit Website
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Company Details Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content Area -->
            <div class="lg:col-span-2">
                <!-- Company Introduction -->
                @if(isset($company['description']) && $company['description'])
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Company Introduction</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($company['description'])) !!}
                        </div>
                    </div>
                @endif

                <!-- Company Culture -->
                @if(isset($company['culture']) && $company['culture'])
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Company Culture</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($company['culture'])) !!}
                        </div>
                    </div>
                @endif

                <!-- Benefits -->
                @if(isset($company['benefits']) && is_array($company['benefits']) && count($company['benefits']) > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Benefits</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($company['benefits'] as $benefit)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700">{{ $benefit }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar Information -->
            <div class="lg:col-span-1">
                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                    <div class="space-y-3">
                        @if(isset($company['email']) && $company['email'])
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                                <a href="mailto:{{ $company['email'] }}" class="hover:text-blue-600">{{ $company['email'] }}</a>
                            </div>
                        @endif
                        
                        @if(isset($company['phone']) && $company['phone'])
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                                <a href="tel:{{ $company['phone'] }}" class="hover:text-blue-600">{{ $company['phone'] }}</a>
                            </div>
                        @endif
                        
                        @if(isset($company['address']) && $company['address'])
                            <div class="flex items-start text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $company['address'] }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Company Tags -->
                @if(isset($company['tags']) && is_array($company['tags']) && count($company['tags']) > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Company Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($company['tags'] as $tag)
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- View Jobs Button -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Currently Hiring</h3>
                    <a href="{{ url('/jobs?company=' . ($company['slug'] ?? $company['id'] ?? '')) }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        View Jobs
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection