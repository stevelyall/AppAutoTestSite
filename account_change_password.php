<?php
ob_start();
require_once("model.php");

//only accessible if logged in as instructor
session_start();
if (!isset($_SESSION['loggedInUser']) || $_SESSION['isInstructor'] != '1') {
    redirectTo("index.php");
}

// user to edit
$username = $_GET['user'];
// no access to default user
if ($username == 'admin') {
    redirectTo("index.php");
}

if (isset($_POST['submit'])) {
    // form was submitted
    $username = $_POST['user'];
    $newpassword = $_POST['inputPassword'];
    modifyUser($username, $newpassword);
    redirectTo("manage_accounts.php");
}

ob_flush();

include_once("templates/page_head.php");
?>
<div class="container">
    <?php
    include_once("templates/navigation.php");
    ?>

    <content>
        <!-- add user form -->
        <form class="account-form form-signin" action="account_change_password.php" method="post">
            <h2 class="form-signin-heading"> Change <?php echo $username; ?>'s Password </h2>
            <!-- also post current user name for new page to access -->
            <input type="hidden" name="user" value="<?php echo $username; ?>">
            <label for="inputPassword" class="sr-only">New Password</label>
            <input type="password" name="inputPassword" class="form-control" placeholder="New Password" required
                   autofocus>
            <br>
            <button id="change-password-back-button" class="btn btn-primary" type="button" name="done">Back</button>
            <button class="btn btn-primary" type="submit" name="submit">Submit Changes</button>
        </form>
        <br>
    </content>

</div>
<!-- /container -->


<?php include_once("templates/page_footer.php"); ?>

<script>
    $(document).ready(function () {
        console.log('load');
        $('#change-password-back-button').click(function () {
            window.open('accounts_manage.php', '_self');
        })
    })
</script>