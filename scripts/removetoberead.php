<?php
$bookname=$_POST['bookname'];

	session_start();

	if (!isset($_SESSION['views'])) {
   		echo "You must log in first";
	}
	else{
		$username = $_SESSION['username'];
	}

//$bookname = preg_replace('#[^A-Za-z0-9]#i', '', $bookname);
$bookname= preg_replace('/\ /', '+', $bookname);

mysql_connect('localhost','root','') or die ("could not connect to database");
mysql_select_db('BookHub') or die ("no database");

$sql = mysql_query("SELECT toberead FROM users WHERE username ='$username'");

$row = mysql_fetch_array($sql); 
$added = $row['toberead'];

//echo $bookname;
$string = "," . $bookname . ",";

if(stripos($added, $string)!== false){ 
	//echo "done  ";
//	$string = $string . ","; // echo $string; 
	$added = str_replace($string, ',', $added); 
}
mysql_query("UPDATE users SET toberead = '$added' WHERE username = '$username'"); 
echo "Successfully removed!"
?>