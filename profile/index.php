<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="profile.css">
    <title>Take-a-ref</title>
</head>

<?php
    session_start();

    include '../backend/profile.php';

    $isLoggedIn = isset($_SESSION['user']);

    if (!$isLoggedIn) {
        header('Location: ../index.php');  
    }
?>

<body>
    <section class="header">
        <nav>
            <a href="../"><img src="../assets/logo.png" height="100px"></a>
            
            <div class="nav-links">
                <ul>
                    <li><a href="../">HOME</a></li>
                    <?php if ($isLoggedIn){
                            echo ' <li><a href="../backend/logout.php">LOG OUT</a></li>';
                        }else{
                            echo ' <li><a href="#login">LOG IN</a></li>';
                        }
                    ?>
                    <?php if ($isLoggedIn){
                            echo ' <li><a href="">MY PROFILE</a></li>';
                            echo ' <li><a href="../import">IMPORT</a></li>';
                        }
                    ?>
                    <li><a href="#aboutUs">ABOUT US</a></li>
                </ul>
            </div>
        </nav>
    </section>

    <section class="profile">
        <div class="profile-container">
            <?php 
                $error = $_SESSION['profileError'];
                echo $error != null ? "<font color='red'>$error</font>" : null;
                unset($_SESSION['profileError']);
            ?>

            <h2><?php echo $userData['EMail']; ?></h2>

            <p>Taken by you:</p>

            <p class='empty-message' <?php echo count($referats) > 0 ? 'hidden' : '' ?>>You have not taken any referats :(</p>

            <ul class="referat-list" <?php echo count($referats) == 0 ? 'hidden' : '' ?>>
                <?php 
                    foreach ($referats as $ref) {
                        $title = $ref['Title'];
                        $id = $ref['Book_ID'];

                        $button = "<button class='return-button' referat-id=$id onClick='remove(event)'>Return</button>";

                        echo "<li><a href='#'>$title</a>$button</li>";
                    }
                ?>
            </ul>
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

    <script>
        function remove(event) {
            const element = event.target
            const referatId = element.getAttribute('referat-id')

            const xhttp = new XMLHttpRequest()
            xhttp.open("POST", "../backend/returnReferat.php")
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState !== 4 || xhttp.status !== 200) {
                    return
                }

                element.closest('li').remove()

                maybeShowEmptyMessage()
            }
            xhttp.send("referatId="+referatId)
        }

        function maybeShowEmptyMessage() {
            const list = document.getElementsByClassName('referat-list')[0]

            if (list.childElementCount > 0) {
                return
            }

            const emptyMessageElement = document.createElement('p')
            emptyMessageElement.classList.add("empty-message")
            emptyMessageElement.append('You have not taken any referats :(')

            list.parentElement.appendChild(emptyMessageElement)

            list.remove()
        }
    </script>
</body>
</html>