<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>bookhub: Search</title>

    <link href="../static/style/bootstrap.min.css" rel="stylesheet">
    <link href="../static/style/search.css" rel="stylesheet">
    <link href="../static/style/jumbotron.css" rel="stylesheet">
    <link href="../static/style/navbar.css" rel="stylesheet">
    <link href="../static/style/signin.css" rel="stylesheet">
    <link href="../static/style/sticky-footer.css" rel="stylesheet">
  </head>
  <script src="../scripts/jquery-1.10.2.min.js"></script>
  <script src="../scripts/raty-2.5.2/lib/jquery.raty.min.js"></script>
   
  <body>
<?php session_start(); 
      if(isset($_SESSION['username'])){
        echo '<style>#pleaselogin { display: none; } </style>';
      } 
      else {
        echo '<style>#alreadydone { display: none; } </style>';
      }
    ?>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="../html/index.php">bookhub</a>
        </div>
        <div class="navbar-collapse collapse">
          
          <div id = "pleaselogin" class="navbar-form navbar-right" role="form">
            <div class="form-group">
              <input id="uname" placeholder="Username" class="form-control" type="text">
            </div>
            <div class="form-group">
              <input placeholder="Password" id="upass" class="form-control" type="password">
            </div>
            <button type="submit" id="checklog" class="btn btn-success">Sign in</button>
          </div>
          <div id='alreadydone'>
            <?php
              if(isset($_SESSION['username']))
              {
              $user = $_SESSION['username'];
              mysql_connect('localhost','root','') or die ("could not connect to database");
              mysql_select_db('BookHub') or die ("no database");
              $sql = mysql_query("SELECT * FROM signup WHERE username LIKE '$user'");
              $row = mysql_fetch_array($sql);
              echo "<span id ='filename' style='visibility:hidden'>" . $row['filepath'] . "</span>";
              }
            ?>

            <img height = "70px" style='margin-left:-600px;' id = 'userimage' src='' />
            <script>
              document.getElementById("userimage").src = document.getElementById('filename').innerHTML;
            </script>
            <div class="navbar-brand form-group" style='margin-left:665px;'>
              <a style = "margin-top: -15px;" class = "navbar-brand" href = "user.php">Welcome&nbsp;<?php echo $_SESSION['username'] ?></a>
            </div>
            <form action = "../scripts/logout.php" id = "alrydone" class="navbar-right" role="form">
              <button type="submit" id="logout" class="btn btn-success">Logout</button>
          </form>
        </div>
        </div><!--/.navbar-collapse -->
      </div>
    </div>     



    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <form class="col-md-6" id = "searchbox1" action='search.php' method='GET'>
        <table>
        <tr>
          <td><input style = "width:400px;" id = "searchinput" type="text" name='input' class="form-control" placeholder="Search" required autofocus></td>
          <td><button style = "margin-left:3px;" id = "bton" type="submit" class="btn btn-success">Search</button></td>
        </tr>
        </table>
          <div style = "margin-top:10px;">
           <input type="radio" name="search" class = "rad" id="bookname">&nbsp; Title
           &nbsp;  &nbsp;  &nbsp; <input type="radio" class = "rad" name="search" id="author">&nbsp; Author
           &nbsp;  &nbsp;  &nbsp; <input type="radio" class = "rad" name="search" id="genre">&nbsp;  Genre
            <input id = 'what' name='checked' style='visibility:hidden;' value = 'empty'></input>
             
              <script>
                $('#bookname').click(function(){
                  document.getElementById('what').value = "bookname";
                });
                $('#author').click(function(){
                  document.getElementById('what').value = "author";
                });
                $('#genre').click(function(){
                  document.getElementById('what').value = "genre";
                });
              </script>
          </div>
        </form>
        <div class="col-md-4">
        
        </div>
      </div>
      <div id="result" class = "col-md-12">

    <?php
if(isset($_GET['input']) && isset($_GET['checked']))
{
  $input=$_GET['input'];
  $checked=$_GET['checked'];
  if(strpos($input, '&'))
    $input = substr($input, 0, strpos($input, '&'));
  //echo " " . $input . " hahaanura  " . $checked;
  if(strpos($checked, '='))
    $checked = substr($checked, strpos($checked, '=')+1, strlen($checked));
  //echo "sak  " . $checked;

  if($input==""){
    echo "Input field empty";
    exit;
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
      $sql = mysql_query("SELECT * FROM books WHERE bookname LIKE '%$input%' OR author LIKE '%$input%' OR genre LIKE '%$input%' ORDER BY bookname");
      //$sql = mysql_query("SELECT * FROM books WHERE '$checked'='$input'");
      //$sql = mysql_query("SELECT * FROM books WHERE '$checked'='$input'");

    }
    $Count = mysql_num_rows($sql);
    if ($Count == 0) {
      echo "No search results found";
      exit;
    }
    else {
      $i = 0;
      while($row=mysql_fetch_array($sql)){
      $pl = substr($row['plot'], 0, 100);
      $auth = preg_replace('/\+/', ' ', $row['author']); 
      $gen = preg_replace('/\+/', ' ', $row['genre']); 
      $name= preg_replace('/\+/', ' ', $row['bookname']);
      if($row['count'] ==0)
        $myraty = 0;
      else $myraty = $row['rating']/$row['count'];
      $ret = "<br /><div class ='row'><div class = 'col-md-2'><a href = ../html/bookpage.php?bookname=" . $row['bookname'] . "><img height = '150px' width = '110px' src = '" . $row['cover'] . "'></a></div>";
      $ret = $ret . "<div class = 'col-md-9' style = 'margin-top:-10px; '><span class = 'bkname'><a href = ../html/bookpage.php?bookname=" . $row['bookname'] . ">" . $name . "</a></span>"; 
      $ret = $ret . "<br>by <span class = 'authname'><a href = '../html/search.php?input=" . $row['author'] . "&checked=author'>" . $auth . "</a></span>";
      $ret = $ret . "<br>genre: <span class = 'genname'><a href = '../html/search.php?input=" . $row['genre'] . "&checked=genre'>" . $gen . "</a></span>"; 
      //$ret = $ret . "<span id = 'star" . $i . "'></span>";
      $ret = $ret . "<br><span id = 'anurag" . $i . "'></span>";
      $ret = $ret . "<script>$('#anurag" . $i . "').raty({ path : '../scripts/raty-2.5.2/lib/img/', scoreName: 'entity[score]', score: " . $myraty . ", readOnly: true,});</script>";
      $ret = $ret . "<br><div style = 'margin-top: 15px;'><span class = 'plot'>Plot: " . $pl . "...</span></div></div></div><br />";
      $ret = $ret . "<script> document.getElementById('#searchinput').value = ".$input." </script>";
      echo $ret;
      $i++;
      }
    }
  }
   $inp = $_GET['input'];
   $che = $_GET['checked'];
   echo "<script>function def(){document.getElementById('searchinput').value = '" . $inp . "'; document.getElementById('".$che."').checked = true;}; ";
   echo "window.addEventListener('load', def); </script>";                
}
?>

      </div>
    </div>
    
    <div id="footer">
      <div class="container1">
        <p class="text-muted">© 2014 bookhub Inc.</p>
      </div>
    </div>
    <script src="../scripts/bootstrap.js"></script>
    <script src="../scripts/index.js"></script>
  </body>
</html>
