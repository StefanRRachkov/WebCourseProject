<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- for icons -->
    <link rel="stylesheet" href="../assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="aboutUs.css">

    <title> Take-a-ref </title>

</head>

<?php
    session_start();

    $isLoggedIn = isset($_SESSION['user']);
    $canImport = isset($_SESSION['user_grade']) && ($_SESSION['user_grade'] > 1);
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
                            echo ' <li><a href="../#login">LOG IN</a></li>';
                        }
                    ?>
                    <?php if ($isLoggedIn){
                            echo ' <li><a href="../profile">MY PROFILE</a></li>';
                            if ($canImport){
                              echo ' <li><a href="../import">IMPORT</a></li>';
                            }
                        }
                    ?>
                    <li><a href="">ABOUT US</a></li>
                </ul>
            </div>
        </nav>
    </section>


<!-- <style>
.we {
    display: block;
    margin-left: auto;
    margin-right: auto;
    /* width: 50%; */
    width: 150px;
    height: 150px;
    border: solid 2px #630737;
    border-radius: 50%;
    justify-content: space-between;

}
</style>
<h2>About Us</h2>
<img src="../assets/background.jpg" class="we">
<img src="../assets/background.jpg" class="we">
<img src="../assets/background.jpg" class="we"> -->

<!-- ---------------------------------------------------------------------------------------------------------- -->
<style>
/* body, html {
  height: 100%;
  margin: 0;
  font-family:sans-serif;
}

.lusi-image {
  background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url("../assets/l.jpg");
  height: 100%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
}

.emo-image {
  background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url("../assets/e.jpg");
  height: 100%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
}

.stef-image {
  background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url("../assets/s.jpg");
  height: 100%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
}

.hero-text {
  text-align: left;
  position: absolute;
  top: 40%;
  left: 10%;
  color: white;
} */


</style>
</head>
<body>

<div class="lusi-image">
  <div class="hero-text">
    <h1 style="font-size:40px">Lyubka Vracheva</h1>
    <p>Computer Science<br>
    IV course<br>
    Faculty number 81776<br>
    Web Course Edition 17<br>
    lu2000@abv.bg
  </div>
</div>
<div class="emo-image">
  <div class="hero-text">
    <h1 style="font-size:40px">Emanuil Gospodinov</h1>
    <p>Computer Science<br>
    IV course<br>
    Faculty number 81770<br>
    Web Course Edition 17<br>
    gospodinove@gmail.com
  </div>
</div>
<div class="stef-image">
  <div class="hero-text">
    <h1 style="font-size:40px">Stefan Rachkov</h1>
    <p>Computer Science<br>
    IV course<br>
    Faculty number 81801<br>
    Web Course Edition 17<br>
    stefan.r.rachkov@gmail.com
  </div>
</div>
<!-- ----------------------------------------------------------------------------------------------------------------- -->



    <section class="footer">
        <p>Тhis website is a course project of three colleagues from the Faculty of Mathematics and Informatics 
            at Sofia University </p>
        <div class="icons">
            <a href="https://www.facebook.com/lusi.ivanova.17/" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://www.instagram.com/stefan.rachkov/" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com/in/emanuil-gospodinov" target="_blank"><i class="fab fa-linkedin"></i></a>
        </div>
    </section>

</body>
</html>
