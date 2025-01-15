<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'transactionID';

    protected $allowedFields = [
        'userID',
        'amount',
        'transactionType',
        'date',
        'details'
    ];

    public function getTransactionDetails($userID) {
        return $this->select('userID, amount, transactionType, date, details')
                    ->where('userID', $userID)
                    ->first();
    }
    protected $returnType = 'array'; // Return data as an array
}