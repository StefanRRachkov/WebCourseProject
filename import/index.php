<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="import.css">
    <title> Take-a-ref </title>
</head>

<?php
    include '../backend/DBConnection.php';
    session_start();

    $isLoggedIn = isset($_SESSION['user']);
    $hasError = isset($_SESSION['csvFileUploadError']);
    $canImport = isset($_SESSION['user_grade']) && ($_SESSION['user_grade'] > 1);

    if (!$isLoggedIn || !$canImport) {
        header('Location: ../index.php');
    }

    $courseEditions = DBConnection::sharedInstance()->getCourseEditions();
?>

<body>
    <section class="header">
        <nav>
            <a href="../"><img src="../assets/logo.png" height="100px"></a>
            
            <div class="nav-links">
                <ul>
                    <li><a href="../">HOME</a></li>
                    <?php 
                        if ($isLoggedIn) {
                            echo ' <li><a href="../backend/logout.php">LOG OUT</a></li>';
                        } else {
                            echo ' <li><a href="#login">LOG IN</a></li>';
                        }
                    ?>
                    <?php if ($isLoggedIn){
                            echo ' <li><a href="../profile">MY PROFILE</a></li>';
                            echo ' <li><a href="">IMPORT</a></li>';
                        }
                    ?>
                    <li><a href="../aboutus/aboutUs.php">ABOUT US</a></li>
                </ul>
            </div>
        </nav>
    </section>

    <section class="upload">
        <div class="upload-form-container">
            <div id="drop-pad" class="drag-and-drop-pad">
                <div class="drag-and-drop-pad-label">Drop file here</div>
            </div>

            <form id="file-form" action="../backend/import.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="uploaded-file" id="file-input" hidden required>

                <button id="upload-file-button" class="button">Upload file manually</button>

                <label for="edition">Edition</label>
                <select name="edition" id="edition" class="edition-picker">
                    <?php 
                        foreach ($courseEditions as $value) {
                            $edition = $value['CourseEditionID'];
                            echo "<option value='$edition'>$edition</option>";
                        } 
                    ?>
                </select>

                <input type="submit" name="submit" value="Import" id="file-form-submit-button" class="button" disabled>
            </form>

            <?php 
                if($hasError){
                    echo "<br><font color='yellow'>".$_SESSION['csvFileUploadError']."</font>";
                    unset($_SESSION['csvFileUploadError']);
                }
            ?>
        </div>
    </section>

    <section class="footer">
        <p>Тhis website is a course project ot three colleagues from the Faculty of Mathematics and Informatics 
            at Sofia University </p>
        <div class="icons">
            <a href="https://www.facebook.com/lusi.ivanova.17/" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://www.instagram.com/stefan.rachkov/" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com/in/emanuil-gospodinov" target="_blank"><i class="fab fa-linkedin"></i></a>
        </div>
    </section>
</body>

<script>
    const dropPad = document.getElementById('drop-pad');
    const uploadFileButton = document.getElementById("upload-file-button");
    const fileInput = document.getElementById("file-input");
    const submitButton = document.getElementById('file-form-submit-button');

    dropPad.addEventListener('drop', (event) => {
        event.preventDefault();

        if (event.dataTransfer.files.length) {
            fileInput.files = event.dataTransfer.files;

            changeButtonState(event.dataTransfer.files[0].name);
        }

        dropPad.classList.remove('drag-and-drop-pad-over')
    });

    dropPad.addEventListener('dragover', (event) => {
        event.preventDefault();
        dropPad.classList.add('drag-and-drop-pad-over');
    });

    ["dragleave", "dragend"].forEach((type) => {
        dropPad.addEventListener(type, (event) => {
            dropPad.classList.remove("drag-and-drop-pad-over");
        });
    });

    uploadFileButton.addEventListener("click", (event) => {
        event.preventDefault();

        fileInput.click();

    });

    fileInput.addEventListener("change", (event) => {
        changeButtonState(fileInput.files[0].name);

    });

    function changeButtonState(title){
        uploadFileButton.innerHTML = title;
        submitButton.disabled = false;
    }



</script>
</html>
