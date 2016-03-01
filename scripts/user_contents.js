function defaultarg()
{
	var url = window.location.href;

	var loc = url.indexOf('?');

	if(loc!=-1){
		var arg1 = url.slice(url.indexOf('?')+1,url.length);
		arg1 = arg1.slice(arg1.indexOf('=')+1,arg1.length);
		$.ajax({
    		url: "../scripts/user_contents.php",
	    	type: 'GET',
    		data: {
    			content:arg1,
    		},
    		success: function(msg){
    			document.getElementById('result').innerHTML=msg;
    			
    			if(arg1=="toberead")
    			{	x=document.getElementsByClassName('rembut');
                    for (var i = x.length - 1; i >= 0; i--) {
//					removebook.apply(x[i]);
					x[i].addEventListener('click', removebook);
				};
				}
    		},
    		error: function()
    		{
    			alert("Connection Error");
    		}
  		});
	}

	else 
	{
		alert("No arguement given");
	}
}

function removebook()
{
	$.ajax({
    url: "../scripts/removetoberead.php",
    type: 'POST',
    data: {
    	bookname:this.id
    },
    success: function(msg){
    	console.log(msg);
        alert(msg);
    	defaultarg();
    },
    error: function()
    {
    	alert("Connection Error");
    }
  });
}

window.addEventListener("load",defaultarg)