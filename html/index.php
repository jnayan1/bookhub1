<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="http://getbootstrap.com/assets/ico/favicon.ico">

    <title>bookhub: Home</title>

    <link href="../static/style/bootstrap.min.css" rel="stylesheet">
    <link href="../static/style/carousel.css" rel="stylesheet">
    <link href="../static/style/jumbotron.css" rel="stylesheet">
    <link href="../static/style/navbar.css" rel="stylesheet">
    <link href="../static/style/sticky-footer.css" rel="stylesheet">
  </head>

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
   


    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      
      <div class = "col-md-6" id = "aboutsite">A Place where reading does the talking.<br>
      <!--<div id ="features">
      <h2><b>Add Them.</b></h2>
      <h2><b>Read Them.</b></h2>
      <h2><b>Review Them.</b></h2>
      </div>-->
      <br>
      <div class = "col-md-1">
      </div>
      <div class = "col-md-9">
      <div id="carousel">

  <ul class="panes">

    <li>
      
       <p class="quotes_on_books">"A room without books is like a body without soul."</p>
       <p class="authorname">- Cicero</p> 
    </li>

    <li>
      
        <p class="quotes_on_books">"Reading one books is like eating one potato chip." </p>
        <p class="authorname">- Diana Duane</p>
    </li>

    <li>
      
        <p class="quotes_on_books">"There is no friend as loyal as a book."</p>
        <p class="authorname">- Ernest Hemigway</p>
    </li>

    <li>
      
          <p class="quotes_on_books">"Books are a uniquely portable magic."</p>
        <p class="authorname">- Stephen King</p>
    </li>
  
    <li>
      
          <p class="quotes_on_books">"We live for books."</p>
        <p class="authorname">- Umberto Eco</p>
    </li>

  </ul>

</div>
      <p>  
      </div>  
      </div>
          <div class = "col-md-6" style='margin-top:-20px;'>
        <div id = "form" class="container">
        <form class="form-signin" id="signup">

        <h2 class="form-signin-heading">Please sign up</h2>
      
         <div id="results" style = "color: red;"></div><br />

         <input type="text" class="signup form-control" id="name" name="name" placeholder="Name" required autofocus>
         <input type="text" class="signup form-control" id="username" name="username" placeholder="Username" required autofocus>
         <input type="email" class="signup form-control" id="email" name="email" placeholder="Email address" required autofocus>
         <input type="password" class="signup form-control" id="pass" name="pass" placeholder="Password" required autofocus>
         <input type="password" class="signup form-control" id="conpass" name="conpass" placeholder="Confirm-Password" required autofocus>
         <textarea type="text" class="signup form-control" id="quote" name="quote" placeholder="Favourite quote" required autofocus></textarea>

         Upload your photo<input style='margin-top:10px;' name="userimg" type="file" class="inputFile" id="userImage"/>

        <button class="btn btn-lg btn-primary btn-block" type="submit" id="check">Sign Up For Free</button>
        </form>
        <div style = "margin-top: 9px;">Already registered? &nbsp;
        <a style = "font-size: 1.3em; color: rgba(12, 123, 123, 1);" href = "signin.html"><span>Sign in</span></a>
        </div>
       </div>
       </div>
    
    </div>
    <br />
    <div class = "container">
    <div class = "col-md-8" id = "search">
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

    <?php include ("../scripts/genre.php"); ?>
    </div>
    <div class = "col-md-4" style='margin-top:52px;' id="about_us">
   <h3> Read them. Add them. Review them.</h3>
   <div id="bookhub-content">
   <p><span id="bookhub"><b>Bookhub</b></span> provides exciting features for book lovers of all ages.</p> <li>Readers can review their books.</li> <li>Readers can make a list of books 
   which they want to read.</li><li> The best feature of bookhub is that readers can add their own books and can get them reviewed by other readers. 
   <!--<h3> Read them. Add them. Review them.</h3>--></li>
  </div>
  </div>
  <div style = "display:none;">
      <input type="radio" name="search" class = "rad" id="bookname">&nbsp; Title
      <input type="radio" class = "rad" name="search" id="author">&nbsp; Author
      <input type="radio" class = "rad" name="search" id="genre">&nbsp;  Genre
  </div>
  </div>


    <div id="footer">
      <div class="container1">
        <p class="text-muted">© 2014 bookhub Inc.</p></div>
    </div>
      
    <script src="../scripts/jquery-1.10.2.min.js"></script>
    <script src="../scripts/bootstrap.js"></script>
    <script src="../scripts/index.js"></script>
    <script src="../scripts/signup.js"></script>
  
</body></html>