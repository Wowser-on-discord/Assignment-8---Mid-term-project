<?php
if (isset($_GET['filename'])) {
    $filename = $_GET['filename'];
    
    // Define the directory 
    $sourceDirectory = 'uploads/';
    $destinationDirectory = 'images/';

    
    if (file_exists($sourceDirectory . $filename)) {
        // Move the file to the destination directory
        if (rename($sourceDirectory . $filename, $destinationDirectory . $filename)) {
            // Set appropriate headers for image download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $filename);
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($destinationDirectory . $filename));

            // Read the file and output it to the browser
            readfile($destinationDirectory . $filename);
            exit;
        } else {
            // Error moving the file
            echo 'Error moving the file to the "images" directory.';
        }
    } else {
        // File not found in the source directory
        echo 'File not found in the source directory.';
    }
} else {
    echo 'No filename specified.';
}
?>
