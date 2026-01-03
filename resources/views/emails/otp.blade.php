<!DOCTYPE html>
<html>
<head>
    <title>Password Reset OTP</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;">
        <h2 style="color: #d4af37; text-align: center;">Password Reset Request</h2>
        <p>Hello,</p>
        <p>You have requested to reset your password for your Leathers.pk account. Please use the following One-Time Password (OTP) to verify your identity:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #333; background: #f9f9f9; padding: 10px 20px; border-radius: 5px; border: 1px solid #ddd;">{{ $otp }}</span>
        </div>
        
        <p>This OTP is valid for 15 minutes.</p>
        <p>If you did not request a password reset, please ignore this email.</p>
        
        <p style="margin-top: 30px; font-size: 12px; color: #999; text-align: center;">&copy; {{ date('Y') }} Leathers.pk. All rights reserved.</p>
    </div>
</body>
</html>
