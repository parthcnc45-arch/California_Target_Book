@extends('layouts.auth')
@section('title', 'Set Password | California Target Book')

@section('content')
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
