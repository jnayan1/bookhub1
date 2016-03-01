<?php

if (isset($_SESSION['views'])) {
   echo 'You are already looged in ';
   echo $_SESSION['username'];
   exit();
}

?>
$("#check").click(function(){
    $.ajax({
    url: "../scripts/checklogin.php",
    type: 'POST',
    data: {
        username: document.getElementById('name').value,
        password: document.getElementById('pass').value,
    },
    success: function(msg){
        if(msg == "success")
        {
        //document.getElementById("results").innerHTML = msg;
        window.location = "../html/user.php";
        }
        else {
    document.getElementById("results").innerHTML = msg;
  }
    },
    error: function()
    {
    	alert("damn!");
    }
});
});
$(document).ready(function(){
    $(".input").val("");
});
