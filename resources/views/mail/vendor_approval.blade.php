<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
        }
        .credentials {
            background-color: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin: 20px 0;
        }
        .credentials p {
            margin: 10px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            color: #666666;
            font-size: 12px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Vendor Approval Notification</h1>
        </div>
        <div class="content">
            <p>Dear {{ $vendor->name }},</p>
            <p>We are pleased to inform you that your vendor application has been approved! You can now access your vendor account and start managing your shop.</p>

            <div class="credentials">
                <h3>Your Login Credentials</h3>
                <p><strong>Email:</strong> {{ $vendor->email }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
            </div>

            <p>Please use the credentials above to log in to your vendor account. We recommend changing your password after your first login for security purposes.</p>

            <a href="{{ url('/shop/login') }}" class="button">Log In to Your Account</a>

            <p>If you have any questions or need assistance, please contact our support team at support@example.com.</p>

            <p>Thank you for joining our platform!</p>
            <p>Best regards,<br>The VendorSync Team</p>
        </div>
        <div class="footer">
            <p>This is an automated message. Please do not reply directly to this email.</p>
            <p>&copy; {{ date('Y') }} VendorSync. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
