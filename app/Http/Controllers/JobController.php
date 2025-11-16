<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use App\Helpers\SeoHelper;
use Illuminate\Support\Str;

class JobController extends Controller
{
    /**
     * Job detail page
     */
    public function show($slug)
    {
        $apiService = new ApiService();
        
        // Method 1: First try to get job list through slug query parameter
        $jobsData = $apiService->getJobs(['slug' => $slug]);
        
        if (isset($jobsData['success']) && $jobsData['success'] && isset($jobsData['data']) && count($jobsData['data']) > 0) {
            // Get the first matching job from the job list
            $job = $jobsData['data'][0];
        } else {
            // Method 2: If query parameter method fails, try to use slug as ID directly
            $jobData = $apiService->getJobDetail($slug);
            
            // Check API response data structure
            if (empty($jobData) || (isset($jobData['success']) && !$jobData['success']) || empty($jobData['data'])) {
                abort(404, 'Job does not exist');
            }
            
            $job = $jobData['data'] ?? $jobData; // Compatible with different data structures
        }
        
        // Process image paths - convert relative paths to complete URLs
        if (class_exists('App\\Helpers\\ImageHelper')) {
            $job = \App\Helpers\ImageHelper::processJobImages($job);
        }
        
        // Set SEO data - Fix: Ensure $job is an array
        $seo = SeoHelper::generateMetaData([
            'title' => SeoHelper::generateTitle($job['name'] ?? $job['title'] ?? 'Job Details'),
            'description' => Str::limit(strip_tags($job['description'] ?? ''), 160),
            'keywords' => ($job['name'] ?? $job['title'] ?? 'Job') . ',recruitment,job opportunities',
            'canonical' => url('/jobs/' . ($job['slug'] ?? $slug))
        ]);
        
        // Structured data - Fix: Ensure data exists
        $structuredData = [
            'jobPosting' => SeoHelper::generateJobPostingSchema($job),
            'breadcrumb' => SeoHelper::generateBreadcrumbSchema([
                ['name' => 'Home', 'url' => url('/')],
                ['name' => 'Job Search', 'url' => url('/jobs')],
                ['name' => $job['name'] ?? $job['title'] ?? 'Job Details', 'url' => '']
            ]),
            'website' => SeoHelper::generateWebsiteSchema(),
            'organization' => SeoHelper::generateOrganizationSchema()
        ];

        // Add JSON-LD structured data
        $structuredData['jsonLd'] = $this->generateJobJsonLd($job, $slug);
        
        // Breadcrumb navigation - Fix: Ensure data exists
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Job Search', 'url' => url('/jobs')],
            ['name' => $job['name'] ?? $job['title'] ?? 'Job Details', 'url' => '']
        ];
        
