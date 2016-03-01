<?php
$bookname=$_GET['bookname'];
$rating = $_GET['rating'];

$bookname= preg_replace('/\ /', '+', $bookname);
session_start();

if (!isset($_SESSION['views'])) {
   echo "You must log in first";
}
else{
	$username = $_SESSION['username'];
}


if($bookname == ""){
	die ("Bookname is not valid");
}
else {
	mysql_connect('localhost','root','') or die ("could not connect to database");
	mysql_select_db('BookHub') or die ("no database");
	#echo $username . " " . $password;
	$sql = mysql_query("SELECT * FROM users WHERE username = '$username'");
	$Count = mysql_num_rows($sql);
	if ($Count == 0) {
		die ("No such book present in the database");
	}
	else {

	$bookcheck = "," . $bookname;
	$sql = mysql_query("SELECT booksrated FROM users WHERE username = '$username' AND booksrated LIKE '%$bookcheck%' LIMIT 1");
    $bookcount = mysql_num_rows($sql);

    if($bookcount!=0)
    {
    	echo "Book has already been rated";
    }
    else {
    $sql = mysql_query("SELECT * FROM books WHERE bookname = '$bookname' LIMIT 1");
    $row = mysql_fetch_array($sql);
    $added = $row['rating'] + $rating;
    $count = $row['count'] + 1;
    mysql_query("UPDATE books SET rating = '$added' WHERE bookname = '$bookname'");
    mysql_query("UPDATE books SET count = '$count' WHERE bookname = '$bookname'");

    $sql = mysql_query("SELECT * FROM users WHERE username = '$username' LIMIT 1");
    $row = mysql_fetch_array($sql);
    $added = $row['booksrated'];
    $added = $added . $bookname . " " . $rating . ",";
    mysql_query("UPDATE users SET booksrated = '$added' WHERE username = '$username'");
    echo "Book has been successfully rated";
	}
   }
}
?>