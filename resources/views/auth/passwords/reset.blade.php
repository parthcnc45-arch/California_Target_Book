<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Password | California Target Book</title>
    <link rel="shortcut icon" href="/ctb_logo.ico" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Bellefair&display=swap" rel="stylesheet">

    <link href="/css/portal_custom.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
                <a href="/book" class="nav-item">Book App</a>
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

    <div class="login-container-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h2>Set Password</h2>
                <p>Create a password for your account</p>
            </div>

            <form method="POST" action="{{ route('password.request') }}">
                {{ csrf_field() }}

                <input type="hidden" name="token" value="{{ $token }}">

                <!-- E-Mail Address -->
                <div class="form-group-custom">
                    <div class="label-wrapper">
                        <label for="email" class="form-label-custom">E-Mail Address</label>
                    </div>
                    <input id="email" type="email" class="input-custom{{ $errors->has('email') ? ' has-error-border' : '' }}" name="email" value="{{ $email ?? old('email') }}" @if ($email ?? old('email')) readonly @endif required autofocus>
                    @if ($errors->has('email'))
                        <span class="error-message">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>

                <!-- Password -->
                <div class="form-group-custom">
                    <div class="label-wrapper">
                        <label for="password" class="form-label-custom">Password</label>
                    </div>
                    <input id="password" type="password" class="input-custom{{ $errors->has('password') ? ' has-error-border' : '' }}" name="password" required>
                    @if ($errors->has('password'))
                        <span class="error-message">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div class="form-group-custom">
                    <div class="label-wrapper">
                        <label for="password-confirm" class="form-label-custom">Confirm Password</label>
                    </div>
                    <input id="password-confirm" type="password" class="input-custom{{ $errors->has('password_confirmation') ? ' has-error-border' : '' }}" name="password_confirmation" required>
                    @if ($errors->has('password_confirmation'))
                        <span class="error-message">
                            {{ $errors->first('password_confirmation') }}
                        </span>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit-custom">
                    Set Password
                </button>
            </form>
        </div>
    </div>

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

    <script>
    $(document).on('submit', '#loginForm', function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerText = 'Signing In...';
        
        // Clear previous errors
        $('.error-message').hide();
        $('.input-custom').removeClass('has-error-border');
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        $.ajax({
            url: '{{ route("login") }}',
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                'Accept': 'application/json'
            },
            success: function(result) {
                if (result.success && result.api_token) {
                    localStorage.setItem('api_token', result.api_token);
                    window.location.href = result.redirect || '/book';
                } else {
                    window.location.href = '/book';
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const result = xhr.responseJSON;
                    if (result && result.errors) {
                        for (const [key, messages] of Object.entries(result.errors)) {
                            $('#error-' + key).text(messages[0]).show();
                            $('#' + key).addClass('has-error-border');
                        }
                    }
                } else {
                    console.error('Error:', xhr.responseText);
                    alert('Invalid credentials or sign in failed.');
                }
                submitBtn.disabled = false;
                submitBtn.innerText = 'Sign In';
            }
        });
    });
    </script>
    </body>
</html>
