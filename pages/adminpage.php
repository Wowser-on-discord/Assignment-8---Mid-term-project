<?php
session_start();
$jsonFile = "../data/fypinfo.json";
$data = [];

if (file_exists($jsonFile)) {
    $jsonContent = file_get_contents($jsonFile);
    $data = json_decode($jsonContent, true);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../js/likes.js"></script>
    <script src="../js/replies.js"></script>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Welcome to y!</title>
    <!-- Favicon-->
    <link rel="icon" type="../image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/styles.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .post {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }

        .post p {
            margin: 0;
            padding: 0;
        }

        .post img {
            max-width: 100%;
        }

        .like-button,
        .reply-button {
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            margin-right: 10px;
        }

        .replies {
            margin-left: 20px;
            border-left: 2px solid #007bff;
            padding-left: 10px;
        }

        /* Style the form */
        form {
            margin-bottom: 20px;
        }

        textarea {
            width: 100%;
            max-width: 600px;
            padding: 10px;
            font-family: Arial, sans-serif;
            resize: none;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .max-size-image {
        max-width: 400px;
        max-height: 300px;
    }
    </style>
</head>

<body>
<?php

    $jsonFile = "../data/fyp.json";
?>



<div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <?php
        include '../navbar.html';
        ?>

        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <!-- Your top navigation content here -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">☰</button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <img src="../assets/Y.png" alt="site-logo" width="50" height="40" title="y Site Logo">

                            <?php
                                if (isset($_SESSION['username'])) {
                                    $username = $_SESSION['username'];
                                } elseif (isset($_SESSION['registeredName'])) {
                                    $username = $_SESSION['registeredName'];
                                } else {
                                    $username = ''; 
                                }

                                if (!empty($username)) {
                                    echo '<li class="nav-item"><a class="nav-link" href="profiles.php?username=' . $username . '">Profile</a></li>';
                                } else {
                                    echo '<li class="nav-item"><a class="nav-link" href="#">Profile</a></li>'; // Display a default link or handle this case as needed.
                                }
                            ?>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More...</a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="./TOS.php">Terms of Service</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="./AboutUs.php">About Us</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="adminpage.php">Admin Page</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="logout.php">Log Out</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>


<form method="POST" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
            <h1>Admin Page</h1><br>
            <button id="deleteButton">
                Delete any Post
            </button>
        </form><br><br>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="../js/scripts.js"></script>
    <!-- Popup window-->
    <script src="../js/deletepost.js"></script>
</body>
</html>
