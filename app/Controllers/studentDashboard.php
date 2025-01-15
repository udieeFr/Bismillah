<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\models\StudentModel;
use App\models\TransactionModel;

class StudentDashboard extends BaseController
{
    public function index()
    {
        //instance of student and transaction
        $studentModel = new StudentModel();
        $transactionModel = new TransactionModel();

        $loggedUser = session()->get('userID');
        //find specific student using userID that logged in
        $studentData = $studentModel->getStudentDetails($loggedUser);

        // Ensure studentData is not null (error handling)
        if (!$studentData) {
            return redirect()->to('/login')->with('error', 'Student data not found');
        }
        // list all transaction that match userID
        $transactionHistory = $transactionModel->where('userID', $loggedUser)->orderBy('date', 'DESC')->findAll();
        return view('v_stDashboard', ['studentData' => $studentData, 'transactionHistory' => $transactionHistory]);
    }
}
