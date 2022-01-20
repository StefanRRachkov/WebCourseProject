<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="main.css">

    <!-- for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title> Take-a-ref </title>

</head>

<?php
    session_start();

    $isLoggedIn = isset($_SESSION['user']);
?>

<body>
    <section class="header">
        <nav>
            <a href="index.php"><img src="assets/logo.png" height="100px"></a>
            
            <div class="nav-links">
                <ul>
                    <li><a href="#">HOME</a></li>
                    <?php if ($isLoggedIn){
                            echo ' <li><a href="backend/logout.php">LOG OUT</a></li>';
                        }else{
                            echo ' <li><a href="#login">LOG IN</a></li>';
                        }
                    ?>
                    <?php if ($isLoggedIn){
                            echo ' <li><a href="profile">MY PROFILE</a></li>';
                            echo ' <li><a href="import">IMPORT</a></li>';
                        }
                    ?>
                    <li><a href="#aboutUs">ABOUT US</a></li>
                </ul>
            </div>
        </nav>
        <div class="text-box">
            <h1>Take a Referat!</h1>
            <p>On this platform you can import or export one or more referats.
                <br>Read texts on different topics or provide other users with interesting
                information on your favourite topics.
            </p>
            <a href="search/index.php" class="contact-btn">Explore!</a>
        </div>

    </section>

    <section class="login" <?php echo $isLoggedIn ? 'hidden' : '' ?>>
        <h2 id="login">Log In/Register</h2>

        <div class="signup">
            <form class="signup-col" method="post" action="backend/login.php">
                <h3>Login Here</h3>

                <?php 
                    if(isset($_SESSION['loginError'])){
                    echo "<br><font color='yellow'>".$_SESSION['loginError']."</font>";
                    unset($_SESSION['loginError']);
                    }
                ?>

                <label for="email"> E-mail </label>
                <input id="email" name="email" type="email" placeholder="E-mail" required>

                <label for="pass"> Password </label>
                <input id="pass" name="pass" type="password" placeholder="Password" required>
                
                <button>Log In</button>
            </form>

            <form class="signup-col" method="post" action="backend/register.php">
                <h3>Register Here</h3>

                <?php 
                    if(isset($_SESSION['regError'])){
                    echo "<br><font color='yellow'>".$_SESSION['regError']."</font>";
                    unset($_SESSION['regError']);
                    }
                ?>

                <label for="email"> E-mail </label>
                <input id="email" name="email" type="email" placeholder="E-mail" required>
                
                <label for="pass"> Password </label>
                <input id="pass" name="pass" type="password" placeholder="Password" required>
                
                <label for="pass2"> Repeat Password </label>
                <input id="pass2" name="pass2" type="password" placeholder="Repeat Password" required>

                <button>Register</button>
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

</html>