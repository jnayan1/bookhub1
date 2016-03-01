<?php
   if (!isset($_SESSION['views'])) {
         echo "You must log in first";
   }
   else {
      $username = $_SESSION['username'];
   }
   mysql_connect('localhost','root','') or die ("could not connect to database");
   mysql_select_db('BookHub') or die ("no database");
   $sql = mysql_query("SELECT booksadded FROM users WHERE username LIKE '$username'");
   $Count = mysql_num_rows($sql);
   $starcount = 0;
   if ($Count == 0) {
      echo "<div id=''>No books added till now</div>";
   }
   else {

      $row=mysql_fetch_array($sql);
      $row['booksadded'] = preg_replace('/\+/', ' ', $row['booksadded']);
      $x = $row['booksadded'];
      $myArray = explode(',', $x);

      echo "<div class='col-xs-12 col-sm-12' style='margin-top: 70px;'>";
      echo "<br><br><span id = 'booksadd'> Books Added </span>";
      echo "<div class = 'outerdiv'><br>";
      $i=1;
      if(!$myArray[1]) {
         echo "<div id='nobook'>No books added till now</div><br><br>";     
      }
      else {
      while($myArray[$i] && $i<=4){
         $name = preg_replace('/\ / ', '+' , $myArray[$i]);
         $x = $myArray[$i];
         $x = preg_replace('/\ / ', '+' , $x);
         //echo $x;
         $sql1 = mysql_query("SELECT * FROM books WHERE bookname LIKE '$x'");
         $row1 = mysql_fetch_array($sql1);
         $cover = $row1['cover'];
         if($row1['count'] == 0)
            $userrating = 0;
         else $userrating = $row1['rating']/$row1['count'];
         echo "<div class='col-6 col-sm-6 col-lg-3'><span style='margin-left:70px;'><a href='../html/bookpage.php?bookname=" .$name ."'><img height=130px width=120px src ='$cover'></img></span></a>";
         echo "<div class='read'><a href='../html/bookpage.php?bookname=" .$name ."'>" . $myArray[$i] . "</a></div>";
         echo "<span class = 'sta' id = 'star" . $starcount . "'></span></div>";
         echo "<script> $('#star" . $starcount . "').raty({ path : '../scripts/raty-2.5.2/lib/img/', scoreName: 'entity[score]', score:" . $userrating . ", readOnly: true,});</script>";
         $i=$i+1;
         $starcount = $starcount + 1;
      }
      echo "</div><div class='more'><span><a href='../html/toberead.php?content=booksadded'>More...</a></span></div><br>";
      }
   }

   $sql = mysql_query("SELECT booksrated FROM users WHERE username LIKE '$username'");
   $Count = mysql_num_rows($sql);
   if ($Count == 0) {
      echo "<div id='nobook'>No books added till now</div>";
   }
   else {

      echo "<br><span id = 'booksadd'> Books Rated <br></span>";
      $row=mysql_fetch_array($sql);
      $row['booksrated'] = preg_replace('/\+/', ' ', $row['booksrated']);
      $x = $row['booksrated'];
      $myArray = explode(',', $x);
      $i=1;
      echo "<br>";
      if(!$myArray[1]) {
         echo "<div id='nobook'>No books rated till now</div><br><br>";     
      }
      else {
      echo "<div class='outerdiv'>";
      while($myArray[$i] && $i<=4){
         $display = substr($myArray[$i],0,strlen($myArray[$i])-2);
         $name = preg_replace('/\ / ', '+' , $display);
         $x = $display;
         $x = preg_replace('/\ / ', '+' , $x);
         $sql1 = mysql_query("SELECT * FROM books WHERE bookname LIKE '$x'");
         $row1 = mysql_fetch_array($sql1);
         $cover = $row1['cover'];
         if($row1['count'] == 0)
            $userrating = 0;
         else $userrating = $row1['rating']/$row1['count'];
         echo "<div class='col-6 col-sm-6 col-lg-3'><span style='margin-left:70px;'><a href='../html/bookpage.php?bookname=" .$name ."'><img height=130px width=120px src ='$cover'></img></span></a>";
         echo "<div class='read'><a href='../html/bookpage.php?bookname=" .$name ."'>" . $display . "</a></div>";
         echo "<span class = 'sta' id = 'star" . $starcount . "'></span></div>";
         echo "<script> $('#star" . $starcount . "').raty({ path : '../scripts/raty-2.5.2/lib/img/', scoreName: 'entity[score]', score:" . $userrating . ", readOnly: true,});</script>";
         $starcount = $starcount + 1;
         $i=$i+1;
      }
      echo "</div><div class = 'more'><span><a href='../html/toberead.php?content=booksrated'>More...</a></span></div><br>";
      }
   }   

   $sql = mysql_query("SELECT toberead FROM users WHERE username LIKE '$username'");
   $Count = mysql_num_rows($sql);
   if ($Count == 0) {
      echo "<br><div id=''>No books added till now</div>";
   }
   else {
      echo "<br><span id = 'booksadd'>To Be Read<br></span>";
      $row=mysql_fetch_array($sql);
      //echo $row['toberead'];
      $row['toberead'] = preg_replace('/\+/', ' ', $row['toberead']);
      $x = $row['toberead'];
      $myArray = explode(',', $x);
      echo "<br>";
      //echo $myArray[3];
      $i=1;
      if(!$myArray[1]) {
         echo "<div id='nobook'>No books in your to be read list</div><br><br>";     
      }
      else {
      echo "<div class='outerdiv'>";
      while($myArray[$i] && $i<=4){
         //echo $myArray[$i];
         $name = preg_replace('/\ / ', '+' , $myArray[$i]);
         $x = $myArray[$i];
         $x = preg_replace('/\ / ', '+' , $x);
         $sql1 = mysql_query("SELECT * FROM books WHERE bookname LIKE '$x'");
       //  echo mysql_num_rows($sql1);
         $row1 = mysql_fetch_array($sql1);
         $cover = $row1['cover'];
         if($row1['count'] == 0)
            $userrating = 0;
         else $userrating = $row1['rating']/$row1['count'];
         echo "<div class='col-6 col-sm-6 col-lg-3'><span style='margin-left:70px;'><a href='../html/bookpage.php?bookname=" .$name ."'><img height=130px width=120px src = '$cover'></img></span></a>";
         echo "<div class='read'><a href='../html/bookpage.php?bookname=" .$name ."'>" . $myArray[$i] . "</a></div>";
         echo "<span class = 'sta' id = 'star" . $starcount . "'></span></div>";
         echo "<script> $('#star" . $starcount . "').raty({ path : '../scripts/raty-2.5.2/lib/img/', scoreName: 'entity[score]', score:" . $userrating . ", readOnly: true,});</script>";
         $starcount = $starcount + 1;
         $i=$i+1;
      }
      echo "</div><div class='more'><span><a href='../html/toberead.php?content=toberead'>More...</a></span></div><br>";
      //echo "</div>";
     }
      echo "</div>";
   }
?>