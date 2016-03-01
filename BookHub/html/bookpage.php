<html>
<script src="../scripts/bookpage.js">
</script>
<body>
<? include ("../scripts/bookpage.php"); ?>

Write a review

<form action="../scripts/review.php" method="post">
	<input type="hidden" name="bookname" id="bookname"  /><br>
	<input type='text' name="review" /><br>
	<input type="submit" id="bton" value="submit" />
</form>
<div id="result"></div>

<? include ("../scripts/viewreviews.php"); ?>
</form>
</body>
<script src="../scripts/bookpage.js">
</script>
<script src="../scripts/jquery-1.10.2.min.js"></script>
<script src = "../scripts/raty-2.5.2/lib/jquery.raty.min.js"></script>
<script>
$('#star').raty({
  path : '../scripts/raty-2.5.2/lib/img/',
  scorename: 'entity[score]',
  score: document.getElementById('rating').innerHTML,
  readOnly: true,
});
//$('#star').click(function(){
//	document.getElementById('score').innerHTML = document.getElementsByName('score').value;
//});
</script>

</html>