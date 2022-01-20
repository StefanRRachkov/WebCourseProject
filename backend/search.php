<?php 
    include 'DBConnection.php';

    $condition = '';
    if(!empty($_POST['search']))
    {
        $condition = $_POST['search'];
    }

    $result = DBConnection::sharedInstance()->getReferatsWithConditions($condition);
?>