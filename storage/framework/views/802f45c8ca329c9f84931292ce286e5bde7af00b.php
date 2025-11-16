<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo e(is_array($seo) ? ($seo['title'] ?? (($job['name'] ?? $job['title']) . ' - ' . $job['company_name'] . ' - ' . ($site['site_name'] ?? 'MyJob Portal'))) : (($job['name'] ?? $job['title']) . ' - ' . $job['company_name'] . ' - ' . ($site['site_name'] ?? 'MyJob Portal'))); ?></title>
    <meta name="description" content="<?php echo e(is_array($seo) ? ($seo['description'] ?? Str::limit(strip_tags($job['description'] ?? ''), 160)) : Str::limit(strip_tags($job['description'] ?? ''), 160)); ?>">
    <meta name="keywords" content="<?php echo e(is_array($seo) ? ($seo['keywords'] ?? 'job details,recruitment,career opportunities') : 'job details,recruitment,career opportunities'); ?>">
    <link rel="canonical" href="<?php echo e(is_array($seo) ? ($seo['canonical'] ?? url()->current()) : url()->current()); ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="<?php echo e(is_array($seo) ? ($seo['og_type'] ?? 'article') : 'article'); ?>">
    <meta property="og:title" content="<?php echo e(is_array($seo) ? ($seo['title'] ?? (($job['name'] ?? $job['title']) . ' - ' . $job['company_name'] . ' - ' . ($site['site_name'] ?? 'MyJob Portal'))) : (($job['name'] ?? $job['title']) . ' - ' . $job['company_name'] . ' - ' . ($site['site_name'] ?? 'MyJob Portal'))); ?>">
    <meta property="og:description" content="<?php echo e(is_array($seo) ? ($seo['description'] ?? Str::limit(strip_tags($job['description'] ?? ''), 160)) : Str::limit(strip_tags($job['description'] ?? ''), 160)); ?>">
    <meta property="og:url" content="<?php echo e(is_array($seo) ? ($seo['canonical'] ?? url()->current()) : url()->current()); ?>">
    <meta property="og:image" content="<?php echo e($job['company_logo'] ?? (is_array($seo) ? ($seo['og_image'] ?? asset('assets/images/logo.svg')) : asset('assets/images/logo.svg'))); ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="<?php echo e(is_array($seo) ? ($seo['twitter_card'] ?? 'summary_large_image') : 'summary_large_image'); ?>">
    <meta name="twitter:title" content="<?php echo e(is_array($seo) ? ($seo['title'] ?? (($job['name'] ?? $job['title']) . ' - ' . $job['company_name'] . ' - ' . ($site['site_name'] ?? 'MyJob Portal'))) : (($job['name'] ?? $job['title']) . ' - ' . $job['company_name'] . ' - ' . ($site['site_name'] ?? 'MyJob Portal'))); ?>">
    <meta name="twitter:description" content="<?php echo e(is_array($seo) ? ($seo['description'] ?? Str::limit(strip_tags($job['description'] ?? ''), 160)) : Str::limit(strip_tags($job['description'] ?? ''), 160)); ?>">
    <meta name="twitter:image" content="<?php echo e($job['company_logo'] ?? (is_array($seo) ? ($seo['og_image'] ?? asset('assets/images/logo.svg')) : asset('assets/images/logo.svg'))); ?>">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/responsive.css')); ?>">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">

    <!-- JSON-LD Structured Data -->
    <?php if(isset($structuredData['jobPosting'])): ?>
    <script type="application/ld+json">
        <?php echo json_encode($structuredData['jobPosting'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

    </script>
    <?php endif; ?>

    <?php if(isset($structuredData['breadcrumb'])): ?>
    <script type="application/ld+json">
        <?php echo json_encode($structuredData['breadcrumb'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

    </script>
    <?php endif; ?>

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

    <!-- Job Detail Section -->
    <section class="job-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <!-- Job Header -->
                    <div class="job-header">
                        <div class="job-company-info">
                            <div class="company-logo sidebar-company-logo">
                                <img src="<?php echo e($job['company_logo'] ?? asset('assets/images/company-logos/company1.svg')); ?>" alt="<?php echo e($job['company_name']); ?>">
                            </div>
                            <div class="job-title-section">
                                <h1><?php echo e($job['name'] ?? $job['title']); ?></h1>
                                <div class="job-meta">
                                    <span class="company-name"><?php echo e($job['company_name']); ?></span>
                                    <span class="job-location"><i class="fa fa-map-marker"></i> <?php echo e($job['location'] ?? 'Location TBD'); ?></span>
                                    <span class="job-type"><?php echo e($job['employment_type'] ?? 'Full-time'); ?></span>
                                    <?php if(isset($job['salary_min']) || isset($job['salary_max'])): ?>
                                    <span class="job-salary">
                                        <?php echo e($job['salary_min'] ?? ''); ?><?php echo e(isset($job['salary_min']) && isset($job['salary_max']) ? '-' : ''); ?><?php echo e($job['salary_max'] ?? ''); ?><?php echo e($job['salary_currency'] ?? 'CNY'); ?>/month
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="job-actions">
                            <a href="https://myjob.one/jobs/<?php echo e($job['slug'] ?? $job['id']); ?>" class="button large" target="_blank">Apply Now</a>
                            <button class="button secondary">Save Job</button>
                        </div>
                    </div>

                    <!-- Job Content -->
                    <div class="job-content">

                        <!-- Job Description -->
                        <div class="job-section">
                            <h3>Job Description</h3>
                            <div class="job-description">
                                <?php echo $job['content'] ?? $job['description'] ?? 'No detailed description available.'; ?>

                            </div>
                        </div>

                        <!-- Job Requirements -->
                        <?php if(!empty($job['requirements'])): ?>
                        <div class="job-section">
                            <h3>Job Requirements</h3>
                            <ul class="job-requirements">
                                <?php $__currentLoopData = explode('\n', $job['requirements']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requirement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e(trim($requirement)); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <!-- Job Benefits -->
                        <?php if(!empty($job['benefits'])): ?>
                        <div class="job-section">
                            <h3>Benefits</h3>
                            <ul class="job-benefits">
                                <?php $__currentLoopData = explode('\n', $job['benefits']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e(trim($benefit)); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <!-- Apply Section -->
                        <div class="job-section" id="apply-now">
                            <h3>Apply for this Job</h3>
                            <div class="apply-form">
                                <p>Please send your resume to:</p>
                                <div class="contact-info">
                                    <p><strong>Email:</strong> <?php echo e($job['contact_email'] ?? 'hr@company.com'); ?></p>
                                    <p><strong>Phone:</strong> <?php echo e($job['contact_phone'] ?? 'TBD'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">

                    <!-- Company Info -->
                    <div class="sidebar-widget">
                        <h3>Company Information</h3>
                        <div class="company-info">
                            <div class="company-logo">
                                <img src="<?php echo e($job['company_logo'] ?? asset('assets/images/company-logos/company1.svg')); ?>" alt="<?php echo e($job['company_name']); ?>">
                            </div>
                            <h4><?php echo e($job['company_name']); ?></h4>
                            <p><?php echo e($job['company_description'] ?? 'No company information available.'); ?></p>
                            <div class="company-details">
                                <?php if(!empty($job['company_website'])): ?>
                                <p><strong>Website:</strong> <a href="<?php echo e($job['company_website']); ?>" target="_blank"><?php echo e($job['company_website']); ?></a></p>
                                <?php endif; ?>
                                <?php if(!empty($job['company_size'])): ?>
                                <p><strong>Size:</strong> <?php echo e($job['company_size']); ?> employees</p>
                                <?php endif; ?>
                                <?php if(!empty($job['company_industry'])): ?>
                                <p><strong>Industry:</strong> <?php echo e($job['company_industry']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Similar Jobs -->
                    <div class="sidebar-widget">
                        <h3>Similar Jobs</h3>
                        <div class="similar-jobs">
                            <!-- Similar job recommendations can be added here -->
                            <p>No similar job recommendations available.</p>
                        </div>
                    </div>

                    <!-- Share Job -->
                    <div class="sidebar-widget">
                        <h3>Share This Job</h3>
                        <div class="share-buttons">
                            <a href="#" class="share-button wechat"><i class="fa fa-wechat"></i> WeChat</a>
                            <a href="#" class="share-button weibo"><i class="fa fa-weibo"></i> Weibo</a>
                            <a href="#" class="share-button linkedin"><i class="fa fa-linkedin"></i> LinkedIn</a>
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
                        <h3><?php echo e($site['site_name'] ?? 'MyJob Portal'); ?></h3>
                        <p><?php echo e($site['site_description'] ?? 'Connecting great talent with the best career opportunities.'); ?></p>
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
                        <p>Subscribe to our mailing list for the latest job updates.</p>
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
                        <p>&copy; <?php echo e(date('Y')); ?> <?php echo e($site['site_name'] ?? 'MyJob Portal'); ?>. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>

</body>

</html><?php /**PATH /www/wwwroot/default_com/resources/views/jobs/show.blade.php ENDPATH**/ ?>