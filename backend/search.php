<?php 
    include 'DBConnection.php';

    $condition = '';
    $userId = $_SESSION['user'];

    if($userId != null){
        if(!empty($_POST['search']))
        {
            $condition = $_POST['search'];
        }
        $result = DBConnection::sharedInstance()->getReferatsWithConditions($userId, $condition);
    }
?>