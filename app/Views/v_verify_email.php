<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - SMK Tanjung Puter Resort</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #eee;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow-y: auto;
            padding: 1rem;
        }

        .card {
            display: flex;
            width: 100%;
            max-width: 1000px;
            height: auto;
            margin: 0 auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            flex: 1;
            background-color: #fff;
            padding: 2rem;
            box-sizing: border-box;
        }

        .welcome-section {
            flex: 1;
            background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            text-align: center;
            box-sizing: border-box;
        }

        .form-outline {
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
        }

        .form-control {
            font-size: 0.9rem;
            padding: 0.8rem;
            margin-top: 0.4rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        .form-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.3rem;
        }

        h1 {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: #333;
        }

        h4 {
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }

        p {
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .btn {
            font-size: 1rem;
            padding: 0.8rem 2rem;
            border-radius: 4px;
            cursor: pointer;
            border: 1px solid #d8363a;
            background: transparent;
            color: #d8363a;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }

        .btn:hover {
            background: #d8363a;
            color: white;
        }

        .text-center {
            text-align: center;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert ul {
            margin: 0;
            padding-left: 1.5rem;
        }

        .divider {
            margin: 1.5rem 0;
            text-align: center;
            color: #666;
        }

        .password-hint {
            font-size: 0.8rem;
            color: #666;
            margin-top: 0.3rem;
        }

        @media (max-width: 768px) {
            .card {
                flex-direction: column;
                max-width: 500px;
            }

            .form-section, .welcome-section {
                width: 100%;
            }

            .welcome-section {
                order: -1;
                padding: 1.5rem;
            }
        }
    </style>
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