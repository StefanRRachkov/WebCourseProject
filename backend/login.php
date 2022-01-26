<?php

include 'DBConnection.php';

session_start();

$email = $_POST['email'];
$password = $_POST['pass'];

DBConnection::sharedInstance()->login($email, $password);

header('Location: ../index.php#login');

?>
