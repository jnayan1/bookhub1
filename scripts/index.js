
$("#checklog").click(function(){
    $.ajax({
    url: "../scripts/checklogin.php",
    type: 'POST',
    data: {
        username: document.getElementById('uname').value,
        password: document.getElementById('upass').value,
    },
    success: function(msg){
        if(msg == "success")
        {
            window.location.href = "../html/user.php";
        }
        else if(msg.slice(0, 3) == "You")
        {
            alert(msg);
            window.location.href = "../html/user.php";
        }
        else {
            alert(msg);
            window.location.href = "../html/signin.html";
//            document.getElementById('pass').value='';
        }
    },
    error: function()
    {
    	alert("Connection Error");
    }
  });
});
$(document).ready(function(){
    $(".form-control").val("");
});
