function add(){
    //alert("clicked");
    $.ajax({
    url: "../scripts/toberead.php",
    type: 'GET',
    data: {
        bookname: url,
    },
    success: function(msg){
              alert(msg);  
},
    error: function()
    {
    	alert("Connection Error");
    },
});
}

function rate(score){
    //alert(score);
    $.ajax({
    url: "../scripts/rate.php",
    type: 'GET',
    data: {
        bookname: url,
        rating: score,
    },
    success: function(msg){
              alert(msg);
              $('#startwo').raty({
                path : '../scripts/raty-2.5.2/lib/img/',
                score: 0
              });
              window.location.href = document.URL;    
    },
    error: function() {
        alert("Connection Error");
    },
  });
}

function clearrating(){
    $.ajax({
    url: "../scripts/clearrating.php",
    type: 'GET',
    data: {
        bookname: url,
        rating: document.getElementById("myrat").innerHTML,
    },
    success: function(msg){
              alert(msg);
              $('#startwo').raty({
                path : '../scripts/raty-2.5.2/lib/img/',
                score: 0
              });
              window.location.href = document.URL;    
    },
    error: function() {
        alert("Connection Error");
    },
  });
}

function displaybook(){
	url=document.URL;
	url=url.slice(url.indexOf("=")+1,url.length);
	document.getElementById("bookname").value=url;
}	


function likebook(){

    var mid = this.id.slice(this.id.indexOf('_')+1,this.length);
//    alert(this.innerHTML);
    var username = mid.slice(0,mid.indexOf('+'));
    var bookname = mid.slice(mid.indexOf('+')+1,mid.length);
   // alert(bookname);
    var x = this;
    $.ajax({
    url: "../scripts/likebook.php",
    type: 'POST',
    data: {
        bookname: bookname,
        username: username,
        like:"likes",
    },
    success: function(msg){
        x.innerHTML= x.innerHTML.slice(0,x.innerHTML.lastIndexOf('>')+1)+" "+msg;
    },
    error: function() {
        alert("Connection Error");
    },
  });    
}


function dislikebook(){
    //alert(this.innerHTML);
    var mid = this.id.slice(this.id.indexOf('_')+1,this.length);
//    alert(mid);

    var username = mid.slice(0,mid.indexOf('+'));
    var bookname = mid.slice(mid.indexOf('+')+1,mid.length);
    //alert(bookname);
    var x = this;
//    alert(x.innerHTML);
    $.ajax({
    url: "../scripts/likebook.php",
    type: 'POST',
    data: {
        bookname: bookname,
        username: username,
        like:"dislikes",
    },
    success: function(msg){
        //alert(msg);
        x.innerHTML= x.innerHTML.slice(0,x.innerHTML.lastIndexOf('>')+1)+" "+msg;
    },
    error: function() {
        alert("Connection Error");
    },
  });    
}

window.addEventListener("load",displaybook);

window.addEventListener("load", func);
function func(){

    var likers = document.getElementsByClassName('like');
    for (var i = likers.length - 1; i >= 0; i--) {
        likers[i].addEventListener("click",likebook);
    };

    var dislikers = document.getElementsByClassName('dislike');
    for (var i = dislikers.length - 1; i >= 0; i--) {
        dislikers[i].addEventListener("click",dislikebook);
    };

    document.getElementById("toberead").addEventListener("click",add);
//    document.getElementById("rate").addEventListener("click",rate);
    document.getElementById("clear").addEventListener("click", clearrating);

}