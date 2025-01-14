<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - SMK Tanjung Puter Resort</title>
    <!-- Use the same CSS as your registration page -->
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="form-section">
                <div class="text-center">
                    <h1>Verify Your Email</h1>
                    <p>Please enter the verification code sent to your email address</p>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php echo form_open('auth/processEmailVerification'); ?>
                <?= csrf_field() ?>

                <div class="form-outline">
                    <label class="form-label" for="code">Verification Code</label>
                    <input type="text" name="code" id="code" 
                           class="form-control" placeholder="Enter 6-digit code" 
                           required maxlength="6" pattern="[0-9]{6}">
                </div>

                <button type="submit" class="btn">Verify Email</button>

                <div class="divider">
                    <p>Didn't receive the code? <a href="<?= site_url('auth/resend-code') ?>" 
                       style="color: #d8363a; text-decoration: none;">Resend code</a></p>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</body>
</html>