<?php

$dbconnection = mysqli_connect('localhost', 'root', '', 'login_registration_system');

if(!$dbconnection) {
  die('Error:' . mysqli_connect_error());  
} 

?>