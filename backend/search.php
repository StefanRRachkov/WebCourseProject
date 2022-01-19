<?php 
    include 'DBConnection.php';

    session_start();
    
    $result = DBConnection::sharedInstance()->getAllFrom('REF_LIBRARY');
?>