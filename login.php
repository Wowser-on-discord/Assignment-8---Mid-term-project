<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Welcome to y!</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/styles.css" rel="stylesheet" />
</head>
<body class="gradient-background">
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <?php
            //include '../navbar.html';
        ?>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        <img src="../assets/Y.png" alt="site-logo" width="50" height="40" title="y Site Logo">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More...</a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="./TOS.php">Terms of Service</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./AboutUs.php">About Us</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Center the card using Flexbox -->
            <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
                <div class="card text-center" style="max-width: 1000px;">
                    <div class="card-body">
                        <h5 class="card-title">Login</h5>
                        <p class="card-text">Enter your username and password:</p>
                        <form action="login.php" method="POST">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="username" placeholder="Username" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                        </form>
                        <br>
                        <p>Don't have an account?</p>
                        <a href="register.php">Register Here!</a>
                    </div>
                </div>
            </div>

            <?php
            // Function to check user credentials for login
            function loginUser($username, $password) {
                $csvFile = 'login.csv';
            
                // Check if the CSV file exists
                if (file_exists($csvFile)) {
                    
                    $file = fopen($csvFile, 'r');
            
                    // Skip the first row (header)
                    fgetcsv($file);
            
                    while (($row = fgetcsv($file)) !== false) {
                        if ($row[0] == $username && $row[1] == $password) {

                            fclose($file);
                            return true; // Login successful

                        }
                    }
                    
                    fclose($file);
                }
            
                return false; // Login failed
            }

            if (!empty($_POST)) {
                
                $username = $_POST["username"];
                $password = $_POST["password"];

                // Call the loginUser function
                if (loginUser($username, $password)) {
                    // Store the username in the session
                    $_SESSION['username'] = $username;
                    header("Location: ./dynamicaccount.php");
                    exit();
                } else {
                    // Handle login failure
                    echo "<div class='alert alert-danger'>Login failed. Please try again.</div>";
                }
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="../js/scripts.js"></script>
</body>
</html>
