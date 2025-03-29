<?php

namespace App\Controllers;

use App\Models\DonationUnit;
use App\Models\User;
use App\Config\Database;

class DonationUnitController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function index()
    {
        $donationUnits = DonationUnit::all($this->db);
        require_once '../app/views/donation_units/index.php';
    }

    public function create()
    {
        require_once '../app/views/donation_units/create.php';
    }

    public function store($data)
    {
        $donationUnit = new DonationUnit($data);
        $donationUnit->save($this->db);
        header('Location: /donation_units');
    }

    public function edit($id)
    {
        $donationUnit = DonationUnit::find($id, $this->db);
        require_once '../app/views/donation_units/edit.php';
    }

    public function update($id, $data)
    {
        $donationUnit = DonationUnit::find($id, $this->db);
        $donationUnit->update($data, $this->db);
        header('Location: /donation_units');
    }

    public function delete($id)
    {
        $donationUnit = DonationUnit::find($id, $this->db);
        $donationUnit->delete($this->db);
        header('Location: /donation_units');
    }
}