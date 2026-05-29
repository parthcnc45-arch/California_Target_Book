@extends('layouts.email')

@section('content')

<div style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="{{ url('img/ctb_logo.png') }}" alt="California Target Book Logo" style="max-width: 200px; height: auto;">
    </div>
    <h1 style="color: #0056b3; font-size: 24px; border-bottom: 2px solid #0056b3; padding-bottom: 10px;">Welcome to The California Target Book</h1>

    <p style="font-size: 16px;">Hello <strong>{{ $user->first_name }}</strong>,</p>

    <p style="font-size: 16px;">
        We are thrilled to welcome you! Your account has been successfully created. 
        Below are your login credentials to access our portal securely.
    </p>

    <div style="background-color: #f9f9f9; border: 1px solid #e0e0e0; padding: 15px; margin: 20px 0; border-radius: 5px;">
        <p style="margin: 0; font-size: 16px;"><strong>Email:</strong> {{ $user->email }}</p>
        <p style="margin: 10px 0 0; font-size: 16px;"><strong>Password:</strong> {{ $password }}</p>
    </div>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/login') }}" style="background-color: #0056b3; color: #fff; padding: 12px 25px; text-decoration: none; border-radius: 4px; font-weight: bold; display: inline-block;">
            Login to Your Account
        </a>
    </div>

    <h2 style="color: #333; font-size: 20px; margin-top: 30px;">Important Information</h2>
    
    <ul style="padding-left: 20px; font-size: 16px;">
        <li style="margin-bottom: 10px;">
            <strong>Change Your Password:</strong> We highly recommend modifying your password after logging in for the first time. You can accomplish this easily by navigating to your account settings within the user portal.
        </li>
        <li style="margin-bottom: 10px;">
            <strong>Manage Your Subscription:</strong> Our user portal offers a central hub to manage your ongoing subscriptions, view the details of your plan, upgrade if necessary, and securely manage billing information.
        </li>
        <li style="margin-bottom: 10px;">
            <strong>Need Assistance?</strong> In case you have questions or require support navigating the portal or taking advantage of your subscription, please do not hesitate to contact our dedicated support personnel.
        </li>
    </ul>

    <p style="font-size: 16px; margin-top: 30px;">
        Thank you for choosing The California Target Book. We look forward to serving you!
    </p>
</div>

@endsection
