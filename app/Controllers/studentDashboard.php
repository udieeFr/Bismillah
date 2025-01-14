<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\models\StudentModel;

class StudentDashboard extends BaseController
{
    public function index()
    {
        $studentModel = new StudentModel();
        $studentData = $studentModel->getStudentDetails(session()->get('userID'));

        return view('v_stDashboard', ['studentData' => $studentData]);
    }
}