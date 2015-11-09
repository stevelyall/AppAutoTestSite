<?php
/**
 * Deletes the user id passed as a URL parameter from the database.
 */
ob_start();
require_once("model.php");

//only accessible if logged in as instructor
session_start();
if (!isset($_SESSION['loggedInUser']) || $_SESSION['isInstructor'] != '1') {
    redirectTo("index.php");
}


//delete user, unless it is admin
$user = $_GET['user'];
echo $user;
if ($user != 'admin') {
    deleteUser($user);
}
redirectTo("accounts_manage.php");

ob_flush();
?>