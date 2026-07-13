@extends('layouts.auth')
@section('title', 'Sign Up | California Target Book')

@section('content')
    <div class="login-container-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h2>Create Account</h2>
                <p>Get started with California Target Book</p>
            </div>

            <form id="signupForm">
                @csrf

                <!-- Full Name -->
                <div class="form-group-custom">
                    <div class="label-wrapper">
                        <label for="name" class="form-label-custom">Full Name</label>
                    </div>
                    <input id="name" type="text" class="input-custom" name="name" value="{{ old('name') }}" placeholder="John Smith" required autofocus>
                    <span class="error-message" id="error-name" style="display:none;"></span>
                </div>

                <!-- Email -->
                <div class="form-group-custom">
                    <div class="label-wrapper">
                        <label for="email" class="form-label-custom">Email</label>
                    </div>
                    <input id="email" type="email" class="input-custom" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                    <span class="error-message" id="error-email" style="display:none;"></span>
                </div>

                <!-- Company / Organization -->
                <div class="form-group-custom">
                    <div class="label-wrapper">
                        <label for="company" class="form-label-custom">Company / Organization</label>
                    </div>
                    <input id="company" type="text" class="input-custom" name="company" value="{{ old('company') }}" placeholder="Your organization">
                    <span class="error-message" id="error-company" style="display:none;"></span>
                </div>

                <!-- Password -->
                <div class="form-group-custom">
                    <div class="label-wrapper">
                        <label for="password" class="form-label-custom">Password</label>
                    </div>
                    <input id="password" type="password" class="input-custom" name="password" placeholder="Min 8 characters" required>
                    <span class="error-message" id="error-password" style="display:none;"></span>
                </div>

                <!-- Success message -->
                <div id="success-message" style="display:none; color: green; margin-bottom: 15px; font-weight: 600; text-align: center;">
                    Account created successfully! Redirecting...
                </div>

                <!-- Sign Up Button -->
                <button type="submit" class="btn-submit-custom" id="submitBtn">
                    Create Account
                </button>
            </form>

            <!-- Already have an account? Sign In -->
            <div class="login-footer-links">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
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
        $(document).on('submit', '#signupForm', function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerText = 'Creating...';
            
            // Clear previous errors
            $('.error-message').hide();
            $('.input-custom').removeClass('has-error-border');
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            $.ajax({
                url: '/signup',
                type: 'POST',
                data: JSON.stringify(data),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    'Accept': 'application/json'
                },
                success: function(result) {
                    if (result.success) {
                        $('#success-message').show();
                        setTimeout(() => {
                            window.location.href = '/login';
                        }, 1500);
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
                        alert('Something went wrong. Please try again.');
                    }
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Create Account';
                }
            });
        });
    </script>
@endsection
