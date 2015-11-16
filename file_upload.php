<?php

function uploadFile($file, $lab_id, $username)
{
	// get file upload location
	require_once("model.php");
	$target_dir = getConfigProperty('upload_directory');

	// process file upload
	$fileType = pathinfo($file, PATHINFO_EXTENSION);
	if ($fileType != "java") {
		return array('success' => false, 'message' => 'Not a Java File');
	}

	// rename uploaded file with username and lab id
	$file = $username . "_" . $lab_id . "." . $fileType;
	$target_file = $target_dir . $file;

	//echo $target_file;

	//if file already exists
	if (file_exists($target_file)) {
		return array('success' => false, 'message' => 'File already exists');
	}

	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		return array('success' => false, 'message' => 'File too large');

	}

	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		return array('success' => true, 'message' => "The file has been uploaded successfully.");
	} else {
		return array('success' => false, 'message' => "Sorry, there was an error uploading your file.");
	}
}

?>
