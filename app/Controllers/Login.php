<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use CodeIgniter\HTTP\ResponseInterface;

class Login extends BaseController
{
    public function index()
    {
        return view('v_login');
    }

    public function authenticate()
    {
        // Get user input
        $matricNum = $this->request->getPost('matricNum');
        $password = $this->request->getPost('password');

        // Load the StudentModel
        $studentModel = new StudentModel();

        // Check if the student exists by matric number
        $student = $studentModel->where('matricNum', $matricNum)->first();

        if ($student && password_verify($password, $student['password_hash'])) {
            // If student exists and password is correct
            session()->set([
                'userID' => $student['userID'],
                'name' => $student['name'],
                'logged_in' => true,
            ]);

        return redirect()->to('/studentDashboard');  // 
        } else {
            // Invalid credentials
            session()->setFlashdata('error', 'Invalid Matric Number or Password');
            return redirect()->to('/login');  // Stay on login page
        }
    }
}