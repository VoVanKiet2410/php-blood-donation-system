<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Config\Database;

class UserController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function index()
    {
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        require_once '../app/views/users/index.php';
    }

    public function create()
    {
        $roles = $this->getRoles();
        require_once '../app/views/users/create.php';
    }

    public function store($data)
    {
        $query = "INSERT INTO users (CCCD, password, phone, email, role_id) VALUES (:username, :password, :phone, :email, :role_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':role_id', $data['role_id']);
        if ($stmt->execute()) {
            header("Location: /users");
        } else {
            // Handle error
        }
    }

    public function edit($id)
    {
        $query = "SELECT * FROM users WHERE CCCD = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        $roles = $this->getRoles();
        require_once '../app/views/users/edit.php';
    }

    public function update($data)
    {
        $query = "UPDATE users SET phone = :phone, email = :email, role_id = :role_id WHERE CCCD = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':role_id', $data['role_id']);
        if ($stmt->execute()) {
            header("Location: /users");
        } else {
            // Handle error
        }
    }

    private function getRoles()
    {
        $query = "SELECT * FROM roles";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}