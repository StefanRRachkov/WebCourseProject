<?php

session_start();
unset($_SESSION['regError']);

$email = $_POST['email'];
$password = $_POST['pass'];

if(strlen($password) < 6){
	$_SESSION['regError'] = "Password is too short";
	finish();
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	$_SESSION['regError'] = "Incorrect Email Syntax";
	finish();
}

if($password != $_POST['pass2']){
	$_SESSION['regError'] = "Passwords are different";
	finish();
}

$hashed_password = sha1($password);

//---------insert record in DB--------------------------------------
try {
	$conn = new PDO('mysql:host=localhost;dbname=web_take_a_ref', 'root', '');	
	$sql = 'INSERT INTO Users (email, password) VALUES (?, ?)';
	$stmt = $conn->prepare($sql);
	$result = $stmt->execute(array($email, $hashed_password));

	if ($result && $stmt->rowCount() == 1) {
		$_SESSION['user'] = $email;
	}
	finish();
}
catch(Exception $e) {
	$error = $stmt->errorInfo();
    if ($error[1] == 1062) {
		$_SESSION['regError'] = 'Email is already registered';
    } 
	else{
		$_SESSION['regError'] = "No connection with DB<br>".$e->getMessage();
	}
	//var_dump($e->getMessage());
	finish();
}

function finish(){
	header('Location: index.php#login');
	exit();
}
	


?>