        return view('jobs.show', compact('job', 'seo', 'structuredData', 'breadcrumbs'));
    }

    /**
     * Job list page
     */
    public function index(Request $request, $page = null)
    {
        $apiService = app(ApiService::class);
        
        // Determine current page: use URL path parameter if available, otherwise use query parameter
        $currentPage = $page ? intval($page) : $request->get('page', 1);
        
        // Search parameters
        $searchParams = [
            'page' => $currentPage,
            'per_page' => $request->get('limit', 20),
            'sort_by' => 'created_at',
            'sort_order' => 'DESC'
        ];
        
        // Add filter conditions
        if ($request->has('category') && $request->category) {
            $searchParams['category'] = $request->category;
        }
        if ($request->has('location') && $request->location) {
            $searchParams['location'] = $request->location;
        }
        if ($request->has('keyword') && $request->keyword) {
            $searchParams['q'] = $request->keyword;
        }
        
        // Get job data using correct API sorting parameters
        $jobsData = $apiService->getJobs($searchParams);
        
        // Get category list
        $categoriesData = $apiService->getCategories();
        
        // SEO data
        $seo = SeoHelper::generateMetaData([
            'title' => SeoHelper::generateTitle('Job Search'),
            'description' => 'Search for the latest job information and find suitable job opportunities',
            'keywords' => 'job search,recruitment,job hunting,job opportunities',
            'canonical' => route('jobs.index')
        ]);
        
        // Structured data
        $structuredData = [
            'website' => SeoHelper::generateWebsiteSchema(),
            'organization' => SeoHelper::generateOrganizationSchema()
        ];
        
        // Breadcrumb navigation
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Job Search', 'url' => '']
        ];
        
        // Process image paths - convert relative paths to complete URLs
        $jobs = $jobsData['data'] ?? $jobsData ?? [];
        if (class_exists('App\\Helpers\\ImageHelper')) {
            $jobs = \App\Helpers\ImageHelper::processJobsImages($jobs);
        }
        
        // Debug log - check pagination data structure
        logger()->info('JobController - Jobs data structure: ' . json_encode($jobsData));
        
        // Determine if using URL path pagination
        $isPathPagination = $page !== null;
        
        // Fix pagination data structure
        $pagination = [];
        if (isset($jobsData['pagination']) && is_array($jobsData['pagination'])) {
            // Fix: API returns pagination field containing total_pages, but pagination component needs last_page
            $pagination = $jobsData['pagination'];
            // Ensure required fields for pagination component exist
            if (isset($pagination['total_pages']) && !isset($pagination['last_page'])) {
                $pagination['last_page'] = $pagination['total_pages'];
            }
            // Fix: API returns page field, but pagination component needs current_page field
            if (isset($pagination['page']) && !isset($pagination['current_page'])) {
                $pagination['current_page'] = $pagination['page'];
            }
            // Add other fields needed by pagination component
            if ($isPathPagination) {
                $pagination['path'] = route('jobs.page', ['page' => $currentPage]);
                $pagination['prev_page_url'] = ($pagination['current_page'] ?? 1) > 1 ? 
                    route('jobs.page', ['page' => ($pagination['current_page'] ?? 1) - 1]) : null;
                $pagination['next_page_url'] = ($pagination['current_page'] ?? 1) < ($pagination['last_page'] ?? 1) ? 
                    route('jobs.page', ['page' => ($pagination['current_page'] ?? 1) + 1]) : null;
            } else {
                $pagination['path'] = route('jobs.index');
                $pagination['prev_page_url'] = ($pagination['current_page'] ?? 1) > 1 ? 
                    route('jobs.index', array_merge($searchParams, ['page' => ($pagination['current_page'] ?? 1) - 1])) : null;
                $pagination['next_page_url'] = ($pagination['current_page'] ?? 1) < ($pagination['last_page'] ?? 1) ? 
                    route('jobs.index', array_merge($searchParams, ['page' => ($pagination['current_page'] ?? 1) + 1])) : null;
            }
        } elseif (isset($jobsData['meta']) && is_array($jobsData['meta'])) {
            // Compatible with meta format pagination data
            if ($isPathPagination) {
                $pagination = [
                    'current_page' => $jobsData['meta']['current_page'] ?? 1,
                    'last_page' => $jobsData['meta']['last_page'] ?? 1,
                    'per_page' => $jobsData['meta']['per_page'] ?? 20,
                    'total' => $jobsData['meta']['total'] ?? count($jobs),
                    'from' => $jobsData['meta']['from'] ?? 1,
                    'to' => $jobsData['meta']['to'] ?? count($jobs),
                    'path' => route('jobs.page', ['page' => $currentPage]),
                    'prev_page_url' => ($jobsData['meta']['current_page'] ?? 1) > 1 ? 
                        route('jobs.page', ['page' => ($jobsData['meta']['current_page'] ?? 1) - 1]) : null,
                    'next_page_url' => ($jobsData['meta']['current_page'] ?? 1) < ($jobsData['meta']['last_page'] ?? 1) ? 
                        route('jobs.page', ['page' => ($jobsData['meta']['current_page'] ?? 1) + 1]) : null
                ];
            } else {
                $pagination = [
                    'current_page' => $jobsData['meta']['current_page'] ?? 1,
                    'last_page' => $jobsData['meta']['last_page'] ?? 1,
                    'per_page' => $jobsData['meta']['per_page'] ?? 20,
                    'total' => $jobsData['meta']['total'] ?? count($jobs),
                    'from' => $jobsData['meta']['from'] ?? 1,
                    'to' => $jobsData['meta']['to'] ?? count($jobs),
                    'path' => route('jobs.index'),
                    'prev_page_url' => ($jobsData['meta']['current_page'] ?? 1) > 1 ? 
                        route('jobs.index', array_merge($searchParams, ['page' => ($jobsData['meta']['current_page'] ?? 1) - 1])) : null,
                    'next_page_url' => ($jobsData['meta']['current_page'] ?? 1) < ($jobsData['meta']['last_page'] ?? 1) ? 
                        route('jobs.index', array_merge($searchParams, ['page' => ($jobsData['meta']['current_page'] ?? 1) + 1])) : null
                ];
            }
        } else {
            // Default pagination data
            if ($isPathPagination) {
                $pagination = [
                    'current_page' => $searchParams['page'] ?? 1,
                    'last_page' => 1,
                    'per_page' => $searchParams['per_page'] ?? 20,
                    'total' => count($jobs),
                    'from' => 1,
                    'to' => count($jobs),
                    'path' => route('jobs.page', ['page' => $currentPage]),
                    'prev_page_url' => null,
                    'next_page_url' => null
                ];
            } else {
                $pagination = [
                    'current_page' => $searchParams['page'] ?? 1,
                    'last_page' => 1,
                    'per_page' => $searchParams['per_page'] ?? 20,
                    'total' => count($jobs),
                    'from' => 1,
                    'to' => count($jobs),
                    'path' => route('jobs.index'),
                    'prev_page_url' => null,
                    'next_page_url' => null
                ];
            }
        }
        
        // Fix: Ensure correct data is passed to the view
        return view('jobs.index', [
            'jobs' => $jobs,
            'categories' => is_array($categoriesData) ? ($categoriesData['data'] ?? $categoriesData) : [],
            'pagination' => $pagination,
            'searchParams' => $searchParams,
            'seo' => $seo,
            'structuredData' => $structuredData,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Generate job description
     */
    protected function generateJobDescription(array $job): string
    {
        $description = $job['description'] ?? '';
        
        // Take the first 160 characters as description
        $description = strip_tags($description);
        $description = mb_substr($description, 0, 160);
        
        return $description . '...';
    }

    /**
     * Generate job JSON-LD structured data
     */
    protected function generateJobJsonLd(array $job, string $slug): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'JobPosting',
            'title' => $job['name'] ?? $job['title'] ?? '',
            'description' => $job['description'] ?? '',
            'datePosted' => $job['created_at'] ?? date('c'),
            'validThrough' => $job['expires_at'] ?? date('c', strtotime('+30 days')),
            'employmentType' => $this->mapEmploymentType($job['employment_type'] ?? ''),
            'hiringOrganization' => [
                '@type' => 'Organization',
                'name' => $job['company_name'] ?? '',
                'sameAs' => $job['company_website'] ?? '',
            ],
            'jobLocation' => [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => $job['location'] ?? '',
                ],
            ],
            'baseSalary' => $this->generateSalaryInfo($job),
            'url' => url('/jobs/' . ($job['slug'] ?? $slug)),
        ];
    }

    /**
     * Map employment type
     */
    protected function mapEmploymentType(string $type): string
    {
        $mapping = [
            'full_time' => 'FULL_TIME',
            'part_time' => 'PART_TIME',
            'contract' => 'CONTRACTOR',
            'internship' => 'INTERN',
        ];
        
        return $mapping[$type] ?? 'FULL_TIME';
    }

    /**
     * Generate salary information
     */
    protected function generateSalaryInfo(array $job): ?array
    {
        if (empty($job['salary_min']) && empty($job['salary_max'])) {
            return null;
        }
        
        return [
            '@type' => 'MonetaryAmount',
            'currency' => $job['salary_currency'] ?? 'CNY',
            'value' => [
                '@type' => 'QuantitativeValue',
                'minValue' => $job['salary_min'] ?? 0,
                'maxValue' => $job['salary_max'] ?? 0,
                'unitText' => 'MONTH',
            ],
        ];
    }

    /**
     * Company detail page
     */
    public function company($slug)
    {
        $apiService = new ApiService();
        
        // Method 1: First try to get company list through slug query parameter
        $companiesData = $apiService->getCompanies(['slug' => $slug]);
        
        if (isset($companiesData['success']) && $companiesData['success'] && isset($companiesData['data']) && count($companiesData['data']) > 0) {
            // Get the first matching company from the company list
            $company = $companiesData['data'][0];
        } else {
            // Method 2: If query parameter method fails, try to use slug as ID directly
            // First get company list to find the correct company ID
            $allCompaniesData = $apiService->getCompanies(['per_page' => 1000]); // Get all companies to find by slug
            
            $companyId = null;
            if (isset($allCompaniesData['success']) && $allCompaniesData['success'] && isset($allCompaniesData['data'])) {
                foreach ($allCompaniesData['data'] as $comp) {
                    if (isset($comp['slug']) && $comp['slug'] === $slug) {
                        $companyId = $comp['id'];
                        break;
                    }
                }
            }
            
            if (!$companyId) {
                abort(404, 'Company does not exist');
            }
            
            $companyData = $apiService->getCompanyDetail($companyId);
            
            // Check API response data structure
            if (empty($companyData) || (isset($companyData['success']) && !$companyData['success']) || empty($companyData['data'])) {
                abort(404, 'Company does not exist');
            }
            
            $company = $companyData['data'] ?? $companyData; // Compatible with different data structures
        }
        
        // Process image paths - convert relative paths to complete URLs
        if (class_exists('App\\Helpers\\ImageHelper')) {
            $company = \App\Helpers\ImageHelper::processCompanyImages($company);
        }
        
        // Set SEO data - Fix: Ensure $company is an array
        $seo = SeoHelper::generateMetaData([
            'title' => SeoHelper::generateTitle($company['name'] ?? 'Company Details'),
            'description' => Str::limit(strip_tags($company['description'] ?? ''), 160),
            'keywords' => ($company['name'] ?? 'Company') . ',company introduction,employer branding',
            'canonical' => url('/companies/' . ($company['slug'] ?? $slug))
        ]);
        
        // Structured data - Fix: Ensure data exists
        $structuredData = [
            'organization' => SeoHelper::generateOrganizationSchema($company),
            'breadcrumb' => SeoHelper::generateBreadcrumbSchema([
                ['name' => 'Home', 'url' => url('/')],
                ['name' => 'Company List', 'url' => url('/companies')],
                ['name' => $company['name'] ?? 'Company Details', 'url' => '']
            ]),
            'website' => SeoHelper::generateWebsiteSchema(),
            'organization' => SeoHelper::generateOrganizationSchema()
        ];

        // Add JSON-LD structured data
        $structuredData['jsonLd'] = $this->generateCompanyJsonLd($company, $slug);
        
        // Breadcrumb navigation - Fix: Ensure data exists
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Company List', 'url' => url('/companies')],
            ['name' => $company['name'] ?? 'Company Details', 'url' => '']
        ];
        
        return view('companies.show', compact('company', 'seo', 'structuredData', 'breadcrumbs'));
    }

    /**
     * Generate company JSON-LD structured data
     */
    protected function generateCompanyJsonLd(array $company, string $slug): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $company['name'] ?? '',
            'description' => $company['description'] ?? '',
            'url' => $company['website'] ?? url('/companies/' . ($company['slug'] ?? $slug)),
            'logo' => $company['logo'] ?? '',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $company['address'] ?? '',
                'addressLocality' => $company['location'] ?? '',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => $company['phone'] ?? '',
                'email' => $company['email'] ?? '',
            ]
        ];
    }

    /**
     * Company list page
     */
    public function companies(Request $request, $page = null)
    {
        $apiService = app(ApiService::class);
        
        // Determine current page: use URL path parameter if available, otherwise use query parameter
        $currentPage = $page ? intval($page) : $request->get('page', 1);
        
        // Search parameters
        $searchParams = [
            'page' => $currentPage,
            'per_page' => $request->get('limit', 20),
            'sort_by' => 'name',
            'sort_order' => 'ASC'
        ];
        
        // Add filter conditions
        if ($request->has('q') && $request->q) {
            $searchParams['q'] = $request->q;
        }
        if ($request->has('location') && $request->location) {
            $searchParams['location'] = $request->location;
        }
        if ($request->has('industry') && $request->industry) {
            $searchParams['industry'] = $request->industry;
        }
        
        // Get company data
        $companiesData = $apiService->getCompanies($searchParams);
        
        // Get industry list
        try {
            $industriesData = $apiService->getIndustries();
        } catch (Exception $e) {
            // Use empty array if getting industry list fails
            $industriesData = [];
            \Log::warning('Failed to get industry list: ' . $e->getMessage());
        }
        
        // SEO data
        $seo = SeoHelper::generateMetaData([
            'title' => SeoHelper::generateTitle('Company List'),
            'description' => 'Browse quality companies and discover more career opportunities',
            'keywords' => 'company list,corporate recruitment,employer branding',
            'canonical' => route('companies.index')
        ]);
        
        // Structured data
        $structuredData = [
            'website' => SeoHelper::generateWebsiteSchema(),
            'organization' => SeoHelper::generateOrganizationSchema()
        ];
        
        // Breadcrumb navigation
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Company List', 'url' => '']
        ];
        
        // Process image paths - convert relative paths to complete URLs
        $companies = $companiesData['data'] ?? $companiesData ?? [];
        if (class_exists('App\\Helpers\\ImageHelper')) {
            $companies = \App\Helpers\ImageHelper::processCompaniesImages($companies);
        }
        
        // Fix pagination data structure
        $pagination = [];
        
        // Determine if we're using URL path pagination
        $isPathPagination = $page !== null;
        
        if (isset($companiesData['pagination']) && is_array($companiesData['pagination'])) {
            // Fix: API returns pagination field containing total_pages, but pagination component needs last_page
            $pagination = $companiesData['pagination'];
            // Ensure required fields for pagination component exist
            if (isset($pagination['total_pages']) && !isset($pagination['last_page'])) {
                $pagination['last_page'] = $pagination['total_pages'];
            }
            // Fix: API returns page field, but pagination component needs current_page field
            if (isset($pagination['page']) && !isset($pagination['current_page'])) {
                $pagination['current_page'] = $pagination['page'];
            }
            // Add other fields needed by pagination component
            if ($isPathPagination) {
                // Use URL path pagination
                $pagination['path'] = route('companies.page', ['page' => $currentPage]);
                $pagination['prev_page_url'] = ($pagination['current_page'] ?? 1) > 1 ? 
                    route('companies.page', ['page' => ($pagination['current_page'] ?? 1) - 1]) : null;
                $pagination['next_page_url'] = ($pagination['current_page'] ?? 1) < ($pagination['last_page'] ?? 1) ? 
                    route('companies.page', ['page' => ($pagination['current_page'] ?? 1) + 1]) : null;
            } else {
                // Use query parameter pagination
                $pagination['path'] = route('companies.index');
                $pagination['prev_page_url'] = ($pagination['current_page'] ?? 1) > 1 ? 
                    route('companies.index', array_merge($searchParams, ['page' => ($pagination['current_page'] ?? 1) - 1])) : null;
                $pagination['next_page_url'] = ($pagination['current_page'] ?? 1) < ($pagination['last_page'] ?? 1) ? 
                    route('companies.index', array_merge($searchParams, ['page' => ($pagination['current_page'] ?? 1) + 1])) : null;
            }
        } elseif (isset($companiesData['meta']) && is_array($companiesData['meta'])) {
            // Compatible with meta format pagination data
            $pagination = [
                'current_page' => $companiesData['meta']['current_page'] ?? 1,
                'last_page' => $companiesData['meta']['last_page'] ?? 1,
                'per_page' => $companiesData['meta']['per_page'] ?? 20,
                'total' => $companiesData['meta']['total'] ?? count($companies),
                'from' => $companiesData['meta']['from'] ?? 1,
                'to' => $companiesData['meta']['to'] ?? count($companies),
            ];
            
            if ($isPathPagination) {
                // Use URL path pagination
                $pagination['path'] = route('companies.page', ['page' => $currentPage]);
                $pagination['prev_page_url'] = ($pagination['current_page'] ?? 1) > 1 ? 
                    route('companies.page', ['page' => ($pagination['current_page'] ?? 1) - 1]) : null;
                $pagination['next_page_url'] = ($pagination['current_page'] ?? 1) < ($pagination['last_page'] ?? 1) ? 
                    route('companies.page', ['page' => ($pagination['current_page'] ?? 1) + 1]) : null;
            } else {
                // Use query parameter pagination
                $pagination['path'] = route('companies.index');
                $pagination['prev_page_url'] = ($pagination['current_page'] ?? 1) > 1 ? 
                    route('companies.index', array_merge($searchParams, ['page' => ($pagination['current_page'] ?? 1) - 1])) : null;
                $pagination['next_page_url'] = ($pagination['current_page'] ?? 1) < ($pagination['last_page'] ?? 1) ? 
                    route('companies.index', array_merge($searchParams, ['page' => ($pagination['current_page'] ?? 1) + 1])) : null;
            }
        } else {
            // Default pagination data
            $pagination = [
                'current_page' => $searchParams['page'] ?? 1,
                'last_page' => 1,
                'per_page' => $searchParams['per_page'] ?? 20,
                'total' => count($companies),
                'from' => 1,
                'to' => count($companies),
            ];
            
            if ($isPathPagination) {
                // Use URL path pagination
                $pagination['path'] = route('companies.page', ['page' => $currentPage]);
                $pagination['prev_page_url'] = null;
                $pagination['next_page_url'] = null;
            } else {
                // Use query parameter pagination
                $pagination['path'] = route('companies.index');
                $pagination['prev_page_url'] = null;
                $pagination['next_page_url'] = null;
            }
        }
        
        return view('companies.index', [
            'companies' => $companies,
            'industries' => is_array($industriesData) ? ($industriesData['data'] ?? $industriesData) : [],
            'pagination' => $pagination,
            'searchParams' => $searchParams,
            'seo' => $seo,
            'structuredData' => $structuredData,
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}