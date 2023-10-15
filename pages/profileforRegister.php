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
<body>
    <div class="d-flex" id="wrapper">
        
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Your page content -->

            <div class="container-fluid">
                <?php
                if (isset($_SESSION['registeredName'])) {
                    $newUsername = $_SESSION['registeredName'];
                    echo "<br>";
                    echo "Welcome, $newUsername! Let's design your profile!<br><br>";
                } else {
                    echo "No user currently logged in.";
                }
                    // Function to get the bio value from the CSV file
                    function getBioValue($username) {
                        $csvFile = 'user_accounts.csv'; 
                        if (file_exists($csvFile)) {
                            $file = fopen($csvFile, 'r');
                            while (($row = fgetcsv($file)) !== false) {
                                if ($row[0] === $username) {
                                    fclose($file);
                                    return $row[1]; 
                                }
                            }
                            fclose($file);
                        }
                        return ''; 
                    }

                    // Function to get the profile picture path from the CSV file
                    function getProfilePicturePath($username) {
                        $csvFile = 'user_accounts.csv'; 
                        if (file_exists($csvFile)) {
                            $file = fopen($csvFile, 'r');
                            while (($row = fgetcsv($file)) !== false) {
                                if ($row[0] === $username) {
                                    fclose($file);
                                    return $row[2]; 
                                }
                            }
                            fclose($file);
                        }
                        return '';
                    }

                    // Function to get the banner path from the CSV file
                    function getBannerPath($username) {
                        $csvFile = 'user_accounts.csv'; 
                        if (file_exists($csvFile)) {
                            $file = fopen($csvFile, 'r');
                            while (($row = fgetcsv($file)) !== false) {
                                if ($row[0] === $username) {
                                    fclose($file);
                                    return $row[3]; 
                                }
                            }
                            fclose($file);
                        }
                        return '';
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Process the form data
                        $username = $_POST['username'];
                        $user_bio = $_POST['user_bio'];
                    

                        // Check if profile picture is uploaded
                        if (!empty($_FILES['profile_picture']['name'])) {
                            $profile_picture = $_FILES['profile_picture']['name'];
                            $profile_picture_path = 'fileuploads/' . $profile_picture;
                            move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture_path);
                        } else {
                            // Profile picture was not updated, so retrieve the existing path from the CSV
                            $profile_picture_path = getProfilePicturePath($username);
                        }

                        // Check if banner is uploaded
                        if (!empty($_FILES['banner']['name'])) {
                            $banner = $_FILES['banner']['name'];
                            $banner_path = 'fileuploads/' . $banner;
                            move_uploaded_file($_FILES['banner']['tmp_name'], $banner_path);
                        } else {
                            // Banner was not updated, so retrieve the existing path from the CSV
                            $banner_path = getBannerPath($username);
                        }
                        // 
                        $csvFile = 'user_accounts.csv';

                        $data = [];

                        // Check if the CSV file exists
                        if (file_exists($csvFile)) {
                            
                            $file = fopen($csvFile, 'r');

                            // Read and update the data
                            while (($row = fgetcsv($file)) !== false) {
                                if ($row[0] === $username) {
                                    // Update the user's bio, profile picture, and banner
                                    $row[1] = $user_bio;
                                    $row[2] = $profile_picture_path;
                                    $row[3] = $banner_path;
                                }
                                $data[] = $row;
                            }

                            fclose($file);

                            // Open the CSV file in write mode to save the updated data
                            $file = fopen($csvFile, 'w');

                            // Write the updated data back to the CSV file
                            foreach ($data as $row) {
                                fputcsv($file, $row);
                            }

                            // Close the CSV file
                            fclose($file);
                        }
                        header("Location: ./profiles.php?username=" . $newUsername);
                        
                    }   
                ?>

                
                <form action="profileforRegister.php" method="POST" enctype="multipart/form-data">
                    <!-- Hidden field to store the user ID -->
                    <input type="hidden" name="username" value="<?php echo $newUsername; ?>">

                    
                    <div class="mb-3">
                        <label for="user_bio">Bio:</label>
                        <textarea class="form-control" id="user_bio" name="user_bio" rows="4"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="profile_picture">Profile Picture:</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                    </div>

                    <div class="mb-3">
                        <label for="banner">Banner:</label>
                        <input type="file" class="form-control" id="banner" name="banner">
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg btn-block">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/scripts.js"></script>
</body>
</html>
