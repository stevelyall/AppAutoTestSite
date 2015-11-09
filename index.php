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

include_once("templates/page_head.php");
?>

<body>
<div class="container">
    <?php
    include_once("templates/navigation.php");
    ?>

    <content>
        <div class="container-fluid">
            <h2>Main Page Content</h2>
            <br>

            <p>content goes here</p>
        </div>
    </content>

</div> <!-- /container -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>>