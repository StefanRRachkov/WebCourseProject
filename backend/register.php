<?php

include '../Index_BackEnd/DBConnection.php';

session_start();
unset($_SESSION['regError']);

$email = $_POST['email'];
$password = $_POST['pass'];
$pass2 = $_POST['pass2'];

$conn = DBConnection::sharedInstance()->register($email, $password, $pass2);

?>
