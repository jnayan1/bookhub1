<?php

function getdescription($myurl) {
    //echo $myurl;
    function curl($url) {
        $ch = curl_init();  // Initialising cURL
        curl_setopt($ch, CURLOPT_URL, $url);    // Setting cURL's URL option with the $url variable passed into the function
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Setting cURL's option to return the webpage data
        $data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
        curl_close($ch);    // Closing cURL
        return $data;   // Returning the data from the function
    }
    // Defining the basic scraping function
    function scrape_between($data, $start, $end){
        $data = stristr($data, $start); // Stripping all data from before $start
        $data = substr($data, strlen($start));  // Stripping $start
        $stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
        $data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
        return $data;   // Returning the scraped data from the function
    }
    $data = curl("http://www.goodreads.com".$myurl);
    $data = scrape_between($data, "<div id=\"description\"", "</div>"); // Scraping out only the middle section of the results page that contains our results
    if($data != "") {
        $doc = new DOMDocument();
        $doc->loadHTML($data);
        $div = $doc->getElementsByTagName("span");
        if($div->item(1))
           $mytext = $div->item(1)->nodeValue;
        else 
           $mytext = $div->item(0)->nodeValue;
        return $mytext; 
    }
    else {
        $mytext = "Not Available";
        return $mytext;
    }  
}

$bookurl = $_POST['url'];
$bookname = $_POST['bookname'];
$author = $_POST['author'];
$plot = $_POST['plot'];
$genre = $_POST['genre'];
$rating = $_POST['rating'];

if($bookname=="")
{
	die ('Invalid bookname');
}
$cover = "../static/images/".$bookname.".jpg";
$bookname = preg_replace('/\ /', "+", $bookname);
if($author=="")
{    
	die ("Invalid author name");
}
if($genre=="")
{
	die ("Invalid genre");
}
if ($plot == "")
{
	$plot = getdescription($bookurl);
//    $plot = preg_replace('/\W\w+\s*(\W*)$/', '$1', $plot);
    if($plot[strlen($plot)-1] == ')' && $plot[strlen($plot)-2] == 's' && $plot[strlen($plot)-3] == 's')
        $plot = substr($plot, 0, strlen($plot)-6);
}
$plot = preg_replace('/\"/', "'", $plot);

$user='root';
$password='';
$database='BookHub';
$connect = mysql_connect('localhost',$user,$password) or die ("could not connect to database");
mysql_select_db($database) or die ("no database");
$allbooks = mysql_query("SELECT bookname FROM books WHERE bookname = '$bookname' LIMIT 1");
$count = mysql_num_rows($allbooks);

if($count=='1'){
	die("Book already present in the database!");
}
else {
    if($rating != 0) $count = 1;
    else $count = 0;
    $q = mysql_query("INSERT INTO books VALUES ('$bookname', '$author', \"$plot\", '$genre', $rating, $count, '$cover')");
    echo "Thanks for adding a book";
}
?>
