<?php
    session_start();
    require 'dbconnection.php';

    if(isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $result = mysqli_query($db, "DELETE FROM post WHERE id=$delete_id");

        if($result) {
            $_SESSION['successMsg'] = "A Post Delete successfully";
            header('location:home.php');
        }else {
            echo "ERROR: ". mysqli_error($db);
        }

    }



?>