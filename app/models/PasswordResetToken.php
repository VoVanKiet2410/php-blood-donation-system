<?php

namespace App\Models;

use App\Config\Database;

class PasswordResetToken
{
    public $id;
    public $token;
    public $user_cccd; // Changed from user_id to user_cccd
    public $expiry_date;
    
    private $db;
    
    public function __construct()
    {
        $this->db = Database::getConnection();
    }
    
    public function save()
    {
        if (isset($this->id)) {
            // Update existing record
            $stmt = $this->db->prepare("UPDATE password_reset_token SET token = ?, user_cccd = ?, expiry_date = ? WHERE id = ?");
            $stmt->bind_param("sssi", $this->token, $this->user_cccd, $this->expiry_date, $this->id);
        } else {
            // Insert new record
            $stmt = $this->db->prepare("INSERT INTO password_reset_token (token, user_cccd, expiry_date) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $this->token, $this->user_cccd, $this->expiry_date);
        }
        
        if ($stmt->execute()) {
            if (!isset($this->id)) {
                $this->id = $this->db->insert_id;
            }
            return true;
        }
        return false;
    }
    
    public function delete()
    {
        if (!isset($this->id)) return false;
        
        $stmt = $this->db->prepare("DELETE FROM password_reset_token WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }
    
    public static function find($id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM password_reset_token WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) return null;
        
        $data = $result->fetch_assoc();
        $token = new self();
        $token->id = $data['id'];
        $token->token = $data['token'];
        $token->user_cccd = $data['user_cccd']; // Changed from user_id to user_cccd
        $token->expiry_date = $data['expiry_date'];
        return $token;
    }
    
    public static function findByToken($token)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM password_reset_token WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) return null;
        
        $data = $result->fetch_assoc();
        $passwordResetToken = new self();
        $passwordResetToken->id = $data['id'];
        $passwordResetToken->token = $data['token'];
        $passwordResetToken->user_cccd = $data['user_cccd']; // Changed from user_id to user_cccd
        $passwordResetToken->expiry_date = $data['expiry_date'];
        return $passwordResetToken;
    }
    
    public static function findByUserId($userId)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM password_reset_token WHERE user_cccd = ?"); // Changed from user_id to user_cccd
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) return null;
        
        $data = $result->fetch_assoc();
        $passwordResetToken = new self();
        $passwordResetToken->id = $data['id'];
        $passwordResetToken->token = $data['token'];
        $passwordResetToken->user_cccd = $data['user_cccd']; // Changed from user_id to user_cccd
        $passwordResetToken->expiry_date = $data['expiry_date'];
        return $passwordResetToken;
    }
    
    public static function deleteByUserId($userId)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM password_reset_token WHERE user_cccd = ?"); // Changed from user_id to user_cccd
        $stmt->bind_param("s", $userId);
        return $stmt->execute();
    }
    
    public static function deleteExpiredTokens()
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM password_reset_token WHERE expiry_date < NOW()");
        return $stmt->execute();
    }
    
    public function isExpired()
    {
        return strtotime($this->expiry_date) < time();
    }
}