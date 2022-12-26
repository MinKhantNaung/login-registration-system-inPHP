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

<?php

include('connect.php');

$nameError = '';
$emailError = '';
$addressError = '';
$passwordError = '';
$confirmPasswordError = '';

$name = $email = $address = $password = $confirmPassword = '';

if (isset($_POST['register_button'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($name)) {
        $nameError = 'The name field is required!';
    }
    if (empty($email)) {
        $emailError = 'The email field is required!';
    }
    if (empty($address)) {
        $addressError = 'The address field is required!';
    }
    if (empty($password)) {
        $passwordError = 'The password field is required!';
    }
    if (empty($confirmPassword)) {
        $confirmPasswordError = 'The confirm password field is required!';
    }
    if ($confirmPassword != $password) {
        $confirmPasswordError = 'The password does not match!';
    }

    if (!empty($name) && !empty($email) && !empty($address) && !empty($password) && !empty($confirmPassword) && $confirmPassword == $password) {

        $encryptPassword = md5($password);

        $query = "INSERT INTO users(name, email, address, password) VALUES('$name', '$email', '$address', '$encryptPassword')";
        $result = mysqli_query($dbconnection, $query);

        if ($result) {
            echo "<script>alert('Registration Success')</script>";
            header('location: login.php');
        } else {
            echo "<script>alert('Registration Fail!')</script>";
        }
    }
}

?>

<body>
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
                                <form action="register.php" method="POST">
                                    <div class="card">
                                        <div class="card-header bg-info">
                                            <div class="card-title">Register</div>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group my-3">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" id="name" class="form-control <?php if ($nameError != '') { ?> is-invalid <?php } ?>" value="<?php echo $name; ?>">
                                                <i class="text-danger">
                                                    <?php echo $nameError; ?>
                                                </i>
                                            </div>
                                            <div class="form-group my-3">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" class="form-control <?php if ($emailError != '') { ?> is-invalid <?php } ?>" value="<?php echo $email; ?>">
                                                <i class="text-danger">
                                                    <?php echo $emailError; ?>
                                                </i>
                                            </div>
                                            <div class="form-group my-3">
                                                <label for="address">Address</label>
                                                <textarea name="address" id="address" class="form-control <?php if ($addressError != '') { ?> is-invalid <?php } ?>" rows="3"><?php echo $address; ?></textarea>
                                                <i class="text-danger">
                                                    <?php echo $addressError; ?>
                                                </i>
                                            </div>
                                            <div class="form-group my-3">
                                                <label for="password">Password</label>
                                                <input type="password" name="password" id="password" class="form-control <?php if ($passwordError != '') { ?> is-invalid <?php } ?>" value="<?php echo $password; ?>">
                                                <i class="text-danger">
                                                    <?php echo $passwordError; ?>
                                                </i>
                                            </div>
                                            <div class="form-group my-3">
                                                <label for="confirm-password">Confirm Password</label>
                                                <input type="password" name="confirm_password" id="confirm-password" class="form-control <?php if ($confirmPasswordError != '') { ?> is-invalid <?php } ?>" value="<?php echo $confirmPassword; ?>">
                                                <i class="text-danger">
                                                    <?php echo $confirmPasswordError; ?>
                                                </i>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-info">
                                            <button type="submit" name="register_button" class="btn btn-danger">Register</button>
                                            <span class="float-end">If you already have account,
                                                <a href="login.php">login here</a>
                                            </span>
                                        </div>
                                    </div>
                                </form>
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