<?php
/**
 * User management page
 */
ob_start();
require_once("model.php");

//only accessible if logged in as instructor
session_start();
if (!isset($_SESSION['loggedInUser']) || $_SESSION['isInstructor'] != '1') {
    redirectTo("index.php");
}

ob_flush();

include_once("templates/page_head.php");
// TODO shouldn't be able to delete currently logged in user

?>

<div class="container">
    <?php
    require("templates/navigation.php");
    ?>

    <content>
        <div class="container-fluid">

            <h2>Manage Accounts</h2>
            <br>

	        <p>
		        You may add, delete or change passwords for user accounts here.
	        </p>
            <?php
            $connection = connectToDb();

            $result = findAllUsers();
            ?>
            <a href="account_add.php"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Add Users</a>
            <table id='accounts-table' class='table-striped table-hover'>
                <tr>
                    <th>Username</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Type</th>
                    <th>Options</th>
                </tr>

                <?php

                while ($row = mysqli_fetch_assoc($result)) { ?>
                <!-- output each row-->
                <tr>
                    <td><?php echo htmlentities($row['username']) ?></td>
                    <td><?php echo htmlentities($row['last_name']) ?></td>
                    <td><?php echo htmlentities($row['first_name']) ?></td>
                    <td>
                        <?php
                        $type = ($row['is_instructor'] == "1") ? "Instructor" : "Student";
                        echo $type;
                        ?>
                    </td>

                    <td>
                        <?php
                        // no editing default user
                        if ($row['username'] == 'admin') {
                            continue;
                        }
                        ?>

                        <a href='account_delete.php?user=<?php echo urlencode($row["username"]) ?>'> <span
                                class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>
                        <a href='account_change_password.php?user=<?php echo urlencode($row["username"]) ?>'> <span
                                class='glyphicon glyphicon-pencil' aria-hidden='true'></span> </a>
                    </td>
                    <?php } ?>
            </table>
            <br>


            <?php
            // release returned data
            mysqli_free_result($result);
            // close database connection
            mysqli_close($connection);
            ?>
        </div>
    </content>

</div>
<!-- /container -->

<?php include_once("templates/page_footer.php"); ?>