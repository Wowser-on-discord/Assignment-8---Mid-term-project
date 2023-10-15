<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Search</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="linkCards.css" rel="stylesheet" />
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    
</head>
<body class="gradient-background">
<div class="d-flex" id="wrapper">
    <!-- Sidebar-->
    <?php
        include '../navbar.html';
    ?>
    <!-- Page content wrapper-->
    <div id="page-content-wrapper">
        <!-- Top navigation-->
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
                                <a class="dropdown-item" href="adminpage.php">Admin Page</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Sign In/Log Out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container-fluid">
            <br>
            <h1 class="card text-center" style="max-width: 500px; margin: 0 auto;">Search for Users on 𝕪!</h1>
            <p></p>

            <!-- Giant Card -->
            <div class="card text-center" style="max-width: 800px; margin: 0 auto;">
                <div class="card-body">
                <h1>User Search</h1>
                    <form action="User_Search.php" method="POST">
                        <input type="text" name="username" placeholder="Enter username">
                        <input type="submit" value="Search">
                    </form>
                        <?php
                            
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                
                                $search_username = $_POST["username"];

                                // Read data from CSV file
                                $csv_data = array_map('str_getcsv', file('user_accounts.csv'));

                                // Iterate through CSV data to find matching usernames
                                $results = array();
                                foreach ($csv_data as $row) {
                                    if (stripos($row[0], $search_username) !== false) {
                                        $results[] = array(
                                            'username' => $row[0],
                                            'profile_picture' => $row[2]
                                        );
                                    }
                                }

                                // Display results
                                if (!empty($results)) {
                                    foreach ($results as $result) {
                                        echo "<div class='user-card'>";
                                        echo "<img src='{$result['profile_picture']}' alt='{$result['username']}'>";
                                        // Link to profile.php with the username as a query parameter
                                        echo "<p><a href='profiles.php?username={$result['username']}'>{$result['username']}</a></p>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "No matching users found.";
                                }
                            }
                        ?>
                </div>
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