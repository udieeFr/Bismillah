<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\AdminModel;
use CodeIgniter\Controller;
use App\Libraries\SecurityHelper;

class Auth extends Controller
{

    protected $securityHelper;
    public function __construct()
    {
        helper('form'); // Load the form helper
        $this->securityHelper = new SecurityHelper(); //load SecurityHelper class's instance
    }

    public function register()
    {
        return view('v_register');
    }

    public function save_register()
    {
        $validation = \Config\Services::validation();

        //check rate limit
        $ip = $this->request->getIPAddress();
        if (!$this->securityHelper->checkRateLimit($ip, 'register', 3, 300)) {
            return redirect()->back()
                ->with('error', 'Too many registration attempts. Please try again in 5 minutes.');
        }

        // Get and sanitize input data
        $inputData = $this->securityHelper->sanitizeInput([
            'matricNum' => $this->request->getPost('matricNum'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'confirm_password' => $this->request->getPost('confirm_password')
        ]);

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

        if (!$validation->run($inputData)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        // Create new instance of StudentModel
        $studentModel = new StudentModel();

        // Prepare data for insertion
        $data = [
            'matricNum' => $inputData['matricNum'],
            'name' => $inputData['name'],
            'email' => $inputData['email'],
            'password_hash' => password_hash($inputData['password'], PASSWORD_BCRYPT)
        ];

        // insert after validation and sanitization
        try {
            // Insert the data into the database
            $studentModel->save($data);

            // Get userID to find in table
            $userId = $studentModel->getInsertID();

            // Send verification
            if ($this->sendVerificationCode($studentModel, [
                'userID' => $userId,
                'email' => $data['email'],
                'name' => $data['name']
            ], 'student')) {
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

    public function verifyEmail()
    {
        if (!session()->has('pending_verification_id')) {
            return redirect()->to('register');
        }
        return view('v_verify_email');
    }


    //boleh pakai untuk verify both admin ataupun user
    public function sendVerificationCode($model, $user, $verifyType)
    {

        //cari primary key
        $primaryKey = $model->primaryKey;

        // Generate verification code and waktu exipired
        $verificationCode = sprintf("%06d", mt_rand(100000, 999999));
        $expiryTime = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // masukkan verification code dalam table
        $model->update($user[$primaryKey], [
            'two_factor_code' => $verificationCode,
            'two_factor_expires_at' => $expiryTime
        ]);

        // Send verification email usign gmail smtp
        $email = service('email');
        $email->setTo($user['email']);
        $email->setFrom('rusdirashid04@gmail.com', 'SMK Tanjung Puter Resort');
        $email->setSubject('Verification Code');
        $email->setMessage(view('emails/v_verificationCode', [
            'code' => $verificationCode,
            'name' => $user['name'] ?? $user['username']
        ]));

        if ($email->send()) {
            // Store user ID in session for verification
            session()->set('pending_verification_id', $user[$primaryKey]); //see siapa yang currently in verif proccess
            session()->set('verification_type', $verifyType); //admin or user
            return true;
        }

        return false;
    }
    public function processEmailVerification()
    {
        $code = $this->request->getPost('code'); //code user just entered
        $userId = session()->get('pending_verification_id'); //who is user

        if (!$userId) {
            return redirect()->to('register'); //or login
        }

        // Determine the model based on the verification type
        $verifyType = session()->get('verification_type');

        //student verify when register
        if ($verifyType === 'student') {
            $model = new StudentModel();
            $redirectSuccess = 'login'; //success = go to login page to try log in
            $successMessage = 'Email verified successfully! You can now login.';
        } else {
            //admin verify on each log in
            $model = new AdminModel();
            $redirectSuccess = 'AdminDashboard'; //success = create admin view
            $successMessage = 'Admin verification successful!';
            session()->set('logged_in', true); // Set admin as logged in after verification
        }

        $user = $model->find($userId);

        //reset verification code and expires time on database to NULL
        if (
            $user &&
            $user['two_factor_code'] === $code &&
            strtotime($user['two_factor_expires_at']) > time()
        ) {
            // Clear verification data
            $model->update($userId, [
                'two_factor_code' => null,
                'two_factor_expires_at' => null
            ]);

            // Clear pending status
            session()->remove('pending_verification_id');
            session()->remove('verification_type');

            // if success, dapat message success
            return redirect()->to($redirectSuccess)
                ->with('success', $successMessage);
        } else {
            return redirect()->to('verify-email') //repeat
                ->with('error', 'Invalid or expired verification code');
        }
    }
}
