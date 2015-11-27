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
	$currentpassword = sha1($_POST['inputCurrentPassword']);

	$user = findUser($_SESSION['loggedInUser']);
	$passwordsMatch = ($currentpassword == $user['password']) ? true : false;
	if (!$passwordsMatch) {
		$msg = "Your current password was entered incorrectly. " . $username . "'s password was not changed.";

	} else {
		$newpassword = sha1($_POST['inputPassword']);
		modifyUser($username, $newpassword);
		redirectTo("accounts_manage.php");
	}
}

ob_flush();

include_once("templates/page_head.php");
?>
<div class="container">
    <?php
    include_once("templates/navigation.php");
    ?>

    <content>
        <form class="account-form form-signin" action="account_change_password.php" method="post">
            <h2 class="form-signin-heading"> Change <?php echo $username; ?>'s Password </h2>

	        <?php if (isset($msg)) {
		        echo "<div class='alert alert-danger upload-result-alert' role='alert'>{$msg}</div>";
	        } ?>

            <input type="hidden" name="user" value="<?php echo $username; ?>">
	        <label for="inputCurrentPassword" class="sr-only">Current Password</label>
	        <input type="password" name="inputCurrentPassword" class="form-control" placeholder="Your Current Password"
	               required
	               autofocus>
            <label for="inputPassword" class="sr-only">New Password</label>
	        <input type="password" name="inputPassword" class="form-control"
	               placeholder="New Password for <?php echo $username ?>" required>
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