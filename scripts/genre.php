<?php

//$username="apaar";
$user='root';
$password='';
$database='BookHub';
//echo $date;

$connect = mysql_connect('localhost',$user,$password) or die ("could not connect to database");
mysql_select_db($database) or die ("no database");

$sql = mysql_query("SELECT DISTINCT genre FROM books");
$count = mysql_num_rows($sql);
$count=$count/2;
$index=0;
$string='<div class = "col-md-2"></div><div class = "col-md-4"><div class = "genres">';
while($index<$count and $row=mysql_fetch_array($sql)){
	$input = preg_replace('/\+/', ' ', $row['genre']);
	$string = $string . "<a href = ../html/search.php?input=" . $row['genre'] . "&checked=genre>" .$input ."</a><br />";
	$index++;
}
$string = $string . '</div></div><div class = "col-md-4"><div class = "genres">';

while($row=mysql_fetch_array($sql)){
	$input = preg_replace('/\+/', ' ', $row['genre']);
	$string = $string . "<a href = ../html/search.php?input=" . $row['genre'] . "&checked=genre>" .$input ."</a><br />";
}
$string = $string . '</div></div><div class = "md-col-2"></div>';
echo $string;

?>