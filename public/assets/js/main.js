/* ====== Main JavaScript ====== */

// DOM Elements
const mobileMenuTrigger = document.querySelector('.mobile-menu-trigger');
const mobileMenu = document.querySelector('.mobile-menu');
const searchForm = document.querySelector('.job-search form');
const favoriteButtons = document.querySelectorAll('.favorite-button');
const dialogOverlay = document.querySelector('.dialog-overlay');
const dialogClose = document.querySelector('.dialog-close');
const dialogTriggers = document.querySelectorAll('[data-dialog]');
const paginationLinks = document.querySelectorAll('.pagination a');
const viewButtons = document.querySelectorAll('.view-button');
const jobListingsContainer = document.querySelector('.job-listings');
const header = document.getElementById('header');
const faqQuestions = document.querySelectorAll('.faq-question');
const contactForm = document.querySelector('.contact-form');

// Mobile Menu Toggle
function toggleMobileMenu() {
    if (mobileMenuTrigger && mobileMenu) {
        mobileMenuTrigger.classList.toggle('active');
        mobileMenu.classList.toggle('active');
        document.body.classList.toggle('menu-open');
    }
}

// Close Mobile Menu on Link Click
function closeMobileMenuOnLinkClick() {
    const mobileMenuLinks = document.querySelectorAll('.mobile-nav a');
    mobileMenuLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (mobileMenuTrigger && mobileMenu) {
                mobileMenuTrigger.classList.remove('active');
                mobileMenu.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
        });
    });
}

// Job Search Form Submission
function handleSearchFormSubmit(e) {
    if (searchForm) {
        e.preventDefault();
        const keyword = document.querySelector('input[name="keyword"]').value;
        const location = document.querySelector('input[name="location"]').value;
        
        if (keyword.trim() || location.trim()) {
            // Here you would typically send an AJAX request to search for jobs
            console.log('Searching for:', { keyword, location });
            
            // Simulate search results
            // In a real application, you would submit the form or make an AJAX request
            // For now, we'll just log to console
            console.log('Form submitted successfully');
        } else {
            alert('请输入职位关键词或地点');
        }
    }
}

// Toggle Favorite Button
function handleFavoriteButtonClick(e) {
    e.preventDefault();
    const button = e.currentTarget;
    const isFavorite = button.classList.contains('favorited');
    
    if (isFavorite) {
        button.classList.remove('favorited');
        button.innerHTML = '<i class="fa fa-heart-o"></i>';
        button.style.color = '#666';
    } else {
        button.classList.add('favorited');
        button.innerHTML = '<i class="fa fa-heart"></i>';
        button.style.color = '#e74c3c';
    }
}

// Dialog Box Functions
function openDialog() {
    if (dialogOverlay) {
        dialogOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeDialog() {
    if (dialogOverlay) {
        dialogOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Pagination Handling
function handlePaginationClick(e) {
    e.preventDefault();
    const link = e.currentTarget;
    const page = link.textContent;
    
    // Remove active class from all links
    paginationLinks.forEach(link => {
        link.classList.remove('current-page');
    });
    
    // Add active class to clicked link
    link.classList.add('current-page');
    
    // Here you would typically load new page content via AJAX
    console.log('Loading page:', page);
    
    // Simulate loading
    if (jobListingsContainer) {
        jobListingsContainer.style.opacity = '0.5';
        setTimeout(() => {
            jobListingsContainer.style.opacity = '1';
        }, 500);
    }
}

// Enhanced Pagination with AJAX Support
function setupPagination() {
    const paginationLinks = document.querySelectorAll('.pagination a.page-link');
    
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const url = this.getAttribute('href');
            if (url && url !== '#') {
                // AJAX pagination loading
                loadPageViaAjax(url);
            }
        });
    });
}

