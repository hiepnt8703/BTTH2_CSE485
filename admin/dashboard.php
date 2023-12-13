<?php
session_start();
include_once 'Database.php';
include_once 'check_login.php';
checkPermission();
// Kiểm tra xem người dùng đã đăng nhập và có type là 1 không
// Tạo đối tượng Database để sử dụng trong các truy vấn tiếp theo (nếu có)
$database = new Database();
$conn = $database->getConnection();

// Truy vấn số lượng bài viết
$sqlPost = "SELECT COUNT(id) AS post_count FROM cms_posts";
$resultPost = $conn->query($sqlPost);
$rowPost = $resultPost->fetch_assoc();
$postCount = $rowPost['post_count'];

// Truy vấn số lượng danh mục
$sqlCategory = "SELECT COUNT(id) AS category_count FROM cms_category";
$resultCategory = $conn->query($sqlCategory);
$rowCategory = $resultCategory->fetch_assoc();
$categoryCount = $rowCategory['category_count'];

// Truy vấn số lượng người dùng
$sqlUser = "SELECT COUNT(id) AS user_count FROM cms_user";
$resultUser = $conn->query($sqlUser);
$rowUser = $resultUser->fetch_assoc();
$userCount = $rowUser['user_count'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="dashboard.php">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="post.php">
                                Post
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="categories.php">
                                Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="user.php">
                                User
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            </section>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <h2>Post, Categories, and Users</h2>

                <!-- Display Tables -->
                <div class="row">
                    <div class="col-md-4">
                        <h4>Posts</h4>
                        <p><?php echo $postCount; ?></p>
                        <?php
                            // Code to retrieve and display the 'cms_post' table data
                        ?>
                    </div>
                    <div class="col-md-4">
                        <h4>Categories</h4>
                        <p><?php echo $categoryCount; ?></p>
                        <!-- Display the Categories Table -->
                        <?php
                            // Code to retrieve and display the 'cms_category' table data
                        ?>
                    </div>
                    <div class="col-md-4">
                        <h4>Users</h4>
                        <p><?php echo $userCount; ?></p>
                        <!-- Display the Users Table -->
                        <?php
                            // Code to retrieve and display the 'cms_user' table data
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JavaScript and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
