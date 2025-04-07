<?php

namespace App\Controllers;

use App\Models\Faq;
use Exception;
use App\Controllers\AuthController;

class FAQAdmin
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        // Only admin and staff users can access this page
        AuthController::authorize(['ADMIN', 'STAFF']);
        
        try {
            // Lấy dữ liệu FAQ từ database
            $query = "SELECT * FROM faq ORDER BY id";
            $result = $this->db->query($query);
            
            // Kiểm tra nếu có lỗi trong truy vấn SQL
            if (!$result) {
                throw new Exception("Lỗi truy vấn: " . $this->db->error);
            }
            
            // Chuyển đổi kết quả thành mảng các đối tượng
            $faqs = [];
            while ($row = $result->fetch_object()) {
                // Tương thích với view bằng cách chuyển đổi tên trường
                $row->question = $row->title;
                $row->answer = $row->description;
                
                // Lấy ra hoặc gán danh mục mặc định nếu không có
                $category = isset($row->category) && !empty($row->category) ? $row->category : 'Chung';
                
                $faqs[] = $row;
                
                // Nhóm theo danh mục
                if (!isset($faqsByCategory[$category])) {
                    $faqsByCategory[$category] = [];
                }
                $faqsByCategory[$category][] = $row;
            }
            
            // Make the data available to the view
            $data = [
                'faqs' => $faqs,
                'faqsByCategory' => $faqsByCategory
            ];
            
            require_once '../app/views/admin/faqs/index.php';
            
        } catch (Exception $e) {
            error_log('Error in FAQAdmin@index: ' . $e->getMessage());
            echo '<div class="alert alert-danger">Error loading FAQ data: ' . $e->getMessage() . '</div>';
        }
    }

    public function create()
    {
        // Only admin and staff users can access this page
        AuthController::authorize(['ADMIN', 'STAFF']);
        
        try {
            // Instead of trying to fetch categories, just load the form without categories
            require_once '../app/views/admin/faqs/create.php';
        } catch (Exception $e) {
            error_log('Error in FAQAdmin@create: ' . $e->getMessage());
            $_SESSION['error'] = "Error loading FAQ form.";
            header('Location: ' . BASE_URL . '/index.php?controller=FAQAdmin&action=index');
            exit;
        }
    }

    public function store()
    {
        // Only admin and staff users can perform this action
        AuthController::authorize(['ADMIN', 'STAFF']);

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Get form data
                $question = isset($_POST['question']) ? trim($_POST['question']) : '';
                $answer = isset($_POST['answer']) ? trim($_POST['answer']) : '';
                
                // Validate required fields
                if (empty($question) || empty($answer)) {
                    $_SESSION['error_message'] = 'Vui lòng điền đầy đủ câu hỏi và câu trả lời.';
                    header('Location: ' . BASE_URL . '/index.php?controller=FAQAdmin&action=create');
                    exit;
                }
                
                // Map the form fields to the existing database columns
                $faq = new Faq();
                $faq->title = $question;           // Form field 'question' maps to DB column 'title'
                $faq->description = $answer;       // Form field 'answer' maps to DB column 'description'
                $faq->timestamp = date('Y-m-d H:i:s');
                
                // Save to database
                if ($faq->save()) {
                    $_SESSION['success_message'] = 'Thêm câu hỏi thành công!';
                    header('Location: ' . BASE_URL . '/index.php?controller=FAQAdmin&action=index');
                    exit;
                } else {
                    throw new Exception("Không thể lưu câu hỏi.");
                }
            }
        } catch (Exception $e) {
            error_log('Error in FAQAdmin@store: ' . $e->getMessage());
            $_SESSION['error_message'] = 'Đã xảy ra lỗi khi thêm câu hỏi.';
            header('Location: ' . BASE_URL . '/index.php?controller=FAQAdmin&action=create');
            exit;
        }
    }

    public function edit($id)
    {
        // Only admin and staff users can access this page
        AuthController::authorize(['ADMIN', 'STAFF']);
        
        try {
            // Use direct database query instead of Eloquent's find()
            $query = "SELECT * FROM faq WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $faq = $result->fetch_object();

            // Remove debug statement
            if (!$faq) {
                $_SESSION['error'] = "Không tìm thấy câu hỏi.";
                header('Location: ' . BASE_URL . '/index.php?controller=FAQAdmin&action=index');
                exit;
            }
            
            $data = ['faq' => $faq];
            require_once '../app/views/admin/faqs/edit.php';
            
        } catch (Exception $e) {
            error_log('Error in FAQAdmin@edit: ' . $e->getMessage());
            $_SESSION['error'] = "Error loading FAQ data.";
            header('Location: ' . BASE_URL . '/index.php?controller=FAQAdmin&action=index');
            exit;
        }
    }

    public function update($id)
    {
        // Only admin and staff users can perform this action
        AuthController::authorize(['ADMIN', 'STAFF']);
        
        try {
            // Use direct database query instead of Eloquent's find()
            $query = "SELECT * FROM faq WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $faq = $result->fetch_object();
            
            if (!$faq) {
                $_SESSION['error'] = "Không tìm thấy câu hỏi.";
                header('Location: ' . BASE_URL . '/index.php?controller=FAQAdmin&action=index');
                exit;
            }
            
            // Map form fields to existing database fields
            $title = $_POST['question'] ?? '';
            $description = $_POST['answer'] ?? '';
            $timestamp = date('Y-m-d H:i:s');
            
            // Validate input
            if (empty($title) || empty($description)) {
                $_SESSION['error'] = "Question and answer are required fields.";
                header('Location: ' . BASE_URL . '/index.php?controller=FAQAdmin&action=edit&id=' . $id);
                exit;
            }
            
            // Update FAQ using direct database query
            $updateQuery = "UPDATE faq SET title = ?, description = ?, timestamp = ? WHERE id = ?";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->bind_param('sssi', $title, $description, $timestamp, $id);
            $updateStmt->execute();
            
            if ($updateStmt->affected_rows > 0) {
                $_SESSION['success'] = "FAQ updated successfully.";
            } else {
                $_SESSION['info'] = "No changes were made to the FAQ.";
            }
            
            header('Location: ' . BASE_URL . '/index.php?controller=FAQAdmin&action=index');
            exit;
            
        } catch (Exception $e) {
            error_log('Error in FAQAdmin@update: ' . $e->getMessage());
            $_SESSION['error'] = "Error updating FAQ. Please try again.";
            header('Location: ' . BASE_URL . '/index.php?controller=FAQAdmin&action=edit&id=' . $id);
            exit;
        }
    }

    public function view($id)
    {
        // Only admin and staff users can access this page
        AuthController::authorize(['ADMIN', 'STAFF']);
        
        try {
            // Use direct database query instead of Eloquent's find()
            $query = "SELECT * FROM faq WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $faq = $result->fetch_object();
            
            if (!$faq) {
                $_SESSION['error'] = "Không tìm thấy câu hỏi.";
                header('Location: ' . BASE_URL . '/index.php?controller=FAQAdmin&action=index');
                exit;
            }
            
            // Since we don't need the view page, just redirect to the edit page
            header('Location: ' . BASE_URL . '/index.php?controller=FAQAdmin&action=edit&id=' . $id);
            exit;
            
        } catch (Exception $e) {
            error_log('Error in FAQAdmin@view: ' . $e->getMessage());
            $_SESSION['error'] = "Error loading FAQ data.";
            header('Location: ' . BASE_URL . '/index.php?controller=FAQAdmin&action=index');
            exit;
        }
    }

    public function delete($id)
    {
        // Only admin and staff users can perform this action
        AuthController::authorize(['ADMIN', 'STAFF']);
        
        try {
            // Use direct database query to check if FAQ exists
            $query = "SELECT * FROM faq WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $faq = $result->fetch_object();
            
            if (!$faq) {
                $_SESSION['error'] = "Không tìm thấy câu hỏi.";
                header('Location: ' . BASE_URL . '/index.php?controller=FAQAdmin&action=index');
                exit;
            }
            
            // Delete FAQ using direct database query
            $deleteQuery = "DELETE FROM faq WHERE id = ?";
            $deleteStmt = $this->db->prepare($deleteQuery);
            $deleteStmt->bind_param('i', $id);
            $deleteStmt->execute();
            
            if ($deleteStmt->affected_rows > 0) {
                $_SESSION['success'] = "Xóa câu hỏi thành công.";
            } else {
                $_SESSION['error'] = "Không thể xóa câu hỏi.";
            }
            
            header('Location: ' . BASE_URL . '/index.php?controller=FAQAdmin&action=index');
            exit;
            
        } catch (Exception $e) {
            error_log('Error in FAQAdmin@delete: ' . $e->getMessage());
            $_SESSION['error'] = "Lỗi khi xóa câu hỏi.";
            header('Location: ' . BASE_URL . '/index.php?controller=FAQAdmin&action=index');
            exit;
        }
    }
    
    public function updateOrder()
    {
        // Only admin and staff users can perform this action
        AuthController::authorize(['ADMIN', 'STAFF']);
        
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['faq_order'])) {
                $faq_order = json_decode($_POST['faq_order'], true);
                
                // Since we don't have a display_order column, we'll update the timestamp
                // to reflect the new ordering (newer timestamp = higher priority)
                foreach ($faq_order as $order) {
                    $faq_id = $order['id'];
                    
                    // Create timestamps with microseconds difference to preserve order
                    $timestamp = date('Y-m-d H:i:s', time() + $order['position']);
                    
                    Faq::where('id', $faq_id)->update(['timestamp' => $timestamp]);
                }
                
                echo json_encode(['success' => true]);
                exit;
            }
            
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            exit;
            
        } catch (Exception $e) {
            error_log('Error in FAQAdmin@updateOrder: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error updating FAQ order']);
            exit;
        }
    }
}