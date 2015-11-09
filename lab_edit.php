<?php

// TODO not overwriting with empty field? load current desc?
ob_start();
require_once("model.php");

//only accessible if logged in as instructor
session_start();
if (!isset($_SESSION['loggedInUser']) || $_SESSION['isInstructor'] != '1') {
    redirectTo("index.php");
}

$name = $_GET['name'];

if (isset($_POST['submit'])) {
    // form was submitted
    $name = $_POST['name'];
    $newname = $_POST['newLabName'];
    $newdesc = $_POST['newLabDesc'];
    modifyLab($name, $newname, $newdesc);
    redirectTo("labs_manage.php");
}

ob_flush();

include_once("templates/page_head.php");
?>
<body>
<div class="container">
    <?php
    include_once("templates/navigation.php");
    ?>

    <content>
        <!-- edit lab form -->
        <form class="account-form form-signin" action="lab_edit.php" method="post">
            <h2 class="form-signin-heading"> Edit Lab <?php echo $name; ?> </h2>
            <!-- also post current name for new page to access -->
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <label for="newLabName" class="sr-only">Name</label>
            <input type="text" name="newLabName" class="form-control" placeholder="Name"
                   autofocus required>
            <label for="newLabDesc" class="sr-only">Description</label>
            <!-- TODO textarea-->
            <input type="text" name="newLabDesc" class="form-control" placeholder="Description"
                   required>
            <br>
            <button id="edit-lab-back-button" class="btn btn-primary" type="button" name="done">Back</button>
            <button class="btn btn-primary" type="submit" name="submit">Submit Changes</button>
        </form>
        <br>
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