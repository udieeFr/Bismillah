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

        // Generate verification code
        $verificationCode = sprintf("%06d", mt_rand(100000, 999999));
        $expiryTime = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Prepare data for insertion
        $data = [
            'matricNum' => $this->request->getPost('matricNum'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'two_factor_code' => $verificationCode,          // Match database column name
            'two_factor_expires_at' => $expiryTime          // Match database column name
        ];

        // All fields validated, now insert the student
        try {
            // Insert the data into the database
            $studentModel->save($data);
            
            //get userID to find in table
            $userId = $studentModel->getInsertID();

            //sent verification email
            $email = service('email');
            $email->setTo($data['email']);
            $email->setFrom('rusdirashid04@gmail.com', 'SMK Tanjung Puter Resort');
            $email->setSubject('Email Verification');
            $email->setMessage(view('emails/v_verificationCode', [
                'code' => $verificationCode,
                'name' => $data['name']
            ]));
            
            if ($email->send()) {
            // Store user ID in session for verification
            session()->set('pending_verification_id', $userId);
            return redirect()->to('verify-email');

            } else {
                // Handle email sending failure
                $studentModel->delete($userId);
                return redirect()->back()
                            ->withInput()
                            ->with('error', 'Failed to send verification email. Please try again.');
            }
        } catch (\Exception $e) {
            // Handle any database errors
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Registration failed. Please try again.' . $e->getMessage());
        }
    }

    public function verifyEmail(){
        if(!session()->has('pending_verification_id')){
            return redirect()->to('register');
        }
        return view('v_verify_email');
    }

    public function processEmailVerification(){

        $code = $this->request->getPost('code'); //verification code
        $userId = session()->get('pending_verification_id');

        if (!$userId) {
            return redirect()->to('register');
        }
        $studentModel = new StudentModel();
        $student = $studentModel->find($userId);

        if ($student && 
        $student['two_factor_code'] === $code && 
        strtotime($student['two_factor_expires_at']) > time()) 
        {
        
            // Clear verification data
            $studentModel->update($userId, [
                'two_factor_code' => null, //will only have value when code is sent to email
                'two_factor_expires_at' => null
            ]);
            // Clear pending status
            session()->remove('pending_verification_id');

            // Redirect to login with success message
            return redirect()->to('login')
                           ->with('success', 'Email verified successfully! You can now login.');
        }

        return redirect()->to('verify-email')
                       ->with('error', 'Invalid or expired verification code');
    }
}