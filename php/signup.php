<?php
include "connect.php"; // ====== connect to the database

   $error_email="";
   $Fname =$_GET["fname"];
   $Lname =$_GET["lname"];
   $Email =$_GET["email"];
   $Phone =$_GET["phone"];
   $Password = $_GET["password"];
   $hashed_password = MD5($Password);
   $query = "SELECT `email`,`phone_number` FROM `users` WHERE `email`='$Email'  OR `phone_number`='$Phone'";
   //retrieve a single row from the result set of the query and store it in the variable "$Result"
   $Resultq = $conn->query($query)->fetch();

   // if the this file heve been called the code above will work
if(empty($Resultq)){

   if ( true ){

      $sql = "INSERT INTO `users` 
      (`first_name`, `last_name`, `email`, `phone_number`, `password`)
      VALUES 
      ('$Fname' , '$Lname', '$Email', '$Phone', '$hashed_password')";
      // send a request to the db and insert into the values of inputs 

      //retrieve a single row from the result set of the query and store it in the variable "$Result"
      $Result = $conn->exec($sql);
      
      //redirect the browser to a new URL, which is "index.php"
      header("location:Account.php");
   }else{
         // Login failed, redirect back to login page with error message
         $error_email = "An Error Has Occured";
         header("location: Account.php?error_email=".urlencode($error_email)); 
   }
}else{
   // Login failed, redirect back to login page with error message
   $error_email = "user already exist";
   header("location: Account.php?error_email=".urlencode($error_email)); 
}