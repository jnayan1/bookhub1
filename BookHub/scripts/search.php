<?php
$input=$_POST['input'];
$checked=$_POST['checked'];

if($input==""){
	die ("Input field empty");
}
else{
	//$input = preg_replace('#[^A-Za-z0-9]#i', '', $input);
	$input= preg_replace('/\ /', '+', $input);

	mysql_connect('localhost','root','') or die ("could not connect to database");
	mysql_select_db('BookHub') or die ("no database");
	#echo $username . " " . $password;
	if($checked!="empty"){
		$sql = mysql_query("SELECT * FROM books WHERE $checked LIKE '%$input%'");
	}
	else{
		$sql = mysql_query("SELECT * FROM books WHERE bookname LIKE '%$input%' OR author LIKE '%$input%' OR genre LIKE '%$input%'");
		//$sql = mysql_query("SELECT * FROM books WHERE '$checked'='$input'");
		//$sql = mysql_query("SELECT * FROM books WHERE '$checked'='$input'");

	}
	$Count = mysql_num_rows($sql);
	if ($Count == 0) {
		die ("No search results found");
	}
	else {

		while($row=mysql_fetch_array($sql)){
		$name= preg_replace('/\+/', ' ', $row['bookname']);
		echo "<div class ='subresult' >bookname:<a href = ../html/bookpage.php?bookname=" . $row['bookname'] . ">" . $name . "</a><br>author:" . $row['author'] . "<br>Genre:" . $row['genre'] . "</div>"; 
		echo "<br>";
		}
	}
}
?>