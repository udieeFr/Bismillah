<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\StudentModel;
use App\Models\TransactionModel;
use App\Models\AdminModel;

class AdminDashboard extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect(); //connect to database to update data in it
    }
    public function index()
    {
        // Check if admin is logged in
        if (!session()->get('logged_in') || session()->get('user_type') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Please login as admin');
        }

        // Load admins dashboard view
        return view('v_adDashboard');
    }

    //search student to manage fines
    public function searchStudent()
    {
        // Check if admin is logged in
        if (!session()->get('logged_in') || session()->get('user_type') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Please login as admin');
        }

        $matricNum = $this->request->getPost('matricNum'); //load matricNum from form submission

        if (empty($matricNum)) { //no matric num entered
            return redirect()->to('/admin/dashboard')->with('error', 'Please enter a matric number');
        }

        $studentModel = new StudentModel(); //new instance of student
        $student = $studentModel->where('matricNum', $matricNum)->first(); //specify which student is object

        //if student exist
        if ($student) {
            // Get transaction history for this student
            $transactionModel = new TransactionModel();
            $transactions = $transactionModel->where('userID', $student['userID'])
                ->orderBy('date', 'DESC')
                ->findAll();

            // Pass data to the view
            return view('v_adDashboard', ['student' => $student, 'transactions' => $transactions]);
        }

        // If student not found, redirect back with error
        return redirect()->to('/admin/dashboard')->with('error', 'Student not found');
    }

    public function registerFine()
    {
        // Check if admin is logged in
        if (!session()->get('logged_in') || session()->get('user_type') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Please login as admin');
        }

        $rules = [
            'userID' => 'required|numeric',
            'amount' => 'required|numeric',
            'details' => 'required'
        ];

        // Input validation
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Invalid input');
        }
        //ask admin to verify passowrd
        $adminModel = new \App\Models\AdminModel();
        $admin = $adminModel->findByUsername(session()->get('username'));
        if (!$admin || !password_verify($this->request->getPost('admin_password'), $admin['password_hash'])) {
            return redirect()->back()->with('error', 'Invalid admin password');
        }
        $userID = $this->request->getPost('userID');
        $amount = $this->request->getPost('amount');
        $details = $this->request->getPost('details');

        // Create model instances
        $transactionModel = new TransactionModel();
        $studentModel = new StudentModel();

        // Start database transaction to edit data dalam db
        //nama db already defined dalam database config
        $this->db->transStart();

        // Create fine transaction
        $transactionModel->insert([
            'userID' => $userID,
            'amount' => $amount,
            'transactionType' => 'Fine',
            'date' => date('Y-m-d H:i:s'),
            'details' => $details
        ]);

        // Update fine amount in student's table
        $student = $studentModel->find($userID);

        // Place new fine balance in a placeholder
        $updatedFineAmount = ($student['fine_amount'] ?? 0) + $amount;

        // Update fine balance
        $studentModel->update($userID, ['fine_amount' => $updatedFineAmount]);

        // Complete the database transaction
        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Failed to register fine');
        }

        return redirect()->back()->with('success', 'Fine registered successfully');
    }

    public function registerPayment()
    {
        // Check if admin is logged in
        if (!session()->get('logged_in') || session()->get('user_type') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Please login as admin');
        }

        $rules = [
            'userID' => 'required|numeric',
            'amount' => 'required|numeric',
            'details' => 'required'
        ];

        // Input validation
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Invalid input');
        }

        //ask admin untuk verify password
        $adminModel = new \App\Models\AdminModel();
        $admin = $adminModel->findByUsername(session()->get('username'));
        if (!$admin || !password_verify($this->request->getPost('admin_password'), $admin['password_hash'])) {
            return redirect()->back()->with('error', 'Invalid admin password');
        }
        $userID = $this->request->getPost('userID'); //userId used to find student in table
        $amount = $this->request->getPost('amount'); //amount paid
        $details = $this->request->getPost('details'); //transaction description

        // Create model instances
        $transactionModel = new TransactionModel();
        $studentModel = new StudentModel();

        // Start database transaction to edit data dalam db
        //nama db already defined dalam database config
        $this->db->transStart();

        // Create fine transaction
        $transactionModel->insert([
            'userID' => $userID,
            'amount' => $amount,
            'transactionType' => 'Payment',
            'date' => date('Y-m-d H:i:s'),
            'details' => $details
        ]);

        // Update fine amount in student's table
        $student = $studentModel->find($userID);

        // Place new fine balance in a placeholder
        $updatedFineAmount = ($student['fine_amount'] ?? 0) - $amount;

        // Update fine balance
        $studentModel->update($userID, ['fine_amount' => $updatedFineAmount]);

        // Complete the database transaction
        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Failed to register payment');
        }

        return redirect()->back()->with('success', 'Payment registered successfully');
    }
}
