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
            <a href="../"><img src="../assets/logo.png" height="100px"></a>
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
                    <li><a href="../aboutus/aboutUs.php">ABOUT US</a></li>
                    <li><a href="#">COURSE EDITION</a></li>
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
    <div class="pagination-wrapper">
        <div class="pagination">
            <a id="prev" class="prev page-numbers" href="#">previous</a>
            <a id="next" class="next page-numbers" href="#">next</a>
        </div>
    </div>
    <section class="footer">
        <p>Тhis website is a course project ot three colleagues from the Faculty of Mathematics and Informatics 
            at Sofia University </p>
        <div class="icons">
            <a href="https://www.facebook.com/lusi.ivanova.17/" target="_blank"><i class="fa fa-facebook"></i></a>
            <a href="https://www.instagram.com/stefan.rachkov/" target="_blank"><i class="fa fa-instagram"></i></a>
            <a href="https://www.linkedin.com/in/emanuil-gospodinov" target="_blank"><i class="fa fa-linkedin"></i></a>

        </div>
    </section>
</body>
</html>

<script>
  var library = <?php 
      echo json_encode($result); 
    ?>;
  var library_content = document.getElementsByClassName('library')[0];
  var ref_card_list = [];

  var library_page = 0;
  var library_displayed_content = 8;

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
    
    ref_card_list.push(ref_card);
  });

  var prev_btn = document.getElementById("prev");
  var next_btn = document.getElementById("next");

  prev_btn.addEventListener('click', (e)=>{
      if(prev_btn.classList.contains("page-disabled"))
      {
          console.log("Can't go back");
      }
      else
      {
          library_page--;
          reloadPage();
      }
  })

  next_btn.addEventListener('click', (e)=>{
      if(next_btn.classList.contains("page-disabled"))
      {
          console.log("Can't go next");
      }
      else
      {
          library_page++;
          reloadPage();
      }
  })

  loadPage();

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
        };
        xhttp.send("referatId="+referatID);

        removeFromLibrary(referatID);
        reloadPage();
  }

  function loadPage() {
    let start_index = library_page * library_displayed_content;
    let end_index = start_index + library_displayed_content;
    for (let index = start_index; index < end_index && index < ref_card_list.length; index++) {
        library_content.append(ref_card_list[index]);
    }

    prev_btn.classList.remove("page-disabled");
    next_btn.classList.remove("page-disabled");

    if(library_page == 0)
    {
        prev_btn.classList.add("page-disabled");
    }
    if(library_page >= Math.floor(ref_card_list.length / library_displayed_content))
    {
        next_btn.classList.add("page-disabled");
    }
  }

  function unloadPage() {
      while(library_content.firstChild)
      {
          library_content.removeChild(library_content.firstChild);
      }
  }

  function reloadPage()
  {
      unloadPage();
      loadPage();
  }

  function removeFromLibrary(id)
  {
    let start_index = library_page * library_displayed_content;
        let end_index = start_index + library_displayed_content;
        for (let index = start_index; index < end_index && index < ref_card_list.length; index++) {
            let card = ref_card_list[index];
            let card_content = card.firstChild;
            let card_content_button = card_content.lastChild;

            let card_content_button_id = card_content_button.getAttribute("id");
            if(card_content_button_id == id)
            {
                ref_card_list.splice(index, 1);
                return;
            }
        }
  }
</script>