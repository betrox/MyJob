<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo e(is_array($seo) ? ($seo['title'] ?? 'Job Search - ' . ($site['site_name'] ?? 'MyJob Portal')) : 'Job Search - ' . ($site['site_name'] ?? 'MyJob Portal')); ?></title>

    <meta name="description" content="<?php echo e(is_array($seo) ? ($seo['description'] ?? 'Search for the latest job opportunities') : 'Search for the latest job opportunities'); ?>">
    <meta name="keywords" content="<?php echo e(is_array($seo) ? ($seo['keywords'] ?? 'job search, recruitment, employment, career opportunities') : 'job search, recruitment, employment, career opportunities'); ?>">
    <link rel="canonical" href="<?php echo e(is_array($seo) ? ($seo['canonical'] ?? url()->current()) : url()->current()); ?>">

    
    <!-- Open Graph -->
    <meta property="og:type" content="<?php echo e(is_array($seo) ? ($seo['og_type'] ?? 'website') : 'website'); ?>">
    <meta property="og:title" content="<?php echo e(is_array($seo) ? ($seo['title'] ?? 'Job Search - ' . ($site['site_name'] ?? 'MyJob Portal')) : 'Job Search - ' . ($site['site_name'] ?? 'MyJob Portal')); ?>">
    <meta property="og:description" content="<?php echo e(is_array($seo) ? ($seo['description'] ?? 'Search for the latest job opportunities') : 'Search for the latest job opportunities'); ?>">
    <meta property="og:url" content="<?php echo e(is_array($seo) ? ($seo['canonical'] ?? url()->current()) : url()->current()); ?>">
    <meta property="og:image" content="<?php echo e(is_array($seo) ? ($seo['og_image'] ?? asset('assets/images/logo.svg')) : asset('assets/images/logo.svg')); ?>">

    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="<?php echo e(is_array($seo) ? ($seo['twitter_card'] ?? 'summary') : 'summary'); ?>">
    <meta name="twitter:title" content="<?php echo e(is_array($seo) ? ($seo['title'] ?? 'Job Search - ' . ($site['site_name'] ?? 'MyJob Portal')) : 'Job Search - ' . ($site['site_name'] ?? 'MyJob Portal')); ?>">
    <meta name="twitter:description" content="<?php echo e(is_array($seo) ? ($seo['description'] ?? 'Search for the latest job opportunities') : 'Search for the latest job opportunities'); ?>">
    <meta name="twitter:image" content="<?php echo e(is_array($seo) ? ($seo['og_image'] ?? asset('assets/images/logo.svg')) : asset('assets/images/logo.svg')); ?>">

    
    <!-- JSON-LD Structured Data -->
    <?php if(isset($structuredData['website'])): ?>
    <script type="application/ld+json">
        <?php echo json_encode($structuredData['website'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

    </script>
    <?php endif; ?>

    <?php if(isset($structuredData['organization'])): ?>
    <script type="application/ld+json">
        <?php echo json_encode($structuredData['organization'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

    </script>
    <?php endif; ?>

    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/responsive.css')); ?>">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">

</head>

<body>

    <!-- Header Section -->
    <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <!-- Job Search Section -->
    <section class="job-search-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php echo e(__('messages.job_search')); ?></h1>
                    <p><?php echo e(__('messages.find_suitable_jobs')); ?></p>
                    
                    <!-- Search Form -->
                    <div class="job-search">
                        <form action="<?php echo e(route('jobs.index')); ?>" method="get">
                            <div class="search-inputs">
                                <div class="search-input">
                                    <input type="text" name="keyword" placeholder="<?php echo e(__('messages.job_title_keyword_company')); ?>" value="<?php echo e(request('keyword')); ?>">
                                </div>
                                <div class="search-input">
                                    <input type="text" name="location" placeholder="<?php echo e(__('messages.city_province_remote')); ?>" value="<?php echo e(request('location')); ?>">
                                </div>
                                <div class="search-input">
                                    <select name="category">
                                        <option value=""><?php echo e(__('messages.all_categories')); ?></option>
                                        <?php if(isset($categories) && is_array($categories)): ?>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(isset($category) && is_array($category) && isset($category['id']) && isset($category['name'])): ?>
                                                <option value="<?php echo e($category['id']); ?>" <?php echo e(request('category') == $category['id'] ? 'selected' : ''); ?>><?php echo e($category['name']); ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <button type="submit" class="search-button">
                                    <i class="fa fa-search"></i> <?php echo e(__('messages.search_jobs')); ?>

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
                        <h2><?php echo e(__('messages.search_results')); ?></h2>
                        <p><?php echo e(__('messages.found_jobs', ['count' => isset($pagination) && is_array($pagination) && isset($pagination['total']) ? $pagination['total'] : count($jobs)])); ?></p>
                    </div>
                    
                    <!-- Job Listings -->
                    <div class="job-listings">
                        <?php if(!empty($jobs)): ?>
                            <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="job-listing">
                                <div class="job-listing-content">
                                    <div class="job-company-logo">
                                        <img src="<?php echo e($job['company_logo'] ?? asset('assets/images/company-logos/company1.svg')); ?>" alt="<?php echo e($job['company_name']); ?>">
                                    </div>
                                    <div class="job-info">
                                        <h3 class="job-title"><a href="<?php echo e(route('jobs.show', $job['slug'] ?? $job['id'])); ?>"><?php echo e($job['name'] ?? $job['title']); ?></a></h3>
                                        <div class="job-meta">
                                            <span class="company-name"><?php echo e($job['company_name']); ?></span>
                                            <span class="job-location"><?php echo e($job['location'] ?? __('messages.location_undetermined')); ?></span>
                                            <span class="job-type"><?php echo e($job['employment_type'] ?? __('messages.full_time')); ?></span>
                                            <?php if(isset($job['salary_min']) || isset($job['salary_max'])): ?>
                                            <span class="job-salary">
                                                <?php echo e($job['salary_min'] ?? ''); ?><?php echo e(isset($job['salary_min']) && isset($job['salary_max']) ? '-' : ''); ?><?php echo e($job['salary_max'] ?? ''); ?><?php echo e($job['salary_currency'] ?? 'CNY'); ?>/month
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="job-description">
                                            <p><?php echo e(Str::limit(strip_tags($job['description'] ?? ''), 200)); ?></p>
                                        </div>
                                        <div class="job-posted-date">
                                            <?php echo e(__('messages.posted')); ?>: <?php echo e($job['created_at'] ? date('Y-m-d', strtotime($job['created_at'])) : __('messages.unknown')); ?>

                                        </div>
                                    </div>
                                    <div class="job-actions">
                                        <a href="https://myjob.one/jobs/<?php echo e($job['slug'] ?? $job['id']); ?>" class="button" target="_blank">Apply Now</a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="no-results">
                                <h3><?php echo e(__('messages.no_results')); ?></h3>
                                <p><?php echo e(__('messages.try_again')); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if(isset($pagination) && is_array($pagination) && $pagination['total'] > $pagination['per_page']): ?>
                    <div class="pagination-container">
                        <?php echo $__env->make('components.pagination', ['pagination' => $pagination], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <?php endif; ?>
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
                        <h3><?php echo e($site['site_name'] ?? 'MyJob Portal'); ?></h3>
                        <p><?php echo e($site['site_description'] ?? __('messages.connect_talent_opportunities')); ?></p>
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
                        <h3><?php echo e(__('messages.quick_links')); ?></h3>
                        <ul class="footer-links">
                            <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('messages.home')); ?></a></li>
                            <li><a href="<?php echo e(route('jobs.index')); ?>"><?php echo e(__('messages.browse_jobs')); ?></a></li>
                            <li><a href="<?php echo e(route('about')); ?>"><?php echo e(__('messages.about_us')); ?></a></li>
                            <li><a href="<?php echo e(route('contact')); ?>"><?php echo e(__('messages.contact_us')); ?></a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Newsletter -->
                <div class="col-md-4">
                    <div class="footer-widget">
                        <h3><?php echo e(__('messages.newsletter')); ?></h3>
                        <p><?php echo e(__('messages.subscribe_newsletter')); ?></p>
                        <form class="newsletter-form">
                            <input type="email" placeholder="<?php echo e(__('messages.your_email_address')); ?>" required>
                            <button type="submit"><?php echo e(__('messages.subscribe')); ?></button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-12">
                        <p>&copy; <?php echo e(date('Y')); ?> <?php echo e($site['site_name'] ?? 'MyJob Portal'); ?>. <?php echo e(__('messages.all_rights_reserved')); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- JavaScript -->
    <script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>

</body>
</html><?php /**PATH /www/wwwroot/default_com/resources/views/jobs/index.blade.php ENDPATH**/ ?>