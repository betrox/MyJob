<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{ is_array($seo) ? ($seo['title'] ?? 'Contact Us - ' . ($site['site_name'] ?? 'MyJob Portal')) : 'Contact Us - ' . ($site['site_name'] ?? 'MyJob Portal') }}</title>
    <meta name="description" content="{{ is_array($seo) ? ($seo['description'] ?? 'Contact us for more information') : 'Contact us for more information' }}">
    <meta name="keywords" content="{{ is_array($seo) ? ($seo['keywords'] ?? 'contact us, contact information, customer service') : 'contact us, contact information, customer service' }}">
    <link rel="canonical" href="{{ is_array($seo) ? ($seo['canonical'] ?? url()->current()) : url()->current() }}">

    <!-- Open Graph -->
    <meta property="og:type" content="{{ is_array($seo) ? ($seo['og_type'] ?? 'website') : 'website' }}">
    <meta property="og:title" content="{{ is_array($seo) ? ($seo['title'] ?? 'Contact Us - ' . ($site['site_name'] ?? 'MyJob Portal')) : 'Contact Us - ' . ($site['site_name'] ?? 'MyJob Portal') }}">
    <meta property="og:description" content="{{ is_array($seo) ? ($seo['description'] ?? 'Contact us for more information') : 'Contact us for more information' }}">
    <meta property="og:url" content="{{ is_array($seo) ? ($seo['canonical'] ?? url()->current()) : url()->current() }}">
    <meta property="og:image" content="{{ is_array($seo) ? ($seo['og_image'] ?? asset('assets/images/logo.svg')) : asset('assets/images/logo.svg') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="{{ is_array($seo) ? ($seo['twitter_card'] ?? 'summary') : 'summary' }}">
    <meta name="twitter:title" content="{{ is_array($seo) ? ($seo['title'] ?? 'Contact Us - ' . ($site['site_name'] ?? 'MyJob Portal')) : 'Contact Us - ' . ($site['site_name'] ?? 'MyJob Portal') }}">
    <meta name="twitter:description" content="{{ is_array($seo) ? ($seo['description'] ?? 'Contact us for more information') : 'Contact us for more information' }}">
    <meta name="twitter:image" content="{{ is_array($seo) ? ($seo['og_image'] ?? asset('assets/images/logo.svg')) : asset('assets/images/logo.svg') }}">

    <!-- JSON-LD Structured Data -->
    @if(isset($structuredData['website']))
    <script type="application/ld+json">
        {!! json_encode($structuredData['website'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif

    @if(isset($structuredData['organization']))
    <script type="application/ld+json">
        {!! json_encode($structuredData['organization'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif

    @if(isset($structuredData['faq']))
    <script type="application/ld+json">
        {!! json_encode($structuredData['faq'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Header Section -->
    @include('partials.header')

    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(isset($breadcrumbs))
                        @foreach($breadcrumbs as $breadcrumb)
                            @if($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
                            @endif
                        @endforeach
                    @else
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                    @endif
                </ol>
            </nav>
        </div>
    </section>

    <!-- Contact Hero Section -->
    <section class="contact-hero-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Contact Us</h1>
                    <p>We are always here to help and support you.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Content Section -->
    <section class="contact-content-section">
        <div class="container">
            <div class="row">
                <!-- Contact Form -->
                <div class="col-md-8">
                    <div class="contact-form-wrapper">
                        <h2>Send a Message</h2>
                        <p>Please fill out the form below and we will get back to you as soon as possible.</p>
                        
                        <form class="contact-form" action="#" method="post">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">Name *</label>
                                    <input type="text" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="subject">Subject *</label>
                                <input type="text" id="subject" name="subject" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="message">Message *</label>
                                <textarea id="message" name="message" rows="6" required></textarea>
                            </div>
                            
                            <button type="submit" class="submit-button">Send Message</button>
                        </form>
                    </div>
                </div>
                
                <!-- Contact Information -->
                <div class="col-md-4">
                    <div class="contact-info">
                        <h2>Contact Information</h2>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Address</h3>
                                <p>No. 1 Jianguomenwai Avenue, Chaoyang District, Beijing</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Phone</h3>
                                <p>+86 10 1234 5678</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Email</h3>
                                <p>contact@myjobportal.com</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Working Hours</h3>
                                <p>Monday - Friday: 9:00 - 18:00</p>
                                <p>Weekend: 10:00 - 17:00</p>
                            </div>
                        </div>
                        
                        <div class="social-contact">
                            <h3>Social Media</h3>
                            <div class="social-icons">
                                <a href="#" class="social-icon"><i class="fa fa-weibo"></i></a>
                                <a href="#" class="social-icon"><i class="fa fa-wechat"></i></a>
                                <a href="#" class="social-icon"><i class="fa fa-linkedin"></i></a>
                                <a href="#" class="social-icon"><i class="fa fa-qq"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Frequently Asked Questions</h2>
                    <div class="faq-list">
                        <div class="faq-item">
                            <h3 class="faq-question">How to post a job?</h3>
                            <div class="faq-answer">
                                <p>Employers need to register an account first, then log in to the admin panel, click “Post Job”, fill in the job information, and submit for review.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <h3 class="faq-question">How long does job review take?</h3>
                            <div class="faq-answer">
                                <p>In general, job reviews are completed within 24 hours. Delays may occur during holidays.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <h3 class="faq-question">How to apply for a job?</h3>
                            <div class="faq-answer">
                                <p>Job seekers can click “Apply for Job” on the job detail page, fill in personal information and upload a resume, then submit the application.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <h3 class="faq-question">How to edit a posted job?</h3>
                            <div class="faq-answer">
                                <p>Employers can log in to the admin panel, find the job in “My Jobs” list, and click the edit button to make changes.</p>
                            </div>
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
                        <h3>{{ $site['site_name'] ?? 'MyJob Portal' }}</h3>
                        <p>{{ $site['site_description'] ?? 'Connecting great talents with the best job opportunities' }}</p>
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
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('jobs.index') }}">Browse Jobs</a></li>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Newsletter -->
                <div class="col-md-4">
                    <div class="footer-widget">
                        <h3>Newsletter</h3>
                        <p>Subscribe to our mailing list to get the latest job updates.</p>
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
                        <p>&copy; {{ date('Y') }} {{ $site['site_name'] ?? 'MyJob Portal' }}. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    <!-- Contact Form Script -->
    <script>
        $(document).ready(function() {
            // FAQ toggle
            $('.faq-question').click(function() {
                $(this).next('.faq-answer').slideToggle();
                $(this).parent().toggleClass('active');
            });
            
            // Form submission
            $('.contact-form').submit(function(e) {
                e.preventDefault();
                alert('Thank you for your message! We will get in touch with you soon.');
                this.reset();
            });
        });
    </script>
</body>
</html>