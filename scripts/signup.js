
$(document).ready(function (event){
$("#signup").on('submit',(function(e) {
    console.log(e);
    e.preventDefault();
    $.ajax({
    url: "../scripts/checksignup.php",
    type: 'POST',
    data:new FormData(this),
    contentType: false,
    cache: false,
    processData:false,

    success: function(msg){
        if(msg == "success")
        {
                alert("Registration Successful, check your email for activation of account.");
                window.location = "../html/signin.html";
        }
        else {
      //document.getElementById("msg").innerHTML = "";
      document.getElementById('results').innerHTML = msg;
      document.getElementById('pass').value='';
      document.getElementById('conpass').value='';

  }
    },
    error: function()
    {
    	alert("damn!");
    }
});
}));
});
$(document).ready(function(){
    $(".form-control").val("");
    $(".rad").prop('checked', false);
});