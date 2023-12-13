<?php
session_start();
include_once 'Database.php';
include_once 'check_login.php';
checkPermission();

$database = new Database();
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
    $searchTerm = $_GET["search"];

    // Thực hiện truy vấn tìm kiếm
    $sqlUser = "SELECT id, first_name, last_name, email FROM cms_user WHERE first_name LIKE ? OR last_name LIKE ? OR email LIKE ?";
    $stmtUser = $conn->prepare($sqlUser);
    $searchTerm = "%$searchTerm%";
    $stmtUser->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();
    $stmtUser->close();

    // Hiển thị kết quả tìm kiếm cho bảng người dùng
    while ($row = $resultUser->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['first_name'] . ' ' . $row['last_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td><a href='edit_user.php?id=" . $row['id'] . "' class='btn btn-warning'>Edit</a></td>";
        echo "<td><button class='btn btn-danger' onclick='deleteUser(" . $row['id'] . ")'>Delete</button></td>";
        echo "</tr>";
    }
}
?>