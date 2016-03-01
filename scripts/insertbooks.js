/*$("#check").click(function(){
    $.ajax({
        url: "../scripts/geturl.php",
        type: "POST",
        data: {
            query : document.getElementById('bookname').value,
        },
        success: function(msg){

        msg=msg.slice(msg.lastIndexOf("<br />")+7,msg.length);
        
        $.ajax({
            url: "../scripts/addbook.php",
            type: 'POST',
            data: {
                url : msg,
                bookname : document.getElementById('bookname').value,
                author: document.getElementById('author').value,
                plot: document.getElementById('plot').value,
                genre: document.getElementById('genre').value,
                rating: document.getElementById('rating').value,
            },
            success: function(mesg){
            //document.getElementById("msg").innerHTML = "";
            document.getElementById('results').innerHTML = mesg + "<br />";
            },
            error: function()
            {
    	       alert("Connection Error");
            }
        });
        },
        error: function(){ 
            alert("Connection Error");
        }
    });
});

*/

$(document).ready(function (event){
$("#bookadd").on('submit',(function(e) {
    console.log(e);
    e.preventDefault();
    input = document.getElementById('bookname');
    $.ajax({
    url: "../scripts/addbook.php",
    type: 'POST',
    data:new FormData(this),
    contentType: false,
    cache: false,
    processData:false,

    success: function(msg){
            alert('success');
            console.log(msg);
            document.getElementById('results').innerHTML = msg + "<br />";
          /*  for(i=0;i<input.length;i++){
            input = input.replace(' ', '+');
            }
          */  window.location.href = '../html/booksadded.php';
    },
    error: function()
    {
               alert("Connection Error");
    }
});
}));
});