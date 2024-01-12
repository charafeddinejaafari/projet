<?php

function validateForm($username, $password, $connection) {
    $username = $connection->real_escape_string($username);
    $password = $connection->real_escape_string($password);

    $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['username'] = $username;
        return true;
    } else {
        return false;
    }
}
