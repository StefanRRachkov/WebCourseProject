<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.css">
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
                    <li><a href="../aboutus/aboutUs.php">ABOUT US</a></li>
                </ul>
            </div>
        </nav>
    </section>

    <section class="profile">
        <div class="profile-container">
            <?php 
                if(isset($_SESSION['profileError'])){
                    $error = $_SESSION['profileError'];
                    echo $error != null ? "<font color='red'>$error</font>" : null;
                    unset($_SESSION['profileError']);
                }
            ?>

            <h2><?php echo $userData['EMail']; ?></h2>

            <p>Taken by you:</p>

            <p class='empty-message' <?php echo count($referats) > 0 ? 'hidden' : '' ?>>You have not taken any referats :(</p>

            <table class="referat-list" <?php echo count($referats) == 0 ? 'hidden' : '' ?>>            
                <?php 
                    foreach ($referats as $ref) {
                        $title = $ref['Title'];
                        $id = $ref['Book_ID'];
                        $edition = $ref['CourseEdition'];

                        $link = Constants::$linkPrefix.$ref['Link'];

                        $deadline = date_create($ref['Deadline']);
                        $today = date_create(date_format(new DateTime(), 'Y-m-d'));
                        $daysLeft = $deadline->diff($today)->d;

                        $button = "<button class='return-button' referat-id=$id onClick='remove(event)'>Return</button>";

                        echo "<tr>";
                            echo "<td><a href='$link'>$title</a></td>";
                            echo "<td>Edition $edition</td>";
                            echo "<td ".($daysLeft <= 3 ? 'class="important-info"' : '').">$daysLeft day".($daysLeft > 1 ? 's' : '')." left</td>";
                            echo "<td>$button</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
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

                element.closest('tr').remove()

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
