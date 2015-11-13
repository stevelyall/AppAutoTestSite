<?php

function uploadFile($file)
{
	// get file upload location
	require_once("model.php");
	$target_dir = getConfigProperty('upload_directory');

	// process file upload
	$target_file = $target_dir . $file;
	$fileType = pathinfo($target_file, PATHINFO_EXTENSION);
	if ($fileType != "java") {
		return array('success' => false, 'message' => 'Not a Java File');
	}

	//if file already exists
	if (file_exists($target_file)) {
		return array('success' => false, 'message' => 'File already exists');
	}

	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		return array('success' => false, 'message' => 'File too large');

	}

	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		return array('success' => true, 'message' => "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.");
	} else {
		return array('success' => false, 'message' => "Sorry, there was an error uploading your file.");
	}
}

?>
