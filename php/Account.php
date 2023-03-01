<?php
include ("connect.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="../css/sign_style.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">
	<title>Account</title>
</head>
<body>
  <div class="cont">
    <!-- ================= sign In ================== -->
    <form action="signin.php" method="POST" id="forms">
        <div class="form sign-in">
            <h2>Sign In</h2>
            <label class="input-control">
                <input type="email" name="Email" id="emails"  value="<?php if(isset($_GET['Email'])){echo $email;} ?>" placeholder="Email Address">
                <div class="error"></div>
            </label>
            <label class="input-control">
                <input type="password" name="Password" id="passwords" value="<?php if(isset($_GET['Password'])){ echo $password; }?>"  placeholder="Password">
                <div class="error">  
                  <?php if(isset($_GET['error'])) { echo $_GET['error']; } ?>
                </div>
            </label>
            <button type="submit" class="submit">Sign In</button>
        </div>
    </form>
    <!-- ================= image ================== -->
    <div class="sub-cont">
      
      <div class="img">
        <div class="img-text m-up">
          <h2>New here?</h2>
          <p>Sign up and discover great amount of new opportunities!</p><br>
          <a class="guest" href="user.php">Enter As Guest</a>
        </div>
        <div class="img-text m-in">
          <h2>One of us?</h2>
          <p>If you already has an account, just sign in. We've missed you!</p><br>
          <a class="guest" href="user.php">Enter As Guest</a>
        </div>
        <div class="img-btn">
          <span class="m-up">Sign Up</span>
          <span class="m-in">Sign In</span>
        </div>
      </div>
      <!-- ================= Sign Up ================== -->
      <form action="signup.php" method="get" id="form">
        <div class="form sign-up">
            <h2>Sign Up</h2>
            <label class="input-control">
                <input type="text" name="fname" id="fname" placeholder="First Name">
                <div class="error"></div>
            </label>
            <label class="input-control">
                <input type="text" name="lname" id="lname" placeholder="Last Name">
                <div class="error"></div>
            </label>
            <label class="input-control">
                <input type="email" name="email" id="email"  placeholder="Email">
                <div class="error"></div>
            </label>
            <label class="input-control">
                <input type="text" name="phone" id="phone" placeholder="Phone Number">
                <div class="error"></div>
            </label>
            <label class="input-control">
                <input type="password" name="password" id="password1" placeholder="Password">
                <div class="error"></div>
            </label>
            <label class="input-control">
                <input type="password" id="password2" placeholder="Confirm Password">
                <div class="error"><?php if(isset($_GET['error_email'])) { echo $_GET['error_email']; } ?></div>
            </label>
            <button type="submit" class="submit">Sign Up</button>
        </div>
      </form>
    </div>
   </div>
</div>
<script src="../js/script.js"></script>
</body>
</html>