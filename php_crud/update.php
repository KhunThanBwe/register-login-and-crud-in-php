<?php
    session_start();
    require 'dbconnection.php';
    //update button
    if(isset($_GET['update_id'])) {
        $update_id = $_GET['update_id'];
        
        $query = "SELECT * FROM post WHERE id=$update_id";
        $result = mysqli_query($db, $query);

        //Filter row 
        if(mysqli_num_rows($result) == 1 ) {
            foreach($result as $row) {
                $postId = $row['id'];
                $tTitle = $row['title'];
                $dDesc = $row['description'];
            }
        }
        
    }
    
    $tError = "";
    $dError = "";
    //Update Post
    if(isset($_POST['update_button'])) {
        $postId = $_POST['post_id'];
        $title = $_POST['title'];
        $desc = $_POST['description'];

        //Validation
        if(empty($title)) {
            $tError = "The title is field required";
        }
        if(empty($desc)) {
            $dError = "The description is field required";
        }

        if(!empty($title) && !empty($desc)) {
            $query = "UPDATE post SET title='$title', description='$desc' WHERE id=$postId";
            $result = mysqli_query($db, $query);

            if($result) {
                echo "<script>alert('A Post Update successfully');</script>";
                $_SESSION['successMsg'] = "A Post Update Successfully";
                header('location:home.php');
            }else {
                echo ('ERROR: '. mysqli_error($db));
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card mt-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h2>Update Form</h2>
                            </div>
                            <div class="col-md-6">
                                <a class="btn btn-light float-end mt-2" href="home.php"> << Back </a>
                            </div>
                        </div>
                    </div>
                    <form action="update.php" method="post">
                    <div class="card-body">
                        <input type="hidden" name="post_id" id="" value="<?php echo $postId; ?>">
                        <div class="form-group">
                            <label for="title">TITLE</label>
                            <input class="form-control<?php if($tError != "") {?> is-invalid<?php } ?>" type="text" name="title" id="title" value="<?php echo $tTitle; ?>">
                            <i class="text-danger"><?php echo $tError; ?></i>
                        </div>
                        <div class="form-group">
                            <label for="description">DESCRIPTION</label>
                            <textarea class="form-control<?php if($dError != "") { ?> is-invalid <?php } ?>" name="description" id="description"><?php echo $dDesc; ?></textarea>
                            <i class="text-danger"><?php echo $dError; ?></i>
                            </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary btn-sm" name="update_button" type="submit">Create</button>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</body>
</html>