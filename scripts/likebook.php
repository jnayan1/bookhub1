<?php
$bookname = $_POST['bookname'];
$username = $_POST['username'];
$like = $_POST['like'];

session_start();
if(!isset($_SESSION['views'])){
	echo "You must Login First";
}
else{
	$user = $_SESSION['username'];
}

$bookname= preg_replace('/\ /', '+', $bookname);

if($bookname=="" ){
	die ("Bookname is not valid");
}
else{
	mysql_connect('localhost','root','') or die ("could not connect to database");
	mysql_select_db('BookHub') or die ("no database");
	#echo $username . " " . $password;
	$sql = mysql_query("SELECT $like FROM reviews WHERE bookname Like '$bookname' AND username LIKE '$username' LIMIT 1");
	$Count = mysql_num_rows($sql);
	if ($Count == 0) {
		echo "No reviews found";
	}
	else {
		while($row=mysql_fetch_array($sql)){
			$id = $row[$like];
			$id++;
			mysql_query("UPDATE reviews SET $like = $id WHERE bookname Like '$bookname' AND username LIKE '$username'");
			echo $id;
		}
	}
}
?>