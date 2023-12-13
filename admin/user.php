<?php
session_start();
include_once 'Database.php';
include_once 'check_login.php';
checkPermission();

$database = new Database();
$conn = $database->getConnection();

$sqlUser = "SELECT id, first_name, last_name, email FROM cms_user";
$resultUser = $conn->query($sqlUser);
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
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <h2>User Management</h2>

                <a href="add_user.php" class="btn btn-primary mb-3">Add New</a>

                <form class="form-inline mb-3" id="searchForm">
                    <label class="mr-2">Search:</label>
                    <input type="text" class="form-control" name="search" id="searchInput" placeholder="Enter name or email">
                    <button type="submit" class="btn btn-outline-secondary">Search</button>
                </form>

                <table id="userTable" class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $resultUser->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['first_name'] . ' ' . $row['last_name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td><a href='edit_user.php?id=" . $row['id'] . "' class='btn btn-warning'>Edit</a></td>";
                            echo "<td><button class='btn btn-danger' onclick='deleteUser(" . $row['id'] . ")'>Delete</button></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function deleteUser(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        location.reload(); 
                    }
                };
                xhr.open("GET", "delete_user.php?id=" + userId, true);
                xhr.send();
            }
        }
        $(document).ready(function () {
            $("#searchForm").submit(function (e) {
                e.preventDefault();

                var searchTerm = $("#searchInput").val();
                $("#userTable tbody").load("search_user.php?search=" + searchTerm);
            });
        });
        $(document).ready(function () {
            $("#searchForm").submit(function (e) {
            e.preventDefault();

            var searchTerm = $("#searchInput").val();

            $.ajax({
                type: "GET",
                url: "search_user.php",
                data: { search: searchTerm },
                success: function (data) {
                    $("#userTable tbody").html(data);
                }
                });
            });
        });
    </script>
</body>
</html>
