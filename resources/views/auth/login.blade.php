@extends('layouts.auth')
@section('title', 'Login | California Target Book')

@section('content')
    <div class="login-container-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h2>Sign In</h2>
                <p>Access your California Target Book account</p>
            </div>

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                {{ csrf_field() }}

                <!-- Username or Email -->
                <div class="form-group-custom">
                    <div class="label-wrapper">
                        <label for="email" class="form-label-custom">Username or Email</label>
                    </div>
                    <input id="email" type="email" class="input-custom" name="email" value="{{ old('email') }}" required autofocus>
                    <span class="error-message" id="error-email" style="display:none;"></span>
                </div>

                <!-- Password -->
                <div class="form-group-custom">
                    <div class="label-wrapper">
                        <label for="password" class="form-label-custom">Password</label>
                        <a class="forgot-link" href="{{ route('password.reset') }}">
                            Forgot password?
                        </a>
                    </div>
                    <input id="password" type="password" class="input-custom" name="password" required>
                    <span class="error-message" id="error-password" style="display:none;"></span>
                </div>

                <!-- Sign In Button -->
                <button type="submit" class="btn-submit-custom" id="submitBtn">
                    Sign In
                </button>
            </form>

            <!-- Don't have an account? Create one -->
            <div class="login-footer-links">
                Don't have an account? <a href="{{ route('signup') }}">Create one</a>
            </div>
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
@endsection
