<?php

    $myurl = $_POST['url'];
    $bkname = $_POST['bookname'];
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

    $where = "../static/images/".$bkname.".jpg";
    $data = curl("http://www.goodreads.com".$myurl);
    //$data = scrape_between($data, "description", "</div>");
    $data = scrape_between($data, "bookCoverPrimary\">", "</div>"); // Scraping out only the middle section of the results page that contains our results
    if($data != ""){
        $doc = new DOMDocument();
        $doc->loadHTML($data);
        $img = $doc->getElementById("coverImage");
        $data = $img->getAttribute("src");
        echo "<img height = \"342\" id=\"cover\" src=\"".$data."\">";
        file_put_contents($where, curl($data));
    }
    else {
        echo "<img height = \"342\" id=\"cover\" src=\"../static/images/notavailable.jpg\">";
        file_put_contents($where, "../static/images/notavailable.jpg");
    }
?>
