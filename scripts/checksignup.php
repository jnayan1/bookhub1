<?php

$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$conpass = $_POST['conpass'];
$quote = $_POST['quote'];

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["userimg"]["name"]);


$name = preg_replace('#[^A-Za-z0-9\ ]#i', '', $name);
$username = preg_replace('#[^A-Za-z0-9._]#i', '', $username);
$email = preg_replace('#[^A-Za-z0-9@.]#i', '', $email);


if($conpass == "" || $name == "" || $username == "" || $email == "" || $pass == "" || $quote == "")
{
	echo '*All fields are mandatory';
	exit;
}
else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
{    
	echo "*Invalid email id";
	exit;
}
else if(strlen($pass) < 8)
{
	echo "*Password should have minimum 8 characters";
	exit;
}
else if($pass != $conpass)
{
	echo "*Passwords do not match";
	exit;
}
else {

	$pass = md5($pass);
    $user='root';
	$password='';
	$database='BookHub';

	$connect = mysql_connect('localhost',$user,$password) or die ("could not connect to database");
	mysql_select_db($database) or die ("no database");
	$allusers = mysql_query("SELECT username FROM tempsignup WHERE username = '$username' OR email = '$email' LIMIT 1");
	$count = mysql_num_rows($allusers);
	$allusers = mysql_query("SELECT username FROM signup WHERE username = '$username' OR email = '$email' LIMIT 1");
	$count = $count + mysql_num_rows($allusers);
	if($count != 0){
		echo "*Username or Email already exists";
		exit;
	}
	else {

		$extension = end($temp);

		if ((($_FILES["userimg"]["type"] == "image/gif")
		|| ($_FILES["userimg"]["type"] == "image/jpeg")
		|| ($_FILES["userimg"]["type"] == "image/jpg")
		|| ($_FILES["userimg"]["type"] == "image/pjpeg")
		|| ($_FILES["userimg"]["type"] == "image/x-png")
		|| ($_FILES["userimg"]["type"] == "image/png"))
		&& in_array($extension, $allowedExts)) {

			if ($_FILES["userimg"]["error"] > 0) {
		    	echo "Return Code: " . $_FILES["userimg"]["error"] . "<br>";
 	 			exit;
			} 
  			else {
  				$type = substr($_FILES["userimg"]["type"],6,strlen($_FILES["userimg"]["type"]));
  				$_FILES["userimg"]["name"] = $username . "." . $type;
    			$filepath = "../static/images/users/" . $_FILES["userimg"]["name"];

   			 	if (file_exists("../static/images/users/" . $_FILES["userimg"]["name"])) {
     		 	echo $_FILES["userimg"]["name"] . " already exists. ";
    			} 
    			else {
    			$filepath = "../static/images/users/" . $_FILES["userimg"]["name"];
      			move_uploaded_file($_FILES["userimg"]["tmp_name"],$filepath);
    			}
  			}
		} 
		else {
  			echo "*Invalid picture format";
  			exit;
		}

		$md5sum = md5($email);
		mysql_query("INSERT INTO tempsignup VALUES ('$username', '$name', '$pass', '$email', '$md5sum','$quote','$filepath')");
        $to = $email;
		$subject = "Welcome to BookHub";
		$message = "Your registration with BookHub is successful! To activate your account, click on the link given http://".$_SERVER['SERVER_ADDR']."/anurag/BookHub/scripts/confirmreg.php?email=" . $md5sum;
		$message = wordwrap($message, 70);
		$headers = "From: gupta.anu1995@gmail.com";
		$mail = mail($to, $subject, $message, $headers);
		echo "success";
		//echo "http://" . $_SERVER['SERVER_ADDR'] . "/scripts/confirmreg.php?email=" . $md5sum;
	}
}
?>