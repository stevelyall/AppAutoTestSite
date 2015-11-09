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
    $username = $_POST['inputUsername'];
    $password = $_POST['inputPassword'];

    // check for duplicate user
    // user with that name exists
    if (findUser($username) != null) {
        $msg = "Can't add user {$username}, the user already exists.";
    } else {
        // add user
        addUser($username, $password);
        $msg = "User {$username} added.";
    }
} else {
    // form was not submitted (GET request)
    $msg = "Add User";
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
        <!-- add account form -->
        <form class="account-form form-signin" action="account_add.php" method="post">
            <h2 class="form-signin-heading"> <?php echo $msg; ?> </h2>
            <label for="inputUsername" class="sr-only">Username</label>
            <input type="text" name="inputUsername" class="form-control" placeholder="Username" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="inputPassword" class="form-control" placeholder="Password" required>
            <br>
            <button id="done-adding-button" class="btn btn-primary" type="button" name="done">Done</button>
            <button class="btn btn-primary" type="submit" name="submit">Add User</button>

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
            window.open('accounts_manage.php', '_self');
        })
    })
</script>
</body>
</html>