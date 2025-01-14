<!DOCTYPE html>
<html>
<head>
    <title>Email Verification Code</title>
</head>
<body>
    <h2>Email Verification</h2>
    <p>Dear <?= htmlspecialchars($name) ?>,</p>
    
    <p>Your verification code is:</p>
    
    <h3 style="background-color: #f4f4f4; display: inline-block; padding: 10px; border: 1px solid #ddd;">
        <?= htmlspecialchars($code) ?>
    </h3>
    
    <p>This code will expire in 10 minutes.</p>
    
    <p>If you did not request this verification, please ignore this email.</p>
    
    <p>Best regards,<br>SMK Tanjung Puter Resort</p>
</body>
</html>