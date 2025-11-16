<!-- Modify footer.blade.php to unify footer style -->
<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="footer-content">
                    <div class="footer-logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('assets/images/logo.svg') }}" alt="{{ is_array($site) && isset($site['site_name']) ? $site['site_name'] : 'MyJob Portal' }}" class="footer-logo-img">
                        </a>
                    </div>
                    
                    <div class="footer-links">
                        <div class="footer-column">
                            <h4>Quick Links</h4>
                            <ul>
                                <li><a href="{{ url('/') }}">Home</a></li>
                                <li><a href="{{ route('jobs.index') }}">Job Search</a></li>
                                <li><a href="{{ route('companies.index') }}">Company List</a></li>
                                <li><a href="{{ route('about') }}">About Us</a></li>
                                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                            </ul>
                        </div>
                        
                        <div class="footer-column">
                            <h4>Help Center</h4>
                            <ul>
                                <li><a href="#">User Guide</a></li>
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Terms of Service</a></li>
                            </ul>
                        </div>
                        
                        <div class="footer-column">
                            <h4>Contact Us</h4>
                            <ul>
                                <li><i class="fa fa-envelope"></i> support@myjob.one</li>
                                <li><i class="fa fa-phone"></i> 400-123-4567</li>
                                <li><i class="fa fa-map-marker"></i> Chaoyang District, Beijing</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="footer-bottom">
                        <div class="copyright">
                            <p>&copy; {{ date('Y') }} {{ is_array($site) && isset($site['site_name']) ? $site['site_name'] : 'MyJob Portal' }}. All rights reserved.</p>
                        </div>
                        
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fa fa-weibo"></i></a>
                            <a href="#" class="social-link"><i class="fa fa-wechat"></i></a>
                            <a href="#" class="social-link"><i class="fa fa-qq"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>