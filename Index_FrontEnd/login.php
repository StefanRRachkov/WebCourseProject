<?php

	session_start();

	$email = $_POST['email'];
	$password = $_POST['pass'];
	$hashed_password = sha1($password);

	//check if login data is valid
	try {
		$conn = new PDO('mysql:host=localhost;dbname=web_take_a_ref', 'root', '');	
		$sql = 'SELECT * FROM Users WHERE email=? and password = ?';
		$stmt = $conn->prepare($sql);
		$result = $stmt->execute(array($email, $hashed_password));

		if ($result && $stmt->rowCount() == 1) {
			$_SESSION['user'] = $email;
		}
		else{
			$_SESSION['loginError'] = "Wrong email or password";
		}
	}
	catch(Exception $e) {
		$_SESSION['loginError'] = "No connection with DB";
		//var_dump($e->getMessage());
	}

	header('Location: index.php#login');

	


?>