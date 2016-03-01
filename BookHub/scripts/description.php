<?php
    //Defining the basic cURL function
    $myurl = $_GET['url'];
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
        echo $mytext; 
    }
    else echo "Not Available";  

    //header('Location: ../../a.php');

?>
