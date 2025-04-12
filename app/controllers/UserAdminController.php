<?php

namespace App\Controllers;

use App\Models\User;
use App\Controllers\AuthController;

class UserAdminController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        AuthController::authorize(['ADMIN']);

        // Fetch users with their roles and full names
        $query = "SELECT u.*, r.name AS role_name, ui.full_name FROM user u
                  LEFT JOIN role r ON u.role_id = r.id
                  LEFT JOIN user_info ui ON u.user_info_id = ui.id";
        $result = $this->db->query($query);

        $users = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }

        // Pass users to the view
        include_once __DIR__ . '/../views/admin/users/index.php';
    }

    public function create()
    {
        AuthController::authorize(['ADMIN']);

        // Fetch roles from the database
        $query = "SELECT * FROM role";
        $result = $this->db->query($query);

        $roles = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $roles[] = $row;
            }
        }

        // Pass roles to the view
        include_once __DIR__ . '/../views/admin/users/create.php';
    }

    public function store()
    {
        AuthController::authorize(['ADMIN']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cccd = $_POST['cccd'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $role_id = $_POST['role_id'];
            $full_name = $_POST['full_name'];

            $query = "INSERT INTO user_info (full_name) VALUES (?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("s", $full_name);
            $stmt->execute();
            $user_info_id = $this->db->insert_id;

            $query = "INSERT INTO user (cccd, email, phone, role_id, user_info_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sssii", $cccd, $email, $phone, $role_id, $user_info_id);
            $stmt->execute();

            header('Location: index.php?controller=UserAdmin&action=index');
            exit;
        }
    }

    public function edit($cccd)
    {
        AuthController::authorize(['ADMIN']);

        // Fetch user details
        $query = "SELECT u.*, ui.full_name FROM user u
                  LEFT JOIN user_info ui ON u.user_info_id = ui.id
                  WHERE u.cccd = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $cccd);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            header('Location: index.php?controller=UserAdmin&action=index');
            exit;
        }

        // Fetch roles from the database
        $query = "SELECT * FROM role";
        $result = $this->db->query($query);

        $roles = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $roles[] = $row;
            }
        }

        // Pass user and roles to the view
        include_once __DIR__ . '/../views/admin/users/edit.php';
    }

    public function update($cccd)
    {
        AuthController::authorize(['ADMIN']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $role_id = $_POST['role_id'];
            $full_name = $_POST['full_name'];

            $query = "UPDATE user_info ui
                      JOIN user u ON ui.id = u.user_info_id
                      SET ui.full_name = ?, u.email = ?, u.phone = ?, u.role_id = ?
                      WHERE u.cccd = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sssds", $full_name, $email, $phone, $role_id, $cccd);
            $stmt->execute();

            header('Location: index.php?controller=UserAdmin&action=index');
            exit;
        }
    }

    public function delete($cccd)
    {
        AuthController::authorize(['ADMIN']);

        $query = "DELETE u, ui FROM user u
                  JOIN user_info ui ON u.user_info_id = ui.id
                  WHERE u.cccd = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $cccd);
        $stmt->execute();

        header('Location: index.php?controller=UserAdmin&action=index');
        exit;
    }
}