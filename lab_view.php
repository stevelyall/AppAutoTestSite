<?php

ob_start();
require_once("model.php");

session_start();


// must pass lab id
if (!isset($_GET['id'])) {
	redirectTo('index.php');
}

$lab_id = $_GET['id'];

// was submitted for file upload
if (isset($_POST['submit']) && $_POST['command'] == 'upload') {
	require_once("file_upload.php");
	$uploadStatus = uploadFile(basename($_FILES["fileToUpload"]["name"]), $lab_id, $_SESSION['loggedInUser']);
	$uploadWasSuccessful = $uploadStatus['success'];
	$uploadMessage = $uploadStatus['message'];
}


$currentLab = getLabById($lab_id);

ob_flush();

include_once("templates/page_head.php");
?>

<div class="container" xmlns="http://www.w3.org/1999/html">
    <?php
    include_once("templates/navigation.php");
    ?>

    <content>


	    <h1><?php echo $currentLab['name'] ?></h1>

	    <p><?php echo $currentLab['description'] ?>

        <div>
            <button type="button" id="upload_file_button" class="btn btn-primary"
                    data-toggle="modal" data-target="#uploadFileModal"><span class="glyphicon glyphicon-open"> Upload File
            </button>
        </div>

	    <!-- modal shown when upload button pushed -->
        <div id="uploadFileModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Upload File</h4>
                    </div>
                    <div class="modal-body">
	                    <b>Select a Java file to upload:</b>

	                    <form action="lab_view.php?id=<?php echo $lab_id ?>" method="post"
	                          enctype="multipart/form-data">

		                    <input type="hidden" name="command" value="upload">
		                    <input type="file" name="fileToUpload" id="fileToUpload">
		                    <br>
		                    <input type="submit" class="btn btn-primary" value="Upload File" name="submit">
                        </form>
                    </div>
                    <div class="modal-footer">
	                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

	    <!-- File upload result message-->
	    <?php
	    if (isset($uploadStatus)) {
		    if ($uploadWasSuccessful) {
			    echo "<div class='alert alert-success upload-result-alert' role='alert'>{$uploadMessage}</div>";
		    } else {
			    echo "<div class='alert alert-danger upload-result-alert' role='alert'>{$uploadMessage}</div>";
		    }
	    }

	    ?>

	    <?php
	    $results = getResultsForLabAndUser($lab_id, $_SESSION['loggedInUser']);
	    ?>

	    <!--	    TODO create result records-->
	    <!--	    TODO manage test cases?-->

	    <table id="results-table" class='table'>
		    <?php
		    while ($row = mysqli_fetch_assoc($results)) {

			    $testcase = getTestCaseDescriptionById($row['test_case_id']);
			    $isPass = htmlentities($row['result']);
			    // todo what should be shown for instructor?
			    ?>
			    <tr>
				    <th class="id">
					   Test Case Id
				    </th>
				    <th class="description">
					    Description
				    </th>
				    <th class="result">
					    Result
				    </th>
			    </tr>
			    <?php
			    if ($isPass) {
					echo "<tr class='success'>";
			    }
			    else {
			        echo "<tr class='danger'>";
			    }
			    ?>
					<td class="id">
					    <?php echo htmlentities($row['test_case_id']) ?>
					</td>
					<td class="description">
					    <?php echo htmlentities($testcase['description']) ?>
					</td>
					<td class="result">
					    <?php echo ($isPass)? "Pass" : "Fail" ?>
					</td>
			    </tr>
		    <?php } ?>
	    </table>
    </content>

</div>
<!-- /container -->

<?php include_once("templates/page_footer.php"); ?>

<script>
    $(document).ready(function () {

    })

</script>
