<?php
include_once 'Database.php';

function checkPermission() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    $user_id = $_SESSION['user_id'];

    $database = new Database();
    $conn = $database->getConnection();
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT type FROM cms_user WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['type'] !== 1) {
            header("Location: login.php");
            exit();
        }
    } else {
        header("Location: login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
