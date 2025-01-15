<?php

namespace App\Libraries;

class SecurityHelper {
    private $throttler;
    
    public function __construct() {
        $this->throttler = \Config\Services::throttler();
    }
    
    /**
     * Sanitize input data
     * @param array $data Input data array
     * @return array Sanitized data
     */
    public function sanitizeInput(array $data): array {
        $sanitized = [];
        foreach ($data as $key => $value) {
            // Skip password fields from sanitization
            if (in_array($key, ['password', 'confirm_password'])) {
                $sanitized[$key] = $value;
                continue;
            }
            
            if (is_string($value)) {
                // Remove any HTML tags
                $value = strip_tags($value);
                
                // Remove multiple spaces
                $value = preg_replace('/\s+/', ' ', $value);
                
                // Trim whitespace
                $value = trim($value);
                
                // Convert special characters to HTML entities
                $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
            
            $sanitized[$key] = $value;
        }
        return $sanitized;
    }
    
    /**
     * Check rate limiting for an action
     * @param string $key Unique identifier (e.g., IP or user ID)
     * @param string $action Action being rate limited
     * @param int $maxAttempts Maximum attempts allowed
     * @param int $timeWindow Time window in seconds
     * @return bool True if allowed, false if rate limited
     */
    public function checkRateLimit(string $key, string $action, int $maxAttempts = 5, int $timeWindow = 300): bool {
        $tokenName = "rate_limit_{$action}_{$key}";
        
        //sanitize 
        $safeKey = preg_replace('/[^a-zA-Z0-9_]/', '_', $key);
        $safeAction = preg_replace('/[^a-zA-Z0-9_]/', '_', $action);
        $tokenName = "rate_limit_{$safeAction}_{$safeKey}";

        // Check if the action is allowed
        if ($this->throttler->check($tokenName, $maxAttempts, $timeWindow) === false) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Get remaining attempts for rate limited action
     * @param string $key Unique identifier
     * @param string $action Action being rate limited
     * @param int $maxAttempts Maximum attempts allowed
     * @param int $timeWindow Time window in seconds
     * @return int Number of attempts remaining
     */

     //prevent bruteforce
    public function getRemainingAttempts(string $key, string $action, int $maxAttempts = 5, int $timeWindow = 300): int {
        $tokenName = "rate_limit_{$action}_{$key}";
        return $this->throttler->getTokentime($tokenName, $maxAttempts, $timeWindow);
    }
    
    //prevent timing attack
    public function hashEquals($knownString, $userString) 
    {
        return hash_equals($knownString, $userString);
    }
}