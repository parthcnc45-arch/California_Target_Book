<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #b91c1c;
            color: #ffffff;
            padding: 32px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
        }
        .content {
            padding: 32px;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            background-color: #b91c1c;
            color: #ffffff !important;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 24px;
            text-align: center;
        }
        .footer {
            background-color: #f1f5f9;
            padding: 24px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>California Target Book</h1>
        </div>
        <div class="content">
            <p>Dear {{ $user->first_name }},</p>
            <p>Thank you for purchasing the <strong>{{ $itemName }}</strong>. We are pleased to deliver your digital product details to you.</p>
            
            <p>You can access your digital package using the button below:</p>
            
            <div style="text-align: center;">
                <a href="{{ route('home') }}" class="btn">Access Digital Product</a>
            </div>

            <p style="margin-top: 32px;">If you have any questions or require assistance, please contact our support team.</p>
            
            <p>Best regards,<br>The California Target Book Team</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} California Target Book. All rights reserved.
        </div>
    </div>
</body>
</html>
