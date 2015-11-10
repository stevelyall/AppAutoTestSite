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
            $result = getLabs();
            ?>
            <a href="lab_add.php"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Add Lab</a>
            <table id="labs-table" class='table-striped table-hover'>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <!--                        TODO view lab details?-->
                        <!--                        <th><a href="lab_view.php?id=-->
                        <?php //echo urlencode($row["id"]) ?><!--"> -->
                        <?php //echo htmlentities($row['name']) ?><!--</th></a>-->
                        <th><?php echo htmlentities($row['name']) ?></th>
                        <td>
                            <!--                            TODO confirm deletion?-->
                            <a href='lab_delete.php?id=<?php echo urlencode($row["id"]) ?>'> <span
                                    class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>
                            <a href='lab_edit.php?id=<?php echo urlencode($row["id"]) ?>'> <span
                                    class='glyphicon glyphicon-pencil' aria-hidden='true'></span> </a>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"><?php echo htmlentities($row['description']) ?></td>

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