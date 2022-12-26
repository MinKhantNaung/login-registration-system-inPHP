<?php
session_start();
include('connect.php');
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
    $error = '';
    if (isset($_POST['loginButton'])) {
        $email = trim($_POST['email']);
        $password = md5(trim($_POST['password']));

        $user_result = mysqli_query($dbconnection, "SELECT * FROM users WHERE email='$email' AND password='$password'");

        $user_count = mysqli_num_rows($user_result);
        if ($user_count === 1) {
            $user_array = mysqli_fetch_assoc($user_result);
            
            $_SESSION['user_array'] = $user_array;
            if ($user_array['role'] == 'admin') {
                header('location: admin-dashboard.php');
            } else {
                header('location: user-dashboard.php');
            }
            
        } else {
            $error = 'Invalid Email or Password!';
        }
    }

    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-title">
                                    <h6>
                                        <a href="index.php">
                                            Home
                                        </a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <div class="card-title">Login</div>
                                    </div>
                                    <form action="./login.php" method="POST">
                                        <div class="card-body">
                                            <?php if ($error != '') { ?>
                                                <div class="alert alert-danger alert-dismissible fade show">
                                                    <?php echo $error; ?>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group my-3">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" class="form-control">
                                            </div>

                                            <div class="form-group my-3">
                                                <label for="password">Password</label>
                                                <input type="password" name="password" id="password" class="form-control">
                                            </div>

                                        </div>
                                        <div class="card-footer bg-info">
                                            <button type="submit" class="btn btn-danger" name="loginButton">
                                                Login
                                            </button>
                                            <span class="float-end">If you have no account,
                                                <a href="register.php">register here</a>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="./js/bootstrap.min.js"></script>

</html>