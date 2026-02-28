<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Habari Recruitment Portal - Find your perfect career opportunity">
    <meta name="author" content="Habari Node PLC">
    <meta name="theme-color" content="#C4122F">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('assets/images/habari_logo.png') }}">

    <title>@yield('title', 'Habari Recruitment Portal')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/layout-improvements.css') }}">

    <!-- Footer Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/footer-style.css') }}">

    @stack('styles')

    <style>
        /* Critical inline styles for better initial render */
        body {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        body.loaded {
            opacity: 1;
        }

        /* Ensure proper spacing */
        main {
            min-height: calc(100vh - 160px);
            padding-top: 80px;
        }

        /* Mobile-first responsive utilities */
        @media (max-width: 767px) {
            main {
                padding-top: 80px;
            }

            .container {
                padding-left: 20px;
                padding-right: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <!-- Header -->
    @include('layouts.navigation')

    <!-- Main Content -->
    <main role="main">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- JS -->
    <script src="{{ asset('assets/js/jquery-2.1.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/scrollreveal.min.js') }}"></script>
    <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/imgfix.min.js') }}"></script>
    <script src="{{ asset('assets/js/mixitup.js') }}"></script>
    <script src="{{ asset('assets/js/accordions.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- Layout improvement script -->
    <script>
        (function() {
            'use strict';

            // Mark body as loaded after preloader
            window.addEventListener('load', function() {
                setTimeout(function() {
                    document.body.classList.add('loaded');
                }, 300);
            });

            // Mobile menu improvements
            if (window.innerWidth <= 767) {
                // Close mobile menu when clicking outside
                document.addEventListener('click', function(e) {
                    const nav = document.querySelector('.main-nav .nav');
                    const trigger = document.querySelector('.menu-trigger');

                    if (nav && trigger && !nav.contains(e.target) && !trigger.contains(e.target)) {
                        if (nav.style.display === 'block') {
                            nav.style.display = 'none';
                            trigger.classList.remove('active');
                        }
                    }
                });

                // Close menu when clicking a link
                const mobileLinks = document.querySelectorAll('.main-nav .nav li a');
                mobileLinks.forEach(function(link) {
                    link.addEventListener('click', function() {
                        const nav = document.querySelector('.main-nav .nav');
                        const trigger = document.querySelector('.menu-trigger');

                        if (nav && trigger) {
                            nav.style.display = 'none';
                            trigger.classList.remove('active');
                        }
                    });
                });
            }

            // Smooth scroll with header offset
            document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
                anchor.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href !== '#' && href !== '#!') {
                        const target = document.querySelector(href);
                        if (target) {
                            e.preventDefault();
                            const headerHeight = 80;
                            const targetPosition = target.getBoundingClientRect().top + window
                                .pageYOffset - headerHeight;

                            window.scrollTo({
                                top: targetPosition,
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            });

            // Add active state to current page navigation
            const currentLocation = window.location.pathname;
            const navLinks = document.querySelectorAll('.main-nav .nav li a');

            navLinks.forEach(function(link) {
                const linkPath = new URL(link.href).pathname;
                if (linkPath === currentLocation) {
                    link.classList.add('active');
                }
            });

            // Prevent layout shift on mobile keyboard open
            if ('visualViewport' in window) {
                const viewport = window.visualViewport;
                viewport.addEventListener('resize', function() {
                    document.documentElement.style.setProperty(
                        '--viewport-height',
                        viewport.height + 'px'
                    );
                });
            }

            // Handle orientation change
            window.addEventListener('orientationchange', function() {
                setTimeout(function() {
                    window.scrollTo(0, 0);
                }, 100);
            });

            // Optimize images on mobile
            if (window.innerWidth <= 767) {
                const images = document.querySelectorAll('img[data-mobile-src]');
                images.forEach(function(img) {
                    img.src = img.getAttribute('data-mobile-src');
                });
            }

            // Add loading class for better UX
            document.querySelectorAll('form').forEach(function(form) {
                form.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.classList.contains('loading')) {
                        submitBtn.classList.add('loading');
                        submitBtn.disabled = true;

                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<span>Loading...</span>';

                        // Re-enable after 5 seconds as fallback
                        setTimeout(function() {
                            submitBtn.classList.remove('loading');
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        }, 5000);
                    }
                });
            });
        })();
    </script>

    @stack('scripts')
</body>

</html>
