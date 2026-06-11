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

    <!-- CSS Variables & Theme Definitions -->
    <style>
        :root {
            --bg-main: #f8fafc;
            --text-primary: #0b2545;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --border-color: #cbd5e1;
            --link-color: #c14747;
            --link-hover-color: #a33636;
            --btn-secondary-bg: #ffffff;
            --btn-secondary-text: #334155;
            --btn-secondary-border: #cbd5e1;
            --btn-secondary-hover-bg: #f1f5f9;
        }

        body.dark-mode {
            --bg-main: #090d16;
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --border-color: #1e293b;
            --link-color: #cbd5e1;
            --link-hover-color: #ffffff;
            --btn-secondary-bg: transparent;
            --btn-secondary-text: #ffffff;
            --btn-secondary-border: rgba(255, 255, 255, 0.4);
            --btn-secondary-hover-bg: rgba(255, 255, 255, 0.05);
        }

        /* CSS Reset */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-secondary);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        a {
            color: inherit;
            text-decoration: inherit;
        }

        /* Header Navigation */
        header {
            background-color: #0b2545;
            padding: 14px 40px;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        @media (max-width: 640px) {
            header {
                padding: 14px 20px;
            }
        }

        .header-logo-container {
            display: flex;
            align-items: center;
        }

        .logo-box {
            background-color: #ffffff;
            border-radius: 6px;
            padding: 4px 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 48px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo-box img {
            height: 100%;
            width: auto;
            object-fit: contain;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .nav-item {
            color: #cbd5e1 !important;
            font-weight: 500;
            font-size: 14.5px;
            transition: color 0.2s ease;
        }

        .nav-item:hover {
            color: #ffffff !important;
        }

        .btn-get-started {
            background-color: #ffffff !important;
            color: #0b2545 !important;
            font-weight: 600;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 6px;
            transition: background-color 0.2s ease, opacity 0.2s ease;
        }

        .btn-get-started:hover {
            background-color: #f1f5f9 !important;
        }

        .dark-mode-toggle {
            color: #cbd5e1;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: color 0.2s ease;
        }

        .dark-mode-toggle:hover {
            color: #ffffff;
        }

        /* Hero Section */
        .hero-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 100px 24px 80px 24px;
            text-align: center;
            background-color: transparent;
            position: relative;
        }

        @media (max-width: 640px) {
            .hero-section {
                padding: 60px 20px 50px 20px;
            }
        }

        .hero-logo-card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 6px 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 64px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            margin-bottom: 28px;
        }

        .hero-logo-card img {
            height: 100%;
            width: auto;
            object-fit: contain;
        }

        .hero-section h1 {
            font-size: 46px;
            font-weight: 800;
            color: var(--text-primary);
            max-width: 800px;
            line-height: 1.15;
            margin-bottom: 20px;
            letter-spacing: -0.02em;
            transition: color 0.3s ease;
        }

        @media (max-width: 640px) {
            .hero-section h1 {
                font-size: 32px;
            }
        }

        .hero-subtitle {
            font-size: 15px;
            color: var(--text-secondary);
            max-width: 620px;
            line-height: 1.6;
            margin-bottom: 36px;
            transition: color 0.3s ease;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            margin-bottom: 28px;
        }

        @media (max-width: 480px) {
            .hero-actions {
                flex-direction: column;
                width: 100%;
                max-width: 320px;
            }
        }

        .btn-hero-primary {
            background-color: #c14747 !important;
            color: #ffffff !important;
            font-weight: 600;
            font-size: 14.5px;
            padding: 11px 22px;
            border-radius: 6px;
            border: 1px solid #c14747;
            transition: background-color 0.2s ease, transform 0.1s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-hero-primary:hover {
            background-color: #a33636 !important;
        }

        .btn-hero-primary:active {
            transform: scale(0.98);
        }

        .btn-hero-secondary {
            background-color: var(--btn-secondary-bg) !important;
            color: var(--btn-secondary-text) !important;
            font-weight: 600;
            font-size: 14.5px;
            padding: 11px 22px;
            border-radius: 6px;
            border: 1px solid var(--btn-secondary-border);
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease, transform 0.1s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-hero-secondary:hover {
            background-color: var(--btn-secondary-hover-bg) !important;
        }

        .btn-hero-secondary:active {
            transform: scale(0.98);
        }

        .hero-sublinks {
            display: flex;
            gap: 28px;
            font-size: 14px;
            font-weight: 600;
        }

        .hero-sublinks a {
            color: var(--link-color) !important;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s ease;
        }

        .hero-sublinks a:hover {
            color: var(--link-hover-color) !important;
            text-decoration: underline;
        }

        /* Features Section */
        .features-section {
            padding: 80px 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        @media (max-width: 640px) {
            .features-section {
                padding: 60px 20px;
            }
        }

        .features-section h2 {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-primary);
            text-align: center;
            margin-bottom: 48px;
            letter-spacing: -0.01em;
            transition: color 0.3s ease;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 32px;
        }

        @media (max-width: 1024px) {
            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .features-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }
        }

        .feature-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .feature-icon-box {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background-color: rgba(193, 71, 71, 0.08);
            color: #c14747;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            box-shadow: 0 4px 6px -1px rgba(193, 71, 71, 0.05);
        }

        .feature-card h3 {
            font-size: 17.5px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 10px;
            transition: color 0.3s ease;
        }

        .feature-card p {
            font-size: 14.5px;
            color: var(--text-secondary);
            line-height: 1.6;
            transition: color 0.3s ease;
        }

        /* Footer */
        footer {
            border-top: 1px solid var(--border-color);
            background-color: transparent;
            padding: 24px 40px;
            transition: border-color 0.3s ease;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        @media (max-width: 768px) {
            footer {
                padding: 24px 20px;
            }
            .footer-container {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }
        }

        .footer-copyright {
            font-size: 13.5px;
            color: var(--text-muted);
            transition: color 0.3s ease;
        }

        .footer-links {
            display: flex;
            gap: 24px;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text-muted);
            transition: color 0.3s ease;
        }

        @media (max-width: 480px) {
            .footer-links {
                flex-direction: column;
                gap: 8px;
            }
        }

        .footer-links a {
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: #c14747;
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <header>
        <div class="header-container">
            <div class="header-logo-container">
                <div class="logo-box">
                    <img src="/img/ctb-logo-6QqsiqVS.png" alt="California Target Book Logo">
                </div>
            </div>
            <div class="nav-links">
                <a href="/book" class="nav-item">Book App</a>
                @guest
                    <a href="/login" class="nav-item">Sign In</a>
                    <a href="/signup" class="btn-get-started">Get Started</a>
                @else
                    <a href="/account" class="nav-item">My Account</a>
                    <a href="/logout" class="btn-get-started" style="background-color: transparent !important; border: 1px solid rgba(255,255,255,0.4); color: #cbd5e1 !important;">Logout</a>
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
            <a href="/book">
                <span>Open Book Application</span>
                <!-- External Link SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                    <polyline points="15 3 21 3 21 9"></polyline>
                    <line x1="10" y1="14" x2="21" y2="3"></line>
                </svg>
            </a>
            @guest
                <a href="/login">Sign In</a>
            @endguest
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
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
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-copyright">
                &copy; {{ date('Y') }} California Target Book. All rights reserved.
            </div>
            <div class="footer-links">
                <a href="/book">Book Application</a>
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
