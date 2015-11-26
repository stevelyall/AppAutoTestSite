<?php

ob_start();
require_once("model.php");

session_start();

//only accessible if logged in
if (!isset($_SESSION['loggedInUser'])) {
	redirectTo("index.php");
}

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

	    <!-- Test progress message -->
	    <div id="TestProgressModal" class="modal fade" role="dialog">
		    <div class="modal-dialog">
			    <div class="modal-content">
				    <div class="modal-body">
					    <div id="test-progress" class="progress">
						    <div class="progress-bar progress-bar-striped active" role="progressbar" data-keyboard
						         aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
							    Please Wait
						    </div>
					    </div>

				    </div>
			    </div>
		    </div>
	    </div>

	    <!-- todo for instructor show all users -->
	    <!--	    TODO create result records-->
	    <br>
	    <h4>Test Cases</h4>
	    <table id="results-table" class='table'>
		    <tr>
			    <th class="num">
				    #
			    </th>
			    <th class="id">
				    Name
			    </th>
			    <th class="description">
				    Description
			    </th>
			    <th class="result">
				    Result
			    </th>
		    </tr>
		    <?php
		    $testCases = getTestCasesForLab($lab_id);
		    while ($testCase = mysqli_fetch_assoc($testCases)) {
			    $num = $testCase['test_case_num'];
			?>
			    <tr>
				    <td class="num">
				        <?php echo $num ?>
				    </td>
			        <td class="id">
				        <?php echo htmlentities($testCase['name']) ?>
			        </td>
			        <td class="description">
				        <?php echo htmlentities($testCase['description']) ?>
			        </td>
		        <?php
				$results = getTestCaseResult($lab_id, $num, $_SESSION['loggedInUser']);
				// no results for test case
				if ($results->num_rows < 1) {
				?>
					<td class="result warning">
						    Not Run
						</td>
				<?php
					continue;
				}

				while ($result = mysqli_fetch_assoc($results)) {
				    $isPass = false;
					if ($result['result'] == 1) {
						$isPass = true;
					}

				} ?>
				    <td class="result <?php echo ($isPass) ? "success" : "danger" ?>">
					    <?php echo ($isPass) ? "Pass" : "Fail" ?>
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

	    <?php
		if (isset($uploadStatus) && $uploadWasSuccessful) { ?>

	    if (typeof(EventSource) !== "undefined") {
		    console.log('listening for updates');
		    var source = new EventSource('run_tests.php');
		    source.onmessage = function (event) {
			    console.log(event.data);
			    if (event.data == "result ready") {
				    // display results
				    window.location.href = window.location.pathname + window.location.search;
			    }

			    else {
				    $("#TestProgressModal").modal({backdrop: "static"});

			    }
		    }
	    }
	    else {
		    alert("Your browser is not supported.");
	    }
	    <?php
	    }?>
    });

</script>