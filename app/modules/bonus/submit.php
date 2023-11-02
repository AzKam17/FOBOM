<?php

/*
 * Projet de developpement@Copyright Forever Living
 * Application de gestion des bonus des FBO
 * Project Manager and Developper : Mr AYOLIE Say-halatte Stivell
 */

// You need to add server side validation and better error handling here

$data = array();

if (isset($_GET['files'])) {
    $error = false;
    $files = array();

    $uploaddir = __DIR__ . '/img/';
    foreach ($_FILES as $file) {
        if (move_uploaded_file($file['tmp_name'], $uploaddir . basename($file['name']))) {
            $files[] = $uploaddir . $file['name'];
        } else {
            $error = true;
        }
    }
    $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
} else {
    $data = array('success' => 'Form was submitted', 'formData' => $_POST);
}

echo json_encode($data);
?>
