<?php

namespace App\Controllers;

use App\Models\News;
use Exception;
use App\Controllers\AuthController;

class NewsAdmin
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
            // Lấy dữ liệu tin tức từ database
            $query = "SELECT * FROM news ORDER BY id DESC";
            $result = $this->db->query($query);
            
            // Kiểm tra nếu có lỗi trong truy vấn SQL
            if (!$result) {
                throw new Exception("Lỗi truy vấn: " . $this->db->error);
            }
            
            // Chuyển đổi kết quả thành mảng các đối tượng
            $news = [];
            while ($row = $result->fetch_object()) {
                $news[] = $row;
            }
            
            // Bỏ dòng debug ở đây
            // echo '<pre>'; print_r($news); echo '</pre>';
            
            $data = ['news' => $news];
            require_once '../app/views/admin/news/index.php';
            
        } catch (Exception $e) {
            error_log('Error in NewsAdmin@index: ' . $e->getMessage());
            echo '<div class="alert alert-danger">Error loading news data: ' . $e->getMessage() . '</div>';
        }
    }

    public function create()
    {
        // Only admin and staff users can access this page
        AuthController::authorize(['ADMIN', 'STAFF']);
        
        require_once '../app/views/admin/news/create.php';
    }

    public function store()
    {
        // Only admin and staff users can perform this action
        AuthController::authorize(['ADMIN', 'STAFF']);
        
        try {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $image_url = $_POST['image_url'] ?? '';
            $is_featured = isset($_POST['is_featured']) ? 1 : 0;
            $status = $_POST['status'] ?? 'published';
            
            // Validate input
            if (empty($title) || empty($content)) {
                $_SESSION['error'] = "Title and content are required fields.";
                header('Location: ' . BASE_URL . '/index.php?controller=NewsAdmin&action=create');
                exit;
            }
            
            // Handle image upload if present
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $upload_dir = '../public/uploads/news/';
                
                // Create directory if it doesn't exist
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $file_name = time() . '_' . basename($_FILES['image']['name']);
                $target_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    $image_url = BASE_URL . '/uploads/news/' . $file_name;
                }
            }
            
            // Get current user ID for author
            $author_id = $_SESSION['user_id'] ?? null;
            
            // Create news article
            $news = News::create([
                'title' => $title,
                'content' => $content,
                'image_url' => $image_url,
                'author_id' => $author_id,
                'is_featured' => $is_featured,
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
            $_SESSION['success'] = "News article created successfully.";
            header('Location: ' . BASE_URL . '/index.php?controller=NewsAdmin&action=index');
            exit;
            
        } catch (Exception $e) {
            error_log('Error in NewsAdmin@store: ' . $e->getMessage());
            $_SESSION['error'] = "Error creating news article. Please try again.";
            header('Location: ' . BASE_URL . '/index.php?controller=NewsAdmin&action=create');
            exit;
        }
    }

    public function edit($id)
    {
        // Only admin and staff users can access this page
        AuthController::authorize(['ADMIN', 'STAFF']);
        
        try {
            $news = News::find($id);
            
            if (!$news) {
                $_SESSION['error'] = "News article not found.";
                header('Location: ' . BASE_URL . '/index.php?controller=NewsAdmin&action=index');
                exit;
            }
            
            $data = ['news' => $news];
            require_once '../app/views/admin/news/edit.php';
            
        } catch (Exception $e) {
            error_log('Error in NewsAdmin@edit: ' . $e->getMessage());
            $_SESSION['error'] = "Error loading news data.";
            header('Location: ' . BASE_URL . '/index.php?controller=NewsAdmin&action=index');
            exit;
        }
    }

    public function update($id)
    {
        // Only admin and staff users can perform this action
        AuthController::authorize(['ADMIN', 'STAFF']);
        
        try {
            $news = News::find($id);
            
            if (!$news) {
                $_SESSION['error'] = "News article not found.";
                header('Location: ' . BASE_URL . '/index.php?controller=NewsAdmin&action=index');
                exit;
            }
            
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $image_url = $_POST['image_url'] ?? $news->image_url;
            $is_featured = isset($_POST['is_featured']) ? 1 : 0;
            $status = $_POST['status'] ?? 'published';
            
            // Validate input
            if (empty($title) || empty($content)) {
                $_SESSION['error'] = "Title and content are required fields.";
                header('Location: ' . BASE_URL . '/index.php?controller=NewsAdmin&action=edit&id=' . $id);
                exit;
            }
            
            // Handle image upload if present
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $upload_dir = '../public/uploads/news/';
                
                // Create directory if it doesn't exist
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $file_name = time() . '_' . basename($_FILES['image']['name']);
                $target_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    $image_url = BASE_URL . '/uploads/news/' . $file_name;
                }
            }
            
            // Update news article
            $news->update([
                'title' => $title,
                'content' => $content,
                'image_url' => $image_url,
                'is_featured' => $is_featured,
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
            $_SESSION['success'] = "News article updated successfully.";
            header('Location: ' . BASE_URL . '/index.php?controller=NewsAdmin&action=index');
            exit;
            
        } catch (Exception $e) {
            error_log('Error in NewsAdmin@update: ' . $e->getMessage());
            $_SESSION['error'] = "Error updating news article. Please try again.";
            header('Location: ' . BASE_URL . '/index.php?controller=NewsAdmin&action=edit&id=' . $id);
            exit;
        }
    }

    public function view($id)
    {
        // Only admin and staff users can access this page
        AuthController::authorize(['ADMIN', 'STAFF']);
        
        try {
            $news = News::with('author')->find($id);
            
            if (!$news) {
                $_SESSION['error'] = "News article not found.";
                header('Location: ' . BASE_URL . '/index.php?controller=NewsAdmin&action=index');
                exit;
            }
            
            $data = ['news' => $news];
            require_once '../app/views/admin/news/view.php';
            
        } catch (Exception $e) {
            error_log('Error in NewsAdmin@view: ' . $e->getMessage());
            $_SESSION['error'] = "Error loading news data.";
            header('Location: ' . BASE_URL . '/index.php?controller=NewsAdmin&action=index');
            exit;
        }
    }

    public function delete($id)
    {
        // Only admin and staff users can perform this action
        AuthController::authorize(['ADMIN', 'STAFF']);
        
        try {
            $news = News::find($id);
            
            if (!$news) {
                $_SESSION['error'] = "News article not found.";
                header('Location: ' . BASE_URL . '/index.php?controller=NewsAdmin&action=index');
                exit;
            }
            
            $news->delete();
            
            $_SESSION['success'] = "News article deleted successfully.";
            header('Location: ' . BASE_URL . '/index.php?controller=NewsAdmin&action=index');
            exit;
            
        } catch (Exception $e) {
            error_log('Error in NewsAdmin@delete: ' . $e->getMessage());
            $_SESSION['error'] = "Error deleting news article.";
            header('Location: ' . BASE_URL . '/index.php?controller=NewsAdmin&action=index');
            exit;
        }
    }
}