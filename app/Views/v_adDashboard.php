<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SMK Tanjung Puteri Resort</title>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
        }

        .dashboard-container {
            padding: 20px;
        }

        .header {
            background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logout-btn {
            background: transparent;
            border: 1px solid white;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: white;
            color: #d8363a;
        }

        .dashboard-content {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .welcome-message {
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid #eee;
        }

        .stat-card h3 {
            margin: 0 0 0.5rem 0;
            color: #333;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: #d8363a;
        }

        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .search-section {
            margin-bottom: 2rem;
        }

        .search-container {
            margin-bottom: 1rem;
        }

        .search-box {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .search-input {
            flex: 1;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .search-btn {
            padding: 0.8rem 1.5rem;
            background: #d8363a;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .search-btn:hover {
            background: #c62828;
        }

        .student-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .transaction-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .transaction-table th,
        .transaction-table td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .transaction-table th {
            background: #f8f9fa;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="user-info">
            <img src="<?= base_url('assets/images/administrator.png'); ?>" alt="Admin" style="width: 40px; height: 40px;">
            <div>
                <h2 style="margin: 0;">Admin Dashboard</h2>
                <small>Welcome, <?= session()->get('username') ?></small>
            </div>
        </div>
        <a href="<?= site_url('/logout') ?>" class="logout-btn">Logout</a>
    </div>

    <div class="dashboard-container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="dashboard-content">
            <div class="welcome-message">
                <h1>Welcome, <?= session()->get('username') ?>!</h1>
                <p>Manage student fines from here.</p>
            </div>

            <div class="search-section">
                <div class="search-container">
                    <h2>Search Student</h2>
                    <form action="<?= base_url('admin/search-student') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="search-box">
                            <input type="text" name="matricNum" placeholder="Enter Matric Number" class="search-input" required>
                            <button type="submit" class="search-btn">Search</button>
                        </div>
                    </form>
                </div>

                <?php if (isset($student)): ?>
                    <div class="student-card">
                        <div class="student-info">
                            <h3>Student Information</h3>
                            <p><strong>Name:</strong> <?= $student['name'] ?? 'N/A' ?></p>
                            <p><strong>Matric Number:</strong> <?= $student['matricNum'] ?? 'N/A' ?></p>
                            <p><strong>Current Fine Amount:</strong> RM <?= $student['fine_amount'] ?? '0.00' ?></p>
                        </div>

                        <div class="transaction-history">
                            <h3>Transaction History</h3>
                            <table class="transaction-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($transactions)): ?>
                                        <?php foreach ($transactions as $transaction): ?>
                                            <tr>
                                                <td><?= $transaction['date'] ?? 'N/A' ?></td>
                                                <td><?= $transaction['transactionType'] ?? 'N/A' ?></td>
                                                <td>RM <?= $transaction['amount'] ?? '0.00' ?></td>
                                                <td><?= $transaction['details'] ?? 'N/A' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" style="text-align: center;">No transactions found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="registration-section" style="margin-top: 20px;">
                            <h3>Register Fine or Payment</h3>
                            <div style="display: flex; justify-content: space-between;">
                                <!-- Fine Registration Form -->
                                <div style="width: 48%; background: #f9f9f9; padding: 15px; border-radius: 8px;">
                                    <h4>Register Fine</h4>
                                    <form action="<?= base_url('admin/register-fine') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="userID" value="<?= $student['userID'] ?>">

                                        <div style="margin-bottom: 10px;">
                                            <label>Fine Amount (RM)</label>
                                            <input type="number" name="amount" class="search-input" step="0.01" required>
                                        </div>

                                        <div style="margin-bottom: 10px;">
                                            <label>Fine Details</label>
                                            <textarea name="details" class="search-input" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="admin_password">Confirm Admin Password:</label>
                                            <input type="password" name="admin_password" id="admin_password" class="form-control" required>
                                        </div>
                                        <button type="submit" class="search-btn">Register Fine</button>
                                    </form>
                                </div>

                                <!-- Payment Registration Form -->
                                <div style="width: 48%; background: #f9f9f9; padding: 15px; border-radius: 8px;">
                                    <h4>Register Payment</h4>
                                    <form action="<?= base_url('admin/register-payment') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="userID" value="<?= $student['userID'] ?>">

                                        <div style="margin-bottom: 10px;">
                                            <label>Payment Amount (RM)</label>
                                            <input type="number" name="amount" class="search-input" step="0.01" required>
                                        </div>

                                        <div style="margin-bottom: 10px;">
                                            <label>Payment Details</label>
                                            <textarea name="details" class="search-input" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="admin_password">Confirm Admin Password:</label>
                                            <input type="password" name="admin_password" id="admin_password" class="form-control" required>
                                        </div>
                                        <button type="submit" class="search-btn">Register Payment</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Current Fine Amount</h3>
                    <div class="stat-value">RM <?= isset($student['fine_amount']) ? number_format($student['fine_amount'], 2) : '0.00' ?></div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>