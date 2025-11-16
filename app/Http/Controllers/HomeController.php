<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use App\Helpers\SeoHelper;

class HomeController extends Controller
{
    /**
     * Home page
     */
    public function index(Request $request)
    {
        $apiService = app(ApiService::class);
        
        // Get site configuration
        $siteConfig = $this->getSiteConfig();
        
        // Get job data
        try {
            // Get job list with correct API sorting parameters
            $jobsData = $apiService->getJobs([
                'page' => $request->get('page', 1),
                'per_page' => $request->get('limit', 6),
                'featured' => true,
                'sort_by' => 'created_at',
                'sort_order' => 'DESC'
            ]);
            
            // Get job categories
            $categoriesData = $apiService->getCategories();
        } catch (\Exception $e) {
            // Use sample data if API call fails
            // Log::error('API call exception: ' . $e->getMessage());
            
            // Sample job data
            $jobsData = [
                'success' => true,
                'data' => [
                    ['id' => 1, 'title' => 'Sample Job 1', 'company_name' => 'Sample Company', 'location' => 'Beijing', 'salary' => '10k-20k'],
                    ['id' => 2, 'title' => 'Sample Job 2', 'company_name' => 'Sample Company', 'location' => 'Shanghai', 'salary' => '15k-25k'],
                ]
            ];
            
            // Sample category data
            $categoriesData = [
                'success' => true,
                'data' => [
                    ['id' => 1, 'name' => 'Technology'],
                    ['id' => 2, 'name' => 'Product'],
                    ['id' => 3, 'name' => 'Design'],
                ]
            ];
        }
        
        // Search parameters
        $searchParams = [
            'keyword' => $request->get('keyword'),
            'location' => $request->get('location'),
            'category' => $request->get('category')
        ];
        
        // SEO data - ensure complete SEO array structure
        $seoData = [
            'title' => ($siteConfig['site_name'] ?? 'Job Chain') . ' - Professional Recruitment and Job-Seeking Platform',
            'description' => $siteConfig['site_description'] ?? 'Professional recruitment platform providing latest job information, helping companies find suitable talent, and helping job seekers find ideal jobs.',
            'keywords' => 'Recruitment, Job seeking, Job opportunities, Job search',
            'canonical' => url('/'),
            'og_type' => 'website',
            'og_title' => ($siteConfig['site_name'] ?? 'Job Chain') . ' - Professional Recruitment and Job-Seeking Platform',
            'og_description' => $siteConfig['site_description'] ?? 'Professional recruitment platform providing latest job information',
            'og_url' => url('/'),
            'og_image' => asset('assets/images/logo.svg'),
            'twitter_card' => 'summary',
            'twitter_title' => ($siteConfig['site_name'] ?? 'Job Chain') . ' - Professional Recruitment and Job-Seeking Platform',
            'twitter_description' => $siteConfig['site_description'] ?? 'Professional recruitment platform providing latest job information'
        ];
        
        // Use example data if API fails
        if (!isset($jobsData['success']) || !$jobsData['success']) {
            $jobsData = [
                'success' => true,
                'data' => [
                    ['id' => 1, 'title' => 'Sample Job 1', 'company_name' => 'Sample Company', 'location' => 'Beijing', 'salary' => '10k-20k'],
                    ['id' => 2, 'title' => 'Sample Job 2', 'company_name' => 'Sample Company', 'location' => 'Shanghai', 'salary' => '15k-25k'],
                ]
            ];
        }
        
        if (!isset($categoriesData['success']) || !$categoriesData['success']) {
            $categoriesData = [
                'success' => true,
                'data' => [
                    ['id' => 1, 'name' => 'Technology'],
                    ['id' => 2, 'name' => 'Product'],
                    ['id' => 3, 'name' => 'Design'],
                ]
            ];
        } else {
            // Add simulated job count for categories if not present
            foreach ($categoriesData['data'] as &$category) {
                if (!isset($category['job_count'])) {
                    $category['job_count'] = rand(30, 200);
                }
            }
            unset($category); // break reference
        }

        // Use SeoHelper if available to generate SEO data
        if (class_exists(SeoHelper::class) && method_exists(SeoHelper::class, 'generateMetaData')) {
            try {
                $seo = SeoHelper::generateMetaData([
                    'title' => ($siteConfig['site_name'] ?? 'Job Chain') . ' - Professional Recruitment and Job-Seeking Platform',
                    'description' => $siteConfig['site_description'] ?? 'Professional recruitment platform providing latest job information, helping companies find suitable talent, and helping job seekers find ideal jobs.',
                    'keywords' => 'Recruitment, Job seeking, Job opportunities, Job search',
                    'canonical' => url('/'),
                ]);
                $seoData = array_merge($seoData, $seo);
            } catch (\Exception $e) {
                logger()->error('SeoHelper error: ' . $e->getMessage());
            }
        }

        // Structured data
        $structuredData = [
            'website' => class_exists(SeoHelper::class) ? SeoHelper::generateWebsiteSchema() : [],
            'organization' => class_exists(SeoHelper::class) ? SeoHelper::generateOrganizationSchema() : []
        ];
        
        // Ensure correct data passed to view
        $jobs = $jobsData['data'] ?? $jobsData ?? [];
        $categories = $categoriesData['data'] ?? $categoriesData ?? [];
        
        // Process image paths
        if (class_exists('App\\Helpers\\ImageHelper')) {
            $jobs = \App\Helpers\ImageHelper::processJobsImages($jobs);
        }
        
        // Prepare pagination data for view
        $pagination = [];
        if (isset($jobsData['pagination']) && is_array($jobsData['pagination'])) {
            $pagination = $jobsData['pagination'];
            // Ensure required fields for pagination component exist
            if (isset($pagination['total_pages']) && !isset($pagination['last_page'])) {
                $pagination['last_page'] = $pagination['total_pages'];
            }
            if (isset($pagination['page']) && !isset($pagination['current_page'])) {
                $pagination['current_page'] = $pagination['page'];
            }
            // Set pagination path
            $pagination['path'] = url('/');
        }
        
        // Debug logs
        logger()->info('HomeController - Jobs data count: ' . count($jobs));
        logger()->info('HomeController - Jobs data structure: ' . json_encode($jobs));
        
        return view('home.index', [
            'jobs' => $jobs,
            'categories' => $categories,
            'pagination' => $pagination,
            'searchParams' => $searchParams,
            'seo' => $seoData,
            'structuredData' => $structuredData,
            'site' => $siteConfig
        ]);
    }

