<?php
session_start();
include_once 'Database.php';
include_once 'check_login.php';
checkPermission();

$database = new Database();
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $userId = $_GET['id'];
    $sqlDeleteUser = "DELETE FROM cms_user WHERE id = $userId";
    $resultDeleteUser = $conn->query($sqlDeleteUser);

    if ($resultDeleteUser) {
        header("Location: user.php");
        exit();
    } else {
        echo "Delete failed";
    }
} else {
    header("Location: user.php");
    exit();
}
?>
