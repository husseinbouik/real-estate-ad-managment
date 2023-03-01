<?php 
require "connect.php";//connect to the db

if(isset($_GET["ad_id"])){//check the id
  $id = $_GET["ad_id"];

  $query = "SELECT advertisement.*, images_gallery.*
          FROM advertisement
          NATURAL JOIN images_gallery 
         where `ad_id`= $id
          ";
  $ads = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);

  // echo "<pre>";
  // print_r($ads);
  // echo "</pre>";



  //store the request for annouce table and run it
  $query = $conn->query("SELECT * FROM advertisement WHERE `ad_id` = $id"); 
  $array = $query->fetch(PDO::FETCH_ASSOC);
  $queryPHONE = $conn->query("SELECT * FROM users WHERE `user_id` = $id"); 
  $arrayPHONE = $queryPHONE->fetch(PDO::FETCH_ASSOC);

} 

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Infos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/style_detail.css">
    <link rel="stylesheet" href="../css/home.css">
  </head>
  <body>
    <div>
      </div>
      <div class = "card-wrapper">
        <div class = "card">
          <div class = "product-imgs">
          <button class="btn"><a href="user.php">Back home</a></button>
          <div class = "img-display">
            <div class = "img-showcase">
              <?php
              foreach ($ads as $ad) {
                  if ($ad['primary_or_secondary'] == 1) {
                      echo '<img src="../' . $ad['image_path'] . '" alt = "shoe image2">';
                  }
              }
              ?>
              <?php
              $count = 0;
              foreach ($ads as $ad) {
                  if ($ad['primary_or_secondary'] == 0) {
                      echo '
                        <img src="../' . $ad['image_path'] . '"  alt = "shoe image1">';
                      $count++;
                      if ($count == 3) {
                          break;
                      }
                  }
              }
              ?>
            </div>
          </div>
          <div class = "img-select">
            <div class = "img-item">
              <a href = "#" data-id = "1">
                <?php
              foreach ($ads as $ad) {
                  if ($ad['primary_or_secondary'] == 1) {
                    echo '<img src="../' . $ad['image_path'] . '" alt = "shoe image2" > ';  }  }
              ?>
              </a>
            </div>

            <?php
              $count = 0;
              $img_count = 2;
              foreach ($ads as $ad) {
                  if ($ad['primary_or_secondary'] == 0) {  ?>
                        <div class = "img-item">
                          <a href = "#" data-id = "<?php echo $img_count ?>">
                            <img src="../<?php echo $ad['image_path'] ?>" alt = "shoe image2">
                          </a>
                        </div>
                        <?php
                      $count++;
                      $img_count++;
              if ($count == 3) {  break; } } 
              } ?>

          </div>
        </div>
        <div class = "product-content">
        <h2 class = "product-title"><?php if(isset($_GET["ad_id"])){echo $array["title"];} ?></h2>
          <a href = "#" class = "product-link"><?php if(isset($_GET["ad_id"])){echo $array["type"];} ?></a>
          <div class = "product-price">
            <p class = "new-price">Price: <span><?php if(isset($_GET["ad_id"])){echo $array["price"];} ?> DH</span></p>
          </div>
          <div class = "product-detail">
            <ul>
              <li>Size : <span><?php if(isset($_GET["ad_id"])){echo $array["surface"];} ?> m2</span></li>
              <li>Category: <span><?php if(isset($_GET["ad_id"])){echo $array["category"];} ?></span></li>
              <li>Location : <span><?php if(isset($_GET["ad_id"])){echo $array["address"];} ?></span></li>
              <li>Publication Date: <span><?php if(isset($_GET["ad_id"])){echo $array["publication_date"];} ?></span></li>
              <li>Zip Code: <span><?php if(isset($_GET["ad_id"])){echo $array["zip_code"];} ?></span></li>
            </ul>
            <h2>Description :</h2>
            <p><?php if(isset($_GET["ad_id"])){echo $array["description"];} ?></p>
          </div>
          <div class="purchase-info">
            <button class="btn" onclick="document.getElementById('product_info').style.display='block';" id="del">Contact Seller</button>
          </div>
        </div>
      </div>
    </div>


    <div id="product_info" class="product_info" style="display: none;">
        <div class="content">
          <span onclick="document.getElementById('product_info').style.display='none'" class='close' title="Close">&#10005;</span>
          <h2>Message</h2>
          <hr>
          <div id="message">
            <h3>that is the seller number :</h3>
            <h2><?php if(isset($_GET["ad_id"])){echo $arrayPHONE["phone_number"];} ?></h2>
          </div>
          <hr>
          <div class="btns">
          <a  onclick="document.getElementById('product_info').style.display='none'" class="cancel">CANCEL</a>
          </div>
      </div>
    </div>

    <script src="../js/app.js"></script>
  </body>
</html>