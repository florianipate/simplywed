<?php
// SET TIMEZONE
date_default_timezone_set("Europe/London");



// FLG 360 API DETAILS
$api_key = "ipFPvzokcscGCScH9q6YHFDoc7jLcvVS";
$url_read = "https://ukweddingsavings.flg360.co.uk/api/APILead.php";
$url_search = "https://ukweddingsavings.flg360.co.uk/api/APILead.php";



// FETCH DETAILS FROM URL STRING
$date = date("d/m/Y H:i:s");
$account_id = $_REQUEST["id"];
$venue_name = $_REQUEST["v"];
$wedding_date = $_REQUEST["d"];
$wedding_price = $_REQUEST["p"];



// DEFINE DATE RANGE (1 YEAR)
$date_string_one = strtotime("now -1 year");
$date_string_two = strtotime("now");
$date_one = date('d/m/Y', $date_string_one);
$date_two = date('d/m/Y', $date_string_two);



// FETCH LEADS - CREATE THE XML DOCUMENT
$xmlDoc_search = new DOMDocument();



// FETCH LEADS - CREATE THE XML ELEMENTS
$root_search = $xmlDoc_search->appendChild(
$xmlDoc_search->createElement("data"));
$root_search->appendChild($xmlDoc_search->createElement("key", $api_key));
$root_search->appendChild($xmlDoc_search->createElement("request", "search"));
$root_search->appendChild($xmlDoc_search->createElement("startdate", $date_one));
$root_search->appendChild($xmlDoc_search->createElement("enddate", $date_two));
$root_search->appendChild($xmlDoc_search->createElement("perpage", "1000"));
$xmlDoc_search->formatOutput = true;
$xml_search = $xmlDoc_search->saveXML();



