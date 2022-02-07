<?php 
    include 'DBConnection.php';

    $condition = '';
    $userId = $_SESSION['user'];

    if($userId != null){
        if(!empty($_POST['search']))
        {
            $condition = $_POST['search'];
        }
        $new_course_edition = $_POST['courseEdition'] or $_REQUEST['courseEdition'];
        $course_edition = $_SESSION['user_courseedition'];
        $result = DBConnection::sharedInstance()->getReferatsWithConditions($userId, $condition, $course_edition);
    }
?>