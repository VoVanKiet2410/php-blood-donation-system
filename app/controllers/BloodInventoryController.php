<?php

namespace App\Controllers;

use App\Models\BloodInventory;
use App\Models\Appointment;
use Exception;

class BloodInventoryController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function __destruct()
    {
        $this->db = null;
    }

    public function index()
    {
        global $bloodInventories;
        AuthController::authorize(['ADMIN']);
        // Fetch all blood inventories

        $bloodInventories = BloodInventory::all();
        require_once '../app/views/blood_inventory/index.php';
    }

    public function create()
    {
        AuthController::authorize(['ADMIN']);
        require_once '../app/views/blood_inventory/create.php';
    }

    public function store()
    {
        AuthController::authorize(['ADMIN']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bloodInventory = new BloodInventory();
            $bloodInventory->blood_type = $_POST['bloodType'];
            $bloodInventory->quantity = $_POST['quantity'];
            $bloodInventory->last_updated = date('Y-m-d H:i:s');
            $bloodInventory->expiration_date = $_POST['expirationDate'];

            // Add notes if provided
            if (isset($_POST['notes']) && !empty($_POST['notes'])) {
                $bloodInventory->notes = $_POST['notes'];
            }

            try {
                $bloodInventory->save();
                header('Location: ' . BASE_URL . '/index.php?controller=BloodInventory&action=index');
                exit;
            } catch (Exception $e) {
                // Handle error
                echo 'Error: ' . $e->getMessage();
            }
        }
    }

    public function edit()
    {
        AuthController::authorize(['ADMIN']);

        // Get the ID from the URL parameter
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php?controller=BloodInventory&action=index');
            exit;
        }

        $bloodInventory = BloodInventory::find($id);
        if (!$bloodInventory) {
            header('Location: ' . BASE_URL . '/index.php?controller=BloodInventory&action=index');
            exit;
        }

        require_once '../app/views/blood_inventory/edit.php';
    }

    public function update()
    {
        AuthController::authorize(['ADMIN']);

        // Get the ID from the URL parameter
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php?controller=BloodInventory&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bloodInventory = BloodInventory::find($id);
            if (!$bloodInventory) {
                header('Location: ' . BASE_URL . '/index.php?controller=BloodInventory&action=index');
                exit;
            }

            $bloodInventory->blood_type = $_POST['bloodType'];
            $bloodInventory->quantity = $_POST['quantity'];
            $bloodInventory->last_updated = date('Y-m-d H:i:s');
            $bloodInventory->expiration_date = $_POST['expirationDate'];

            // Add notes if provided
            if (isset($_POST['notes']) && !empty($_POST['notes'])) {
                $bloodInventory->notes = $_POST['notes'];
            }

            try {
                $bloodInventory->save();
                header('Location: /blood-inventory');
            } catch (Exception $e) {
                // Handle error
                echo 'Error: ' . $e->getMessage();
            }
        }
    }

    public function delete()
    {
        AuthController::authorize(['ADMIN']);

        // Get the ID from the URL parameter
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php?controller=BloodInventory&action=index');
            exit;
        }

        $bloodInventory = BloodInventory::find($id);
        if ($bloodInventory) {
            try {
                $bloodInventory->delete();
                header('Location: ' . BASE_URL . '/index.php?controller=BloodInventory&action=index');
                exit;
            } catch (Exception $e) {
                // Handle error
                echo 'Error: ' . $e->getMessage();
            }
        } else {
            header('Location: ' . BASE_URL . '/index.php?controller=BloodInventory&action=index');
            exit;
        }
    }
}
