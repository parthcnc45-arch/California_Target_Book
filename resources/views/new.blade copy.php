<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Definitive Guide to California Politics | California Target Book</title>
    <link rel="shortcut icon" href="/ctb_logo.ico" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Bellefair&display=swap" rel="stylesheet">

    <link href="/css/portal_custom.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style_new.css') }}">

</head>
<body class="landing-body">
    @if (Auth::check() && Auth::user()->isAdmin())
        <div class="admin-nav-bar">
            <div class="admin-nav-container">
                <div class="admin-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: -2px;">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    <span>California Target Book Admin</span>
                </div>
                <a href="/ctb-admin" class="admin-dashboard-link">Go To Admin Dashboard &rarr;</a>
            </div>
        </div>
    @endif

    <!-- Header Navigation -->
    <header>
        <div class="header-container">
            <div class="header-logo-container">
                <div class="logo-box">
                    <img src="/img/ctb-logo-6QqsiqVS.png" alt="California Target Book Logo">
                </div>
            </div>
            <div class="nav-links">
                <a href="/" class="nav-item">Home</a>
                @if (Auth::check() && Auth::user()->hasActiveSubscription())
                    <a href="/book" class="nav-item">Book App</a>
                @endif
                @guest
                    <a href="/login" class="nav-item">Sign In</a>
                    <a href="/signup" class="btn-get-started">Get Started</a>
                @else
                    <a href="/account" class="nav-item">My Account</a>
                    <a href="/logout" class="btn-get-started btn-get-started-logout">Logout</a>
                @endguest
                <div class="dark-mode-toggle" aria-label="Toggle Dark Mode">
                    <!-- Toggle Moon/Sun SVG will be inserted by JS -->
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-logo-card">
            <img src="/img/ctb-logo-6QqsiqVS.png" alt="California Target Book Logo">
        </div>
        
        <h1>The Definitive Guide to California Politics</h1>
        
        <p class="hero-subtitle">
            California Target Book provides essential political data, district profiles, and election analytics trusted by professionals statewide.
        </p>
        
        <!-- <div class="hero-actions">
            <a href="{{ auth()->check() ? '/subscriptions/one-year' : '/login' }}" class="btn-hero-primary">One-Year Subscription</a>
            <a href="{{ auth()->check() ? '/subscriptions/two-year' : '/login' }}" class="btn-hero-secondary">Two-Year Subscription</a>
        </div> -->

        <div class="hero-actions">
            <a href="/subscriptions/one-year" class="btn-hero-primary">One-Year Subscription</a>
            <a href="/subscriptions/two-year" class="btn-hero-secondary">Two-Year Subscription</a>
        </div>
        
        <div class="hero-sublinks">
            @if (Auth::check() && Auth::user()->hasActiveSubscription())
                <a href="/book">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15 3 21 3 21 9"></polyline>
                        <line x1="10" y1="14" x2="21" y2="3"></line>
                    </svg>
                    <span>Open Book Application</span>
                    <!-- External Link SVG -->
                </a>
            @endif
            @guest
                <a href="/login">Sign In</a>
            @endguest
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2>Why Professionals Choose CTB</h2>
            
            <div class="features-grid">
                <!-- Feature 1: Comprehensive Data -->
                <div class="feature-card">
                    <div class="feature-icon-box">
                        <!-- Book SVG Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        </svg>
                    </div>
                    <h3>Comprehensive Data</h3>
                    <p>Access detailed information on every California legislative district and elected official.</p>
                </div>

                <!-- Feature 2: Election Analytics -->
                <div class="feature-card">
                    <div class="feature-icon-box">
                        <!-- Analytics SVG Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="20" x2="18" y2="10"></line>
                            <line x1="12" y1="20" x2="12" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="14"></line>
                        </svg>
                    </div>
                    <h3>Election Analytics</h3>
                    <p>Track campaign finance, voting trends, and political landscape with powerful analytics.</p>
                </div>

                <!-- Feature 3: Team Collaboration -->
                <div class="feature-card">
                    <div class="feature-icon-box">
                        <!-- Users SVG Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <h3>Team Collaboration</h3>
                    <p>Share access with your team through multi-user subscriptions and role management.</p>
                </div>

                <!-- Feature 4: Trusted Source -->
                <div class="feature-card">
                    <div class="feature-icon-box">
                        <!-- Shield SVG Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <h3>Trusted Source</h3>
                    <p>Relied on by lobbyists, campaigns, and political professionals across California.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-copyright">
                &copy; {{ date('Y') }} California Target Book. All rights reserved.
            </div>
            <div class="footer-links">
                <a href="/">Home</a>
                @if (Auth::check() && Auth::user()->hasActiveSubscription())
                    <a href="/book">Book Application</a>
                @endif
                @guest
                    <a href="/login">Sign In</a>
                    <a href="/signup">Create Account</a>
                @else
                    <a href="/account">My Account</a>
                @endguest
            </div>
        </div>
    </footer>

    <!-- Dark Mode Toggle Script -->
    <script>
        const moonIcon = `
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
        `;

        const sunIcon = `
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5"></circle>
                <line x1="12" y1="1" x2="12" y2="3"></line>
                <line x1="12" y1="21" x2="12" y2="23"></line>
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                <line x1="1" y1="12" x2="3" y2="12"></line>
                <line x1="21" y1="12" x2="23" y2="12"></line>
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
            </svg>
        `;

        const toggleBtn = document.querySelector('.dark-mode-toggle');

        function updateIcon(isDark) {
            toggleBtn.innerHTML = isDark ? sunIcon : moonIcon;
        }

        // Initialize theme from localStorage
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'dark') {
            document.body.classList.add('dark-mode');
            updateIcon(true);
        } else {
            updateIcon(false);
        }

        // Add toggle action
        toggleBtn.addEventListener('click', () => {
            const isDark = document.body.classList.toggle('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateIcon(isDark);
        });
    </script>
</body>
</html>
