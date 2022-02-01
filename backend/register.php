<?php

include 'DBConnection.php';

session_start();
unset($_SESSION['regError']);

$email = $_POST['email'];
$password = $_POST['pass'];
$pass2 = $_POST['pass2'];
$first_name = $_POST['name'];
$last_name = $_POST['name2'];
$course_edition = $_POST['edition'];
$faculty_number = $_POST['fn'];

DBConnection::sharedInstance()->register($email, $password, $pass2, $first_name, $last_name, $course_edition, $faculty_number);

?>
