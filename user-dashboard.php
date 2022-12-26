<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_array'])) {
    header('location: login.php');
} else {
    if ($_SESSION['user_array']['role'] != 'user') {
        header('location: admin-dashboard.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Registration System</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <!--bootstrap CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            padding-top: 2px;
        }

        a {
            color: whitesmoke;
        }
    </style>
</head>

<body>

    <?php
    // READ AUTHENTICATED USER DATA
    $authenticated_user_id = $_SESSION['user_array']['id'];

    $auth_user_result = mysqli_query($dbconnection, "SELECT * FROM users WHERE id=$authenticated_user_id");

    if ($auth_user_result) {
        $auth_user_array = mysqli_fetch_array($auth_user_result);
    } else {
        die("Error: ". mysqli_error($dbconnection));
    }
    // Edit
    $user_edition_form_status = false;
    if (isset($_REQUEST['user_id_to_update'])) {
        $user_edition_form_status = true;
        $user_id_to_update = $_REQUEST['user_id_to_update'];

        $result = mysqli_query($dbconnection, "SELECT * FROM users WHERE id=$user_id_to_update");

        if ($result) {
            $user = mysqli_fetch_assoc($result);
        } else {
            die("Error: " . mysqli_error($dbconnection));
        }
    }

    // UPDATE
    if (isset($_POST['user_update_btn'])) {
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        $result = mysqli_query($dbconnection, "SELECT * FROM users WHERE id=$user_id");
        $user_array = mysqli_fetch_assoc($result);
        $old_password = $user_array['password'];
        $input_password = $_POST['password'];

        $new_password = $old_password != $input_password ? md5($input_password) : $input_password;
        
        $update_user = mysqli_query($dbconnection, "UPDATE users SET name='$name', email='$email', address='$address', password='$new_password' WHERE id=$user_id");

        if ($update_user) {
            // $_SESSION['expired_time'] = time() + (0.01 * 60);
            // $_SESSION['success_msg'] = '<script>swal("Good job!", "Your Profile Updated Successfully", "success");</script>';  // for sweet alert
            header('location: user-dashboard.php');
        } else {
            die('Error: '. mysqli_error($dbconnection));
        }
    } 

    // if (time() < $_SESSION['expired_time']) {  // for sweet alert
    //     echo $_SESSION['success_msg'];
    // } else {
    //     unset($_SESSION['success_msg']);
    //     unset($_SESSION['expired_time']);
    // }
    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="card-title">
                                    <h6>
                                        <a href="user-dashboard.php">
                                            User-Dashboard
                                        </a>
                                    </h6>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                <form action="logout.php" method="GET">
                                    <button type="submit" class="btn btn-danger btn-sm float-end" onclick="return confirm('Are you sure you want to logout?')">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>User Info</h6>
                                        <div>
                                            Role:
                                            <span class="badge bg-success">
                                                <?php echo $auth_user_array['role']; ?>
                                            </span>
                                        </div>
                                        <div>
                                            Name: <?php echo $auth_user_array['name']; ?>
                                        </div>
                                        <div>
                                            Email: <?php echo $auth_user_array['email']; ?>
                                        </div>
                                        <div>
                                            Address: <?php echo $auth_user_array['address']; ?>
                                        </div>
                                        <div>
                                            Password: <?php echo $auth_user_array['password']; ?>
                                        </div>
                                        <div>
                                            <a href="user-dashboard.php?user_id_to_update=<?php echo $auth_user_array['id']; ?>" class="btn btn-success btn-sm">Edit Your Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php if($user_edition_form_status == true) : ?>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">User Edition Form</div>
                                    </div>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                        <div class="card-body">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id'] ?>">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" id="name" class="form-control" value="<?php echo $user['name']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" class="form-control" value="<?php echo $user['email']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <textarea name="address" id="address" class="form-control"><?php echo $user['address']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="text" name="password" id="password" class="form-control" value="<?php echo $user['password']; ?>">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" name="user_update_btn" class="btn btn-primary">Update</button>
                                            <button type="submit" name="cancel_button" class="btn btn-outline-danger float-end">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                                <?php endif ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="./js/bootstrap.min.js"></script>
<!--Bootstrap JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</html>