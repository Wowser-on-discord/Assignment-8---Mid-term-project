<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['postId']) && isset($_POST['action'])) {
        $postId = intval($_POST['postId']); 
        $action = $_POST['action'];

        $jsonFile = "../data/fypinfo.json";
        $data = [];

        if (file_exists($jsonFile)) {
            $jsonContent = file_get_contents($jsonFile);
            $data = json_decode($jsonContent, true);
        }

        if (isset($data[$postId])) {
            if ($action === 'like') {
                $data[$postId]['likes']++;
            } elseif ($action === 'unlike') {
                $data[$postId]['likes']--;
            }

            // Save the updated data back to the JSON file
            file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));

            // Send the updated likes count as a response
            echo $data[$postId]['likes'];
        }
    }
}
