@extends('layouts.master')

@section('title', 'Create Account | California Target Book')

@section('body_class', 'auth-card-body')

@section('styles')
<link href="/css/portal_custom.css" rel="stylesheet">
@endsection

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
