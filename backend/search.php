<?php 
    include 'DBConnection.php';

    $condition = '';
    if(!empty($_POST['search']))
    {
        $condition = $_POST['search'];
    }

    $userId = $_SESSION['user'];

    $result = DBConnection::sharedInstance()->getReferatsWithConditions($userId, $condition);
?>