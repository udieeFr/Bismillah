<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body,
        html {
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
            max-width: 1200px;
            height: auto;
            margin: 0 auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            flex: 1;
            background-color: #fff;
            padding: 1.5rem;
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

        .admin-section {
            flex: 1;
            background-color: #fff;
            padding: 1.5rem;
            box-sizing: border-box;
        }

        .form-outline {
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
        }

        .form-control {
            font-size: 0.9rem;
            padding: 0.6rem;
            margin-top: 0.4rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        label {
            font-size: 0.9rem;
        }

        h1 {
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }

        h4 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        p {
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .btn {
            font-size: 0.9rem;
            padding: 0.6rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            border: 1px solid #d8363a;
            background: transparent;
            color: #d8363a;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #d8363a;
            color: white;
        }

        .text-center {
            text-align: center;
        }

        .text-center img {
            width: 80px;
            margin-bottom: 1rem;
        }

        .divider {
            margin: 1rem 0;
            text-align: center;
            color: #666;
        }

        @media (max-width: 1024px) {
            .card {
                flex-direction: column;
                max-width: 500px;
            }

            .form-section,
            .welcome-section,
            .admin-section {
                width: 100%;
            }

            .welcome-section {
                order: -1;
            }
        }

        .alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            padding: 15px;
            border-radius: 4px;
            min-width: 300px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            animation: slideIn 0.3s ease-out, fadeOut 0.3s ease-in forwards;
            animation-delay: 0s, 3s;
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

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translate(-50%, -20px);
            }
            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translate(-50%, 0);
            }
            to {
                opacity: 0;
                transform: translate(-50%, -20px);
            }
        }

        /* Adjust the placement of alerts */
        .container {
            position: relative;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <!-- Student Login Section -->
            <div class="form-section">
                <div class="text-center">
                <img src="<?= base_url('assets/images/user-profile.png'); ?>" alt="logo">
                    <h1>Student Login</h1>
                </div>

                <form action="<?= base_url('login/authenticate') ?>" method="POST">
                    <div class="form-outline">
                        <label for="studentMatric">Matric Number</label>
                        <input type="text" id="studentMatric" class="form-control" placeholder="e.g., AI2111111" name="matricNum" required />
                    </div>

                    <div class="form-outline">
                        <label for="studentPassword">Password</label>
                        <input type="password" id="studentPassword" class="form-control" placeholder="*********" name="password" required />
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn">Student Login</button>
                    </div>

                    <div class="divider">
                        <p>Don't have an account? <a href="<?= site_url('auth/register') ?>">Register</a></p>
                    </div>
                </form>
            </div>

            <!-- Welcome Section (Middle) -->
            <div class="welcome-section">
                <h4>Welcome to SMK Tanjung Puteri Resort</h4>
                <p>This is the school's fine management system. Students can log in to view fines, and admins can log in with their credentials.</p>
                <img src="<?= base_url('assets/images/logoTanjung.jpg'); ?>" alt="School Logo" style="width: 150px; margin: 2rem 0;">

            </div>

            <!-- Admin Login Section -->
            <div class="admin-section">
                <div class="text-center">
                <img src="<?= base_url('assets/images/administrator.png'); ?>" alt="logo">

                    <h1>Admin Login</h1>
                </div>

                <form action="<?= base_url('admin/authenticate') ?>" method="POST">
                    <div class="form-outline">
                        <label for="adminUsername">Username</label>
                        <input type="text" id="adminUsername" class="form-control" placeholder="Admin Username" name="username" required />
                    </div>

                    <div class="form-outline">
                        <label for="adminPassword">Password</label>
                        <input type="password" id="adminPassword" class="form-control" placeholder="*********" name="password" required />
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn">Admin Login</button>
                    </div>
                </form>
            </div>
        </div>
        <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
    </div>
    
</body>

</html>