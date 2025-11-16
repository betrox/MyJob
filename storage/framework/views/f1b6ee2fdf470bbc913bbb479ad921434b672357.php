<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo e(is_array($seo) && isset($seo['title']) ? $seo['title'] : (is_array($site) && isset($site['site_name']) ? $site['site_name'] : 'MyJob Portal')); ?></title>
    <meta name="description" content="<?php echo e(is_array($seo) && isset($seo['description']) ? $seo['description'] : (is_array($site) && isset($site['site_description']) ? $site['site_description'] : 'A professional job and recruitment platform')); ?>">
    <meta name="keywords" content="<?php echo e(is_array($seo) && isset($seo['keywords']) ? $seo['keywords'] : 'recruitment, job search, career opportunities, find jobs'); ?>">
    <link rel="canonical" href="<?php echo e(is_array($seo) && isset($seo['canonical']) ? $seo['canonical'] : url()->current()); ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="<?php echo e(is_array($seo) && isset($seo['og_type']) ? $seo['og_type'] : 'website'); ?>">
    <meta property="og:title" content="<?php echo e(is_array($seo) && isset($seo['title']) ? $seo['title'] : 'MyJob Portal'); ?>">
    <meta property="og:description" content="<?php echo e(is_array($seo) && isset($seo['description']) ? $seo['description'] : 'A professional job and recruitment platform'); ?>">
    <meta property="og:url" content="<?php echo e(is_array($seo) && isset($seo['canonical']) ? $seo['canonical'] : url()->current()); ?>">
    <meta property="og:image" content="<?php echo e(is_array($seo) && isset($seo['og_image']) ? $seo['og_image'] : asset('assets/images/logo.svg')); ?>">
    <meta property="og:site_name" content="<?php echo e(is_array($site) && isset($site['site_name']) ? $site['site_name'] : 'MyJob Portal'); ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="<?php echo e(is_array($seo) && isset($seo['twitter_card']) ? $seo['twitter_card'] : 'summary'); ?>">
    <meta name="twitter:title" content="<?php echo e(is_array($seo) && isset($seo['title']) ? $seo['title'] : 'MyJob Portal'); ?>">
    <meta name="twitter:description" content="<?php echo e(is_array($seo) && isset($seo['description']) ? $seo['description'] : 'A professional job and recruitment platform'); ?>">
    <meta name="twitter:image" content="<?php echo e(is_array($seo) && isset($seo['og_image']) ? $seo['og_image'] : asset('assets/images/logo.svg')); ?>">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/responsive.css')); ?>">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">

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
</head>

