<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>bookhub: User</title>

    <link href="../static/style/bootstrap.min.css" rel="stylesheet">
    <link href="../static/style/jumbotron.css" rel="stylesheet">
    <link href="../static/style/navbar.css" rel="stylesheet">
    <link href="../static/style/search.css" rel="stylesheet">
    <link href="../static/style/signin.css" rel="stylesheet">
    <link href="../static/style/offcanvas.css" rel="stylesheet">
    <link href="../static/style/justified-nav.css" rel="stylesheet">
    <link href="../static/style/user.css" rel="stylesheet">
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

      <!-- Example row of columns -->
          <div class="container main">
      <div id="alternate-navbar">
        <ul class="nav nav-justified">
          <li class = "hov"><a href="../html/user.php">Home</a></li>
          <li class = "hov"><a href="../html/toberead.php?content=toberead">To Be Read</a></li>
          <li class = "hov"><a href="../html/booksadded.php?content=booksadded">Books Added</a></li>
          <li class="active hov"><a href="../html/booksrated.php?content=booksrated">Books Rated</a></li>
          <li class = "hov"><a href="../html/addbook.php">Add a Book</a></li>
        </ul>
      </div>

      <br />
      <span id='who' style='visibility:hidden'> <?php echo $_SESSION['username'] ?> </span>
      <style>
        .ratedsearch {
          margin-top: 40px;
          margin-left: -164px;
        }
      </style>
      <div class = "col-md-8 ratedsearch" id = "search">
      <table id = "searchbox">
          <tr>
          <td>  <input style = "width: 350px;" id="searchinput" placeholder="Name / Author / Genre" class="form-control" type="text"> </td> 
          <td>  <button type="submit" id="bton" class="form-control btn btn-success" style="margin-left: 5px;">Search</button> </td>
        </tr>
      </table>

    <script>
      function click(){
        var input = document.getElementById('searchinput').value;
        for(i=0;i<input.length;i++){
          input = input.replace(' ', '+');
        }
        window.location.href = "../html/search.php?input="+input+"&checked=empty";
       // alert('apaar');
      }
      document.getElementById('bton').addEventListener('click',click);
    </script>
    </div>
    <br />
      <h2 style='margin-left:17px; margin-top:110px;'>Books Rated</h2>
      <div id="result" style='margin-top:10px;'class = "col-md-12"></div>
        <?php include("../scripts/user_contents.php"); ?>
    </div>
    <div id="footer">
      <div class="container1">
        <p class="text-muted">© 2014 bookhub Inc.</p>
      </div>
    </div>
    <script src="../scripts/bootstrap.js"></script>
    <script src="../scripts/index.js"></script>
<!--    <script src="../scripts/user_contents.js"></script>
  --></body>
</html>