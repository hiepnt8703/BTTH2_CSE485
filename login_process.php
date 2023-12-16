<?php
session_start();
include_once './config/Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["username"];
    $password = $_POST["password"];
    $database = new Database();
    $conn = $database->getConnection();
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM `cms_user` WHERE `email` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];
        if ($password == $hashedPassword) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_type'] = $row['type'];
            // chuyen huong trang vao dashboard
            header("Location:admin/dashboard.php");
            exit();
        } else {
            echo "Invalid email or password";
        }
    } else {
        echo "Invalid email or password";
    }

    $stmt->close();
    $conn->close();
}
?>
