<?php
session_start();

require "db.php";
$error = "";
if(isset($_POST['login_button'])) {
    $email = trim($_POST['email']);
    $password = md5(trim($_POST['password']));

    $user_result = mysqli_query($conn, "SELECT * FROM user WHERE email='$email' AND password='$password'");
    $user_count = mysqli_num_rows($user_result);

    if($user_count === 1) {
        $user_array = mysqli_fetch_assoc($user_result);

        $_SESSION['user_array'] = $user_array;
        if($user_array['role'] == 'user'){
            $_SESSION['Msg'] = "Login successfully";
            header('location:user_dashboard.php');
        }else {
            $_SESSION['Msg'] = "Login successfully";
            header('location:admin_dashboard.php');
        }
        
    }else{
        $error = "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>login</title>
    <style>
        body {
            padding: 5px;
        }
        a {
            text-decoration: none;
        }
        
    </style>
</head>
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
                                <a class="btn float-end btn-sm mt-2 btn-light" href="../index.php"> << back </a>
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
                        <div class="container">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-info">
                                            <div class="card-title">
                                                <h4>Login</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <?php if($error != "") {?>
                                                <div class="alert alert-danger" role="alert">
                                                    <?php  echo $error; ?>
                                                </div>
                                            <?php }?>
                                            <form action="login.php" method="post">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input class="form-control" type="email" name="email" id="email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input class="form-control" type="password" name="password" id="password">
                                                </div>
                                                
                                                <button class="btn btn-primary btn-sm mt-2" type="submit" name="login_button">Login</button>
                                                <span class="mx-2">If you have not account,
                                                    <a href="register.php"><i>Register Here</i></a>
                                                </span>
                                            </form> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
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