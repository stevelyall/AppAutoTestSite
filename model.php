<?php

// 302 redirect
function redirectTo($page)
{
    header("Location: " . $page);
}

require_once('database.php');

function getConfigProperty($property)
{
    $connection = connectToDb();
    $query = "SELECT value FROM config WHERE property = '$property'";
    $result = mysqli_fetch_assoc(mysqli_query($connection, $query));
    return $result['value'];
}

function setConfigProperty($property, $value)
{
    $connection = connectToDb();
    $query = "UPDATE config SET value = '$value' where property = '$property';";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("Updating config failed" . mysqli_error($connection));
    }
    mysqli_close($connection);
}

// queries the database for all users
function findAllUsers()
{
    $connection = connectToDb();
    $query = "SELECT * FROM user ORDER BY username";
    $users = mysqli_query($connection, $query);
    return $users;
}

// queries the database for the specified username
function findUser($username)
{
    $connection = connectToDb();
    $userid = mysqli_real_escape_string($connection, $username);
    $query = "SELECT * FROM user WHERE username = '{$userid}' LIMIT 1";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        echo "findUserById {$username} failed";
    }
    if ($user = mysqli_fetch_assoc($result)) {
        return $user;
    } else {
        return null;
    }
}

// adds a user to the database
function addUser($username, $firstName, $lastName, $password)
{
    $connection = connectToDb();
    $usr = mysqli_real_escape_string($connection, $username);
	$fn = mysqli_real_escape_string($connection, $firstName);
	$ln = mysqli_real_escape_string($connection, $lastName);
	$pw = mysqli_real_escape_string($connection, $password);

    // add new user
	$query = "INSERT INTO user (username, first_name, last_name, password)
                VALUES ('$usr', '$fn', '$ln', '$pw'); ";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Adding user failed");
    }
    mysqli_close($connection);
}

// deletes a user from the database
function deleteUser($user)
{
    $connection = connectToDb();
    $username = mysqli_real_escape_string($connection, $user);

    $query = "DELETE FROM user WHERE username = '$username';";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Deleting user failed" . mysqli_error($connection));
    }

    mysqli_close($connection);
}

// replaces a user's information in the database with the new information provided
function modifyUser($user, $newPass)
{
    $connection = connectToDb();
    $user = mysqli_real_escape_string($connection, $user);
    $newPass = mysqli_real_escape_string($connection, $newPass);

    $query = "UPDATE user SET password = '$newPass' WHERE username = '$user' LIMIT 1;";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Updating user failed" . mysqli_error($connection));
    }
    mysqli_close($connection);
}

// retrieves all labs
function getLabs()
{
    $connection = connectToDb();
    $query = "SELECT * FROM lab ORDER BY id";
    $labs = mysqli_query($connection, $query);
    return $labs;

}

// retrieves lab results for user
function getResultsForLabAndUser($labid, $username)
{
	$connection = connectToDb();
	$query = "SELECT * FROM result WHERE lab_id=$labid AND username = '$username'";
	$results = mysqli_query($connection, $query);
	return $results;
}

function getResultsForDownload()
{
	$connection = connectToDb();
	$query = "SELECT lab.name, username, test_case_id, result FROM result JOIN lab ON result.lab_id = lab.id ORDER BY username";
	$results = mysqli_query($connection, $query);
	return $results;
}

function getTestCaseDescriptionById($testcaseid)
{
	$connection = connectToDb();
	$query = "SELECT description FROM testcase WHERE test_case_id=$testcaseid";
	$results = mysqli_query($connection, $query);
	return mysqli_fetch_assoc($results);
}

function getLabByName($name)
{
    $connection = connectToDb();
    $name = mysqli_real_escape_string($connection, $name);
    $query = "SELECT * FROM lab WHERE name = '$name' LIMIT 1";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        echo "findLab {$name} failed";
    }
    if ($lab = mysqli_fetch_assoc($result)) {
        return $lab;
    } else {
        return null;
    }
}

function getLabById($id)
{
    $connection = connectToDb();
    $id = mysqli_real_escape_string($connection, $id);
    $query = "SELECT * FROM lab WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        echo "findLab {$id} failed";
    }
    if ($lab = mysqli_fetch_assoc($result)) {
        return $lab;
    } else {
        return null;
    }
}



function addLab($name, $desc)
{
    $connection = connectToDb();
    $name = mysqli_real_escape_string($connection, $name);
	$desc = mysqli_real_escape_string($connection, $desc);
    $query = "INSERT INTO lab (name, description)
                VALUES ('$name', '$desc'); ";
	$result = mysqli_query($connection, $query);
    if (!$result) {
	    die("Adding lab failed" . mysqli_error($connection));
    }
    mysqli_close($connection);
}

function deleteLab($id)
{
    $connection = connectToDb();
	$id = mysqli_real_escape_string($connection, $id);

	$query = "DELETE FROM lab WHERE id = '$id';";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("Deleting lab failed" . mysqli_error($connection));
    }

    mysqli_close($connection);
}

function modifyLab($name, $newname, $newdesc)
{
    $connection = connectToDb();
    $name = mysqli_real_escape_string($connection, $name);
    $newname = mysqli_real_escape_string($connection, $newname);
    $newdesc = mysqli_real_escape_string($connection, $newdesc);

    $query = "UPDATE lab SET name = '$newname', description = '$newdesc' WHERE name = '$name' LIMIT 1;";
    var_dump($query);
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Updating lab failed" . mysqli_error($connection));
    }
    mysqli_close($connection);
}

?>