<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'userID';  // Update to the correct column name

    protected $allowedFields = [
        'userID',
        'matricNum',
        'name',
        'email',
        'password_hash',
        'fine_amount',
        'two_factor_code',
        'two_factor_expires_at',
    ];
    //get data from database
    public function getStudentDetails($userID) {
        return $this->select('matricNum, name, email, fine_amount')
                    ->where('userID', $userID)
                    ->first();
    }

    protected $returnType = 'array'; // Return data as an array
}
