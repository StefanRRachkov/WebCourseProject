# Search

## Main View:
![Screenshot 2022-01-20 025319](https://user-images.githubusercontent.com/25185815/150242725-dac07ba3-0979-4220-8971-9679e75b8d8f.png)

## Description:
There are two main parts
* Search functionality:
```php
    $condition = '';
    if(!empty($_POST['search']))
    {
        $condition = $_POST['search'];
    }

    $result = DBConnection::sharedInstance()->getReferatsWithConditions($condition);
```
```php
    $query = $this->$connection->query("SELECT * FROM REF_LIBRARY WHERE Title LIKE '%{$str_condition}%'");

    return $query->fetchAll(PDO::FETCH_ASSOC);
```
```html
    <div id="wrap">
      <form name="form" method="post" action="#" autocomplete="on">
       <input id="search" name="search" type="text" placeholder="What're we looking for ?">
       <input id="search_submit" value="Rechercher" type="submit">
      </form>
    </div>
```
* Display Library:
```javascript
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
```
