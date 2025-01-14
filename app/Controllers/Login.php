<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Libraries\SecurityHelper;
use CodeIgniter\HTTP\ResponseInterface;

class Login extends BaseController
{
    protected $securityHelper;

    public function __construct() {
        $this->securityHelper = new SecurityHelper(); 
    }

    public function index()
    {
        return view('v_login');
    }

    public function authenticate()
    {
        // Check rate limiting
        $ip = $this->request->getIPAddress();

        if (!$this->securityHelper->checkRateLimit($ip, 'login', 5, 300)) {
            $remainingTime = $this->securityHelper->getRemainingAttempts($ip, 'login', 5, 300);
            return redirect()->back()
                           ->with('error', "Too many login attempts. Please try again in {$remainingTime} seconds.");
        }
        // Sanitize and Get user input
        $inputData = $this->securityHelper->sanitizeInput([
            'matricNum' => $this->request->getPost('matricNum'),
            'password' => $this->request->getPost('password')
        ]);

        // Load the StudentModel
        $studentModel = new StudentModel();

        // Check if the student exists by matric number
        $student = $studentModel->where('matricNum', $inputData['matricNum'])->first();

        if ($student && password_verify($inputData['password'], $student['password_hash'])) {
            // If student exists and password is correct
            session()->set([
                'userID' => $student['userID'],
                'name' => $student['name'],
                'logged_in' => true,
            ]);

        return redirect()->to('/studentDashboard');  // 
        } 
        else {
            // Invalid credentials
            session()->setFlashdata('error', 'Invalid Matric Number or Password');
            return redirect()->to('/login');  // Stay on login page
        }
    }
}