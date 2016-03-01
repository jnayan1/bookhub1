<?php
$bookname=$_GET['bookname'];

$bookname= preg_replace('/\ /', '+', $bookname);
session_start();

if (!isset($_SESSION['views'])) {
   echo "You must log in first";
   exit;
}
else{
	$username = $_SESSION['username'];
}


if($bookname==""){
	die ("Bookname is not valid");
}
else{
	mysql_connect('localhost','root','') or die ("could not connect to database");
	mysql_select_db('BookHub') or die ("no database");
	#echo $username . " " . $password;
	$sql = mysql_query("SELECT * FROM users WHERE username = '$username'");
	$Count = mysql_num_rows($sql);
	if ($Count == 0) {
		die ("No such book present in the database");
	}
	else {

	$bookcheck = "," .$bookname.  ",";
	$sql = mysql_query("SELECT toberead FROM users WHERE username = '$username' AND toberead LIKE '%$bookcheck%' LIMIT 1");
    $bookcount = mysql_num_rows($sql);

    if($bookcount!=0)
    {
    	echo "Book has already been added";
    }
    else {
    $sql = mysql_query("SELECT * FROM users WHERE username = '$username' LIMIT 1");
    $row = mysql_fetch_array($sql);

    $added = $row['toberead'];

    $added = $added . $bookname . ",";
    mysql_query("UPDATE users SET toberead = '$added' WHERE username = '$username'");
    echo "Book added to your to be read list";
	}
   }
}
?>