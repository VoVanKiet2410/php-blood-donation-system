<?php
namespace App\Controllers;

class AuthController
{
    private $mysqli;

    // Nhận đối tượng MySQLi qua constructor
    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    // Phương thức đăng nhập
    public function login()
    {
        // Nếu nhận được form submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            // Sử dụng prepared statement để tránh SQL injection
            $stmt = $this->mysqli->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                echo "Thông tin đăng nhập không hợp lệ.";
                return;
            }

            $user = $result->fetch_assoc();

            // Kiểm tra mật khẩu đã được hash bằng password_hash
            if (!password_verify($password, $user['password'])) {
                echo "Thông tin đăng nhập không hợp lệ.";
                return;
            }

            // Đăng nhập thành công, lưu thông tin vào session
            $_SESSION['user_id']    = $user['id'];
            $_SESSION['username']   = $user['username'];
            $_SESSION['user_role']  = $user['role']; // Giả sử cột role lưu tên role dưới dạng chuỗi

            header("Location: index.php");
            exit;
        } else {
            // Hiển thị form đăng nhập
            require_once '../app/Views/auth/login.php';
        }
    }

    // Phương thức đăng xuất
    public function logout()
    {
        session_destroy();
        header("Location: index.php?controller=Auth&action=login");
        exit;
    }

    /**
     * Kiểm tra phân quyền.
     * Nếu người dùng chưa đăng nhập hoặc không thuộc các role cho phép, chuyển hướng hoặc hiển thị thông báo.
     *
     * @param array $requiredRoles Mảng các role được phép truy cập. Nếu rỗng, chỉ cần đăng nhập.
     */
    public static function authorize(array $requiredRoles = [])
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=Auth&action=login");
            exit;
        }
        if (!empty($requiredRoles) && !in_array($_SESSION['user_role'], $requiredRoles)) {
            echo "Bạn không có quyền truy cập chức năng này.";
            exit;
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $role_id = $_POST['role_id'];

            // Validate input
            if (empty($username) || empty($password) || empty($phone) || empty($email) || empty($role_id)) {
                echo "All fields are required.";
                return;
            }

            // Check if the user already exists
            $stmt = $this->mysqli->prepare("SELECT * FROM users WHERE cccd = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                echo "User already exists.";
                return;
            }

            // Insert user into the database
            $stmt = $this->mysqli->prepare("INSERT INTO users (cccd, password, phone, email, role_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $username, $password, $phone, $email, $role_id);
            if ($stmt->execute()) {
                header("Location: /auth/login");
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            // Render the registration form
            require_once '../app/views/auth/register.php';
        }
    }
}
?>
