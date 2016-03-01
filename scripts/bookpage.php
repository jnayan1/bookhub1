<?php
$bookname=$_GET['bookname'];

$bookname= preg_replace('/\ /', '+', $bookname);
$flag = 0;

if($bookname==""){
	die ("Bookname is not valid");
}
else{
	mysql_connect('localhost','root','') or die ("could not connect to database");
	mysql_select_db('BookHub') or die ("no database");
	#echo $username . " " . $password;
	$sql = mysql_query("SELECT * FROM books WHERE bookname Like '$bookname'");
	$Count = mysql_num_rows($sql);
	//	echo "<div id='apaar'></div>";
	//	echo "<script>$('#apaar').raty({ path : '../scripts/raty-2.5.2/lib/img/', scoreName: 'entity[score]', score: 4, readOnly: true,});</script>";
		
	if ($Count == 0) {
		die ("No such book present in the database");
	}
	else {

			if(isset($_SESSION['username'])){
				$username = $_SESSION['username'];
				$query = mysql_query("SELECT * FROM users WHERE username LIKE '$username'");
				$r = mysql_fetch_array($query);
				if(strpos($r['booksrated'], $bookname)!=false){
					$flag = 1;
					$var = strpos($r['booksrated'], $bookname) + strlen($bookname) + 1;
					$userrating = substr($r['booksrated'], $var, 1);

		while($row=mysql_fetch_array($sql)){
		$name= preg_replace('/\+/', ' ', $row['bookname']);
		$auth= preg_replace('/\+/', ' ', $row['author']);
		$genre= preg_replace('/\+/', ' ', $row['genre']);
		$src = $row['cover'];
		if($row['count'] == 0)
			$value = 0;
		else
			$value = $row['rating']/$row['count'];
		if ($row['count'] == 0)
			$rat = 0;
		else $rat = $row['rating']/$row['count'];
		$ret = "";
		$ret = $ret . "<div class ='col-md-9 subresult'><div class = 'col-md-4'><img id = 'cover' src = \"" . $src . "\">";
		$ret = $ret . "<div><button type='submit' id='toberead' class='btn btn-success'>Want to Read</button></div>";
		//$ret = $ret . "<div style = 'font-size:0.85em; margin-left:65px;'>Rate this book </div><span style = 'margin-left:57px;' id = 'star2'> </span>";
		$ret = $ret . "<div style = 'font-size:0.85em; margin-left:72px;'><a id='clear'>Clear Rating </a></div><span style = 'margin-left:57px;' id = 'startwo'> </span>";
		$ret = $ret . "</div><div class = 'col-md-8 info'><span class = bkname>" . $name . "</span><br>by <span class = 'authname'>" . $auth . "<span>";
		$ret = $ret . "<br>Genre: <span class = 'genname'>" . $genre .  "</span>";
		$ret = $ret . "<span id='myrat' style='visibility:hidden;'>".$userrating."</span><br /><span id = 'star'></span><span style='margin-top:3px;'> &nbsp;&nbsp;" . round($rat, 2) . "</span><br><br />Plot: " . $row['plot'] . "</div></div>"; 
		$ret = $ret . "<script> $('#star').raty({ path : '../scripts/raty-2.5.2/lib/img/', scoreName: 'entity[score]', score:" . $rat . ", readOnly: true,});</script>";
		//$ret = $ret . "<script> $('#star2').raty({ path : '../scripts/raty-2.5.2/lib/img/', scoreName: 'entity[score]', click: function(score) { document.getElementById('star2').attributes['data-number'] = score;},});</script>";
		$ret = $ret . "<script> $('#startwo').raty({ path : '../scripts/raty-2.5.2/lib/img/', scoreName: 'entity[score]', score: $userrating, readOnly: true, click: function(score) { document.getElementById('star2').attributes['data-number'] = score;},});</script>"; 
		}
	  }
	}
	  if($flag == 0) {
	  	while($row=mysql_fetch_array($sql)){
		$name= preg_replace('/\+/', ' ', $row['bookname']);
		$auth= preg_replace('/\+/', ' ', $row['author']);
		$genre= preg_replace('/\+/', ' ', $row['genre']);
		$src = $row['cover'];
		if($row['count'] == 0)
			$value = 0;
		else
			$value = $row['rating']/$row['count'];
		if ($row['count'] == 0)
			$rat = 0;
		else $rat = $row['rating']/$row['count'];
		$ret = "";
		$ret = $ret . "<div class ='col-md-9 subresult'><div class = 'col-md-4'><img id = 'cover' src = \"" . $src . "\">";
		$ret = $ret . "<div><button type='submit' id='toberead' class='btn btn-success'>Want to Read</button></div>";
		$ret = $ret . "<div style = 'font-size:0.85em; margin-left:65px;'>Rate this book </div><span style = 'margin-left:57px;' id = 'startwo'> </span>";
		//$ret = $ret . "<div style = 'font-size:0.85em; margin-left:72px;'>Clear Rating </div><span style = 'margin-left:57px;' id = 'star2'> </span>";
		$ret = $ret . "</div><div class = 'col-md-8 info'><span class = bkname>" . $name . "</span><br>by <span class = 'authname'>" . $auth . "<span>";
		$ret = $ret . "<br>Genre: <span class = 'genname'>" . $genre .  "</span>";
		$ret = $ret . "<br /><span id = 'star'></span><span style='margin-top:3px;'> &nbsp;&nbsp;" . round($rat, 2) . "</span><br><br />Plot: " . $row['plot'] . "</div></div>"; 
		$ret = $ret . "<script> $('#star').raty({ path : '../scripts/raty-2.5.2/lib/img/', scoreName: 'entity[score]', score:" . $rat . ", readOnly: true,});</script>";
		$ret = $ret . "<script> $('#startwo').raty({ path : '../scripts/raty-2.5.2/lib/img/', scoreName: 'entity[score]', click: function(score) { rate(score); },});</script>";
		//$ret = $ret . "<script> $('#star2').raty({ path : '../scripts/raty-2.5.2/lib/img/', scoreName: 'entity[score]', score: $userrating, readOnly: true, click: function(score) { document.getElementById('star2').attributes['data-number'] = score;},});</script>";
	  }
	}
  }
  echo $ret;
}
?>
