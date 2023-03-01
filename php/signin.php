<?php
  // Start a session to store user information
  session_start();
  require "connect.php";
  $error = ""; 

  // Get the email and password submitted from the login form
  $email = isset($_POST['Email']) ? $_POST['Email'] : '';
  $password = isset($_POST['Password']) ? $_POST['Password'] : ''; 
  $hashed_password = MD5($password);

  if(!empty($email) && !empty($password)){
  // Query the database for a user with the submitted email and password
  $sql = "SELECT * FROM `users` WHERE `email`='$email' AND `password`='$hashed_password'";

  $result = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);
  echo $result['user_id'];
  // Check if the query returned a result
  if (!empty($result)) {
    // Login successful, set session variables and redirect to home page
    $_SESSION['user_email'] = $result['email'];
    $_SESSION['user_id'] = $result['user_id'];

    header("Location: user.php");
  } else {
    // Login failed, redirect back to login page with error message
      $error = "Email or Password is invalid";
      header("location: Account.php?error=".urlencode($error)); 

  }
}