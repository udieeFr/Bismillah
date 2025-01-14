<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class studentDashboard extends BaseController
{
    public function index()
    {
        return view('v_stDashboard'); // You'll need to create this view
    }

    public function getProfile()
    {
       //$studentModel = new StudentModel();
        //$userID = session()->get('userID');
       // $student = $studentModel->getStudentDetails($userID);
        //return $this->response->setJSON($student);
    }
}
