<?php
$bookname=$_GET['bookname'];
$rating = $_GET['rating'];
$bookname= preg_replace('/\ /', '+', $bookname);
session_start();

if (!isset($_SESSION['views'])) {
   echo "You must log in first";
   exit;
}
else{
	$username = $_SESSION['username'];
}


if($bookname == ""){
	echo "Bookname is not valid";
    exit;
}
else {
	mysql_connect('localhost','root','') or die ("could not connect to database");
	mysql_select_db('BookHub') or die ("no database");
	#echo $username . " " . $password;
	$sql = mysql_query("SELECT * FROM users WHERE username = '$username'");
	$Count = mysql_num_rows($sql);
	if ($Count == 0) {
		echo "No such book present in the database";
        exit;
	}
	else {

    $sql = mysql_query("SELECT * FROM books WHERE bookname = '$bookname' LIMIT 1");
    $row = mysql_fetch_array($sql);
    $added = $row['rating'] - $rating;
    $count = $row['count'] - 1;
    mysql_query("UPDATE books SET rating = '$added' WHERE bookname = '$bookname'");
    mysql_query("UPDATE books SET count = '$count' WHERE bookname = '$bookname'");

    $sql = mysql_query("SELECT * FROM users WHERE username = '$username' LIMIT 1");
    $row = mysql_fetch_array($sql);
    $added = $row['booksrated'];
    $string = "," . $bookname . " " . $rating;
    if(stripos($added, $string) !== false){
        $string = $string . ",";
        $added = str_replace($string, ',', $added);
    }
    
    mysql_query("UPDATE users SET booksrated = '$added' WHERE username = '$username'");
    echo "Rating has been successfully cleared.";
   }
}
?>