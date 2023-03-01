<?php 
require_once 'connect.php';

$conn->beginTransaction(); // Begin the transaction

// Retrieving form data
$property_id = $_POST['property_id'];
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

// Update data in real_estate_gallery table
$stmt = $conn->prepare("UPDATE real_estate_gallery SET title = :title, category = :category, price = :price, address = :address, surface = :surface, type = :type, description = :description, area = :area, zip_code = :zip_code, city = :city, country = :country WHERE id = :property_id");

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
$stmt->bindParam(':property_id', $property_id);
$stmt->execute();

// prepare and bind the update statement for images_gallery table
$stmt2 = $conn->prepare("UPDATE images_gallery SET primary_or_secondary = :primary_or_secondary, image_path = :image_path WHERE image_id = :image_id AND property_id = :property_id");

// loop through the uploaded images
for ($i = 0; $i < count($_FILES['image']['name']); $i++) {
  $image_id = $_POST['image_id'][$i];
  $filename = $_FILES['image']['name'][$i];
  $filetmp = $_FILES['image']['tmp_name'][$i];
  $filesize = $_FILES['image']['size'][$i];
  if ($filesize > 0) {
    $filetype = $_FILES['image']['type'][$i];
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
    // delete the existing file
    $image_path_query = $conn->prepare("SELECT image_path FROM images_gallery WHERE image_id = :image_id AND property_id = :property_id");
    $image_path_query->bindParam(':image_id', $image_id);
    $image_path_query->bindParam(':property_id', $property_id);
    $image_path_query->execute();
    $image_path_result = $image_path_query->fetch(PDO::FETCH_ASSOC);
    if ($image_path_result) {
      unlink($image_path_result['image_path']);
    }
    // move the uploaded image to the images folder
    move_uploaded_file($filetmp, "images/" . $unique_filename);
    $file_path = "images/" . $unique_filename;
    // bind the parameters and execute the update statement
    $stmt2->bindParam(':primary_or_secondary', $primary_or_secondary);
    $stmt2->bindParam(':image_path', $file_path);
    $stmt2->bindParam(':image_id', $image_id);
    $stmt2->bindParam(':property_id', $property_id);
    $stmt2->execute();
  }
}

$conn->commit(); // Commit the transaction

// Redirect to another PHP file
header("Location: profile.php");
exit;
