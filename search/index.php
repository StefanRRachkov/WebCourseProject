<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="../main.css">
    <link rel="stylesheet" href="search.css">
    <title>Take-A-Ref</title>
</head>

<?php
    session_start();

    include '../backend/search.php';

    $isLoggedIn = isset($_SESSION['user']);

    if (!$isLoggedIn) {
        header('Location: ../index.php');  
    }
?>

<body>
    <div class="header-content">
        <nav>
            <a href="../index.php"><img src="../assets/logo.png" height="100px"></a>
            <div class="nav-links">
                <ul>
                    <li><a href="../">HOME</a></li>
                    <?php if ($isLoggedIn){
                            echo ' <li><a href="../backend/logout.php">LOG OUT</a></li>';
                        }else{
                            echo ' <li><a href="../#login">LOG IN</a></li>';
                        }
                    ?>
                    <?php if ($isLoggedIn){
                            echo ' <li><a href="../profile">MY PROFILE</a></li>';
                            echo ' <li><a href="../import/index.php">IMPORT</a></li>';
                        }
                    ?>
                    <li><a href="#aboutUs">ABOUT US</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <div id="search_box" class="main-content">
        <div class="search-box">
            <div id="wrap">
              <form name="form" method="post" action="#" autocomplete="on">
                <input id="search" name="search" type="text" placeholder="What are we looking for ?">
                <input id="search_submit" value="Rechercher" type="submit">
              </form>
            </div>
        </div>
    </div>
    <div class="display">
        <div class="library">

        </div>
    </div>
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

<script>
  var library = <?php 
      echo json_encode($result); 
    ?>;
  var library_content = document.getElementsByClassName('library')[0];

  library.forEach(ref => {
    var ref_card = document.createElement("div");
    ref_card.classList.add("card");

    var ref_content = document.createElement("div");
    ref_content.classList.add("content");

    var ref_title = document.createElement("h2");
    ref_title.classList.add("title");
    ref_title.innerHTML = ref["Title"];

    var ref_btn = document.createElement("button");
    ref_btn.setAttribute("id", ref["Book_ID"]);
    ref_btn.classList.add("btn");
    ref_btn.setAttribute("onclick", "takeAReferat(event)");
    ref_btn.innerHTML = "Take-a-Ref";
    
    ref_btn.addEventListener("click", () => {
        
    }); 

    ref_content.append(ref_title);
    ref_content.append(ref_btn);
    
    ref_card.append(ref_content);

    library_content.append(ref_card);
  });

  function takeAReferat(e) {
        const element = e.target;
        const referatID = element.getAttribute("id");
      
        const xhttp = new XMLHttpRequest();
        xhttp.open("POST", "../backend/takeReferat.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState !== 4 || xhttp.status !== 200) {
                return;
            }
            element.closest(".card").remove();
        };
        xhttp.send("referatId="+referatID);

        reload();
  }
</script>