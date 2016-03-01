<?php

$bookname = $_POST['bookname'];
$review = $_POST['review'];
$bookname= preg_replace('/\ /', '+', $bookname);
//echo $bookname;
session_start();

if (!isset($_SESSION['views'])) {
   die("You must log in first");
}
else
{
	$username = $_SESSION['username'];
}

if($bookname=="")
{
	die ('Invalid bookname');
}
if($review=="")
{    
	die ("Write something!");
}

//$username="apaar";
$user='root';
$password='';
$database='BookHub';
$date = date('Y-m-d H:i:s');
//echo $date;
$connect = mysql_connect('localhost',$user,$password) or die ("could not connect to database");
mysql_select_db($database) or die ("no database");

$allbooks = mysql_query("SELECT username FROM reviews WHERE username = '$username' and bookname = '$bookname' LIMIT 1");
$bookpresent = mysql_query("SELECT bookname FROM books WHERE bookname = '$bookname'LIMIT 1");
$count = mysql_num_rows($allbooks);

if($count=='1'){
	die("You Have already reviewed the book!");
}
$count = mysql_num_rows($bookpresent);
if($count=='0'){
	die("No such book is present in the database!");
}
else{
	mysql_query("INSERT INTO reviews VALUES ('$bookname', '$date','$review', '0', '0', '$username')");
	echo "Thanks for adding a review";
}
$bookname= preg_replace('/\+/', ' ', $bookname);
header( 'Location: ../html/bookpage.php?bookname=' . $bookname);
?>
