<?php

namespace App\Models;

use CodeIgniter\Model;

class FineModel extends Model
{
    protected $table = 'fines';
    protected $primaryKey = 'transactionID';

    protected $allowedFields = [
        'studentID',
        'amount',
        'transactionType',
        'date',
    ];

    protected $useTimestamps = false; // Set to true if you add created_at/updated_at
    protected $returnType = 'array'; // Return data as an array
}