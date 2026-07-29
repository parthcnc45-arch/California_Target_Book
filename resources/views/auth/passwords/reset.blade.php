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

