<?php
require_once 'connect.php';
session_start();
echo $_SESSION['user_id'];

try {
  
  $conn->beginTransaction(); // Begin the transaction

  // Retrieving form data
  $title = $_POST['title'];
  $category = $_POST['category'];
  $price = $_POST['price'];
  $address = $_POST['address'];
  $surface = $_POST['surface'];
  $type = $_POST['type'];
  $description = $_POST['description'];
  $area = $_POST['area'];
  $zip_code = $_POST['zipCode'];
  $city = $_POST['city'];
  $country = $_POST['country']; 
  $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
  

  // Inserting data into advertisement table
  $stmt = $conn->prepare("INSERT INTO advertisement (user_id, title, category, price, address, surface, type, description, area, zip_code, city, country) 
                        VALUES (:user_id, :title, :category, :price, :address, :surface, :type, :description, :area, :zip_code, :city, :country)");

  $stmt->bindParam(':user_id', $user_id);
  $stmt->bindParam(':title', $title);
  $stmt->bindParam(':category', $category);
  $stmt->bindParam(':price', $price);
  $stmt->bindParam(':address', $address);
  $stmt->bindParam(':surface', $surface);
  $stmt->bindParam(':type', $type);
  $stmt->bindParam(':description', $description);
  $stmt->bindParam(':area', $area);
  $stmt->bindParam(':zip_code', $zip_code);
  $stmt->bindParam(':city', $city);
  $stmt->bindParam(':country', $country);
  $stmt->execute();


  // Get the ID of the inserted row
  $ad_id = $conn->lastInsertId();

  // prepare and bind the insert statement
  $stmt = $conn->prepare("INSERT INTO images_gallery (primary_or_secondary, image_path, ad_id) VALUES (:primary_or_secondary, :image_path, :ad_id)");

  // loop through the uploaded images
  for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
    $filename = $_FILES['images']['name'][$i];
    $filetmp = $_FILES['images']['tmp_name'][$i];
    $filesize = $_FILES['images']['size'][$i];
    if ($filesize > 0) {
      $filetype = $_FILES['images']['type'][$i];
      $fileext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
      // determine if the image is a primary or secondary image
      if ($i == 0) {
        // generate a unique filename for the uploaded image
        $unique_filename = "primary." . uniqid() .".".$fileext;
        $primary_or_secondary = "1";
      } else {
        // generate a unique filename for the uploaded image
        $unique_filename = "secondary." . uniqid() .".".$fileext;
        $primary_or_secondary = "0";
      }
      // move the uploaded image to the images folder
      move_uploaded_file($filetmp, "../images/" . $unique_filename);
      $file_path ="images/". $unique_filename;
      // bind the parameters and execute the insert statement
      $stmt->bindParam(':primary_or_secondary', $primary_or_secondary);
      $stmt->bindParam(':image_path',$file_path);
      $stmt->bindParam(':ad_id', $ad_id);
      $stmt->execute();
    }
  }

  // Commit the transaction
  $conn->commit();
  // display success message
  echo "Data inserted successfully";
} catch (PDOException $e) {
  // Rollback the transaction if an error occurred
  $conn->rollback();
  echo "Error: " . $e->getMessage();
}

// close the prepared statement and database connection
$stmt = null;
$conn = null;
header("Location: profile.php");
exit;
?>
