<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo e(is_array($seo) ? ($seo['title'] ?? 'MyJob Portal') : 'MyJob Portal'); ?></title>

    <meta name="description" content="<?php echo e(is_array($seo) ? ($seo['description'] ?? 'A professional recruitment and job-seeking platform') : 'A professional recruitment and job-seeking platform'); ?>">

    <meta name="keywords" content="<?php echo e(is_array($seo) ? ($seo['keywords'] ?? 'recruitment, jobs, career opportunities, job search') : 'recruitment, jobs, career opportunities, job search'); ?>">

    <link rel="canonical" href="<?php echo e(is_array($seo) ? ($seo['canonical'] ?? url()->current()) : url()->current()); ?>">

    
    <!-- Structured Data -->
    <?php if(isset($structuredData)): ?>
    <script type="application/ld+json">
        <?php echo json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

    </script>
    <?php endif; ?>

    
    <!-- CSS Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/responsive.css')); ?>">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(asset('assets/images/favicon.ico')); ?>" type="image/x-icon">

</head>

<body>

    <!-- Header Navigation -->
    <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    
    <!-- Footer -->
    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <!-- JavaScript -->
    <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>
    
    <!-- Page-specific Scripts -->
    <?php echo $__env->yieldContent('scripts'); ?>

</body>

</html><?php /**PATH /www/wwwroot/default_com/resources/views/layouts/app.blade.php ENDPATH**/ ?>