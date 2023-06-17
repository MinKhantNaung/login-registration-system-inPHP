<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_array'])) {
    header('location: login.php');
} else {
    if ($_SESSION['user_array']['role'] != 'admin') {
        header('location: user-dashboard.php');
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
    <link rel="stylesheet" href="./css/bootstrap.min.css">
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
        die("Error: " . mysqli_error($dbconnection));
    }

    $user_edition_form_status = false;
    // User Edit
    if (isset($_GET['user_id_to_update'])) {
        $user_edition_form_status = true;
        $user_id_to_update = $_GET['user_id_to_update'];

        $query = "SELECT * FROM users WHERE id=$user_id_to_update";
        $result = mysqli_query($dbconnection, $query);

        if ($result) {
            $user = mysqli_fetch_assoc($result);
        } else {
            die('Error: ' . mysqli_error($dbconnection));
        }
    }

    $nameError = $emailError = $addressError = $roleError = $passwordError = '';
    // User Update
    if (isset($_POST['user_update_button'])) {
        $user_id = intval($_POST['user_id']);

        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $role = $_POST['role'];
        $input_password = $_POST['password'];

        $error = false;
        if ($name == '') {
            $nameError = 'User name is required';
            $error = true;
        }
        if ($email == '') {
            $emailError = 'Email field is required';
            $error = true;
        }
        if ($address == '') {
            $addressError = 'Address field is required';
            $error = true;
        }
        if ($role == '') {
            $roleError = 'Please select one role!';
            $error = true;
        }
        if ($input_password == '') {
            $passwordError = 'Password field is required!';
            $error = true;
        }

        if (!$error) {
            $result = mysqli_query($dbconnection, "SELECT * FROM users WHERE id=$user_id");
            $user_array = mysqli_fetch_assoc($result);
            $old_password = $user_array['password'];
            $new_password = $old_password != $input_password ? md5($input_password) : $input_password;  // ternary operator

            // if ($old_password == $input_password) {
            //     $new_password = $input_password;
            // } else {
            //     $new_password = md5($input_password);
            // }

            $query = "UPDATE users SET name='$name', email='$email', address='$address', password='$new_password', role='$role' WHERE id=$user_id";

            $result = mysqli_query($dbconnection, $query);
            $_SESSION['successMsg'] = 'User updated successfully!'; // start output buffering
            header('location: admin-dashboard.php');
            exit();
        } else {
            $_SESSION['nameError'] = $nameError;
            $_SESSION['emailError'] = $emailError;
            $_SESSION['addressError'] = $addressError;
            $_SESSION['roleError'] = $roleError;
            $_SESSION['passwordError'] = $passwordError;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    // USER DELETE
    if (isset($_REQUEST['user_id_to_delete'])) {
        $user_id_to_delete = $_REQUEST['user_id_to_delete'];

        $result = mysqli_query($dbconnection, "DELETE FROM users WHERE id=$user_id_to_delete");
        if ($result) {
            $_SESSION['successMsg'] = 'User deleted successfully!';
            header('location: admin-dashboard.php');
            exit();
        } else {
            die("Error: " . mysqli_error($dbconnection));
        }
    }

    // FOR CANCEL BUTTON IF YOU DON'T WANT TO UPDATE
    if (isset($_POST['cancel_button'])) {
        $user_edition_form_status = false;
    }
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
                                        <a href="admin-dashboard.php">
                                            Admin-Dashboard
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
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Admin Info</h6>
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
                                    </div>
                                </div>
                                <?php if ($user_edition_form_status == true) : ?>
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
                                                    <div class="text-danger">
                                                        <?php
                                                        if (isset($_SESSION['nameError'])) {
                                                            echo $_SESSION['nameError'];
                                                            unset($_SESSION['nameError']);
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $user['email']; ?>">
                                                    <div class="text-danger">
                                                        <?php
                                                        if (isset($_SESSION['emailError'])) {
                                                            echo $_SESSION['emailError'];
                                                            unset($_SESSION['emailError']);
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="address">Address</label>
                                                    <textarea name="address" id="address" class="form-control"><?php echo $user['address']; ?></textarea>
                                                    <div class="text-danger">
                                                        <?php
                                                        if (isset($_SESSION['addressError'])) {
                                                            echo $_SESSION['addressError'];
                                                            unset($_SESSION['addressError']);
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="text" name="password" id="password" class="form-control" value="<?php echo $user['password']; ?>">
                                                    <div class="text-danger">
                                                        <?php
                                                        if (isset($_SESSION['passwordError'])) {
                                                            echo $_SESSION['passwordError'];
                                                            unset($_SESSION['passwordError']);
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="role">Role</label>
                                                    <select name="role" id="role" class="form-select">
                                                        <option value="">Select Role</option>
                                                        <option value="admin" <?php if ($user['role'] == 'admin') : ?> selected <?php endif ?>>Admin</option>
                                                        <option value="user" <?php if ($user['role'] == 'user') : ?> selected <?php endif ?>>User</option>
                                                    </select>
                                                    <div class="text-danger">
                                                        <?php
                                                        if (isset($_SESSION['roleError'])) {
                                                            echo $_SESSION['roleError'];
                                                            unset($_SESSION['roleError']);
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" name="user_update_button" class="btn btn-primary">Update</button>
                                                <button type="submit" name="cancel_button" class="btn btn-outline-danger float-end">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                <?php endif ?>
                            </div>
                            <div class="col-md-8 table-responsive">
                                <h5>User List</h5>

                                <?php
                                if (isset($_SESSION['successMsg'])) { ?>
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong><?php
                                         echo $_SESSION['successMsg'];
                                                unset($_SESSION['successMsg']);
                                        ?></strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php
                                    
                                }
                                ?>

                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // SELECT ALL USERS RECORD
                                        $query = "SELECT * FROM users";
                                        $users = mysqli_query($dbconnection, $query);

                                        foreach ($users as $user) { ?>

                                            <tr>
                                                <td><?php echo $user['id']; ?></td>
                                                <td><?php echo $user['name']; ?></td>
                                                <td><?php echo $user['email']; ?></td>
                                                <td><?php echo $user['address']; ?></td>
                                                <td><?php echo $user['role']; ?></td>
                                                <td>
                                                    <a href="admin-dashboard.php?user_id_to_update=<?php echo $user['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                                    <a href="admin-dashboard.php?user_id_to_delete=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete?')">Delete</a>
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
</body>
<script src="./js/bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

</script>

</html>