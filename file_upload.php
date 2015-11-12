<?php

ob_start();

session_start();

// must be logged in and pass lab id
if (!isset($_SESSION['loggedInUser'])) {
    redirectTo('index.php');
}

$id = $_GET['id'];

ob_flush();

// get file upload location
require_once("model.php");
$target_dir = getConfigProperty('upload_directory');

// process file upload
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file, PATHINFO_EXTENSION);
if ($fileType != "java") {
	echo "Not a Java File";
	$uploadOk = 0;
}

//if file already exists
if (file_exists($target_file)) {
	echo "File already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

redirectTo("lab_view.php?id=" . $id);
?>