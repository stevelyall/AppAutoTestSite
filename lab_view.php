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
<body>
<div class="container">
    <?php
    include_once("templates/navigation.php");
    ?>

    <content>
        <h1><?php echo $currentLab['name'] ?></h1>

        <p><?php echo $currentLab['description'] ?>
            <!--        todo upload-->

        <div>
            <a href="##"> <span class="glyphicon glyphicon-open"></span>Upload File</a>
        </div>
        <!--        todo results-->

    </content>

</div>
<!-- /container -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        console.log('load');
        $('#edit-lab-back-button').click(function () {
            window.open('labs_manage.php', '_self');
        })
    })
</script>
</body>
</html>