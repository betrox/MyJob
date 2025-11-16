<?php

return [
    /*
    |--------------------------------------------------------------------------
    | 网站基本信息配置
    |--------------------------------------------------------------------------
    */
    
    'site_name' => env('SITE_NAME', 'MyJob Portal'),
    'site_description' => env('SITE_DESCRIPTION', '专业的求职招聘平台'),
    'site_keywords' => env('SITE_KEYWORDS', '求职,招聘,工作,职位,人才'),
    'site_url' => env('SITE_URL', 'http://localhost'),
    'site_logo' => env('SITE_LOGO', '/assets/images/logo.svg'),
    'site_favicon' => env('SITE_FAVICON', '/assets/images/favicon.ico'),
    
    /*
    |--------------------------------------------------------------------------
    | 联系信息配置
    |--------------------------------------------------------------------------
    */
    
    'contact_email' => env('CONTACT_EMAIL', 'contact@myjobportal.com'),
    'contact_phone' => env('CONTACT_PHONE', '+86 400-123-4567'),
    'contact_address' => env('CONTACT_ADDRESS', '北京市朝阳区某某街道123号'),
    'business_hours' => env('BUSINESS_HOURS', '周一至周五 9:00-18:00'),
    
    /*
    |--------------------------------------------------------------------------
    | 社交媒体配置
    |--------------------------------------------------------------------------
    */
    
    'social_media' => [
        'weibo' => env('SOCIAL_WEIBO', 'https://weibo.com/myjobportal'),
        'wechat' => env('SOCIAL_WECHAT', ''),
        'linkedin' => env('SOCIAL_LINKEDIN', 'https://linkedin.com/company/myjobportal'),
        'github' => env('SOCIAL_GITHUB', 'https://github.com/myjobportal'),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | SEO 配置
    |--------------------------------------------------------------------------
    */
    
    'seo' => [
        'default_title' => env('SEO_DEFAULT_TITLE', 'MyJob Portal - 专业的求职招聘平台'),
        'default_description' => env('SEO_DEFAULT_DESCRIPTION', 'MyJob Portal 是一个专业的求职招聘平台，为企业提供优质的人才招聘服务，为求职者提供丰富的职位机会。'),
        'default_keywords' => env('SEO_DEFAULT_KEYWORDS', '求职,招聘,工作,职位,人才,就业'),
        'og_image' => env('SEO_OG_IMAGE', '/assets/images/og-image.jpg'),
        'twitter_site' => env('SEO_TWITTER_SITE', '@myjobportal'),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | 业务配置
    |--------------------------------------------------------------------------
    */
    
    'job' => [
        'items_per_page' => env('JOB_ITEMS_PER_PAGE', 15),
        'max_salary' => env('JOB_MAX_SALARY', 100000),
        'min_salary' => env('JOB_MIN_SALARY', 3000),
        'salary_units' => ['月薪', '年薪', '时薪', '面议'],
        'experience_levels' => ['不限', '应届生', '1-3年', '3-5年', '5-10年', '10年以上'],
        'education_levels' => ['不限', '高中', '大专', '本科', '硕士', '博士'],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | 文件上传配置
    |--------------------------------------------------------------------------
    */
    
    'upload' => [
        'max_file_size' => env('UPLOAD_MAX_FILE_SIZE', 2048), // KB
        'allowed_image_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'allowed_document_extensions' => ['pdf', 'doc', 'docx', 'txt'],
        'avatar_path' => 'uploads/avatars',
        'resume_path' => 'uploads/resumes',
        'company_logo_path' => 'uploads/company-logos',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | 缓存配置
    |--------------------------------------------------------------------------
    */
    
    'cache' => [
        'job_list_ttl' => env('CACHE_JOB_LIST_TTL', 300), // 5分钟
        'job_detail_ttl' => env('CACHE_JOB_DETAIL_TTL', 600), // 10分钟
        'company_list_ttl' => env('CACHE_COMPANY_LIST_TTL', 300), // 5分钟
    ],
    
    /*
    |--------------------------------------------------------------------------
    | API 配置
    |--------------------------------------------------------------------------
    */
    
    'api' => [
        'base_url' => env('API_BASE_URL', 'https://api.example.com'),
        'timeout' => env('API_TIMEOUT', 30),
        'retry_times' => env('API_RETRY_TIMES', 3),
        'retry_delay' => env('API_RETRY_DELAY', 100),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | 邮件配置
    |--------------------------------------------------------------------------
    */
    
    'email' => [
        'from_address' => env('MAIL_FROM_ADDRESS', 'noreply@myjobportal.com'),
        'from_name' => env('MAIL_FROM_NAME', 'MyJob Portal'),
        'admin_email' => env('ADMIN_EMAIL', 'admin@myjobportal.com'),
        'notification_email' => env('NOTIFICATION_EMAIL', 'notifications@myjobportal.com'),
    ],
];