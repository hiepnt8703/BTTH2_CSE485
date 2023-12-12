
<!-- login_process.php -->

<?php
// Kết nối đến cơ sở dữ liệu - Thay đổi các thông số kết nối cho phù hợp
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpzag_demo";
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xử lý dữ liệu đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["username"];
    $password = $_POST["password"];

    // Sử dụng prepared statement để ngăn chặn tấn công SQL injection
    $sql = "SELECT * FROM cms_user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Kiểm tra mật khẩu đã được mã hóa
        if (password_verify($password, $hashedPassword)) {
            // Đăng nhập thành công
            header("Location: dashboard.php");
            exit();
        } else {
            // Đăng nhập thất bại
            echo "Invalid email or password";
        }
    } else {
        // Đăng nhập thất bại
        echo "Invalid email or password";
    }

    $stmt->close();
}

$conn->close();
?>
