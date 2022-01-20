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
    include '../backend/search.php';
    session_start();
?>

<body>
    <div class="header-content">
        <nav>
            <a href="../index.php"><img src="../assets/logo.png" height="100px"></a>
            <div class="nav-links">
                <ul>
                    <li><a href="../index.php">HOME</a></li>
                    <li><a href="">МY PROFILE</a></li>
                    <li><a href="#aboutUs">ABOUT US</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <div id="search_box" class="main-content">
        <div class="search-box">
            <div id="wrap">
              <form name="form" method="post" action="#" autocomplete="on">
                <input id="search" name="search" type="text" placeholder="What're we looking for ?">
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
    ref_btn.classList.add("btn");
    ref_btn.innerHTML = "Take-a-Ref";

    ref_content.append(ref_title);
    ref_content.append(ref_btn);
    
    ref_card.append(ref_content);

    library_content.append(ref_card);
  });
</script>