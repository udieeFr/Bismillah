<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\AdminModel;

//register admin through command rather than interface
class AdminRegistration extends BaseCommand
{
    protected $group       = 'Admin';
    protected $name        = 'admin:create';

    public function run(array $params)
    {
        // Add a master password for admin creation
        $masterPassword = getenv('ADMIN_CREATION_PASSWORD');
        
        if (!$masterPassword) {
            CLI::error('Admin creation is not configured.');
            return;
        }

        // Prompt for master password verification
        $enteredMasterPassword = CLI::prompt('Enter master creation password', null, 'required');

        // Verify master password
        if (!password_verify($enteredMasterPassword, password_hash($masterPassword, PASSWORD_DEFAULT))) {
            CLI::error('Incorrect master password!');
            return;
        }

        // Rest of the admin creation logic remains the same
        $username = CLI::prompt('Enter admin username', null, 'required');
        $email = CLI::prompt('Enter admin email', null, 'required|valid_email');
        $password = CLI::prompt('Enter admin password', null, 'required|min_length[8]');
        
        $confirmPassword = CLI::prompt('Confirm admin password', null, 'required');

        if ($password !== $confirmPassword) {
            CLI::error('Passwords do not match!');
            return;
        }

        $adminModel = new AdminModel();

        $existingAdmin = $adminModel->where('username', $username)
                                    ->orWhere('email', $email)
                                    ->first();

        if ($existingAdmin) {
            CLI::error('Username or email already exists!');
            return;
        }

        $adminData = [
            'username' => $username,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT)
        ];

        try {
            $adminModel->save($adminData);
            CLI::write('Admin created successfully!', 'green');
        } catch (\Exception $e) {
            CLI::error('Failed to create admin: ' . $e->getMessage());
        }
    }
}