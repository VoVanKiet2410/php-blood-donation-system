<?php

namespace App\Controllers;

use App\Models\PasswordResetToken;
use App\Models\User;
use App\Config\Database;
use Exception;

class PasswordResetController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function requestPasswordReset($email)
    {
        $user = User::findByEmail($email);
        if (!$user) {
            throw new Exception("User not found.");
        }

        $token = bin2hex(random_bytes(16));
        $expiryDate = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $passwordResetToken = new PasswordResetToken();
        $passwordResetToken->token = $token;
        $passwordResetToken->user_id = $user->id;
        $passwordResetToken->expiry_date = $expiryDate;

        if ($passwordResetToken->save()) {
            // Send email with reset link (not implemented)
            return "Password reset link has been sent to your email.";
        }

        throw new Exception("Failed to create password reset token.");
    }

    public function resetPassword($token, $newPassword)
    {
        $passwordResetToken = PasswordResetToken::findByToken($token);
        if (!$passwordResetToken || strtotime($passwordResetToken->expiry_date) < time()) {
            throw new Exception("Invalid or expired token.");
        }

        $user = User::find($passwordResetToken->user_id);
        if (!$user) {
            throw new Exception("User not found.");
        }

        $user->password = password_hash($newPassword, PASSWORD_BCRYPT);
        $user->save();

        // Optionally delete the token after use
        $passwordResetToken->delete();

        return "Password has been reset successfully.";
    }
}