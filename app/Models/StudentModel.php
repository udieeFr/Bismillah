<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'userID';  // Update to the correct column name

    protected $allowedFields = [
        'matricNum',
        'name',
        'email',
        'password_hash',
        'fine_amount',
    ];

    protected $returnType = 'array'; // Return data as an array
}