// AJAX Page Loading Function
function loadPageViaAjax(url) {
    const jobListingsContainer = document.querySelector('.job-listings');
    const paginationContainer = document.querySelector('.pagination-container');
    
    if (jobListingsContainer) {
        jobListingsContainer.style.opacity = '0.5';
        
        // Show loading indicator
        const loadingIndicator = document.createElement('div');
        loadingIndicator.className = 'loading-indicator';
        loadingIndicator.innerHTML = '<div class="spinner"></div><p>加载中...</p>';
        loadingIndicator.style.cssText = `
            text-align: center;
            padding: 2rem;
            color: #666;
        `;
        
        const spinner = document.createElement('style');
        spinner.innerHTML = `
            .spinner {
                border: 4px solid #f3f3f3;
                border-top: 4px solid #26ae61;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                animation: spin 1s linear infinite;
                margin: 0 auto 1rem;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(spinner);
        
        jobListingsContainer.parentNode.insertBefore(loadingIndicator, jobListingsContainer);
        
        // AJAX request
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Parse the response
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Extract job listings and pagination
            const newJobListings = doc.querySelector('.job-listings');
            const newPagination = doc.querySelector('.pagination-container');
            
            if (newJobListings) {
                jobListingsContainer.innerHTML = newJobListings.innerHTML;
            }
            
            if (newPagination && paginationContainer) {
                paginationContainer.innerHTML = newPagination.innerHTML;
            }
            
            // Update URL without page reload
            window.history.pushState({}, '', url);
            
            // Reinitialize pagination
            setupPagination();
        })
        .catch(error => {
            console.error('Error loading page:', error);
            // Fallback to full page reload
            window.location.href = url;
        })
        .finally(() => {
            jobListingsContainer.style.opacity = '1';
            loadingIndicator.remove();
        });
    }
}

// Job View Toggle (List/Grid)
function handleViewToggle(e) {
    const button = e.currentTarget;
    const viewType = button.getAttribute('data-view');
    
    // Remove active class from all buttons
    viewButtons.forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Add active class to clicked button
    button.classList.add('active');
    
    // Toggle view class on job listings container
    if (jobListingsContainer) {
        jobListingsContainer.classList.remove('job-view-list', 'job-view-grid');
        jobListingsContainer.classList.add(`job-view-${viewType}`);
    }
}

// Smooth Scrolling for Navigation Links
function setupSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Form Validation
function validateForm(form) {
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.style.borderColor = '#e74c3c';
            
            // Add error message if not exists
            if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('error-message')) {
                const errorMessage = document.createElement('div');
                errorMessage.classList.add('error-message');
                errorMessage.style.color = '#e74c3c';
                errorMessage.style.fontSize = '12px';
                errorMessage.style.marginTop = '5px';
                errorMessage.textContent = 'This field is required';
                input.parentNode.insertBefore(errorMessage, input.nextSibling);
            }
        } else {
            input.style.borderColor = '#ddd';
            
            // Remove error message if exists
            const errorMessage = input.nextElementSibling;
            if (errorMessage && errorMessage.classList.contains('error-message')) {
                errorMessage.remove();
            }
        }
    });
    
    return isValid;
}

// Handle Form Submissions
function setupFormSubmissions() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });
}

// Sticky Header
function setupStickyHeader() {
    let lastScrollTop = 0;
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > 100) {
            header.classList.add('sticky');
        } else {
            header.classList.remove('sticky');
        }
        
        lastScrollTop = scrollTop;
    });
}

// Lazy Loading Images
function setupLazyLoading() {
    const lazyImages = document.querySelectorAll('img[data-src]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const image = entry.target;
                    image.src = image.dataset.src;
                    image.classList.add('loaded');
                    observer.unobserve(image);
                }
            });
        });
        
        lazyImages.forEach(image => {
            imageObserver.observe(image);
        });
    } else {
        // Fallback for browsers without IntersectionObserver
        lazyImages.forEach(image => {
            image.src = image.dataset.src;
            image.classList.add('loaded');
        });
    }
}

// FAQ Functionality
function setupFAQ() {
    if (faqQuestions.length > 0) {
        faqQuestions.forEach(question => {
            question.addEventListener('click', function() {
                const faqItem = this.parentElement;
                const isActive = faqItem.classList.contains('active');
                
                // Close all FAQ items
                document.querySelectorAll('.faq-item').forEach(item => {
                    item.classList.remove('active');
                });
                
                // If current item wasn't active, activate it
                if (!isActive) {
                    faqItem.classList.add('active');
                }
            });
        });
    }
}

// Contact Form Handling
function setupContactForm() {
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const name = this.querySelector('#name').value;
            const email = this.querySelector('#email').value;
            const subject = this.querySelector('#subject').value;
            const message = this.querySelector('#message').value;
            
            // Simple validation
            if (!name || !email || !subject || !message) {
                alert('请填写所有必填字段');
                return;
            }
            
            // Simulate form submission
            alert('感谢您的留言！我们会尽快与您联系。');
            this.reset();
        });
    }
}

// Current Page Highlighting
function setupCurrentPageHighlight() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.navbar-nav a, .mobile-nav a');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPath || 
            (currentPath === '/' && href === '/') ||
            (currentPath.includes(href) && href !== '/')) {
            link.parentElement.classList.add('active');
        }
    });
}

// Initialize All Functions
function init() {
    // Mobile Menu
    if (mobileMenuTrigger) {
        mobileMenuTrigger.addEventListener('click', toggleMobileMenu);
        closeMobileMenuOnLinkClick();
    }
    
    // Search Form
    if (searchForm) {
        searchForm.addEventListener('submit', handleSearchFormSubmit);
    }
    
    // Favorite Buttons
    favoriteButtons.forEach(button => {
        button.addEventListener('click', handleFavoriteButtonClick);
    });
    
    // Dialog Box
    if (dialogTriggers) {
        dialogTriggers.forEach(trigger => {
            trigger.addEventListener('click', openDialog);
        });
    }
    
    if (dialogClose) {
        dialogClose.addEventListener('click', closeDialog);
    }
    
    if (dialogOverlay) {
        dialogOverlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDialog();
            }
        });
    }
    
    // Pagination
    paginationLinks.forEach(link => {
        link.addEventListener('click', handlePaginationClick);
    });
    
    // Enhanced Pagination
    setupPagination();
    
    // View Toggle
    viewButtons.forEach(button => {
        button.addEventListener('click', handleViewToggle);
    });
    
    // Smooth Scroll
    setupSmoothScroll();
    
    // Form Validation
    setupFormSubmissions();
    
    // Sticky Header
    setupStickyHeader();
    
    // Lazy Loading
    setupLazyLoading();
    
    // FAQ Functionality
    setupFAQ();
    
    // Contact Form
    setupContactForm();
    
    // Current Page Highlighting
    setupCurrentPageHighlight();
    
    // Escape key to close dialog
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDialog();
        }
    });
}

// Run initialization when DOM is fully loaded
document.addEventListener('DOMContentLoaded', init);

// Add window resize event listener to update layout
window.addEventListener('resize', function() {
    // Close mobile menu on resize to desktop
    if (window.innerWidth > 992 && mobileMenu && mobileMenu.classList.contains('active')) {
        mobileMenuTrigger.classList.remove('active');
        mobileMenu.classList.remove('active');
        document.body.classList.remove('menu-open');
    }
});