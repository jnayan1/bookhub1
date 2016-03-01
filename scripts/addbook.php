<?php

session_start();

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

function getcoverimage($myurl, $bookname) {
    if($myurl == 'booknotfound'){
        return "<img height = \"342\" id=\"cover\" src=\"../static/images/book-no-image.jpg\">";
    }
    $where = "../static/images/".$bookname.".jpg";
    $data = curl("http://www.goodreads.com".$myurl);
    //$data = scrape_between($data, "description", "</div>");
    $data = scrape_between($data, "bookCoverPrimary\">", "</div>"); // Scraping out only the middle section of the results page that contains our results
    if($data != ""){
        $doc = new DOMDocument();
        $doc->loadHTML($data);
        $img = $doc->getElementById("coverImage");
        $data = $img->getAttribute("src");
        file_put_contents($where, curl($data));
        return "<img height = \"342\" id=\"cover\" src=\"".$data."\">";
    }
    else {
        return "<img height = \"342\" id=\"cover\" src=\"../static/images/book-no-image.jpg\">";
    }
}

function getdescription($myurl) {
    if($myurl == 'booknotfound'){
        return 'Not Available';
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

function geturl($query){

    $query = preg_replace('/\ /', "+", $query);
    $data = curl("http://www.goodreads.com/search?utf8=%E2%9C%93&query=".$query);
    $data = scrape_between($data, "class=\"tableList", "/table");
    if($data != ""){
    $doc = new DOMDocument();
    $doc->loadHTML($data);
    $div = $doc->getElementsByTagName("a");
    $mytext = $div->item(1)->getAttribute("href");
    return $mytext;
    }
    else return "booknotfound";
}


$bookname = $_POST['bookname'];
$author = $_POST['author'];
$plot = $_POST['plot'];
$genre = $_POST['genre'];
$rating = $_POST['rating'];

if($bookname=="")
{
	echo 'Invalid bookname';
    exit;
}

$bookurl = geturl( $bookname );

        $filename = "../static/images/".$bookname.".jpg";
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["userimg"]["name"]);

        $extension = end($temp);

        if ((($_FILES["userimg"]["type"] == "image/gif")
        || ($_FILES["userimg"]["type"] == "image/jpeg")
        || ($_FILES["userimg"]["type"] == "image/jpg")
        || ($_FILES["userimg"]["type"] == "image/pjpeg")
        || ($_FILES["userimg"]["type"] == "image/x-png")
        || ($_FILES["userimg"]["type"] == "image/png"))
        && in_array($extension, $allowedExts)) {

            if ($_FILES["userimg"]["error"] > 0) {
                echo "Return Code: " . $_FILES["userimg"]["error"] . "<br>";
                exit;
            } 
            else {
                $type = substr($_FILES["userimg"]["type"],6,strlen($_FILES["userimg"]["type"]));
                $_FILES["userimg"]["name"] = $bookname . "." . $type;
                $filepath = "../static/images/" . $_FILES["userimg"]["name"];

                if (file_exists("../static/images/" . $_FILES["userimg"]["name"])) {
                echo $_FILES["userimg"]["name"] . " already exists. ";
                } 
                else {
                move_uploaded_file($_FILES["userimg"]["tmp_name"],$filepath);
                }
                $cover = $filepath;
                $cov = $filepath;
                //echo "echo cover " . $cov;
            }
        } 
        else {
        $cov = getcoverimage($bookurl, $bookname);
        if (file_exists($filename)) {
        $x = substr($filename,strrpos($filename,"."),strlen($filename));
        $cover = "../static/images/".$bookname . $x;
        } 
        else {
            $cover = "../static/images/book-no-image.jpg";
        }
    }

$bookname = preg_replace('/\ /', "+", $bookname);
$genre = preg_replace('/\ /', "+", $genre);
$author = preg_replace('/\ /', "+", $author);
if($author=="")
{    
    echo "Invalid author name";
    exit;
}
if($genre=="")
{
	echo "Invalid genre";
    exit;
}
if ($plot == "")
{
	$plot = getdescription($bookurl);
//    $plot = preg_replace('/\W\w+\s*(\W*)$/', '$1', $plot);
    if($plot[strlen($plot)-1] == ')' && $plot[strlen($plot)-2] == 's' && $plot[strlen($plot)-3] == 's')
        $plot = substr($plot, 0, strlen($plot)-6);
       //     echo "<br>I am plot curl " . $plot . "</br>";

}
$plot = preg_replace('/\"/', "", $plot);
$plot = preg_replace('/\'/', "", $plot);

$user='root';
$password='';
$database='BookHub';
$connect = mysql_connect('localhost',$user,$password) or die ("could not connect to database");
mysql_select_db($database) or die ("no database");
$allbooks = mysql_query("SELECT bookname FROM books WHERE bookname = '$bookname' LIMIT 1");
$count = mysql_num_rows($allbooks);

if($count=='1'){
	echo "Book already present in the database!";
    exit;
}
else {
    $username=$_SESSION['username'];
    $sql = mysql_query("SELECT * FROM users WHERE username = '$username' LIMIT 1");
    $row = mysql_fetch_array($sql);

    $added = $row['booksadded'];
    $added = $added . $bookname . ",";
    mysql_query("UPDATE users SET booksadded = '$added' WHERE username = '$username'");

    if($rating != 0){
        $count = 1;

        $added = $row['booksrated'];
        $added = $added . $bookname . " " . $rating . ",";
        mysql_query("UPDATE users SET booksrated = '$added' WHERE username = '$username'");
    }
    else $count = 0;
    //echo $bookname . $author . $genre . $rating . $count . $cover;
    $q = mysql_query("INSERT INTO books VALUES ('$bookname', '$author', '$plot', '$genre', '$rating', '$count', '$cover')");
    //echo "<br>I am insert curl</br>";
    
    $cov = $cov . "<br />Thanks for adding a book";
    echo $cov;
}
?>
