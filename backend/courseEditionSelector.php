<?php
    session_start();
    $courseEdition = $_POST['courseEdition'] or $_REQUEST['courseEdition'];

    if($courseEdition != null)
    {
        $_SESSION['user_courseedition'] = $courseEdition;
    }
?>