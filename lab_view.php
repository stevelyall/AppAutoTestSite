<?php

ob_start();
require_once("model.php");

session_start();

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
            <button type="button" id="upload_file_button"><span class="glyphicon glyphicon-open btn btn-info"
                                                                data-toggle="modal"
                                                                data-target="uploadFileModal"></span>Upload File
            </button>
        </div>

        <div id="uploadFileModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body">
                        <p>Some text in the modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

                <!--                <h3 class="panel-title">Upload File</h3>-->
                <!--                <form action="file_upload.php" method="post" enctype="multipart/form-data">-->
                <!--                    Select file to upload:-->
                <!--                    <input type="file" name="fileToUpload" id="fileToUpload">-->
                <!--                    <button type="submit" value="Upload File" name="submit">-->
                <!--                </form>-->
            </div>
        </div

        <!--        todo results-->

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
