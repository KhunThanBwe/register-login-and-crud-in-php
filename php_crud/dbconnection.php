<?php

$serverName = "127.0.0.1";
$uName = "root";
$uPassword = "";
$dbName = "login_register";

$db = mysqli_connect($serverName, $uName, $uPassword, $dbName);

if(!$db) {
    echo("Error: ". mysqli_connect_error($db));
}




?>