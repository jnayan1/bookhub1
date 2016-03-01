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
		echo "<br /><div class = 'col-md-2' style = 'margin-left:65px;margin-top:50px;'>No reviews found.</div>";
	}
	else {
		$ret = "";
		$i = 0;
		while($row=mysql_fetch_array($sql)){
			$username = $row['username'];
				$query = mysql_query("SELECT * FROM users WHERE username LIKE '$username'");
				$r = mysql_fetch_array($query);
				if(strpos($r['booksrated'], $bookname)!=false){
					$var = strpos($r['booksrated'], $bookname) + strlen($bookname) + 1;
					$userrating = substr($r['booksrated'], $var, 1);
				}
				else $userrating = 0;
		$id = 'like_' .$row['username'] . "+" . $row['bookname'];
		$name = preg_replace('/\+/', ' ', $row['bookname']);
		$arr = split(' ', $row['datetime']);
		$ret=$ret."<br /><br /><div class ='col-md-12' >";
		$ret=$ret."<div class = 'col-md-7' style='margin-top:40px;'><div class = 'col-md-1'></div><div class = 'col-md-6' style='margin-left:-18px;'><span id='user'>" . $row['username'] . "</span><br>";
		$ret=$ret. "<span id = 'star" . $i . "'></span><br />Date: " . $arr[0];
		$ret=$ret. "<br /><br /><div style='font-size:1.5em; width: 600px;'>" . $row['review'] . "</div>";
		$ret=$ret. "<br /><span class='like' id = $id><img width = '30px' height='20px' src='../static/images/like.png' />&nbsp;" . $row['likes'] . "</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$ret=$ret. "<span class='dislike' id = $id><img width = '30px' height='20px' src='../static/images/dislike.png' />" . $row['dislikes'] . "</span></div>"; 
		$ret=$ret."</div></div>";
		$ret=$ret."<script> $('#star" . $i . "').raty({ path : '../scripts/raty-2.5.2/lib/img/', scoreName: 'entity[score]', score:" . $userrating . ", readOnly: true,});</script>";
		$i++;
		}
		echo $ret;
	}
}
?>