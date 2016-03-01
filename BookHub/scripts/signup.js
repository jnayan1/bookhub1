$("#check").click(function(){
    var a = "false";
    if(document.getElementById("0-11").checked)
        a = "0-11";
    else if(document.getElementById("12-18").checked)
        a = "12-18";
    else if(document.getElementById("19-30").checked)
        a = "19-30";
    else if(document.getElementById("31+").checked)
        a = "31+";
    //alert(document.getElementById('male').checked || document.getElementById('female').checked)
    $.ajax({
    url: "../scripts/checksignup.php",
    type: 'POST',
    data: {
        conpass : document.getElementById('conpass').value,
        name: document.getElementById('name').value,
        user: document.getElementById('username').value,
        pass: document.getElementById('pass').value,
        email: document.getElementById('email').value,
        agegroup: a,
    },
    success: function(msg){
        if(msg == "success")
        {
                alert("Registration Successful, check your email for activation of account.")
               window.location = "http://localhost/anurag/BookHub/html/index.html";
        }
        else {
      //document.getElementById("msg").innerHTML = "";
      document.getElementById('results').innerHTML = msg;
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
    $(".rad").prop('checked', false);
});
