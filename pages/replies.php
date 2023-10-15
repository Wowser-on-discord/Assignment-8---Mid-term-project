<?php
$postId = $_POST['postId']; // The postId passed from the form
$replyText = $_POST['replyText'];


if (isset($data[$postId])) {
    // Add the new reply to the "replies" array for the specified post
    $newReply = [
        'user' => 'User', 
        'content' => $replyText
    ];

    $data[$postId]['replies'][] = json_encode($newReply); 

    // Serialize the data to JSON
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);

    // Write the updated data back to the file
    if (file_put_contents($jsonFile, $jsonData) !== false) {
        // Successfully updated the file
        echo "Reply added successfully.";
    } else {
        // Error handling if the file write fails
        echo "Failed to update the file.";
    }
} else {
    
    echo "Post not found.";
}
?>
