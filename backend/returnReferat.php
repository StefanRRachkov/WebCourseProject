<?php

include 'DBConnection.php';

session_start();

$referatId = $_POST['referatId'] or $_REQUEST['referatId'];
$userId = $_SESSION['user'];

DBConnection::sharedInstance()->returnReferat($userId, $referatId);

?>