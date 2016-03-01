<?php

$bookname = $_POST['bookname'];
$review = $_POST['review'];
$bookname= preg_replace('/\ /', '+', $bookname);
//echo $bookname;
session_start();

if (!isset($_SESSION['views'])) {
   echo '<script> alert("You must login first"); window.location.href =  "../html/bookpage.php?bookname=' . $bookname . '" ;</script>';
   exit;
}
else
{
	$username = $_SESSION['username'];
}

if($bookname=="")
{
	echo 'Invalid bookname';
	header('location: ../html/bookpage.php?bookname=' . $bookname);
}
if($review=="")
{    
	echo '<script> alert("Please write something"); window.location.href =  "../html/bookpage.php?bookname=' . $bookname . '" ;</script>';
	exit;
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
	echo '<script> alert("You have already reviewed the book"); window.location.href =  "../html/bookpage.php?bookname=' . $bookname . '" ;</script>';
	exit;
}
$count = mysql_num_rows($bookpresent);
if($count=='0'){
	echo "No such book is present in the database!";
	exit;
}
else{
    $sql = mysql_query("SELECT * FROM users WHERE username = '$username' LIMIT 1");
    $row = mysql_fetch_array($sql);
    echo $row['username'];
    $added = $row['booksreviewed'];
    $added = $added . $bookname . ",";
    mysql_query("UPDATE users SET booksreviewed = '$added' WHERE username = '$username'");

	mysql_query("INSERT INTO reviews VALUES ('$bookname', '$date','$review', '0', '0', '$username')");
}
//$bookname= preg_replace('/\+/', ' ', $bookname);
header( 'Location: ../html/bookpage.php?bookname=' . $bookname);
?>