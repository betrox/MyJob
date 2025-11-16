<!-- Header Section -->
<header id="header">
    <div class="container">
        <nav class="navbar">
            <!-- Logo -->
            <div class="navbar-brand">
                <a href="<?php echo e(url('/')); ?>" class="logo">
                    <img src="<?php echo e(asset('assets/images/micro-logo.png')); ?>" alt="<?php echo e(is_array($site) && isset($site['site_name']) ? $site['site_name'] : 'MyJob Portal'); ?>" class="main-logo">
                </a>
            </div>

            <!-- Main Navigation -->
            <ul class="navbar-nav">
                <li class="<?php echo e(request()->is('/') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('/')); ?>"><?php echo e(__('messages.home')); ?></a>
                </li>
                <li class="<?php echo e(request()->is('jobs*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('jobs.index')); ?>"><?php echo e(__('messages.browse_jobs')); ?></a>
                </li>
                <li class="<?php echo e(request()->is('companies*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('companies.index')); ?>"><?php echo e(__('messages.companies')); ?></a>
                </li>
                <li class="<?php echo e(request()->is('about') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('about')); ?>"><?php echo e(__('messages.about_us')); ?></a>
                </li>
                <li class="<?php echo e(request()->is('contact') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('contact')); ?>"><?php echo e(__('messages.contact_us')); ?></a>
                </li>
            </ul>

            <!-- Right Side Items -->
            <div class="navbar-right">
                <!-- Language Switcher -->
                <div class="language-switcher">
                    <div class="language-dropdown">
                        <button class="language-button">
                            <i class="fa fa-globe"></i>
                            <span>
                                <?php switch(app()->getLocale()):
                                    case ('en'): ?> English <?php break; ?>
                                    <?php case ('zh'): ?> 中文 <?php break; ?>
                                    <?php case ('ko'): ?> 한국어 <?php break; ?>
                                    <?php case ('ja'): ?> 日本語 <?php break; ?>
                                    <?php case ('ru'): ?> Русский <?php break; ?>
                                    <?php case ('vi'): ?> Tiếng Việt <?php break; ?>
                                    <?php default: ?> English
                                <?php endswitch; ?>
                            </span>
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="language-menu">
                            <a href="<?php echo e(route('locale.switch', ['locale' => 'en'])); ?>" class="language-option <?php echo e(app()->getLocale() == 'en' ? 'active' : ''); ?>"><?php echo e(__('messages.english')); ?></a>
                            <a href="<?php echo e(route('locale.switch', ['locale' => 'zh'])); ?>" class="language-option <?php echo e(app()->getLocale() == 'zh' ? 'active' : ''); ?>"><?php echo e(__('messages.chinese')); ?></a>
                            <a href="<?php echo e(route('locale.switch', ['locale' => 'ko'])); ?>" class="language-option <?php echo e(app()->getLocale() == 'ko' ? 'active' : ''); ?>"><?php echo e(__('messages.korean')); ?></a>
                            <a href="<?php echo e(route('locale.switch', ['locale' => 'ja'])); ?>" class="language-option <?php echo e(app()->getLocale() == 'ja' ? 'active' : ''); ?>"><?php echo e(__('messages.japanese')); ?></a>
                            <a href="<?php echo e(route('locale.switch', ['locale' => 'ru'])); ?>" class="language-option <?php echo e(app()->getLocale() == 'ru' ? 'active' : ''); ?>"><?php echo e(__('messages.russian')); ?></a>
                            <a href="<?php echo e(route('locale.switch', ['locale' => 'vi'])); ?>" class="language-option <?php echo e(app()->getLocale() == 'vi' ? 'active' : ''); ?>"><?php echo e(__('messages.vietnamese')); ?></a>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="navbar-action">
                    <a href="<?php echo e(route('jobs.index')); ?>" class="button color"><?php echo e(__('messages.browse_jobs')); ?></a>
                </div>

                <!-- Mobile Menu Trigger -->
                <div class="mobile-menu-trigger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div class="mobile-menu">
            <ul class="mobile-nav">
                <li class="<?php echo e(request()->is('/') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('/')); ?>"><?php echo e(__('messages.home')); ?></a>
                </li>
                <li class="<?php echo e(request()->is('jobs*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('jobs.index')); ?>"><?php echo e(__('messages.browse_jobs')); ?></a>
                </li>
                <li class="<?php echo e(request()->is('companies*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('companies.index')); ?>"><?php echo e(__('messages.companies')); ?></a>
                </li>
                <li class="<?php echo e(request()->is('about') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('about')); ?>"><?php echo e(__('messages.about_us')); ?></a>
                </li>
                <li class="<?php echo e(request()->is('contact') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('contact')); ?>"><?php echo e(__('messages.contact_us')); ?></a>
                </li>
            </ul>
            
            <!-- Mobile Language Switcher -->
            <div class="mobile-language">
                <div class="language-dropdown">
                    <button class="language-button">
                        <i class="fa fa-globe"></i>
                        <span>
                            <?php switch(app()->getLocale()):
                                case ('en'): ?> English <?php break; ?>
                                <?php case ('zh'): ?> 中文 <?php break; ?>
                                <?php case ('ko'): ?> 한국어 <?php break; ?>
                                <?php case ('ja'): ?> 日本語 <?php break; ?>
                                <?php case ('ru'): ?> Русский <?php break; ?>
                                <?php case ('vi'): ?> Tiếng Việt <?php break; ?>
                                <?php default: ?> English
                            <?php endswitch; ?>
                        </span>
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="language-menu">
                        <a href="<?php echo e(route('locale.switch', ['locale' => 'en'])); ?>" class="language-option <?php echo e(app()->getLocale() == 'en' ? 'active' : ''); ?>"><?php echo e(__('messages.english')); ?></a>
                        <a href="<?php echo e(route('locale.switch', ['locale' => 'zh'])); ?>" class="language-option <?php echo e(app()->getLocale() == 'zh' ? 'active' : ''); ?>"><?php echo e(__('messages.chinese')); ?></a>
                        <a href="<?php echo e(route('locale.switch', ['locale' => 'ko'])); ?>" class="language-option <?php echo e(app()->getLocale() == 'ko' ? 'active' : ''); ?>"><?php echo e(__('messages.korean')); ?></a>
                        <a href="<?php echo e(route('locale.switch', ['locale' => 'ja'])); ?>" class="language-option <?php echo e(app()->getLocale() == 'ja' ? 'active' : ''); ?>"><?php echo e(__('messages.japanese')); ?></a>
                        <a href="<?php echo e(route('locale.switch', ['locale' => 'ru'])); ?>" class="language-option <?php echo e(app()->getLocale() == 'ru' ? 'active' : ''); ?>"><?php echo e(__('messages.russian')); ?></a>
                        <a href="<?php echo e(route('locale.switch', ['locale' => 'vi'])); ?>" class="language-option <?php echo e(app()->getLocale() == 'vi' ? 'active' : ''); ?>"><?php echo e(__('messages.vietnamese')); ?></a>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Action Button -->
            <div class="mobile-action">
                <a href="<?php echo e(route('jobs.index')); ?>" class="button color"><?php echo e(__('messages.browse_jobs')); ?></a>
            </div>
        </div>
    </div>
</header><?php /**PATH /www/wwwroot/default_com/resources/views/partials/header.blade.php ENDPATH**/ ?>