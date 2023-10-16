<?php
session_start();

$jsonFile = "../data/fypinfo.json";
$data = [];
$replies = [];


if (file_exists($jsonFile)) {
    $jsonContent = file_get_contents($jsonFile);
    $data = json_decode($jsonContent, true);
}

function getLikesCount($postId, $data) {
    return isset($data[$postId]['likes']) ? $data[$postId]['likes'] : 0;
}

function getRepliesForPost($postId, $data) {
    foreach ($data as $post) {
        if (isset($post['postId']) && $post['postId'] === $postId && isset($post['replies'])) {
            return $post['replies'];        }
    }
    return $replies;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['postButton'])) {
    $createPost = isset($_POST['createPost']) ? htmlspecialchars($_POST['createPost']) : '';
    
    $fileToUpload = '';
    if (!empty($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            $fileToUpload = $targetFile;
            echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        } else {
            echo "Error: Failed to move the uploaded file.";
        }
    }

    if (!empty($createPost) || !empty($fileToUpload)) {
        $newItem = [
            'postId' => count($data) + 1,
            'createPost' => $createPost,
            'fileToUpload' => $fileToUpload,
            'likes' => 0,
            'replies' => [],
        ];

        $data[] = $newItem;

        if (file_put_contents($jsonFile1, json_encode($data, JSON_PRETTY_PRINT)) !== false) {
            echo "The post has been created successfully!";
        } else {
            echo "Error: Unable to save data.";
        }
    } else {
        echo "Error: The post data is empty.";
    }
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
        
            <h1 style="display: flex; flex-direction: column; align-items: center; text-align: center;">Most Recent Posts</h1>
            <?php shuffle ($data);
            foreach ($data as $post) { ?>
            <div class="post">
    <p><strong>Username:</strong> <?php echo $post['username']; ?></p>
    <p><?php echo $post['createPost']; ?></p><br>
    <?php if (!empty($post['fileToUpload'])) { ?>
        <img src="<?php echo $post['fileToUpload']; ?>" alt="Uploaded Image" class="max-size-image">
    <?php } ?><br><br>
    <button class="like-button" data-postid="<?php echo $post['postId']; ?>" data-initial-like="<?php echo getLikesCount($post['postId'], $data) > 0 ? 'liked' : 'unliked'; ?>">
        <?php echo getLikesCount($post['postId'], $data) > 0 ? '💙' : '🤍'; ?>
    </button>
    <span class="likes-count" id="likes-count-<?php echo $post['postId']; ?>">
        <?php echo getLikesCount($post['postId'], $data); ?>
    </span><br><br>
    <form method="post" action="process_reply.php">
        <input type="hidden" name="postId" value="<?php echo $post['postId']; ?>">
        <textarea name="replyText" placeholder="Write your reply here" rows="4" cols="50"></textarea><br>
        <input type="submit" value="Reply">
    </form>

    <?php
    $replies = getRepliesForPost($post['postId'], $data);
    if (!empty($replies)) {
        echo "<h2>Replies:</h2>";
        foreach ($replies as $reply) {
            echo "<p>{$reply}</p>";
        }
    }
    ?>
</div>
<?php } ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="../js/scripts.js"></script>
    <!-- Popup window-->
    <script src="../js/createapost.js"></script>
    <script src="../js/editpost.js"></script>
    <script src="../js/deletepost.js"></script>
</body>
</html>
