<?php
	$content = $_GET['content'];

	if($content == 'toberead'){
		session_start();
	}
	if (!isset($_SESSION['views'])) {
   		echo "You must log in first";
	}
	else{
		$username = $_SESSION['username'];
	}

//$input = preg_replace('#[^A-Za-z0-9]#i', '', $input);
//	$input= preg_replace('/\ /', '+', $input);

	mysql_connect('localhost','root','') or die ("could not connect to database");
	mysql_select_db('BookHub') or die ("no database");
	#echo $username . " " . $password;
	
	$sql = mysql_query("SELECT $content FROM users WHERE username LIKE '$username'");

	$Count = mysql_num_rows($sql);
	if ($Count == 0) {
		die ("No books found");
	}
	else {
		$row=mysql_fetch_array($sql);
		$row[$content] = preg_replace('/\+/', ' ', $row[$content]);
		$x = $row[$content];
	//	$output = array str_getcsv( string $x [, string $delimiter = ','  [, string $escape = "\\ " ]] );
		//echo $output;
		$myArray = explode(',', $x);
		$i=1;
		//echo "<div  class=''>";
		if($content == "toberead")
		{	while($myArray[$i]){
				$bname = preg_replace('/\ / ', '+' , $myArray[$i]);
					$sql1 = mysql_query("SELECT * FROM books WHERE bookname LIKE '$bname' LIMIT 1");
					$row1=mysql_fetch_array($sql1);
					$pl = substr($row1['plot'], 0, 100);
					$auth = preg_replace('/\+/', ' ', $row1['author']);
					$gen = preg_replace('/\+/', ' ', $row1['genre']); 
					$name= preg_replace('/\+/', ' ', $row1['bookname']);
					$ret = "<br /><div class ='row'><div class = 'col-md-2'><a href = ../html/bookpage.php?bookname=" . $row1['bookname'] . "><img height = '150px' width = '110px' src = '" . $row1['cover'] . "'></a></div>";
					$ret = $ret . "<div class = 'col-md-9' style = 'margin-top:-10px; '><span class = 'bkname' style='font-size:2.5em;x'><a href = ../html/bookpage.php?bookname=" . $row1['bookname'] . ">" . $name . "</a></span>"; 
					$ret = $ret . "<br>by <span class = 'authname'><a href = '../html/search.php?input=" . $row1['author'] . "&checked=author'>" . $auth . "</a></span>";
					$ret = $ret . "<br>genre: <span class = 'genname'><a href = '../html/search.php?input=" . $row1['genre'] . "&checked=genre'>" . $gen . "</a></span>"; 
					$ret = $ret . "<div id = 'star" . $i . "'></div>";
					$ret = $ret . "<script>$('#star" . $i . "').raty({ path : '../scripts/raty-2.5.2/lib/img/', scoreName: 'entity[score]', score:" . $row1['rating'] . ", readOnly: true,});</script>";
					$ret = $ret . "<br><div style = 'margin-top: 0px;'><span class = 'plot'>Plot: " . $pl . "...</span></div>";
					$ret = $ret . "<div class = 'rembutton'><button class = 'rembut btn btn-success' id = '" . $name . "''>Remove</button></div>"; 
					$ret = $ret . "</div></div><br />";
					echo $ret;
	//				echo "<li><a href = '../html/bookpage.php?bookname=" .$bname ."'>" .$display . "</a></li>";
					$i=$i+1;
				}
		}
		else if($content == "booksrated"){
			while($myArray[$i]){
					$display = substr($myArray[$i],0,strlen($myArray[$i])-2);
					$bname = preg_replace('/\ / ', '+' , $display);
					$sql1 = mysql_query("SELECT * FROM books WHERE bookname LIKE '$bname' LIMIT 1");
					$row1=mysql_fetch_array($sql1);
					$pl = substr($row1['plot'], 0, 100);
					$auth = preg_replace('/\+/', ' ', $row1['author']);
					$gen = preg_replace('/\+/', ' ', $row1['genre']); 
					$name= preg_replace('/\+/', ' ', $row1['bookname']);
					$ret = "<br /><div class ='row'><div class = 'col-md-2'><a href = ../html/bookpage.php?bookname=" . $row1['bookname'] . "><img height = '150px' width = '110px' src = '" . $row1['cover'] . "'></a></div>";
					$ret = $ret . "<div class = 'col-md-9' style = 'margin-top:-10px; '><span class = 'bkname' style='font-size:2.5em;x'><a href = ../html/bookpage.php?bookname=" . $row1['bookname'] . ">" . $name . "</a></span>"; 
					$ret = $ret . "<br>by <span class = 'authname'><a href = '../html/search.php?input=" . $row1['author'] . "&checked=author'>" . $auth . "</a></span>";
					$ret = $ret . "<br>genre: <span class = 'genname'><a href = '../html/search.php?input=" . $row1['genre'] . "&checked=genre'>" . $gen . "</a></span>"; 
					$ret = $ret . "<div id = 'star" . $i . "'></div>";
					$ret = $ret . "<script>$('#star" . $i . "').raty({ path : '../scripts/raty-2.5.2/lib/img/', scoreName: 'entity[score]', score:" . $row1['rating'] . ", readOnly: true,});</script>";
					$ret = $ret . "<br><div style = 'margin-top: 0px;'><span class = 'plot'>Plot: " . $pl . "...</span></div></div></div><br />";
					echo $ret;
	//				echo "<li><a href = '../html/bookpage.php?bookname=" .$bname ."'>" .$display . "</a></li>";
					$i=$i+1;
			}
		}
		else{
			while($myArray[$i]){
//					$display = substr($myArray[$i],0,strlen($myArray[$i])-2);
					$bname = preg_replace('/\ / ', '+' , $myArray[$i]);
					$sql1 = mysql_query("SELECT * FROM books WHERE bookname LIKE '$bname' LIMIT 1");
					$row1=mysql_fetch_array($sql1);
					$pl = substr($row1['plot'], 0, 100);
					$auth = preg_replace('/\+/', ' ', $row1['author']);
					$gen = preg_replace('/\+/', ' ', $row1['genre']); 
					$name= preg_replace('/\+/', ' ', $row1['bookname']);
					$ret = "<br /><div class ='row'><div class = 'col-md-2'><a href = ../html/bookpage.php?bookname=" . $row1['bookname'] . "><img height = '150px' width = '110px' src = '" . $row1['cover'] . "'></a></div>";
					$ret = $ret . "<div class = 'col-md-9' style = 'margin-top:-10px; '><span class = 'bkname' style='font-size:2.5em;x'><a href = ../html/bookpage.php?bookname=" . $row1['bookname'] . ">" . $name . "</a></span>"; 
					$ret = $ret . "<br>by <span class = 'authname'><a href = '../html/search.php?input=" . $row1['author'] . "&checked=author'>" . $auth . "</a></span>";
					$ret = $ret . "<br>genre: <span class = 'genname'><a href = '../html/search.php?input=" . $row1['genre'] . "&checked=genre'>" . $gen . "</a></span>"; 
					$ret = $ret . "<div id = 'star" . $i . "'></div>";
					$ret = $ret . "<script>$('#star" . $i . "').raty({ path : '../scripts/raty-2.5.2/lib/img/', scoreName: 'entity[score]', score:" . $row1['rating'] . ", readOnly: true,});</script>";
					$ret = $ret . "<br><div style = 'margin-top: 0px;'><span class = 'plot'>Plot: " . $pl . "...</span></div></div></div><br />";
					echo $ret;
	//				echo "<li><a href = '../html/bookpage.php?bookname=" .$bname ."'>" .$display . "</a></li>";
					$i=$i+1;}
		}
		if($i==1){
			echo "No books found";
		}
		echo "</div>";
}
?>