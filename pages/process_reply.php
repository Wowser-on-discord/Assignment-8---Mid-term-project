<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $replyText = isset($_POST['replyText']) ? htmlspecialchars($_POST['replyText']) : '';

    if (!empty($replyText)) {
        $jsonFile = "../data/fypinfo.json";
        $data = [];

        if (file_exists($jsonFile)) {
            $jsonContent = file_get_contents($jsonFile);
            $data = json_decode($jsonContent, true);

        }

        $postId = $_POST['postId'];
        $replyText = $_POST['replyText'];

        if (isset($data[$postId])) {

            if (!isset($data[$postId]['replies'])) {
                $data[$postId]['replies'] = [];
            }

            $data[$postId]['replies'][] = $replyText;

            if (file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT)) !== false) {
                echo "Reply added successfully!";
            } else {
                echo "Error: Unable to save data.";
            }
        } else {
            echo "Error: Post not found.";
        }
    } else {
        echo "Error: Reply text is empty.";
    }
} else {
    echo "Error: Invalid request.";
}


?>
<br>
<a href="fyp.php">Go back to feed!</a>