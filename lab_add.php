<?php
ob_start();
require_once("model.php");

//only accessible if logged in as instructor
session_start();
if (!isset($_SESSION['loggedInUser']) || $_SESSION['isInstructor'] != '1') {
    redirectTo("index.php");
}

if (isset($_POST['submit'])) {
    // form was submitted
    $name = $_POST['inputLabName'];
    $description = $_POST['inputLabDesc'];
    // check for duplicate lab
    // user with that name exists
    if (getLabByName($name) != null) {
        $msg = "Can't add lab, {$name} already exists.";
    } else {
        // add user
        addLab($name, $description);
        $msg = "{$name} added.";
    }
} else {
    // form was not submitted (GET request)
    $msg = "Add Lab";
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
        <!-- add lab form -->
        <form class="account-form form-signin" action="lab_add.php" method="post">
            <h2 class="form-signin-heading"> <?php echo $msg; ?> </h2>
            <label for="inputLabName" class="sr-only">Username</label>
            <input type="text" name="inputLabName" class="form-control" placeholder="Lab Name" required autofocus>
            <label for="inputLabDesc" class="sr-only">Description</label>
            <!-- TODO textarea?-->
            <input type="text" name="inputLabDesc" class="form-control" placeholder="Description" required>
            <br>
            <button id="done-adding-button" class="btn btn-primary" type="button" name="done">Done</button>
            <button class="btn btn-primary" type="submit" name="submit">Add Lab</button>

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
        $('#done-adding-button').click(function () {
            window.open('labs_manage.php', '_self');
        })
    })
</script>
</body>
</html>