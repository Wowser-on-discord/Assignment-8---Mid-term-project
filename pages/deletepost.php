<?php
session_start();

$jsonFile = "../data/fypinfo.json";

$data = [];

if (file_exists($jsonFile)) {
    $jsonContent = file_get_contents($jsonFile);
    $data = json_decode($jsonContent, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteButton'])) {
        $selectedPosts = isset($_POST['selectedPosts']) ? $_POST['selectedPosts'] : [];

        $selectedPosts = array_filter($selectedPosts, function ($key) use ($data) {
            return isset($data[$key]);
        });

        foreach ($selectedPosts as $key) {
            unset($data[$key]);
        }

        if (file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT)) !== false) {
            echo "Selected posts have been deleted successfully!";
        } else {
            echo "Error: Unable to save data to the JSON file.";
        }

        $_SESSION['data'] = $data;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Posts</title>
    <style>
        body {
            text-align: center;
            font-family: verdana;
            display: flex;
            flex-direction: column;
            justify-content: top;
            align-items: center;
            height: 100vh;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Delete Posts:</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <?php
        foreach ($data as $key => $post) {
            echo '<label>';
            echo '<input type="checkbox" name="selectedPosts[]" value="' . $key . '">';
            
            if (isset($post['createPost'])) {
                echo 'Text: ' . $post['createPost'];
            }
            
            if (isset($post['fileToUpload'])) {
                echo '<br>File: ' . $post['fileToUpload'] . '<br><br>';
            }

            echo '</label>';
        }
        ?>
        <button type="submit" name="deleteButton">Delete Selected Posts</button>
    </form>
</body>
</html>
