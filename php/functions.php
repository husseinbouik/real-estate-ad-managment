
<?php
function authenticated(){
	if(isset($_SESSION['user_email'])){
		return true ;
	}
}

function not_auth_redirect(){
	if(!authenticated()) {
  header("location:Account.php");
	}
}


function auth_redirect(){
	if(authenticated()) {
  header("location:profile.php");
	}
}