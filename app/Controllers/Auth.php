<?php

namespace App\Controllers;

use App\Models\StudentModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function __construct() {
        helper('form'); // Load the form helper
    }  

    public function register()
    {
        return view('v_register');
    }  

    public function save_register()
    {
        $validation = \Config\Services::validation();

        // Validate form data
        $validation->setRules([
            'matricNum' => [
                'rules' => 'required|alpha_numeric|min_length[8]|max_length[12]',
                'errors' => [
                    'required' => 'Matric Number is required',
                    'alpha_numeric' => 'Matric Number can only contain letters and numbers',
                    'min_length' => 'Matric Number must be at least 8 characters long',
                    'max_length' => 'Matric Number cannot exceed 12 characters'
                ]
            ],
            'name' => [
                'rules' => 'required|alpha_space|min_length[3]',
                'errors' => [
                    'required' => 'Name is required',
                    'alpha_space' => 'Name can only contain letters and spaces',
                    'min_length' => 'Name must be at least 3 characters long'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[students.email]',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Please enter a valid email address',
                    'is_unique' => 'This email is already registered'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password must be at least 8 characters long'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Please confirm your password',
                    'matches' => 'Passwords do not match'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Validation failed, redirect back with errors
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validation->getErrors());
        }

        // Create new instance of StudentModel
        $studentModel = new StudentModel();

        // Prepare data for insertion
        $data = [
            'matricNum' => $this->request->getPost('matricNum'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT)
        ];

        // All fields validated, now insert the student
        try {
            // Insert the data into the database
            $studentModel->save($data);
            
            // Flash success message and redirect to login
            return redirect()->to('/login')
                           ->with('success', 'Registration successful! Please login with your email and password.');
        } catch (\Exception $e) {
            // Handle any database errors
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Registration failed. Please try again.');
        }
    }
}