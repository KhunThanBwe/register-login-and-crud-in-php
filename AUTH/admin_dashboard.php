<?php
    session_start();
    require 'db.php';

    //Call session
    if(!isset($_SESSION['user_array'])) {
        header ("location:login.php");
    }else {
        if($_SESSION['user_array']['role'] != 'admin') {
            header('location:user_dashboard.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>header</title>
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

<body>
<?php
    //Click Edit button
    $user_edition_form_status = false;
    if(isset($_GET['user_id_to_update'])) {
        $user_edition_form_status = true;

        $user_id_to_update = $_GET['user_id_to_update'];
        $result = mysqli_query($conn, "SELECT * FROM user WHERE id=$user_id_to_update");
        if($result){
            $user = mysqli_fetch_assoc($result);
        }else {
            echo "Error: ". mysqli_error($conn);
        }
    }

    //User Update button
    if(isset($_POST['updateButton'])) {
        $user_id = $_POST['user_id'];

        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $role = $_POST['role'];

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
        
        //Update User
        $query = "UPDATE user SET name='$name', email='$email', address='$address', password='$new_password', role='$role' WHERE id=$user_id";
        $result = mysqli_query($conn, $query);

        if($result) {
            echo "<script>alert('User update is successfully');</script>";
            header('location:admin_dashboard.php');
        }else {
            die('Error: '.mysqli_error($conn));
        } 
    }

    //User Delete
    if(isset($_REQUEST['user_id_to_delete'])) {
        $user_id_to_delete = $_REQUEST['user_id_to_delete'];

        $result = mysqli_query($conn, "DELETE FROM user WHERE id=$user_id_to_delete");
        if($result) {
            echo "<script>alert('User delete info.');</script>";
            header('location:admin_dashboard.php');
        }else {
            echo "Error: ".mysqli_error($conn);
        }
        
    }

?>
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
                                    <button type='submit' class="btn btn-danger my-2 float-end" onclick="return confirm('Are you sure you want to logout?')">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
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
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="card-title text-white">User List</h4>
                            </div>
                            <div class="card-body"> 
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-header bg-warning">
                                                <div class="card-title">
                                                    <!-- Admin info -->
                                                    <h5 class="text-center">Admin Info</h5>
                                                </div>
                                            </div>
                                            <div class="card-body bg-light">
                                                <div>
                                                    <label class="label-item">Role : </label>
                                                    <i class="bg bg-success text-white"><?php echo $_SESSION['user_array']['role'];  ?></i>
                                                </div>
                                                <div>
                                                    <label class="label-item">Name : </label>
                                                    <i><?php echo $_SESSION['user_array']['name'];  ?></i>
                                                </div>
                                                <div>
                                                    <label class="label-item">Email : </label>
                                                    <i><?php echo $_SESSION['user_array']['email'];  ?></i>
                                                </div>
                                                <div>
                                                    <label class="label-item">Address : </label>
                                                    <i><?php echo $_SESSION['user_array']['address'];  ?></i>
                                                </div>
                                            </div>
                                        </div>  
                                        <?php if($user_edition_form_status == true):  ?>
                                        <div class="card mt-3">
                                            <div class="card-header bg-success">
                                                <div class="card-title">
                                                    <h5>User Edition Form</h5>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <form action="admin_dashboard.php" method="post">
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
                                                    <div class="form-group mt-3">
                                                        <select name="role" class="form-control">
                                                            <option  value="">SELECT ROLE</option>
                                                            <option value="admin"
                                                            <?php if($user['role'] == 'admin') { ?>
                                                                selected
                                                            <?php } ?> >ADMIN</option>
                                                            <option value="user" 
                                                            <?php if($user['role'] == 'user') { ?>
                                                                selected
                                                            <?php } ?> 
                                                            >USER</option>
                                                        </select>
                                                    </div>
                                                    <div class="mt-3">
                                                        <button class="btn btn-primary btn-sm" name="updateButton" type="submit"  onclick="return confirm('Are you sure you want to Update?')">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <?php endif ?>
                                    </div>
                                    <div class="col-md-8">
                                        <table class="table table-bordered table-hover">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>NAME</th>
                                                    <th>EMAIL</th>
                                                    <th>ADDRESS</th>
                                                    <th>ROLE</th>
                                                    <th>ACTIONS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php    
                                                //Select all user Record

                                                $query = "SELECT * FROM user";
                                                $result = mysqli_query($conn, $query);
                                                foreach ($result as $user) { ?>
                                                <tr>
                                                    <td><?php echo $user['id']; ?></td>
                                                    <td><?php echo $user['name'];  ?></td>
                                                    <td><?php echo $user['email'];  ?></td>
                                                    <td><?php echo $user['address'];  ?></td>
                                                    <td><?php echo $user['role'];  ?></td>
                                                    <td>
                                                        <a class="btn btn-primary btn-sm" href="admin_dashboard.php?user_id_to_update=<?php echo $user['id']; ?>">Edit</a>
                                                        <a class="btn btn-danger btn-sm" href="admin_dashboard.php?user_id_to_delete=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                
                                            </tbody>
                                        </table>
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