<body>

    <!-- Header Section -->
    <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Hero Section -->
    <section class="intro-banner" style="background-image: url('<?php echo e(asset('assets/images/intro-banner.jpg')); ?>');">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="intro-text">
                        <h1><?php echo e(__('messages.find_dream_job')); ?></h1>
                        <p><?php echo e(__('messages.search_thousands_jobs')); ?></p>
                    </div>

                    <!-- Job Search -->
                    <div class="job-search">
                        <form action="<?php echo e(route('jobs.index')); ?>" method="get">
                            <div class="search-inputs">
                                <div class="search-input">
                                    <input type="text" name="keyword" placeholder="<?php echo e(__('messages.job_title_keyword_company')); ?>" value="<?php echo e(request('keyword')); ?>">
                                </div>
                                <div class="search-input">
                                    <input type="text" name="location" placeholder="<?php echo e(__('messages.city_province_remote')); ?>" value="<?php echo e(request('location')); ?>">
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

    <!-- Main Content -->
    <main>
        <!-- Featured Jobs Section -->
        <?php if(!empty($jobs) && is_array($jobs) && count($jobs) > 0): ?>
        <section class="featured-jobs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2><?php echo e(__('messages.recommended_jobs')); ?></h2>
                            <p><?php echo e(__('messages.handpicked_jobs')); ?></p>
                        </div>

                        <!-- Job Listings -->
                        <div class="job-listings">
                            <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(is_array($job) && isset($job['name']) && isset($job['company_name'])): ?>
                            <div class="job-listing">
                                <div class="job-listing-content">
                                    <div class="job-company-logo">
                                        <img src="<?php echo e($job['company_logo'] ?? asset('assets/images/company-logos/company1.svg')); ?>" alt="<?php echo e($job['company_name']); ?>">
                                    </div>
                                    <div class="job-info">
                                        <h3 class="job-title"><a href="<?php echo e(route('jobs.show', $job['slug'] ?? $job['id'])); ?>"><?php echo e($job['name']); ?></a></h3>
                                        <div class="job-meta">
                                            <span class="company-name"><?php echo e($job['company_name']); ?></span>
                                            <span class="job-location"><?php echo e($job['address'] ?? $job['city_name'] ?? 'Location TBD'); ?></span>
                                            <span class="job-type"><?php echo e($job['type_name'] ?? 'Full-time'); ?></span>
                                        </div>
                                        <div class="job-description">
                                            <p><?php echo e(Str::limit(strip_tags($job['description'] ?? ''), 150)); ?></p>
                                        </div>
                                    </div>
                                    <div class="job-actions">
                                        <a href="https://myjob.one/jobs/<?php echo e($job['slug'] ?? $job['id']); ?>" class="button" target="_blank">Apply Now</a>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <!-- Pagination -->
                        <?php if(isset($pagination) && $pagination['total'] > $pagination['per_page']): ?>
                        <div class="pagination-container">
                            <?php echo $__env->make('components.pagination', ['pagination' => $pagination], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Categories Section -->
        <?php if(!empty($categories)): ?>
        <section class="job-categories">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2><?php echo e(__('messages.popular_categories')); ?></h2>
                        </div>

                        <div class="categories-grid">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="category-item">
                                <div class="category-icon">
                                    <i class="fa fa-<?php echo e($category['icon'] ?? 'briefcase'); ?>"></i>
                                </div>
                                <h3 class="category-title"><a href="<?php echo e(route('jobs.index', ['category' => $category['id']])); ?>"><?php echo e($category['name']); ?></a></h3>
                                <span class="category-count"><?php echo e($category['job_count'] ?? 0); ?> <?php echo e(__('messages.jobs')); ?></span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Testimonials Section -->
        <section class="testimonials">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2><?php echo e(__('messages.user_reviews')); ?></h2>
                            <p><?php echo e(__('messages.hear_from_users')); ?></p>
                        </div>

                        <div class="testimonials-slider">
                            <!-- Testimonial 1 -->
                            <div class="testimonial-item">
                                <div class="testimonial-content">
                                    <p>"Through this platform, I found my ideal job within a week. It’s easy to use and offers a wide range of positions."</p>
                                    <div class="testimonial-author">
                                        <div class="author-info">
                                            <h4>Mr. Zhang</h4>
                                            <span>Frontend Developer</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="footer">
        <div class="container">
            <div class="row">
                <!-- Company Info -->
                <div class="col-md-4">
                    <div class="footer-widget">
                        <h3><?php echo e(is_array($site) && isset($site['site_name']) ? $site['site_name'] : 'MyJob Portal'); ?></h3>
                        <p><?php echo e(is_array($site) && isset($site['site_description']) ? $site['site_description'] : 'Connecting great talent with the best opportunities'); ?></p>
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
                            <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                            <li><a href="<?php echo e(route('jobs.index')); ?>">Browse Jobs</a></li>
                            <li><a href="<?php echo e(route('about')); ?>">About Us</a></li>
                            <li><a href="<?php echo e(route('contact')); ?>">Contact Us</a></li>
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
                        <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(is_array($site) && isset($site['site_name']) ? $site['site_name'] : 'MyJob Portal'); ?>. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>
</body>

</html><?php /**PATH /www/wwwroot/default_com/resources/views/home/index.blade.php ENDPATH**/ ?>