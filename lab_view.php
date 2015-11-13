<?php

ob_start();
require_once("model.php");

session_start();

// was submitted for file upload
if (isset($_POST['submit']) && $_POST['command'] == 'upload') {
	require_once("file_upload.php");
	$uploadStatus = uploadFile(basename($_FILES["fileToUpload"]["name"])); // TODO pass user and lab to identify uploaded file?
	$uploadWasSuccessful = $uploadStatus['message'];
	$uploadMessage = $uploadStatus['message'];
}

// must pass lab id
if (!isset($_GET['id'])) {
    redirectTo('index.php');
}

$id = $_GET['id'];
$currentLab = getLabById($id);

ob_flush();

include_once("templates/page_head.php");
?>

<div class="container">
    <?php
    include_once("templates/navigation.php");
    ?>

    <content>
        <h1><?php echo $currentLab['name'] ?></h1>

        <p><?php echo $currentLab['description'] ?>
            <!--        todo upload-->

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

	                    <form action="lab_view.php?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">

		                    <input type="hidden" name="command" value="upload">
		                    <input type="file" name="fileToUpload" id="fileToUpload">
		                    <br>
		                    <button type="submit" class="btn btn-primary" value="Upload File" name="submit">Upload
		                    </button>
                        </form>
                    </div>
                    <div class="modal-footer">
	                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div

        <!--        todo results-->
	    <div id="uploadFileResultModal" class="modal fade" role="dialog">
		    <div class="modal-dialog">
			    <div class="modal-content">
				    <div class="modal-header">
					    <button type="button" class="close" data-dismiss="modal">&times;</button>
					    <h4 class="modal-title">Upload File</h4>
				    </div>
				    <div class="modal-body">
					    <b>Select a Java file to upload:</b>

					    <form action="lab_view.php?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">

						    <input type="hidden" name="command" value="upload">
						    <input type="file" name="fileToUpload" id="fileToUpload">
						    <br>
						    <button type="submit" class="btn btn-primary" value="Upload File" name="submit">Upload
						    </button>
					    </form>
				    </div>
				    <div class="modal-footer">
					    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				    </div>
			    </div>
		    </div>
	    </div

	    <?php echo "Upload ok? " . $uploadOk
	    ?>
    </content>

</div>
<!-- /container -->

<?php include_once("templates/page_footer.php"); ?>

<script>
    $(document).ready(function () {
        console.log('load');
        $('#upload-file-button').click(function () {
            // TODO toggle modal
        })
    })

</script>
