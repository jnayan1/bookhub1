<?php

$username=$_POST['username'];
$password=$_POST['password'];

if (isset($_SESSION['views'])) {
   echo 'You are already logged in ';
   echo $_SESSION['username'];
   exit();
}

if( $username=="" || $password==""){
	die ("Username or password is not valid");
}
else{
	$username = preg_replace('#[^A-Za-z0-9._]#i', '', $username);
	$password = md5($password);
	mysql_connect('localhost','root', '') or die ("could not connect to database");
	mysql_select_db('BookHub') or die ("no database");
	$sql = mysql_query("SELECT * FROM signup WHERE username = '$username' AND pass = '$password' LIMIT 1");
	$Count = mysql_num_rows($sql);
	if ($Count == 0) {
		die ("Invalid username or password");
	}
	else {
		$row = mysql_fetch_array($sql);
		session_start();
		$_SESSION['username'] = $row['username'];
		$_SESSION['name'] = $row['name'];
		$_SESSION['views'] = 1;
		//echo $_SESSION['views'];
		//session_destroy();
		echo "success";
	}
}
?>