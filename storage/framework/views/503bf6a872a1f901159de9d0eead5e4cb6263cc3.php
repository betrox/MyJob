<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($seo['title'] ?? 'Company List'); ?></title>
    <meta name="description" content="<?php echo e($seo['description'] ?? 'Browse top companies and discover more career opportunities'); ?>">
    <meta name="keywords" content="<?php echo e($seo['keywords'] ?? 'company list, corporate recruitment, employer branding'); ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo e($seo['canonical'] ?? url('/companies')); ?>">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/responsive.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/font-awesome.min.css')); ?>">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Structured Data -->
    <?php if(isset($structuredData['jsonLd'])): ?>
        <script type="application/ld+json">
            <?php echo json_encode($structuredData['jsonLd']); ?>

        </script>
    <?php endif; ?>
</head>
<body>
    <!-- Header Navigation -->
    <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Breadcrumb Navigation -->
    <section class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <?php if(is_array($breadcrumbs)): ?>
                        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="breadcrumb-item <?php echo e($loop->last ? 'active' : ''); ?>">
                                <?php if(!$loop->last): ?>
                                    <a href="<?php echo e($crumb['url'] ?? ''); ?>"><?php echo e($crumb['name'] ?? ''); ?></a>
                                <?php else: ?>
                                    <?php echo e($crumb['name'] ?? ''); ?>

                                <?php endif; ?>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <!-- Breadcrumb data error, show default navigation -->
                        <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Company List</li>
                    <?php endif; ?>
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
                            <input type="text" id="search" name="q" value="<?php echo e($searchParams['q'] ?? ''); ?>" 
                                   placeholder="Enter company name..." class="form-control">
                        </div>
                        
                        <!-- Industry Filter -->
                        <?php if(!empty($industries) && is_array($industries)): ?>
                            <div class="filter-group">
                                <label for="industry">Industry</label>
                                <select id="industry" name="industry" class="form-control">
                                    <option value="">All Industries</option>
                                    <?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $industry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($industry['id'] ?? $industry['value'] ?? ''); ?>" 
                                                <?php echo e(($searchParams['industry'] ?? '') == ($industry['id'] ?? $industry['value'] ?? '') ? 'selected' : ''); ?>>
                                            <?php echo e($industry['name'] ?? $industry['text'] ?? 'Unknown Industry'); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Location Filter -->
                        <div class="filter-group">
                            <label for="location">Location</label>
                            <input type="text" id="location" name="location" value="<?php echo e($searchParams['location'] ?? ''); ?>" 
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
                    
                    <?php if(!empty($companies) && is_array($companies)): ?>
                        <div class="companies-grid">
                            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(is_array($company)): ?>
                                    <div class="company-card">
                                        <div class="company-logo">
                                            <?php if(!empty($company['logo'])): ?>
                                                <img src="<?php echo e($company['logo']); ?>" alt="<?php echo e($company['name'] ?? 'Company'); ?>" 
                                                     onerror="this.src='<?php echo e(asset('assets/images/default-company.png')); ?>'">
                                            <?php else: ?>
                                                <div class="default-logo">
                                                    <i class="fa fa-building"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="company-info">
                                            <h3>
                                                <a href="<?php echo e(route('companies.show', ['slug' => $company['slug'] ?? $company['id'] ?? ''])); ?>">
                                                    <?php echo e($company['name'] ?? 'Unknown Company'); ?>

                                                </a>
                                            </h3>
                                            
                                            <p class="company-industry">
                                                <i class="fa fa-industry"></i>
                                                <?php echo e($company['industry'] ?? 'Uncategorized'); ?>

                                            </p>
                                            
                                            <p class="company-location">
                                                <i class="fa fa-map-marker"></i>
                                                <?php echo e($company['location'] ?? 'Location Unknown'); ?>

                                            </p>
                                            
                                            <?php if(!empty($company['description'])): ?>
                                                <p class="company-description">
                                                    <?php echo e(Str::limit(strip_tags($company['description']), 120)); ?>

                                                </p>
                                            <?php endif; ?>
                                            
                                            <div class="company-stats">
                                                <?php if(!empty($company['employee_count'])): ?>
                                                    <span class="stat">
                                                        <i class="fa fa-users"></i>
                                                        <?php echo e($company['employee_count']); ?> Employees
                                                    </span>
                                                <?php endif; ?>
                                                
                                                <?php if(!empty($company['job_count'])): ?>
                                                    <span class="stat">
                                                        <i class="fa fa-briefcase"></i>
                                                        <?php echo e($company['job_count']); ?> Jobs
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if(isset($pagination) && is_array($pagination) && ($pagination['last_page'] ?? 1) > 1): ?>
                            <div class="pagination-wrapper">
                                <?php echo $__env->make('components.pagination', ['pagination' => $pagination], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        <?php endif; ?>
                        
                    <?php else: ?>
                        <div class="no-companies">
                            <div class="text-center">
                                <i class="fa fa-building-o fa-3x text-muted"></i>
                                <h3>No Company Data</h3>
                                <p class="text-muted">No matching companies found for the current filter</p>
                                <button class="btn btn-primary" onclick="resetFilters()">Reset Filter Options</button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- JavaScript -->
    <script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>
    
    <script>
        function applyFilters() {
            const search = document.getElementById('search').value;
            const industry = document.getElementById('industry').value;
            const location = document.getElementById('location').value;
            
            const params = new URLSearchParams();
            
            if (search) params.append('q', search);
            if (industry) params.append('industry', industry);
            if (location) params.append('location', location);
            
            window.location.href = '<?php echo e(route("companies.index")); ?>?' + params.toString();
        }
        
        function resetFilters() {
            window.location.href = '<?php echo e(route("companies.index")); ?>';
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
</html><?php /**PATH /www/wwwroot/default_com/resources/views/companies/index.blade.php ENDPATH**/ ?>