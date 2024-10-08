<?php

$conn = mysqli_connect('127.0.0.1', 'root', '', 'login_register');

if(!$conn) {
    die('Error: '.mysqli_error($conn));
}
?>