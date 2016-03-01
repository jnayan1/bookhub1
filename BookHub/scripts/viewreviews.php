<?php
$bookname=$_GET['bookname'];

$bookname= preg_replace('/\ /', '+', $bookname);

if($bookname=="" ){
	die ("Bookname is not valid");
}
else{
	mysql_connect('localhost','root','') or die ("could not connect to database");
	mysql_select_db('BookHub') or die ("no database");
	#echo $username . " " . $password;
	$sql = mysql_query("SELECT * FROM reviews WHERE bookname Like '$bookname'");
	$Count = mysql_num_rows($sql);
	if ($Count == 0) {
		die ("No reviews found");
	}
	else {
		while($row=mysql_fetch_array($sql)){
		$name= preg_replace('/\+/', ' ', $row['bookname']);
		echo "<div class ='subresult' >writer:" . $row['username'] . "<br>review:" . $row['review'] . "<br>Datetime:" . $row['datetime'] . "</div>"; 
		echo "<br>";
		}
	}
}
?>