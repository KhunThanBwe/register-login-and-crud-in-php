<?php
    session_start();

    require 'db.php';


    if(isset($_POST['register_button'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if(empty($name)) {
            $nameError = "The name field is required";
        }else {
            $nameError = "";
        }
        if(empty($email)) {
            $emailError = "The email field is required";
        }else {
            $emailError = "";
        }
        if(empty($address)) {
            $addressError = "The address field is required";
        }else {
            $addressError = "";
        }
        if(empty($password)) {
            $passwordError = "The password field is required";
        }else {
            $passwordError = "";
        }
        if(empty($confirm_password)) {
            $confirmpasswordError = "The confirm_password field is required";
        }else {
            $confirmpasswordError = "";
        }
        if($confirm_password != $password) {
            $conpass = "Confirm_password does not match";
        }else{
            $conpass = "";
        }
        if (strlen($password) >= 8) {
            $countpass = "";
        } else {
            $countpass = "Password must be at least 8 characters long";
        }


        if(!empty($name) && !empty($email) && !empty($address) && !empty($password) && !empty($confirm_password) && ($confirm_password == $password) && (strlen($password) >= 8)){ 

            $encrptpassword = md5($password);
            
            $sql = "INSERT INTO user(name, email, address, password) VALUES('$name', '$email', '$address', '$encrptpassword')";
            $stmt = mysqli_query($conn, $sql);
            if($stmt == true) {
                $_SESSION['Msg'] = "Login successfully";
                echo "<script> alert('Successfully'); </script>";
                header('location:login.php');
            }else {
                die('Error: '.mysqli_error($sql));
            }
            
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>register</title>
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
    <div class="container-fluid mt-2">
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
                        <div class="container">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-info">
                                            <div class="card-title">
                                                <h4>Register</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form action="register.php" method="post">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input class="form-control <?php if($nameError != "") { ?>is-invalid<?php } ?>" type="text" name="name" id="name" value="<?php echo $name; ?>">
                                                    <i class="text-danger"><?php echo $nameError;  ?></i>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input class="form-control<?php if($emailError != "") { ?> is-invalid <?php } ?>" type="email" name="email" id="email" value="<?php echo $email; ?>">
                                                    <i class="text-danger"><?php echo $emailError;  ?></i>
                                                </div>
                                                <div class="form-group">
                                                    <label for="address">Address</label>
                                                    <textarea class="form-control<?php if($addressError != "") { ?> is-invalid <?php } ?>" name="address" id="address"><?php echo $address; ?></textarea>
                                                    <i class="text-danger"><?php echo $addressError;  ?></i>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input class="form-control<?php if($passwordError != "") { ?> is-invalid <?php } ?>" type="password" name="password" id="password" value="<?php echo $password; ?>">
                                                    <i class="text-danger"><?php echo $passwordError;  ?></i>
                                                    <p><i class="text-danger"><?php echo $countpass;  ?></i></p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirm_password">Confirm Password</label>
                                                    <input class="form-control<?php if($confirmpasswordError != "") { ?> is-invalid <?php } ?> " type="password" name="confirm_password" id="confirm_password" value="<?php echo $confirm_password; ?>">
                                                    <i class="text-danger"><?php echo $confirmpasswordError;  ?></i>
                                                    <i class="text-danger"><?php echo $conpass; ?></i>
                                                </div>
                                                
                                                <button class="btn btn-primary btn-sm mt-2" type="submit" name="register_button">Register</button>
                                                <span class="mx-2">If you already account,
                                                    <a href="login.php"><i>Login Here</i></a>
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
</body>
</html>


