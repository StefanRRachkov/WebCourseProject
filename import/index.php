<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="import.css">
    <title> Take-a-ref </title>
</head>

<?php
    session_start();

    $isLoggedIn = isset($_SESSION['user']);
    $hasError = isset($_SESSION['csvFileUploadError']);

    if (!$isLoggedIn) {
        header('Location: ../index.php');  
    }
?>

<body>
    <section class="header">
        <nav>
            <a href="index.php"><img src="../assets/logo.png" height="100px"></a>
            
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
                            echo ' <li><a href="#">IMPORT</a></li>';
                        }
                    ?>
                    <li><a href="#aboutUs">ABOUT US</a></li>
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
                <input type="file" name="uploaded-file" id="file-input" hidden>
                <button id="upload-file-button" class="button">Upload file manually</button>
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
        <h4 id="aboutUs" >About Us</h4>
        <p>Тhree colleagues from the Faculty of Mathematics and Informatics 
            at Sofia University </p>
        <div class="icons">
            <i class="fa fa-facebook"></i>
            <i class="fa fa-twitter"></i>
            <i class="fa fa-instagram"></i>
            <i class="fa fa-linkedin"></i>

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

        document.getElementById('file-input').click();
    });

    fileInput.addEventListener('change', (event) => {
        const fileName = fileInput.files[0].name;

        uploadFileButton.innerHTML = fileName;
        
        submitButton.disabled = false;
    });
</script>
</html>