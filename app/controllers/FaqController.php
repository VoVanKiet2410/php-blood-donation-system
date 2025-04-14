<?php

namespace App\Controllers;

use App\Models\Faq;
use Exception;

class FaqController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function index()
    {
        try {
            // This is for admin site - redirect to client index for regular users
            if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'ADMIN') {
                $this->clientIndex();
                return;
            }
            
            // Admin view
            // Use database query to fetch all FAQs
            $query = "SELECT * FROM faq ORDER BY id DESC";
            $result = $this->db->query($query);
            
            // Kiểm tra nếu có lỗi trong truy vấn SQL
            if (!$result) {
                throw new Exception("Lỗi truy vấn: " . $this->db->error);
            }
            
            // Convert result to array of objects
            $faqs = [];
            while ($row = $result->fetch_object()) {
                $faqs[] = $row;
            }
            
            // Pass data to the view
            require_once '../app/views/faqs/index.php';
        } catch (Exception $e) {
            error_log('Error in FaqController@index: ' . $e->getMessage());
            echo '<div class="alert alert-danger">Error loading FAQ data: ' . $e->getMessage() . '</div>';
        }
    }

    // Client-specific view method with modern UI
    public function clientIndex()
    {
        try {
            // Use database query to fetch all FAQs for client view
            $query = "SELECT * FROM faq ORDER BY id DESC";
            $result = $this->db->query($query);
            
            // Check for query errors
            if (!$result) {
                throw new Exception("Lỗi truy vấn: " . $this->db->error);
            }
            
            // Convert result to array of objects
            $faqs = [];
            while ($row = $result->fetch_object()) {
                $faqs[] = $row;
            }
            
            // Pass data to the client view
            require_once '../app/views/faqs/client_index.php';
        } catch (Exception $e) {
            error_log('Error in FaqController@clientIndex: ' . $e->getMessage());
            echo '<div class="alert alert-danger">Lỗi khi tải dữ liệu câu hỏi thường gặp: ' . $e->getMessage() . '</div>';
        }
    }

    public function create()
    {
        require_once '../app/views/faqs/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];

            $faq = new Faq();
            $faq->title = $title;
            $faq->description = $description;
            $faq->save();

            header('Location: /faqs');
        }
    }

    public function edit($id)
    {
        $faq = Faq::find($id);
        require_once '../app/views/faqs/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];

            $faq = Faq::find($id);
            $faq->title = $title;
            $faq->description = $description;
            $faq->save();

            header('Location: /faqs');
        }
    }

    public function delete($id)
    {
        $faq = Faq::find($id);
        $faq->delete();

        header('Location: /faqs');
    }
}