@extends('layouts.auth')
@section('title', 'Reset Password | California Target Book')

@section('content')
    <div class="login-container-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h2>Reset Password</h2>
                <p>We'll send you a link to reset your password</p>
            </div>

            @if (session('status'))
                <div class="reset-success-card">
                    <div class="reset-success-icon-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
                    </div>
                    <h3 class="reset-success-title">Check your email</h3>
                    <p class="reset-success-text">
                        If an account exists for <strong>{{ old('email') ?? 'the email address provided' }}</strong>, you'll receive a password reset link shortly.
                    </p>
                    <div class="login-footer-links reset-success-footer">
                        <a href="{{ route('login') }}">Back to Sign In</a>
                    </div>
                </div>
            @else
                <form method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}

                    <!-- Email Address -->
                    <div class="form-group-custom">
                        <div class="label-wrapper">
                            <label for="email" class="form-label-custom">Email address</label>
                        </div>
                        <input id="email" type="email" class="input-custom{{ $errors->has('email') ? ' has-error-border' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                        @if ($errors->has('email'))
                            <span class="error-message">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>

                    <!-- Send Reset Link Button -->
                    <button type="submit" class="btn-submit-custom">
                        Send Reset Link
                    </button>
                </form>

                <!-- Back to Sign In -->
                <div class="login-footer-links">
                    <a href="{{ route('login') }}">Back to Sign In</a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
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
            if (toggleBtn) {
                toggleBtn.innerHTML = isDark ? sunIcon : moonIcon;
            }
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
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const isDark = document.body.classList.toggle('dark-mode');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                updateIcon(isDark);
            });
        }
    </script>
@endsection
