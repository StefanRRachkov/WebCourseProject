<?php

include 'DBConnection.php';

$userData = DBConnection::sharedInstance()->fetchUserData();

?>