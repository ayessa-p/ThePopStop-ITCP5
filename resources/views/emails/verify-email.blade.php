<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email Address</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="background-color: #8B0000; padding: 20px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px; letter-spacing: 1px;">The Pop Stop</h1>
        </div>

        <!-- Content -->
        <div style="padding: 30px; color: #333333; text-align: center;">
            <h2 style="color: #8B0000; margin-top: 0;">Welcome, {{ $name }}!</h2>
            <p style="margin-bottom: 20px; font-size: 16px;">Thank you for joining The Pop Stop. Please verify your email address to get started.</p>

            <!-- Action Button -->
            <div style="margin: 30px 0;">
                <a href="{{ $url }}" style="background-color: #8B0000; color: #ffffff; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block; box-shadow: 0 4px 6px rgba(139,0,0,0.2);">
                    Verify Email Address
                </a>
            </div>

            <p style="color: #666666; font-size: 14px; margin-top: 30px;">
                If you did not create an account, no further action is required.
            </p>
        </div>

        <!-- Footer -->
        <div style="background-color: #1F1B1B; padding: 20px; text-align: center;">
            <p style="color: #ffffff; margin: 0; font-size: 12px; margin-bottom: 8px;">&copy; {{ date('Y') }} The Pop Stop. All rights reserved.</p>
            <p style="color: #999999; margin: 0; font-size: 10px;">
                If you're having trouble clicking the button, copy and paste the URL below into your web browser:<br>
                <a href="{{ $url }}" style="color: #8B0000; word-break: break-all;">{{ $url }}</a>
            </p>
        </div>
    </div>
</body>
</html>