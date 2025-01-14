<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - SMK Tanjung Puteri Resort</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #ee7724;
            --secondary-color: #d8363a;
            --accent-color: #dd3675;
            --dark-color: #b44593;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-custom {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color), var(--accent-color), var(--dark-color));
            padding: 1rem;
        }

        .dashboard-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            height: 100%;
        }

        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .profile-icon { background: linear-gradient(45deg, #4e54c8, #8f94fb); }
        .balance-icon { background: linear-gradient(45deg, #11998e, #38ef7d); }
        .history-icon { background: linear-gradient(45deg, #ee0979, #ff6a00); }

        .btn-gradient {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            padding: 0.5rem 1.5rem;
        }

        .btn-gradient:hover {
            opacity: 0.9;
            color: white;
        }

        .profile-section {
            background: #fff;
            border-radius: 10px;
            padding: 2rem;
            margin-top: 2rem;
        }

        .profile-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1rem;
            border-radius: 10px 10px 0 0;
            margin: -2rem -2rem 1rem -2rem;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="<?= base_url('assets/images/logoTanjung.jpg') ?>" alt="School Logo" 
                     height="40" class="me-2 rounded">
                <span>SMK Tanjung Puteri Resort</span>
            </a>
            <div class="ms-auto d-flex align-items-center">
                <span class="text-white me-3">Welcome, <?= esc($studentData['name'] ?? 'Student') ?></span>
                <a href="<?= site_url('/logout') ?>" class="btn btn-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-4">
        <!-- Dashboard Cards -->
        <div class="row g-4">
            <!-- Profile Card -->
            <div class="col-md-4">
                <div class="dashboard-card">
                    <div class="card-icon profile-icon">
                        <i class="fas fa-user-circle text-white fa-2x"></i>
                    </div>
                    <h5>Student Profile</h5>
                    <p class="text-muted">View and manage your profile information</p>
                    <a href="#" onclick="toggleProfile()" class="btn btn-gradient w-100">
                        View Profile
                    </a>
                </div>
            </div>

            <!-- Balance Card -->
            <div class="col-md-4">
                <div class="dashboard-card">
                    <div class="card-icon balance-icon">
                        <i class="fas fa-wallet text-white fa-2x"></i>
                    </div>
                    <h5>Outstanding Balance</h5>
                    <h3 class="text-danger mb-3">
                        RM <?= number_format($studentData['fine_amount'] ?? 0, 2) ?>
                    </h3>
                    <a href="<?= site_url('student/payment') ?>" class="btn btn-gradient w-100">
                        Balance History
                    </a>
                </div>
            </div>

            <!-- History Card -->
            <div class="col-md-4">
                <div class="dashboard-card">
                    <div class="card-icon history-icon">
                        <i class="fas fa-history text-white fa-2x"></i>
                    </div>
                    <h5>Fine History</h5>
                    <p class="text-muted">View your past transactions and payments</p>
                    <a href="<?= site_url('student/transactions') ?>" class="btn btn-gradient w-100">
                        Past Transaction
                    </a>
                </div>
            </div>
        </div>

        <!-- Profile Section -->
        <?php if (isset($showProfile) && $showProfile): ?>
        <div class="profile-section shadow">
            <div class="profile-header">
                <h4 class="mb-0">Student Profile Details</h4>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <p><strong>Student ID:</strong> <?= esc($studentData['matricNum'] ?? 'N/A') ?></p>
                    <p><strong>Name:</strong> <?= esc($studentData['name'] ?? 'N/A') ?></p>
                    <p><strong>Email:</strong> <?= esc($studentData['email'] ?? 'N/A') ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Program:</strong> <?= esc($studentData['program'] ?? 'N/A') ?></p>
                    <p><strong>Status:</strong> <span class="badge bg-success">Active</span></p>
                    <p><strong>Last Login:</strong> <?= date('d M Y H:i:s') ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <div id="profileSection" style="display: none;" class="profile-section shadow">
    <div class="profile-header">
        <h4 class="mb-0">Student Profile Details</h4>
    </div>
    <div class="row g-3">
        <div class="col-md-6">
            <p><strong>Student ID:</strong> <?= esc($studentData['matricNum'] ?? 'N/A') ?></p>
            <p><strong>Name:</strong> <?= esc($studentData['name'] ?? 'N/A') ?></p>
            <p><strong>Email:</strong> <?= esc($studentData['email'] ?? 'N/A') ?></p>
        </div>
        <div class="col-md-6">
            
            <p><strong>Matric Number:</strong> <?= esc($studentData['matricNum'] ?? 'N/A') ?></p>
            <p><strong>Status:</strong> <span class="badge bg-success">Student</span></p>
            <p><strong>Last Login:</strong> <?= date('d M Y') ?></p>
        </div>
    </div>
</div>
    <script>
        function toggleProfile() {
            var profileSection = document.getElementById('profileSection');
            if (profileSection.style.display === 'none') {
                profileSection.style.display = 'block';
            } else {
                profileSection.style.display = 'none';
            }
        }
    </script>
</body>
</html> 