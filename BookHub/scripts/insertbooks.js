$("#check").click(function(){
    $.ajax({
        url: "../scripts/geturl.php",
        type: "POST",
        data: {
            query : document.getElementById('bookname').value,
        },
        success: function(msg){
        console.log(msg);
        msg=msg.slice(msg.lastIndexOf("<br />")+7,msg.length);
        
        $.ajax({
            url: "../scripts/coverimage.php",
            type: 'POST',
            data: {
                url : msg,
                bookname : document.getElementById('bookname').value,
            },
            success: function(mesg){
            //document.getElementById("msg").innerHTML = "";
            document.getElementById('results').innerHTML += mesg+"<br />";
            },
            error: function()
            {
               alert("damn!");
            }
        });

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
            document.getElementById('results').innerHTML += mesg+"<br />";
            },
            error: function()
            {
    	       alert("damn!");
            }
        });
        },
        error: function(){ 
            alert("damn!")
        }
    });
});