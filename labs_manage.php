<?php
/**
 * Lab management page
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

?>

<body>
<div class="container">
    <?php
    require("templates/navigation.php");
    ?>

    <content>
        <div class="container-fluid">

            <h2>Manage Labs</h2>
            <br>

            <?php
            $connection = connectToDb();

            $result = getLabs();
            ?>
            <a href="lab_add.php"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Add Lab</a>
            <br>
            <table class='table-striped table-hover'>
                <?php
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <th><?php echo htmlentities($row['name']) ?></th>
                        <td>
                            <a href='lab_delete.php?name=<?php echo urlencode($row["name"]) ?>'> <span
                                    class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>
                            <a href='lab_edit.php?name=<?php echo urlencode($row["name"]) ?>'> <span
                                    class='glyphicon glyphicon-pencil' aria-hidden='true'></span> </a>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo htmlentities($row['description']) ?></td>

                    </tr>
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

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>