    /**
     * About Us page
     */
    public function about()
    {
        $siteConfig = $this->getSiteConfig();
        
        $seoData = [
            'title' => 'About Us - Job Chain',
            'description' => 'Learn about our mission and values',
            'keywords' => 'About Us, Company, Team, Mission',
            'canonical' => route('about'),
            'og_type' => 'website',
            'og_title' => 'About Us - Job Chain',
            'og_description' => 'Learn about our mission and values',
            'og_url' => route('about'),
            'og_image' => asset('assets/images/logo.svg'),
            'twitter_card' => 'summary',
            'twitter_title' => 'About Us - Job Chain',
            'twitter_description' => 'Learn about our mission and values'
        ];
        
        if (class_exists(SeoHelper::class) && method_exists(SeoHelper::class, 'generateMetaData')) {
            try {
                $seo = SeoHelper::generateMetaData([
                    'title' => 'About Us',
                    'description' => 'Learn about our mission and values',
                    'keywords' => 'About Us, Company, Team, Mission',
                    'canonical' => route('about'),
                ]);
                $seoData = array_merge($seoData, $seo);
            } catch (\Exception $e) {
                logger()->error('SeoHelper error: ' . $e->getMessage());
            }
        }
        
        $structuredData = [
            'website' => class_exists(SeoHelper::class) ? SeoHelper::generateWebsiteSchema() : [],
            'organization' => class_exists(SeoHelper::class) ? SeoHelper::generateOrganizationSchema() : [],
            'faq' => class_exists(SeoHelper::class) ? SeoHelper::generateFAQSchema([
                [
                    'question' => 'How to post a job?',
                    'answer' => 'Company users need to register an account, then log in to the admin panel, click "Post Job", fill in job information, and submit for approval.'
                ],
                [
                    'question' => 'How long does job approval take?',
                    'answer' => 'Generally, job approval is completed within 24 hours. There may be delays during holidays.'
                ]
            ]) : []
        ];
        
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'About Us', 'url' => '']
        ];
        
        return view('pages.about', [
            'seo' => $seoData,
            'structuredData' => $structuredData,
            'breadcrumbs' => $breadcrumbs,
            'site' => $siteConfig
        ]);
    }

    /**
     * Contact Us page
     */
    public function contact()
    {
        $siteConfig = $this->getSiteConfig();
        
        $seoData = [
            'title' => 'Contact Us - Job Chain',
            'description' => 'Contact us for more information',
            'keywords' => 'Contact Us, Contact, Customer Service',
            'canonical' => route('contact'),
            'og_type' => 'website',
            'og_title' => 'Contact Us - Job Chain',
            'og_description' => 'Contact us for more information',
            'og_url' => route('contact'),
            'og_image' => asset('assets/images/logo.svg'),
            'twitter_card' => 'summary',
            'twitter_title' => 'Contact Us - Job Chain',
            'twitter_description' => 'Contact us for more information'
        ];
        
        if (class_exists(SeoHelper::class) && method_exists(SeoHelper::class, 'generateMetaData')) {
            try {
                $seo = SeoHelper::generateMetaData([
                    'title' => 'Contact Us',
                    'description' => 'Contact us for more information',
                    'keywords' => 'Contact Us, Contact, Customer Service',
                    'canonical' => route('contact'),
                ]);
                $seoData = array_merge($seoData, $seo);
            } catch (\Exception $e) {
                logger()->error('SeoHelper error: ' . $e->getMessage());
            }
        }
        
        $structuredData = [
            'website' => class_exists(SeoHelper::class) ? SeoHelper::generateWebsiteSchema() : [],
            'organization' => class_exists(SeoHelper::class) ? SeoHelper::generateOrganizationSchema() : [],
            'faq' => class_exists(SeoHelper::class) ? SeoHelper::generateFAQSchema([
                [
                    'question' => 'How to apply for a job?',
                    'answer' => 'Job seekers can click the "Apply" button on the job detail page, fill in personal information and resume, and submit the application.'
                ],
                [
                    'question' => 'How to edit a posted job?',
                    'answer' => 'Company users can log in to the admin panel, find the job in "My Jobs" list, and click edit to modify it.'
                ]
            ]) : []
        ];
        
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Contact Us', 'url' => '']
        ];
        
        return view('pages.contact', [
            'seo' => $seoData,
            'structuredData' => $structuredData,
            'breadcrumbs' => $breadcrumbs,
            'site' => $siteConfig
        ]);
    }

    /**
     * Get site configuration
     */
    protected function getSiteConfig(): array
    {
        if (app()->bound('site.config')) {
            $config = app('site.config');
            return is_array($config) ? $config : $this->getDefaultSiteData();
        }
        
        return $this->getDefaultSiteData();
    }

    /**
     * Get default site data
     */
    protected function getDefaultSiteData(): array
    {
        return [
            'site_name' => 'Job Chain',
            'site_description' => 'Professional recruitment and job-seeking platform',
            'site_keywords' => 'Recruitment, Job seeking, Job opportunities, Job search'
        ];
    }
}