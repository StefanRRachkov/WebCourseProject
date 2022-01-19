<?php

	include 'DBConnection.php';

	session_start();

	$email = $_POST['email'];
	$password = $_POST['pass'];
	$conn = DBConnection::sharedInstance()->login($email, $password);

	header('Location: index.php#login');

?>
