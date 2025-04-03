<?php

namespace App\Controllers;

use App\Models\News;
use App\Config\Database;
use Illuminate\Http\Request;

class NewsController
{
    private $mysqli;

    public function __construct($mysqli)
    {
        if (!$mysqli) {
            throw new \Exception("Database connection not provided");
        }
        $this->mysqli = $mysqli;
    }

    public function index()
    {
        //$news = News::all();
        $this->show();
    }

    public function show()
    {
        // AuthController::authorize(); 

        //$userCccd = $_SESSION['user_id'];

        $stmt = $this->mysqli->prepare("SELECT * FROM news");
        if (!$stmt) {
            die("Error preparing statement: " . $this->mysqli->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $news = [];
        while ($row = $result->fetch_assoc()) {
            $news[] = $row;
        }

        require_once '../app/views/news/index.php';
    }


    public function create()
    {
        $connection  = $this->mysqli;
        require_once '../app/views/news/create.php';
    }

    public function edit()
    {
        $id = $_GET['id'];
        $stmt = $this->mysqli->prepare("SELECT * FROM news WHERE id = ?");
        $stmt->bind_param("i", $id); 
        $stmt->execute();
        $result = $stmt->get_result();
        $article = $result->fetch_assoc();

        if (!$article) {
            header('Location: /php-blood-donation-system/public/index.php?controller=News&action=manage');
            exit;
        }

        require_once '../app/views/news/edit.php';
    }


    public function update()
    {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $author = $_POST['author'] ?? '';
            $imageUrl = $_POST['imageUrl'] ?? '';

            if (empty($title) || empty($content) || empty($author)) {
                echo "All fields are required!";
                return;
            }

            $stmt = $this->mysqli->prepare("UPDATE news SET title = ?, content = ?, author = ?, image_url = ?, timestamp = NOW() WHERE id = ?");
            $stmt->bind_param("ssssi", $title, $content, $author, $imageUrl, $id);
            if ($stmt->execute()) {
                header('Location: /php-blood-donation-system/public/index.php?controller=News&action=manage');
                exit;
            } else {
                echo "Error updating news article.";
            }
        }
    }



    public function delete()
    {
        $id = $_GET['id'];
        if (!isset($id) || !is_numeric($id)) {
            echo "Invalid article ID.";
            return;
        }
        $stmt = $this->mysqli->prepare("DELETE FROM news WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header('Location: /php-blood-donation-system/public/index.php?controller=News&action=manage');
            exit;
        } else {
            echo "Error deleting news article.";
        }
    }
}
