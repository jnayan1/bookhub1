function geturl(){
	$.ajax({
    	url: "../scripts/geturl.php",
	    type: 'POST',
    	data: {
	        	bookname : document.getElementById('search').value,
    	},
    	success: function(msg){
			document.getElementById('result').innerHTML=msg
			x = document.getElementsByClassName('subresult');
			for (var i = x.length - 1; i >= 0; i--) {
				x[i].addEventListener('click', displaybook);
			};
    	},
    	error: function()
    	{
    		alert("damn!");
    	}
	});
}

$("#bton").click(function(){
   	var checked;
   	var result="";
	var input=document.getElementById("search").value;

	if(document.getElementById("name").checked){
		checked="bookname";
	}
	else if(document.getElementById("author").checked){
		checked="author";
	}
	else if(document.getElementById("genre").checked){
		checked="genre";
	}
	else{
		checked="empty";
	}

   $.ajax({
    	url: "../scripts/search.php",
	    type: 'POST',
    	data: {
	        	input : input,
	        	checked : checked,
    	},
	   	success: function(msg){
			document.getElementById('result').innerHTML=msg
//			if("")
//			var x = document.getElementsByClassName('subresult');
//			for (var i = x.length - 1; i >= 0; i--) {
				//displaybook.apply(x[i]);
//				x[i].addEventListener('click', displaybook);
//			};
    	},
    	error: function()
    	{
    		alert("damn!");
    	}
	});
});

function displaybook(){
	//alert("called");
	//alert(this.innerHTML);
	var a=this.innerHTML.indexOf(":");
	var b=this.innerHTML.indexOf("<br>author:");
	var c=this.innerHTML.slice(a+1,b);
	var bookname="";
	
	var d=c;
	var i=0;
	var index=0;
	
	while(index!=-1)
	{
		index=d.indexOf(" ");
		
		if(index==-1)
		{
			bookname+='+'+d;
			break;
		}
		
		bookname+='+'+d.slice(0,index);
		d=d.slice(index+1,d.length);
	}
	bookname=bookname.slice(1,bookname.length);
//	return bookname;
	var win = window.open("./bookpage.html?bookname="+bookname, "title");
}

$(document).ready(function(){
    $(".input").val("");
    $(".rad").prop('checked', false);
});