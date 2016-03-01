<?php
$name = $_POST['name'];
$username = $_POST['user'];
$email = $_POST['email'];
$agegroup = $_POST['agegroup'];
$pass = $_POST['pass'];
$conpass = $_POST['conpass'];

$name = preg_replace('#[^A-Za-z0-9\ ]#i', '', $name);
$username = preg_replace('#[^A-Za-z0-9._]#i', '', $username);
$email = preg_replace('#[^A-Za-z0-9@.]#i', '', $email);

if($conpass == "" || $name == "" || $username == "" || $email == "" || $pass == "")
{
	die ('<div id = "msg">All fields are mandatory</div>');
}
else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
{    
	die ("Invalid email id");
}
else if(strlen($pass) < 8)
{
	die ("Password should have minimum 8 characters");
}
else if ($agegroup == "false")
{
	die ("Please select an age group");
}
else if($pass != $conpass)
{
	die ("Passwords do not match");
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
		die ("username or email already exists");
	}
	else {
		$md5sum = md5($email);
		mysql_query("INSERT INTO tempsignup VALUES ('$username', '$name', '$pass', '$email', '$md5sum', '$agegroup')");
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
n 