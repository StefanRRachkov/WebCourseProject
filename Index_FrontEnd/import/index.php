<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="import.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title> Take-a-ref </title>
</head>

<?php
    session_start();

    if (isset($_SESSION['user'])) {
        $hidden = 'hidden';
    }else{
        $hidden='';
    }
?>

<body>
    <section class="header">
        <nav>
            <a href="index.php"><img src="../logo.png" height="100px"></a>
            
            <?php
            if (isset($_SESSION['user'])) {
                echo '<font color="yellow">'.$_SESSION['user'].'</font>';
            }
            ?>
            
            <div class="nav-links">
                <ul>
                    <li><a href="">HOME</a></li>
                    <?php if ($hidden){
                            echo ' <li><a href="logout.php">LOG OUT</a></li>';
                        }else{
                            echo ' <li><a href="#login">LOG IN</a></li>';
                        }
                    ?>
                    <?php if ($hidden){
                            echo ' <li><a href="">MY PROFILE</a></li>';
                        }
                    ?>
                    <!-- <li><a href="">MY PROFILE</a></li> -->
                    <li><a href="#aboutUs">ABOUT US</a></li>
                </ul>
            </div>
        </nav>
    </section>

    <section class="upload" <? echo $hidden ?>>
        <div class="upload-form-container">
            <div class="upload-drag-and-drop-pad">
                <div class="upload-drag-and-drop-pad-label">Drop file here</div>
            </div>

            <form id="file-form" action="../../Index_BackEnd" method="POST">
                <input type="file" name="uploaded-file" id="file-input" hidden>
                <button id="upload-file-button" class="button">Upload file manually</button>
                <input type="submit" id="file-form-submit-button" class="button" disabled>
            </form>
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
    document.getElementById("upload-file-button").addEventListener("click", (event) => {
        event.preventDefault();

        document.getElementById('file-input').click();
    });

    document.getElementById("file-input").addEventListener('change', (event) => {
        const submitButton = document.getElementById('file-form-submit-button');
        const fileInput = document.getElementById('file-input');
        const fileName = fileInput.files[0].name;

        const fileUploadButton = document.getElementById("upload-file-button");

        fileUploadButton.innerHTML = fileName;
        
        submitButton.disabled = false;
    });
</script>
</html>