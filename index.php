<?php

include ('connect.php');

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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="card-title">
                                    <h6>
                                        <a href="index.php">
                                            Home 
                                        </a>
                                    </h6>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                <a href="./register.php" class="float-end ms-3">
                                    <h6>Register</h6>
                                </a>
                                <a href="./login.php" class="float-end">
                                    <h6>Login</h6>
                                </a>
                            </div>
                        </div>                        
                    </div>
                    <div class="card-body">
                        <h5>About Our Website</h5>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facilis voluptates earum quam, ex natus adipisci, expedita illum aperiam similique beatae accusamus distinctio eius odio, rerum saepe sit nulla ea! Recusandae.</p>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iure fugiat ipsa iusto quod labore libero neque, animi earum facere dolor beatae, debitis accusantium, veniam amet temporibus inventore atque reprehenderit culpa.</p>
                        <p>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Adipisci sint, a fuga repellendus nesciunt explicabo atque, ducimus, aliquam recusandae cumque quia vel sunt repellat et veritatis debitis quaerat provident molestias!
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel culpa aliquid placeat distinctio nesciunt nulla quaerat rem dicta cum! Nisi perferendis incidunt dolore veniam sint ad non eius quis ut.
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium recusandae sed cum aliquam dolorum molestiae dolor itaque voluptatibus! Magni nulla facere, rem laborum itaque quis dolorum commodi dicta error minus?
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="./js/bootstrap.min.js"></script>
</html>