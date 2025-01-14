<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    // Table name
    protected $table = 'Admins';

    // Primary key
    protected $primaryKey = 'adminID';

    // Allowed fields for insert/update
    protected $allowedFields = [
        'username',
        'email',
        'password_hash',
        'last_login',
        'two_factor_code',
        'two_factor_expires_at'
    ];

    // Return results as an associative array
    protected $returnType = 'array';

    // Automatically use timestamps (if you add `created_at` and `updated_at` later)
    public $useTimestamps = false;

    /**
     * Find admin by email
     *
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Update the last login timestamp for an admin
     *
     * @param int $adminID
     * @return bool
     */
    public function updateLastLogin(int $adminID)
    {
        return $this->update($adminID, ['last_login' => date('Y-m-d H:i:s')]);
    }

    public function findByUsername(string $username)
    {
        return $this->where('username', $username)->first();
    }
}
