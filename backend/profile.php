<?php

include 'DBConnection.php';

$userId = $_SESSION['user'];

$data = DBConnection::sharedInstance()->fetchUserData($userId);

$referats = [];

// return referats that are overdue
foreach ($data['referats'] as $ref) {
  $deadline = date_create($ref['Deadline']);
  $today = date_create(date_format(new DateTime(), 'Y-m-d'));

  if ($today > $deadline) {
    DBConnection::sharedInstance()->returnReferat($userId, $ref['Book_ID']);
  } else {
    array_push($referats, $ref);
  }
}

if ($data) {
  $userData = $data['userData'];
  $referats = $referats;
}

?>