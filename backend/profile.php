<?php

include 'DBConnection.php';

$userId = $_SESSION['user'];

$data = DBConnection::sharedInstance()->fetchUserData($userId);

if ($data) {
  $userData = $data['userData'];
  $referats = $data['referats'];
}

?>