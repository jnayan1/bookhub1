function displaybook(){
	url=document.URL;
	url=url.slice(url.indexOf("=")+1,url.length);
	document.getElementById("bookname").value=url;
}	

window.addEventListener("load",displaybook);