// FETCH LEADS - TRANSFER XML TO FLG 360
$ch_search = curl_init($url_search);
curl_setopt($ch_search, CURLOPT_URL, $url_search);
curl_setopt($ch_search, CURLOPT_POST, count($lead));
curl_setopt($ch_search, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
curl_setopt($ch_search, CURLOPT_POSTFIELDS, $xml_search);
curl_setopt($ch_search, CURLOPT_RETURNTRANSFER, 1);
$result_search = curl_exec($ch_search);
curl_close($ch_search);



// FETCH LEADS - HANDLE XML FLG 360 RESULTS
$string_search = $result_search;
$xml_search = simplexml_load_string($string_search);



// CHECK IF LEAD WITH PROVIDED ID IS IN FLG 360
$account_exist = "No";
$record_item = $xml_search->records->record;
foreach ($record_item as $record) {
    if ($record->id == $account_id) {
        $account_exist = "Yes";
    }
}



// IF LEAD WITH PROVIDED EMAIL EXISTS
if ($account_exist == "Yes") {
    
    
    
    // READ LEAD - CREATE THE XML DOCUMENT
	$xmlDoc_read = new DOMDocument();
    
    
    
    // READ LEAD - CREATE THE XML ELEMENTS
	$root_read = $xmlDoc_read->appendChild(
	$xmlDoc_read->createElement("data"));
	$root_read->appendChild($xmlDoc_read->createElement("key", $api_key));
	$root_read->appendChild($xmlDoc_read->createElement("request", "read"));
	$root_read->appendChild($xmlDoc_read->createElement("id", $account_id));
	$xmlDoc_read->formatOutput = true;
	$xml_read = $xmlDoc_read->saveXML();
	
	
    
	// READ LEAD - TRANSFER XML TO FLG 360
	$ch_read = curl_init($url_read);
	curl_setopt($ch_read, CURLOPT_URL, $url_read);
	curl_setopt($ch_read, CURLOPT_POST, count($lead));
	curl_setopt($ch_read, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
	curl_setopt($ch_read, CURLOPT_POSTFIELDS, $xml_read);
	curl_setopt($ch_read, CURLOPT_RETURNTRANSFER, 1);
	$result_read = curl_exec($ch_read);
	curl_close($ch_read);
    
    
    
    // READ LEAD - HANDLE XML FLG 360 RESULTS
	$string_read = $result_read;
	$xml_read = simplexml_load_string($string_read);
    
    
    
    // READ LEAD - FETCH NAME AND DROPBOX EMAIL
	$dropbox = $xml_read->dropbox;
    $first_name = $xml_read->firstname;
    $last_name = $xml_read->lastname;
    
    
    
    // SEND CHECK AVAILABILITY MESSAGE TO LEAD DROPBOX
    $to = $dropbox;
    $subject = "Book Viewing for ". $venue_name ."";
    $headers = "From: matt@ukweddingsavings.co.uk\r\n";
    $headers.= "MIME-Version: 1.0\r\n";
    $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $message = '<table border="0" cellpadding="3"><tr><td>DATE:</td><td><b>'. $date .'</b></td></tr><tr><td>FROM:</td><td><b>'. $first_name .' '. $last_name .'</b></td></tr><tr><td>VENUE NAME:</td><td><b>'. $venue_name .'</b></td></tr><tr><td>WEDDING DATE:</td><td><b>'. $wedding_date .'</b></td></tr><tr><td>QUOTATION PRICE:</td><td><b>&#163;'. number_format($wedding_price) .'</b></td></tr></table><br />';
    mail($to, $subject, $message, $headers);
    
    
    
    // DISPLAY RESULTS
    $result = '<h1>Thanks for using UK Wedding Savings</h1><h3>We will contact you shortly to confirm the dates and times available for a show round.</h3><br /><h4>In the meantime should you wish to contact us please call <a href="tel:02038411045">0203 841 1045</a> or email us <a href="mailto:enquiries@ukweddingsavings.co.uk">here</a>.</h4><br /><table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td>NAME:</td><td><b>'. $first_name .' '. $last_name .'</b></td></tr><tr><td>VENUE NAME:</td><td><b>'. $venue_name .'</b></td></tr><tr><td>WEDDING DATE:</td><td><b>'. $wedding_date .'</b></td></tr><tr><td>ESTIMATED PRICE:</td><td><b>&#163;'. number_format($wedding_price) .'</b></td></tr></table><br /><br /><br /><br />';
    
    

// IF LEAD WITH PROVIDED EMAIL DOES NOT EXIST
} else if ($account_exist == "No") {
    
    
    
    // DISPLAY RESULTS
    $result = '<h1>We apoligise, there has been a problem</h1><h3>Please call the office on <a href="tel:02038411045">0203 841 1045</a> for information on arranging a show round</h3><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
    
    
    
}



?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="UTF-8" />
<title>UKWS - Book Viewing</title>
<meta name="description" content="UKWS - Book Viewing" />
<meta name="robots" content="noindex,nofollow,noodp,noydir" />
<meta name="author" content="Jason Cheeseborough" />
<meta name="viewport" content="width=device-width, initial-scale=1" />


<!-- BOOTSTRAP / STYLE CSS -->
<link href="/css/quotation.css" rel="stylesheet">
<link href="/css/core/bootstrap.min.css" rel="stylesheet">
<link href="/css/core/fontawesome.min.css" rel="stylesheet">
<link href="/images/favicon.ico" rel="icon" type="image/ico" />


</head><body>
<?php include_once ("includes/header.php"); ?>
<section id="content" class="content">
<div class="container-fluid py-5">
    <div class="container text-center">
        <?php echo $result; ?>
    </div>
</div>
</section>
<?php include_once ("includes/footer.php"); ?>


<!-- JAVASCRIPT FOR BOOTSTRAP ELEMENTS -->
<script src="/js/core/jquery-3.3.1.slim.min.js" type="text/javascript"></script>
<script src="/js/core/popper.min.js" type="text/javascript"></script>
<script src="/js/core/bootstrap.min.js" type="text/javascript"></script>


</body></html>