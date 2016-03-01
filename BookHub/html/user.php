<?php

session_start();
if (!isset($_SESSION['views'])) {
   echo 'You must log in first';
   exit();
}
?>

<body>
<h1>Welcome back, <?php echo $_SESSION['username'] ?></h1>

<br />
Add a book to our database: <br />
bookname: <input type = "text" id = "bookname" /><br>
author: <input type = "text" id = "author" /><br>
plot: <input type = "text" id = "plot" /><br>
genre: <input type = "text" id = "genre" /><br>
<div id = "star">rating: </div>
<input type = "hidden" id = "rating" value = "0"/> <br>

<button id = "check">clickme</button>
<div id = "results"></div>
</body>
<script src="../scripts/jquery-1.10.2.min.js"></script>
<script src="../scripts/insertbooks.js"></script>
<script src = "../scripts/raty-2.5.2/lib/jquery.raty.min.js"></script>
<script>
$('#star').raty({
  path : '../scripts/raty-2.5.2/lib/img/',
  click: function(score) {
    //alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt);
    document.getElementById('rating').value = score;
  }
});
//$('#star').click(function(){
//	document.getElementById('score').innerHTML = document.getElementsByName('score').value;
//});
</script>