<?php
// user is logged in
session_start();
if (isset($_SESSION['loggedInUser'])) {
    $loggedIn = true;
    $logInOut = "<li><a href='/log_out.php'>Log Out</a></li>";
} else {
    $loggedIn = false;
    $logInOut = "<li><a href='/login.php'>Log In</a></li>";
}
?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- navbar brand logo -->
            <a class="navbar-brand" href="../index.php">AppAutoTest</a>
            <!-- navbar brand text -->
            <!--<a class="navbar-brand" href="index.php">ERA Project</a>-->
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php
                if ($loggedIn) {
                    // instructor menu
                    if ($_SESSION['isInstructor'] == '1') {
                        echo "<li><a href='../accounts_manage.php'> Accounts </a></li>";
                        echo "<li><a href='../labs_manage.php'> Labs </a></li>";
                        echo "<li><a href='#'> Results </a></li>";
                        echo "<li><a href='#'> Update Main Page </a></li>";


                    } else {
                        // student menu
                        echo "<li><a href=''> Labs</a></li>";
                        echo "<li><a href=''> </a></li>";
                    }

                }
                ?>
                <li><a href="mailto:helmilgi@tru.ca">Contact</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php if ($loggedIn) {
                    echo "<p class='navbar-text'>Logged in as {$_SESSION['loggedInUser']}</p>";
                }
                echo $logInOut ?>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
    <!--/.container-fluid -->
</nav>