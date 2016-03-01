<?php

$email = $_GET['email'];
echo $email;
$user = "root";
$password = "";
$database = "BookHub";
mysql_connect('localhost',$user,$password) or die ("could not connect to database");
mysql_select_db($database) or die ("no database");

$query = mysql_query("SELECT * FROM tempsignup WHERE md5sum = '$email'");
$count = mysql_num_rows($query);
//echo "<br>";
//echo $count;
echo $count;
if($count == 1) {
$row = mysql_fetch_array($query);
//	echo $row;
	$name = $row['name'];
	$username = $row['username'];
	$email = $row['email'];
	$md5sum = $row['md5sum'];
	$password = $row['password'];
	$agegroup = $row['agegroup'];
	mysql_query("INSERT INTO signup VALUES ('$username', '$name', '$password', '$email', '$md5sum', '$agegroup')");
	mysql_query("DELETE FROM tempsignup WHERE email = '$email'");
	mysql_query("INSERT INTO users VALUES ('$username', '$name', '', '', '', '')");

	if (!isset($_SESSION['views'])) {
   		session_start();
   		$_SESSION['username'] = $row['username'];
		$_SESSION['name'] = $row['name'];
		$_SESSION['views'] = 1;
		echo "<script type=\"text/javascript\">
		alert('Your account has been activated!');
		window.location.href='../html/user.php';
		</script>";
	}
	else {
		echo "<script type=\"text/javascript\">
		alert('Your account has been activated!');
		</script>";	
	}
}
else {
	echo "<script type=\"text/javascript\">
	alert('An error has occured!');
	</script>";
} 
?>