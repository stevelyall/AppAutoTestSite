<?php
/**
 * Main page
 */
ob_start();
require_once("model.php");

// viewable only if user is logged in
session_start();
if (!isset($_SESSION['loggedInUser'])) {
    redirectTo("login.php");
}
ob_flush();

// get main page text
// TODO on login or on every index page load?
$_SESSION['courseName'] = getConfigProperty('course_name');
$_SESSION['welcome_title'] = getConfigProperty('welcome_title');
$_SESSION['welcome_message'] = getConfigProperty('welcome_message');

include_once("templates/page_head.php");
?>

<div class="container">
    <?php
    include_once("templates/navigation.php");
    ?>

    <content>
        <div class="container-fluid">
            <h2><?php echo $_SESSION['courseName'] ?></h2>

            <h3><?php echo $_SESSION['welcome_title'] ?></h3>
            <br>

            <p><?php echo $_SESSION['welcome_message'] ?></p>
        </div>
    </content>

</div> <!-- /container -->

<?php include_once("templates/page_footer.php"); ?>