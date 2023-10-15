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

            <!-- Giant Card -->
            <div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
                <div class="card text-center" style="max-width: 1000px;">
                    <div class="card-body">
                        <h5 class="card-title">Register for an account.</h5>
                        <p class="card-text">Enter a username and password:</p>
                        <form action="register.php" method="POST">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="username" placeholder="Username" required>
                            </div>
                            <br>
                            <div class="mb-3">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Register!</button>
                            <br>
                            <br>
                            <p>Already have an account?</p>
                            <a href="login.php">Login Here!</a>
                        </form>

            <?php
            function registerUser($username, $password) {
                $loginCsvFile = './login.csv';
                $userAccountsCsvFile = 'user_accounts.csv'; 
            
                // Check if the CSV file for login exists
                if (file_exists($loginCsvFile)) {
                    
                    $loginFile = fopen($loginCsvFile, 'a');
            
                    if ($loginFile) {
                        // Write the new user's data to the login CSV file
                        if (fputcsv($loginFile, array($username, $password)) !== false) {
                            
                            fclose($loginFile);
            
                            // Check if the CSV file for user accounts exists
                            if (file_exists($userAccountsCsvFile)) {
                                
                                $userAccountsFile = fopen($userAccountsCsvFile, 'a');
            
                                if ($userAccountsFile) {
                                    // Write the new user's data to the user accounts CSV file
                                    if (fputcsv($userAccountsFile, array($username, '', '', '')) !== false) {
                                        
                                        fclose($userAccountsFile);
                                        return true; // Registration successful
                                    } else {
                                        fclose($userAccountsFile);
                                        return false; // Error writing data to user accounts CSV
                                    }
                                } else {
                                    return false; // Unable to open user accounts file
                                }
                            } else {
                                return false; // User accounts CSV file does not exist
                            }
                        } else {
                            fclose($loginFile);
                            return false; // Error writing data to login CSV
                        }
                    } else {
                        return false; // Unable to open login file
                    }
                } else {
                    return false; // Login CSV file does not exist
                }
            }
            

            if (!empty($_POST)) {
                $username = $_POST["username"];
                $password = $_POST["password"];

                if (registerUser($username, $password)) {
                    
                    $_SESSION['registeredName'] = $username;

                    header("Location: ./profileforRegister.php");
                    exit();
                } else {
                    // Handle registration failure
                    echo "<div class='alert alert-danger'>Registration failed. Please try again.</div>";
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
