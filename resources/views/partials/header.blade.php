<!-- Header Section -->
<header id="header">
    <div class="container">
        <nav class="navbar">
            <!-- Logo -->
            <div class="navbar-brand">
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset('assets/images/micro-logo.png') }}" alt="{{ is_array($site) && isset($site['site_name']) ? $site['site_name'] : 'MyJob Portal' }}" class="main-logo">
                </a>
            </div>

            <!-- Main Navigation -->
            <ul class="navbar-nav">
                <li class="{{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ url('/') }}">{{ __('messages.home') }}</a>
                </li>
                <li class="{{ request()->is('jobs*') ? 'active' : '' }}">
                    <a href="{{ route('jobs.index') }}">{{ __('messages.browse_jobs') }}</a>
                </li>
                <li class="{{ request()->is('companies*') ? 'active' : '' }}">
                    <a href="{{ route('companies.index') }}">{{ __('messages.companies') }}</a>
                </li>
                <li class="{{ request()->is('about') ? 'active' : '' }}">
                    <a href="{{ route('about') }}">{{ __('messages.about_us') }}</a>
                </li>
                <li class="{{ request()->is('contact') ? 'active' : '' }}">
                    <a href="{{ route('contact') }}">{{ __('messages.contact_us') }}</a>
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
                                @switch(app()->getLocale())
                                    @case('en') English @break
                                    @case('zh') 中文 @break
                                    @case('ko') 한국어 @break
                                    @case('ja') 日本語 @break
                                    @case('ru') Русский @break
                                    @case('vi') Tiếng Việt @break
                                    @default English
                                @endswitch
                            </span>
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="language-menu">
                            <a href="{{ route('locale.switch', ['locale' => 'en']) }}" class="language-option {{ app()->getLocale() == 'en' ? 'active' : '' }}">{{ __('messages.english') }}</a>
                            <a href="{{ route('locale.switch', ['locale' => 'zh']) }}" class="language-option {{ app()->getLocale() == 'zh' ? 'active' : '' }}">{{ __('messages.chinese') }}</a>
                            <a href="{{ route('locale.switch', ['locale' => 'ko']) }}" class="language-option {{ app()->getLocale() == 'ko' ? 'active' : '' }}">{{ __('messages.korean') }}</a>
                            <a href="{{ route('locale.switch', ['locale' => 'ja']) }}" class="language-option {{ app()->getLocale() == 'ja' ? 'active' : '' }}">{{ __('messages.japanese') }}</a>
                            <a href="{{ route('locale.switch', ['locale' => 'ru']) }}" class="language-option {{ app()->getLocale() == 'ru' ? 'active' : '' }}">{{ __('messages.russian') }}</a>
                            <a href="{{ route('locale.switch', ['locale' => 'vi']) }}" class="language-option {{ app()->getLocale() == 'vi' ? 'active' : '' }}">{{ __('messages.vietnamese') }}</a>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="navbar-action">
                    <a href="{{ route('jobs.index') }}" class="button color">{{ __('messages.browse_jobs') }}</a>
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
                <li class="{{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ url('/') }}">{{ __('messages.home') }}</a>
                </li>
                <li class="{{ request()->is('jobs*') ? 'active' : '' }}">
                    <a href="{{ route('jobs.index') }}">{{ __('messages.browse_jobs') }}</a>
                </li>
                <li class="{{ request()->is('companies*') ? 'active' : '' }}">
                    <a href="{{ route('companies.index') }}">{{ __('messages.companies') }}</a>
                </li>
                <li class="{{ request()->is('about') ? 'active' : '' }}">
                    <a href="{{ route('about') }}">{{ __('messages.about_us') }}</a>
                </li>
                <li class="{{ request()->is('contact') ? 'active' : '' }}">
                    <a href="{{ route('contact') }}">{{ __('messages.contact_us') }}</a>
                </li>
            </ul>
            
            <!-- Mobile Language Switcher -->
            <div class="mobile-language">
                <div class="language-dropdown">
                    <button class="language-button">
                        <i class="fa fa-globe"></i>
                        <span>
                            @switch(app()->getLocale())
                                @case('en') English @break
                                @case('zh') 中文 @break
                                @case('ko') 한국어 @break
                                @case('ja') 日本語 @break
                                @case('ru') Русский @break
                                @case('vi') Tiếng Việt @break
                                @default English
                            @endswitch
                        </span>
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="language-menu">
                        <a href="{{ route('locale.switch', ['locale' => 'en']) }}" class="language-option {{ app()->getLocale() == 'en' ? 'active' : '' }}">{{ __('messages.english') }}</a>
                        <a href="{{ route('locale.switch', ['locale' => 'zh']) }}" class="language-option {{ app()->getLocale() == 'zh' ? 'active' : '' }}">{{ __('messages.chinese') }}</a>
                        <a href="{{ route('locale.switch', ['locale' => 'ko']) }}" class="language-option {{ app()->getLocale() == 'ko' ? 'active' : '' }}">{{ __('messages.korean') }}</a>
                        <a href="{{ route('locale.switch', ['locale' => 'ja']) }}" class="language-option {{ app()->getLocale() == 'ja' ? 'active' : '' }}">{{ __('messages.japanese') }}</a>
                        <a href="{{ route('locale.switch', ['locale' => 'ru']) }}" class="language-option {{ app()->getLocale() == 'ru' ? 'active' : '' }}">{{ __('messages.russian') }}</a>
                        <a href="{{ route('locale.switch', ['locale' => 'vi']) }}" class="language-option {{ app()->getLocale() == 'vi' ? 'active' : '' }}">{{ __('messages.vietnamese') }}</a>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Action Button -->
            <div class="mobile-action">
                <a href="{{ route('jobs.index') }}" class="button color">{{ __('messages.browse_jobs') }}</a>
            </div>
        </div>
    </div>
</header>