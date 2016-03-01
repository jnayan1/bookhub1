<?php
$bookname=$_GET['bookname'];

$bookname= preg_replace('/\ /', '+', $bookname);

if($bookname==""){
	die ("Bookname is not valid");
}
else{
	mysql_connect('localhost','root','') or die ("could not connect to database");
	mysql_select_db('BookHub') or die ("no database");
	#echo $username . " " . $password;
	$sql = mysql_query("SELECT * FROM books WHERE bookname Like '$bookname'");
	$Count = mysql_num_rows($sql);
	if ($Count == 0) {
		die ("No such book present in the database");
	}
	else {

		while($row=mysql_fetch_array($sql)){
		$name= preg_replace('/\+/', ' ', $row['bookname']);
		$src = $row['cover'];
		echo "<div class ='subresult'><img src = \"" . $src . "\"><br />bookname:" . $name . "<br>author:" . $row['author'] . "<br>Genre:" . $row['genre'] .  "<br>plot:" . $row['plot'] . "<br>rating: </div><div id = \"rating\" style = \"display : none;\">" . $row['rating'] . "</div><div id = \"star\"></div>"; 
		//echo "<div class ='subresult'><img src = \"" . $src . "\"><br />bookname:" . $name . "<br>author:" . $row['author'] . "<br>Genre:" . $row['genre'] .  "<br>plot:" . $row['plot'] . "<br>rating:" . $row['rating'] . "</div>"; 
		echo "<br>";
//		echo "<a href=../html/review.html?bookname=" . $row['bookname'] . ">Add review</a><br>";
//		echo "<a href=../html/viewreviews.html?bookname=" . $row['bookname'] . ">View reviews</a><br>";
		}
	}
}
?>
