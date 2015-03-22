<?php
include "{$_SERVER[DOCUMENT_ROOT]}/include/config.php"; 

$error_msg = "";


session_start();
if($_SESSION['username']!="")
{
	go_url("/landing/tutor/tutor_schedule.php");
}
if (!isset($_SESSION['user_id'])) {
	if (isset($_POST['submit'])) {
		/* 
		$tutor_username = mysqli_real_escape_string($dbconn,trim($_POST['username']));
		$tutor_password = mysqli_real_escape_string($dbconn,trim($_POST['password']));
		 */ 
		$tutor_username = mysql_real_escape_string(trim($_POST['username']),$dbconn);
		$tutor_password = mysql_real_escape_string(trim($_POST['password']),$dbconn);
		 
		if (!empty($tutor_username) && !empty($tutor_password)) {
			//sha 없음
			$query = "SELECT first_name,username,authority FROM tutor WHERE username = '$tutor_username' AND password = '$tutor_password'";
			//$result = mysqli_query($dbconn,$query);
			$result = mysql_query($query,$dbconn);
			if (mysql_num_rows($result) == 1){
				$row = mysql_fetch_array($result);
				$_SESSION['username'] = $row['username'];
				$_SESSION['author']=$row['authority'];
				setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
				go_url("/landing/tutor/tutor_schedule.php");
			}
			else {
				$error_msg = 'Sorry, you must enter a valid username and password to log in.';
			}
		}
		else {
			$error_msg = 'Sorry, you must enter your username and password to log in.';
		}
	}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Login Page</title>
    <meta http-equiv="content-type" content="text/html" charset="euc-kr" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="./js/m.facebook.js"> </script>
	<style type="text/css">
	#main1 {
	width: 175px;
	margin: 0 auto;
	}
	
	#list {
	width: 50%;
	margin: 0 auto;
	margin-top: 10px;
	}
	</style>
</head>
<body>

<?php
  // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
  if (empty($_SESSION['username'])) {
    echo '<p class="error">' . $error_msg . '</p>';
?>
<!-- ////////////////////////////////////////////////////////////// -->
  <form method="post" action="<?=$PHP_SELF?>">
	<div id = "main1">
	  <input type="text" name="username" size="20" value="<?php if (!empty($tutor_username)) echo $tutor_username; ?>" placeholder="Input ID" style="margin-bottom: 5px;">
	  <input type="password" name="password" size="20" value="" placeholder="Input Password" style="margin-bottom: 5px;">
	  <input type="submit"  name="submit" value="Login">
	</div>
  </form>
	
	<div id="list">
        <div style="border:1px solid black; width:100%; padding:10px; margin-bottom:10px;">
        memo
        </div>
	<div>
<!-- ////////////////////////////////////////////////////////////// -->
  
<?php
  }


?>

</body>
</html>
