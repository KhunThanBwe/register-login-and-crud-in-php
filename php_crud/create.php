<?php
    session_start();
    require "dbconnection.php";

    $tError = "";
    $dError = "";

    if(isset($_POST['create_button'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];

        // Validation for title and description
        if(empty($title)) {
            $tError = "The title is field required";
        }
        if(empty($description)) {
            $dError = "The description is field required";
        }
        if(!empty($title) && !empty($description) ) {

            // Create Post
            $sql = "INSERT INTO post(title, description) VALUES ('$title', '$description')";
            $create_result = mysqli_query($db, $sql);
            
            if($create_result) {
                echo "<script>alert('Are you sure Create?');</script>";
                $_SESSION['successMsg'] = "A Post Created Successfully";
                header('location:home.php');
            }else {
                die('ERROR: '. mysqli_error($db));
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
                                <h2>Create Form</h2>
                            </div>
                            <div class="col-md-6">
                                <a class="btn btn-light float-end mt-2" href="home.php"> << Back </a>
                            </div>
                        </div>
                    </div>
                    <form action="create.php" method="post">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">TITLE</label>
                            <input class="form-control<?php if($tError != "") { ?> is-invalid <?php } ?>" type="text" name="title" id="title" placeholder="Please Enter Title">
                            <i class="text-danger"><?php echo $tError; ?></i>
                        </div>
                        <div class="form-group">
                            <label for="description">DESCRIPTION</label>
                            <textarea class="form-control<?php if($dError != "") { ?> is-invalid <?php } ?>" name="description" id="description" placeholder="Please Enter Description"></textarea>
                            <i class="text-danger"><?php echo $dError; ?></i>
                            </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success btn-sm" name="create_button" type="submit">Create</button>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</body>
</html>