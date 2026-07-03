@extends('layouts.master_headless')

@section('title', 'Login | California Target Book')

@section('body_class', 'auth-card-body')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Bellefair&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="/css/portal_custom.css" rel="stylesheet">
@endsection

@section('content')
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
            <div class="login-footer-links">
                Don't have an account? <a href="{{ route('signup') }}">Create one</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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

