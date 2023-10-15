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
    <title>User Profile</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/styles.css" rel="stylesheet" />

    <style>
        .image-container {
            position: relative;
            width: 100%;
            max-width: 1300px;
            height: auto;
            margin: 0 auto;
        }

        .profile-banner {
            z-index: 1;
        }

        body {
            text-align: center;

            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        #profile-picture {
            position: absolute;
            bottom: 50%;
            left: 50%; 
            transform: translate(-50%, 50%); 
            z-index: 2;
            width: 100px;
            height: 100px;
            border-radius: 100px;
        }

        .user-bio {
            color: white;
        }

        .user-name {
            color: white;
        }

    </style>

</head>
<body class=gradient-background>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <?php include '../navbar.html'; ?>
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
                                    echo '<li class="nav-item"><a class="nav-link" href="#">Profile</a></li>'; 
                                }
                            ?>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More...</a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="./TOS.php">Terms of Service</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="./AboutUs.php">About Us</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="logout.php">Sign In/Log Out</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
            <div class="profile-container">
                <div class="image-container">
                    <?php
                    

                    if (isset($_GET['username'])) {
                        $username = $_GET['username'];
                        $data = [];
                        
                        if (($handle = fopen('user_accounts.csv', 'r')) !== false) {
                            while (($row = fgetcsv($handle)) !== false) {
                                if ($row[0] === $username) {
                                    $data = $row;
                                    break;
                                }
                            }
                            fclose($handle);
                        }
                        
                        if (!empty($data)) {
                            
                            $username = $data[0];
                            $user_bio = $data[1];
                            $profile_picture = $data[2];
                            $banner = $data[3];
                        } else {
                            echo "User not found.";
                            exit();
                        }
                    } else {
                        echo "No user logged in or recently registered.";
                        exit();
                    }
                    

                    echo "<img id='profile-picture' src='$profile_picture' alt='Profile Picture' width='100' height='80'>";
                    echo "<img class='profile-banner' src='$banner' alt='Banner Image' width='1300' height='400'>";
                    echo "<h1>Profile of $username</h1>";
                    echo "<p>Bio: $user_bio</p>";
                    ?>

                    
                    
                </div>
            </div>
            
        </div>
    </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/scripts.js"></script>
</body>
</html>
