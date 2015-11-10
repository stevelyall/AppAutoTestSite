<?php

// 302 redirect
function redirectTo($page)
{
    header("Location: " . $page);
}

//returns a database connection
function connectToDb()
{
//    production
//    $host = "localhost";
//    $user = ""; // TODO production
//    $pass = "";
//    $dbname = "appautotestsite";

    // dev
    $host = "127.0.0.1";
    $user = "root";
    $pass = "";
    $dbname = "appautotest";
    $port = "3306";

    // connect to the database
    $connection = mysqli_connect($host, $user, $pass, $dbname, $port);
    if (mysqli_connect_errno()) {
        die('Could not connect: ' . mysqli_connect_error() . ' error number: ' . mysqli_connect_errno() . '<br>');
    }
    return $connection;
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
function addUser($username, $password)
{
    $connection = connectToDb();
    $usr = mysqli_real_escape_string($connection, $username);
    $pw = mysqli_real_escape_string($connection, $password);

    // add new user
    $query = "INSERT INTO user (username, password)
                VALUES ('$usr', '$pw'); ";
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
    // TODO duplicate?
    // add new user
    $query = "INSERT INTO lab (name, description)
                VALUES ('$name', '$desc'); ";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Adding lab failed");
    }
    mysqli_close($connection);
}

function deleteLab($name)
{
    $connection = connectToDb();
    $name = mysqli_real_escape_string($connection, $name);

    $query = "DELETE FROM lab WHERE name = '$name';";
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

    $query = "UPDATE lab SET name = '$newname', description = '$newdesc' WHERE name = '$name' LIMIT 1;";
    var_dump($query);
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Updating lab failed" . mysqli_error($connection));
    }
    mysqli_close($connection);
}
?>