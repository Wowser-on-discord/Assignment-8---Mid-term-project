<?php
session_start();

$jsonFile = "../data/fypinfo.json";
$data = [];

if (file_exists($jsonFile)) {
    $jsonContent = file_get_contents($jsonFile);
    $data = json_decode($jsonContent, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['postButton'])) {
        $createPost = !empty($_POST['createPost']) ? $_POST['createPost'] : '';
        $fileToUpload = ''; // Initialize it as an empty string

        if (isset($_SESSION['username'])) {
            // Get the username from the session (for logged-in users)
            $username = $_SESSION['username'];
        } elseif (isset($_SESSION['registeredName'])) {
            // Get the username from the session (for registered users)
            $username = $_SESSION['registeredName'];
        } else {
            
            $username = 'Anonymous';
        }
        $newItem = [
        'username' => $username,
        ];

        if (isset($_FILES['fileToUpload'])) {
            $targetDirectory = "uploads/";
            $targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);

            if (file_exists($targetFile)) {
                // Handle file already exists case
            } else {
                $fileToUpload = $targetFile;
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                    echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
                } else {
                    echo "Error: Unable to move the uploaded file.";
                }
            }
        }

        $newItem = [
            'createPost' => $createPost,
            'fileToUpload' => $fileToUpload,
        ];
        
        print_r($newItem);

        $data[] = $newItem;
            
        if (file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT))) {
            echo "<br>The post has been created successfully!";
        } else {
            // Check for file writing errors
            $error = error_get_last();
            echo "<br>Error: Unable to save data. Error message: " . $error['message'];
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Popup Window Content</title>
    <script src="../js/createapost.js"></script>
    <style>
        body {
            text-align: center;
            font-family: verdana;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        textarea {
            width: 100%;
            max-width: 600px;
            padding: 10px;
            font-family: verdana;
        }

        button {
            padding: 10px 20px;
            font-family: verdana;
        }
    </style>
</head>
<body>
<h1>Create a Post:</h1>
    <form method="post" action="myposts.php" enctype="multipart/form-data">
        <textarea name="createPost" rows="6" cols="50" required></textarea><br /><br />
        <input type="file" name="fileToUpload" accept=".jpg, .jpeg, .png, .pdf">
        <button type="submit" name="postButton">Post</button>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="../js/scripts.js"></script>
    <!-- Popup window-->

</body>
</html>