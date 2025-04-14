<?php

namespace App\Controllers;

use App\Models\News;
use App\Models\User;
use App\Models\Role;
use Exception;

class NewsController
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
            // Use database query to fetch all news
            $query = "SELECT * FROM news ORDER BY timestamp DESC";
            $result = $this->db->query($query);

            // Check for query errors
            if (!$result) {
                throw new Exception("Lỗi truy vấn: " . $this->db->error);
            }

            // Convert result to array of objects
            $news = [];
            while ($row = $result->fetch_object()) {
                $news[] = $row;
            }

            // Pass data to the admin view
            require_once '../app/views/news/index.php';
        } catch (Exception $e) {
            error_log('Error in NewsController@index: ' . $e->getMessage());
            echo '<div class="alert alert-danger">Error loading news data: ' . $e->getMessage() . '</div>';
        }
    }

    // Client-specific view method with modern UI
    public function clientIndex()
    {
        try {
            // Use database query to fetch all published news for client view
            $query = "SELECT * FROM news ORDER BY timestamp DESC";
            $result = $this->db->query($query);

            // Check for query errors
            if (!$result) {
                throw new Exception("Lỗi truy vấn: " . $this->db->error);
            }

            // Convert result to array of objects
            $news = [];
            while ($row = $result->fetch_object()) {
                $news[] = $row;
            }

            // Pass data to the client view
            require_once '../app/views/news/client_index.php';
        } catch (Exception $e) {
            error_log('Error in NewsController@clientIndex: ' . $e->getMessage());
            echo '<div class="alert alert-danger">Lỗi khi tải dữ liệu tin tức: ' . $e->getMessage() . '</div>';
        }
    }

    public function create()
    {
        // Only admin should have access
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'ADMIN') {
            header('Location: ' . BASE_URL . '/index.php?controller=News&action=index');
            exit;
        }

        require_once '../app/views/news/create.php';
    }

    public function store()
    {
        // Only admin should have access
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'ADMIN') {
            header('Location: ' . BASE_URL . '/index.php?controller=News&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $author = $_POST['author'] ?? '';
            $imageUrl = $_POST['imageUrl'] ?? '';
            $timestamp = date('Y-m-d H:i:s');

            try {
                // Prepare SQL statement to insert data
                $query = "INSERT INTO news (title, content, author, image_url, timestamp) VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param("sssss", $title, $content, $author, $imageUrl, $timestamp);

                // Execute the statement
                if ($stmt->execute()) {
                    header('Location: ' . BASE_URL . '/index.php?controller=News&action=index');
                    exit;
                } else {
                    throw new Exception($stmt->error);
                }
            } catch (Exception $e) {
                error_log('Error in NewsController@store: ' . $e->getMessage());
                echo '<div class="alert alert-danger">Error saving news: ' . $e->getMessage() . '</div>';
            }
        }
    }

    public function edit($id)
    {
        // Only admin should have access
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'ADMIN') {
            header('Location: ' . BASE_URL . '/index.php?controller=News&action=index');
            exit;
        }

        try {
            // Use database query to fetch news by ID
            $query = "SELECT * FROM news WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $news = $result->fetch_object();

            if (!$news) {
                throw new Exception("News not found");
            }

            require_once '../app/views/news/edit.php';
        } catch (Exception $e) {
            error_log('Error in NewsController@edit: ' . $e->getMessage());
            echo '<div class="alert alert-danger">Error loading news: ' . $e->getMessage() . '</div>';
        }
    }

    public function update($id)
    {
        // Only admin should have access
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'ADMIN') {
            header('Location: ' . BASE_URL . '/index.php?controller=News&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $title = $_POST['title'] ?? '';
                $content = $_POST['content'] ?? '';
                $author = $_POST['author'] ?? '';
                $imageUrl = $_POST['imageUrl'] ?? '';
                $timestamp = date('Y-m-d H:i:s');

                // Prepare SQL statement to update data
                $query = "UPDATE news SET title = ?, content = ?, author = ?, image_url = ?, timestamp = ? WHERE id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param("sssssi", $title, $content, $author, $imageUrl, $timestamp, $id);

                // Execute the statement
                if ($stmt->execute()) {
                    header('Location: ' . BASE_URL . '/index.php?controller=News&action=index');
                    exit;
                } else {
                    throw new Exception($stmt->error);
                }
            } catch (Exception $e) {
                error_log('Error in NewsController@update: ' . $e->getMessage());
                echo '<div class="alert alert-danger">Error updating news: ' . $e->getMessage() . '</div>';
            }
        }
    }

    public function view($id)
    {
        try {
            // Use database query to fetch news by ID
            $query = "SELECT * FROM news WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $news = $result->fetch_object();

            // Check if user is an admin
            $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'ADMIN';

            // Use appropriate view based on user role
            if ($isAdmin) {
                require_once '../app/views/news/view.php';
            } else {
                require_once '../app/views/news/client_view.php';
            }
        } catch (Exception $e) {
            error_log('Error in NewsController@view: ' . $e->getMessage());
            echo '<div class="alert alert-danger">Error loading news: ' . $e->getMessage() . '</div>';
        }
    }

    public function delete($id)
    {
        // Only admin should have access
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'ADMIN') {
            header('Location: ' . BASE_URL . '/index.php?controller=News&action=index');
            exit;
        }

        try {
            // Prepare SQL statement to delete data
            $query = "DELETE FROM news WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);

            // Execute the statement
            if ($stmt->execute()) {
                header('Location: ' . BASE_URL . '/index.php?controller=News&action=index');
                exit;
            } else {
                throw new Exception($stmt->error);
            }
        } catch (Exception $e) {
            error_log('Error in NewsController@delete: ' . $e->getMessage());
            echo '<div class="alert alert-danger">Error deleting news: ' . $e->getMessage() . '</div>';
        }
    }

    // Method to get latest news in JSON format (for AJAX requests)
    public function getLatestJson()
    {
        try {
            // Get the 5 most recent news articles
            $query = "SELECT id, title, content, author, timestamp, image_url FROM news ORDER BY timestamp DESC LIMIT 5";
            $result = $this->db->query($query);

            // Check for query errors
            if (!$result) {
                throw new Exception("Lỗi truy vấn: " . $this->db->error);
            }

            // Convert result to array
            $news = [];
            while ($row = $result->fetch_assoc()) {
                // Create a summary from the content
                $row['summary'] = mb_substr(strip_tags($row['content']), 0, 150) . '...';
                $news[] = $row;
            }

            // Return as JSON
            header('Content-Type: application/json');
            echo json_encode($news);
            exit;
        } catch (Exception $e) {
            error_log('Error in NewsController@getLatestJson: ' . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Lỗi khi tải dữ liệu tin tức: ' . $e->getMessage()]);
            exit;
        }
    }
}
