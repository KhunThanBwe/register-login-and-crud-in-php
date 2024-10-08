<?php
    session_start();

    require 'db.php';

    if(!isset($_SESSION['user_array']['name'])) {
        header('location:login.php');
    }else {
        if($_SESSION['user_array']['role'] != 'user') {
            header('location:admin_dashboard.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>user dashboard</title>
    <style>
        body {
            padding: 5px;
        }
        .label-item {
            font-family: bold;
            font-size: 20px;
        }
    </style>
</head>
<?php
    //Read auth user data
    $auth_user_id  = $_SESSION['user_array']['id'];
    $auth_user_result = mysqli_query($conn, "SELECT * FROM user WHERE id=$auth_user_id");

    if($auth_user_result) {
        $auth_user_array = mysqli_fetch_array($auth_user_result);
    }else {
        echo "ERROR: ".mysqli_error($conn);
    }



    //User Edit Profile
    $user_edition_form_status = false;
    if(isset($_REQUEST['user_id_to_update'])) {
        $user_edition_form_status = true;

        $user_id_to_update = $_REQUEST['user_id_to_update'];

        $result = mysqli_query($conn, "SELECT * FROM user WHERE id=$user_id_to_update");
        if($result){
            $user = mysqli_fetch_assoc($result);
        }else {
            echo "Error: ". mysqli_error($conn);
        }
    }

    if(isset($_POST['update_Button'])) {
        $user_id = $_POST['user_id'];
        
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        //Filter Password
        $user_result = mysqli_query($conn, "SELECT * FROM user WHERE id=$user_id");
        $user_array = mysqli_fetch_assoc($user_result);
        $old_password = $user_array['password'];

        $input_password = $_POST['password'];
        if($old_password == $input_password) {
            $new_password = $input_password;
        }else {
            $new_password = md5($input_password);
        }

        $result = mysqli_query($conn, "UPDATE user SET name='$name',email='$email', address='$address', password='$new_password' WHERE id=$user_id");
        if($result)  {
            header("location:user_dashboard.php");
        }
    }

?>
<body>
    <div class="container-fulid mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-title"><h2 class="text-white">Home</h2></div>
                            </div>
                            <div class="col-md-6">
                                <form action="logout.php" method="GET">
                                    <button type='submit' class="btn btn-danger btn-sm my-2 float-end" onclick="return confirm('Are you sure you want to logout?')">Logout</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if(isset($_SESSION['Msg'])) { ?>
                        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                            <strong>
                            <?php 
                                echo $_SESSION['Msg'];
                                unset($_SESSION['Msg']);
                            ?>
                            </strong> 
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php } ?>
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="card-title text-white">User List</h4>
                            </div>
                            <div class="card-body"> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header bg-warning">
                                                <div class="card-title">
                                                    <!-- Admin info -->
                                                    <h5 class="text-center">User Info</h5>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="px-5">
                                                    <label class="label-item">Role : </label>
                                                    <i class="bg bg-success text-white"><?php echo $_SESSION['user_array']['role'];  ?></i>
                                                </div>
                                                <div class="px-5">
                                                    <label class="label-item">Name : </label>
                                                    <i><?php echo $auth_user_array['name'];  ?></i>
                                                </div>
                                                <div class="px-5">
                                                    <label class="label-item">Email : </label>
                                                    <i><?php echo $auth_user_array['email'];  ?></i>
                                                </div>
                                                <div class="px-5">
                                                    <label class="label-item">Address : </label>
                                                    <i><?php echo $auth_user_array['address'];  ?></i>
                                                </div>
                                                <div class="px-5">
                                                    <label class="label-item">Password : </label>
                                                    <i><?php echo $auth_user_array['password'];  ?></i>
                                                </div>
                                                <div>
                                                    <a href="user_dashboard.php?user_id_to_update=<?php echo $auth_user_array['id'];  ?> " class="btn btn-primary btn-sm mx-5 mt-3">Edit Your Profile</a>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="col-md-6">
                                        <?php if($user_edition_form_status == true) { ;?>
                                        <div class="card">
                                            <div class="card-header bg-primary">
                                                <div class="title text-white">User Updation Form</div>
                                            </div>
                                            <div class="card-body">
                                                <form action="user_dashboard.php" method="post">
                                                    <input type="hidden" name="user_id" value="<?php echo $user['id'] ?>"></input>
                                                    <div class="form-group">
                                                        <label for="name">NAME</label>
                                                        <input class="form-control" type="text" name="name" id="name" value="<?php echo $user['name']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">EMAIL</label>
                                                        <input class="form-control" type="email" name="email" id="email" value="<?php echo $user['email']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password">PASSWORD</label>
                                                        <input class="form-control" type="text" name="password" id="password" value="<?php echo $user['password']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address">ADDRESS</label>
                                                        <textarea class="form-control" name="address" id="address"><?php echo $user['address']; ?></textarea>
                                                    </div>
                                                    <div class="mt-3">
                                                        <button class="btn btn-primary btn-sm" name="update_Button" type="submit"  onclick="return confirm('Are you sure you want to Update?')">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>