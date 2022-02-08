<?php 
    include 'DBConnection.php';

    $condition = '';
    $userId = $_SESSION['user'];
    $course_edition = $_SESSION['user_courseedition'];

    if($userId != null){

        if(!empty($_POST['search']))
        {
            $condition = $_POST['search'];
        }

        $result = DBConnection::sharedInstance()->getReferatsWithConditions($userId, $condition, $course_edition);
    }
?>