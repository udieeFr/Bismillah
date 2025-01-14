<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Controllers\Auth as AuthController;
use CodeIgniter\Controller;

class AdminAuth extends Controller
{
    public function authenticate()
    {
        // Get user input
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Load the AdminModel
        $adminModel = new AdminModel();

        // Check if the admin exists by username
        $admin = $adminModel->findByUsername($username);

        if ($admin && password_verify($password, $admin['password_hash'])) {
            // Use the generic verification method from Auth controller
            $authController = new AuthController();
            
            if ($authController->sendVerificationCode($adminModel, $admin, 'admin')) {
                return redirect()->to('verify-email');
            } else {
                return redirect()->to('login')
                    ->with('error', 'Failed to send verification code');
            }
        } else {
            // Invalid credentials
            return redirect()->back()
                ->with('error', 'Invalid Username or Password');
        }
    }
}