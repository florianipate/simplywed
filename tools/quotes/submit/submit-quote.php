<?php
// SET TIMEZONE
date_default_timezone_set("Europe/London");



// CONNECT TO DATABASE
include "../../../includes/connect.php";



// FLG 360 API DETAILS
$api_key = "ipFPvzokcscGCScH9q6YHFDoc7jLcvVS";
$url_read = "https://ukweddingsavings.flg360.co.uk/api/APILead.php";
$url_search = "https://ukweddingsavings.flg360.co.uk/api/APILead.php";
$url_create = "https://ukweddingsavings.flg360.co.uk/api/APILeadCreateUpdate.php";
$url_update = "https://ukweddingsavings.flg360.co.uk/api/APILeadCreateUpdate.php";



// FETCH DETAILS FROM AJAX REQUEST
$date_added = date("d/m/Y H:i:s");
$venue_name = $_REQUEST["venue_name"];
$venue_email = $_REQUEST["venue_email"];
$venue_max_hotel_rooms = $_REQUEST["venue_max_hotel_rooms"];
$venue_hotel_room_price = $_REQUEST["venue_hotel_room_price"];
$wedding_date = $_REQUEST["wedding_date"];
$wedding_day = $_REQUEST["wedding_day"];
$daytime_guests = $_REQUEST["daytime_guests"];
$evening_guests = $_REQUEST["evening_guests"];
$evening_entertain = $_REQUEST["evening_entertain"];
$first_name = $_REQUEST["first_name"];
$last_name = $_REQUEST["last_name"];
$contact_number = $_REQUEST["contact_number"];
$email_address = $_REQUEST["email_address"];
$package_price = $_REQUEST["package_price"];
$package_guests = $_REQUEST["package_guests"];
$daytime_price = $_REQUEST["daytime_price"];
$evening_price = $_REQUEST["evening_price"];
$ext_evening_entertain = $_REQUEST["ext_evening_entertain"];



// CHECK FOR OPTIONAL EXTRAS
if ($evening_entertain == "No") {$ext_evening_entertain = "0";}



// CALCULATE PACKAGE PRICES
$remaining_daytime = $daytime_guests - $package_guests;
$remaining_evening = $evening_guests - $package_guests;
$add_daytime_total = $remaining_daytime * $daytime_price;
$add_evening_total = $remaining_evening * $evening_price;
$grand_total = $package_price + $add_daytime_total + $add_evening_total + $ext_evening_entertain;



// SUBMIT CUSTOMER QUOTATION TO DATABASE
$query = "INSERT INTO cms_quotations (venue_name, wedding_date, daytime_guests, evening_guests, first_name, last_name, contact_number, email_address, package_price, package_guests, daytime_price, evening_price, remaining_daytime, remaining_evening, add_daytime_total, add_evening_total, ext_evening_entertain, grand_total, date_added) VALUES ('". $venue_name ."','". $wedding_date ."','". $daytime_guests ."','". $evening_guests ."','". $first_name ."','". $last_name ."','". $contact_number ."','". $email_address ."','". $package_price ."','". $package_guests ."','". $daytime_price ."','". $evening_price ."','". $remaining_daytime ."','". $remaining_evening ."','". $add_daytime_total ."','". $add_evening_total ."','". $ext_evening_entertain ."','". $grand_total ."','". $date_added ."')";
if (mysqli_query($connection, $query)) {} else {
    
    
    
    // SEND MYSQL FAILURE EMAIL TO DEVELOPER@UKWEDDINGSAVINGS.CO.UK
    $to = "developer@ukweddingsavings.co.uk";
    $subject = "MYSQL Failure - ". $first_name ." ". $last_name ."";
    $headers = "From: matt@ukweddingsavings.co.uk\r\n";
    $headers.= "MIME-Version: 1.0\r\n";
    $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $message = '<p><b>MYSQL produced the following error:</b></p><br /><p><b>ERROR:</b> '. $query .'</p><br />'. mysqli_error($connection) .'<br /><br /><table border="0" cellpadding="3"><tr><td>DATE:</td><td><b>'. $date_added .'</b></td></tr><tr><td>DAYTIME GUESTS:</td><td><b>'. $daytime_guests .'</b></td></tr><tr><td>EVENING GUESTS:</td><td><b>'. $evening_guests .'</b></td></tr><tr><td>FULL NAME:</td><td><b>'. $first_name .' '. $last_name .'</b></td></tr><tr><td>CONTACT NUMBER:</td><td><b>'. $contact_number .'</b></td></tr><tr><td>EMAIL ADDRESS:</td><td><b>'. $email_address .'</b></td></tr></table><br /><table border="0" cellpadding="3"><tr><td>VENUE NAME:</td><td><b>'. $venue_name .'</b></td></tr><tr><td>WEDDING DATE:</td><td><b>'. $wedding_date .'</b></td></tr><tr><td>PACKAGE PRICE:</td><td><b>&#163;'. number_format($package_price) .'</b></td></tr><tr><td>PACKAGE GUESTS:</td><td><b>'. $package_guests .'</b></td></tr><tr><td>ADDITIONAL DAYTIME GUESTS:</td><td><b>'. $remaining_daytime .'</b></td></tr><tr><td>ADDITIONAL DAYTIME PRICE:</td><td><b>&#163;'. number_format($daytime_price) .'</b></td></tr><tr><td>ADDITIONAL DAYTIME TOTAL:</td><td><b>&#163;'. number_format($add_daytime_total) .'</b></td></tr><tr><td>ADDITIONAL EVENING GUESTS:</td><td><b>'. $remaining_evening .'</b></td></tr><tr><td>ADDITIONAL EVENING PRICE:</td><td><b>&#163;'. number_format($evening_price) .'</b></td></tr><tr><td>ADDITIONAL EVENING TOTAL:</td><td><b>&#163;'. number_format($add_evening_total) .'</b></td></tr><tr><td>OPTIONAL DJ HIRE PRICE:</td><td><b>&#163;'. number_format($ext_evening_entertain) .'</b></td></tr><tr><td>GRAND TOTAL:</td><td><b>&#163;'. number_format($grand_total) .'</b></td></tr></table><br />';
    mail($to, $subject, $message, $headers);
    
    
    
}



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



// CHECK IF LEAD WITH PROVIDED EMAIL EXISTS IS IN FLG 360
$lead_id = "";
$lead_exists = "No";
$record_item = $xml_search->records->record;
foreach ($record_item as $record) {
    if ($record->email == $email_address) {
        $lead_id = $record->id;
        $lead_exists = "Yes";
    }
}



// IF LEAD WITH PROVIDED EMAIL EXISTS
if ($lead_exists == "Yes") {
    
    
    
    // READ LEAD - CREATE THE XML DOCUMENT
	$xmlDoc_read = new DOMDocument();
    
    
    
    // READ LEAD - CREATE THE XML ELEMENTS
	$root_read = $xmlDoc_read->appendChild(
	$xmlDoc_read->createElement("data"));
	$root_read->appendChild($xmlDoc_read->createElement("key", $api_key));
	$root_read->appendChild($xmlDoc_read->createElement("request", "read"));
	$root_read->appendChild($xmlDoc_read->createElement("id", $lead_id));
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
    
    
    
    // READ LEAD - FETCH LEAD DROPBOX EMAIL
    $lead_id = $xml_read->id;
	$dropbox = $xml_read->dropbox;
    
    
    
    // IF LEAD FETCH IS SUCCESSFUL MARK LEAD AS ACTIVE
    if (isset($xml_read)) {
        
        
        
        // UPDATE LEAD - CREATE THE XML DOCUMENT
        $xmlDoc_update = new DOMDocument();
        
        
        
        // UPDATE LEAD - CREATE THE XML ELEMENTS
        $root_update = $xmlDoc_update->appendChild(
        $xmlDoc_update->createElement("data"));
        $leadRequestTag = $root_update->appendChild($xmlDoc_update->createElement("lead"));
        $leadRequestTag->appendChild($xmlDoc_update->createElement("key", $api_key));
        $leadRequestTag->appendChild($xmlDoc_update->createElement("request", "update"));
        $leadRequestTag->appendChild($xmlDoc_update->createElement("id", $lead_id));
        $leadRequestTag->appendChild($xmlDoc_update->createElement("status", "Wedding Enquiry"));
        $xmlDoc_update->formatOutput = true;
        $xml_update = $xmlDoc_update->saveXML();
        
        
        
        // UPDATE LEAD - TRANSFER XML TO FLG 360
        $ch_update = curl_init($url_update);
        curl_setopt($ch_update, CURLOPT_URL, $url_update);
        curl_setopt($ch_update, CURLOPT_POST, count($lead));
        curl_setopt($ch_update, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch_update, CURLOPT_POSTFIELDS, $xml_update);
        curl_setopt($ch_update, CURLOPT_RETURNTRANSFER, 1);
        $result_update = curl_exec($ch_update);
        curl_close($ch_update);
    
    
    
        // FETCH VENUE HIGHLIGHTS FROM DATABASE
        $query = "SELECT * FROM cms_venue_highlights WHERE venue_name = '". $venue_name ."' AND package_day = '". $wedding_day ."'";
        $get_highlights = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($get_highlights)) {
            $package_details = $row['package_details'];
        }
    
    
    
        // SEND QUOTE TO LEAD DROPBOX
        $to = $dropbox;
        $subject = "Estimated Quote for ". $venue_name ." Package";
        $headers = "From: matt@ukweddingsavings.co.uk\r\n";
        $headers.= "MIME-Version: 1.0\r\n";
        $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $message = '<html><body style="font-family: Arial, Helvetica, sans-serif; background: #cccccc;"><table width="700" cellpadding="20" cellspacing="0" border="0" style="background-color: #ffffff;"><tr><td><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center"><img src="https://www.ukweddingsavings.co.uk/images/mainlogo.jpg" alt="UK Wedding Savings" width="200px"></td></tr><tr><td><p><b>'. date("d/m/Y") .'</b></p><p><b>Hello '. $first_name .' '. $last_name .'</b></p><p>Thank you for visiting our website.</p><p>As you would have seen we have fantastic deals online at <b><a href="https://www.ukweddingsavings.co.uk">www.ukweddingsavings.co.uk</a></b> and with new deals being offered throughout the year for different venues and locations.</p><p>Our special offers are exclusive to us and will not be offered to you if you directly to the venue. All our quotations are estimated only and should be used as a guide only. The Wedding Venue will supply you with a full quotation upon viewing and will deal with the formal details of your wedding once your final arrangements have been finalised.</p></td></tr></table><br /><table width="100%" cellpadding="10" cellspacing="0" border="0"><tr><td width="48%" valign="top" style="background: #a8d8ff;"><p style="text-align: center; font-size: 22px;"><b>ESTIMATED QUOTE SUMMARY</b></p><p><b>Venue Name</b><br />'. $venue_name .'</p><p><b>Wedding Date</b><br />'. $wedding_date .'</p><p><b>Base Package Price &#163;'. number_format($package_price) .'</b><br />Inc '. $package_guests .' Daytime & Evening Guests</p><p><b>Additional Daytime Total &#163;'. number_format($add_daytime_total) .'</b><br />'. $remaining_daytime .' Guests @ &#163;'. number_format($daytime_price) .' per person</p><p><b>Additional Evening Total &#163;'. number_format($add_evening_total) .'</b><br />'. $remaining_evening .' Guests @ &#163;'. number_format($evening_price) .' per person</p><p><b>Optional Extras</b><br />DJ Hire - &#163;'. number_format($ext_evening_entertain) .'</p><p style="font-size: 20px;"><b>Estimated Total - &#163;'. number_format($grand_total) .'</b></p><br /><p>All Prices are subject to change without notice and can exclude Bank Holidays, Sundays, Monday Public Holidays and Prime Dates.</p></td><td width="4%"></td><td width="48%" valign="top"><p style="text-align: center; font-size: 22px;"><b>PACKAGE HIGHLIGHTS</b></p>'. $package_details .'<p style="text-align: center;"><b>THIS VENUE HAS '. $venue_max_hotel_rooms .' HOTEL ROOMS STARTNG FROM &#163;'. number_format($venue_hotel_room_price) .'</b></p></td></tr></table><br /><table width="100%" cellpadding="30" cellspacing="0" border="0"><tr><td width="48%" align="center" valign="top"><a href="https://www.ukweddingsavings.co.uk/tools/quotes/check-date.php?id='. $lead_id .'&v='. $venue_name .'&d='. $wedding_date .'&p='. $grand_total .'" style="text-decoration: none;"><div style="width: 100%; background: #007bff; padding: 20px 0px; border-radius: 10px; border: 0; line-height: 30px; font-size: 20px; color: #ffffff; cursor: pointer;">Please See If My Date<br />is Still Available</div></a></td><td width="4%"></td><td width="48%" align="center" valign="top"><a href="https://www.ukweddingsavings.co.uk/tools/quotes/book-viewing.php?id='. $lead_id .'&v='. $venue_name .'&d='. $wedding_date .'&p='. $grand_total .'" style="text-decoration: none;"><div style="width: 100%; background: #007bff; padding: 20px 0px; border-radius: 10px; border: 0; line-height: 30px; font-size: 20px; color: #ffffff; cursor: pointer;">Book a Viewing with<br />the Venue Now</div></a></td></tr></table></td></tr></table></td></tr></table></body></html>';
        mail($to, $subject, $message, $headers);
    
    
    
        // SEND QUOTE TO LEAD EMAIL ADDRESS
        $to = $email_address;
        $subject = "Estimated Quote for ". $venue_name ." Package";
        $headers = "From: matt@ukweddingsavings.co.uk\r\n";
        $headers.= "MIME-Version: 1.0\r\n";
        $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $message = '<html><body style="font-family: Arial, Helvetica, sans-serif; background: #cccccc;"><table width="700" cellpadding="20" cellspacing="0" border="0" style="background-color: #ffffff;"><tr><td><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center"><img src="https://www.ukweddingsavings.co.uk/images/mainlogo.jpg" alt="UK Wedding Savings" width="200px"></td></tr><tr><td><p><b>'. date("d/m/Y") .'</b></p><p><b>Hello '. $first_name .' '. $last_name .'</b></p><p>Thank you for visiting our website.</p><p>As you would have seen we have fantastic deals online at <b><a href="https://www.ukweddingsavings.co.uk">www.ukweddingsavings.co.uk</a></b> and with new deals being offered throughout the year for different venues and locations.</p><p>Our special offers are exclusive to us and will not be offered to you if you directly to the venue. All our quotations are estimated only and should be used as a guide only. The Wedding Venue will supply you with a full quotation upon viewing and will deal with the formal details of your wedding once your final arrangements have been finalised.</p></td></tr></table><br /><table width="100%" cellpadding="10" cellspacing="0" border="0"><tr><td width="48%" valign="top" style="background: #a8d8ff;"><p style="text-align: center; font-size: 22px;"><b>ESTIMATED QUOTE SUMMARY</b></p><p><b>Venue Name</b><br />'. $venue_name .'</p><p><b>Wedding Date</b><br />'. $wedding_date .'</p><p><b>Base Package Price &#163;'. number_format($package_price) .'</b><br />Inc '. $package_guests .' Daytime & Evening Guests</p><p><b>Additional Daytime Total &#163;'. number_format($add_daytime_total) .'</b><br />'. $remaining_daytime .' Guests @ &#163;'. number_format($daytime_price) .' per person</p><p><b>Additional Evening Total &#163;'. number_format($add_evening_total) .'</b><br />'. $remaining_evening .' Guests @ &#163;'. number_format($evening_price) .' per person</p><p><b>Optional Extras</b><br />DJ Hire - &#163;'. number_format($ext_evening_entertain) .'</p><p style="font-size: 20px;"><b>Estimated Total - &#163;'. number_format($grand_total) .'</b></p><br /><p>All Prices are subject to change without notice and can exclude Bank Holidays, Sundays, Monday Public Holidays and Prime Dates.</p></td><td width="4%"></td><td width="48%" valign="top"><p style="text-align: center; font-size: 22px;"><b>PACKAGE HIGHLIGHTS</b></p>'. $package_details .'<p style="text-align: center;"><b>THIS VENUE HAS '. $venue_max_hotel_rooms .' HOTEL ROOMS STARTNG FROM &#163;'. number_format($venue_hotel_room_price) .'</b></p></td></tr></table><br /><table width="100%" cellpadding="30" cellspacing="0" border="0"><tr><td width="48%" align="center" valign="top"><a href="https://www.ukweddingsavings.co.uk/tools/quotes/check-date.php?id='. $lead_id .'&v='. $venue_name .'&d='. $wedding_date .'&p='. $grand_total .'" style="text-decoration: none;"><div style="width: 100%; background: #007bff; padding: 20px 0px; border-radius: 10px; border: 0; line-height: 30px; font-size: 20px; color: #ffffff; cursor: pointer;">Please See If My Date<br />is Still Available</div></a></td><td width="4%"></td><td width="48%" align="center" valign="top"><a href="https://www.ukweddingsavings.co.uk/tools/quotes/book-viewing.php?id='. $lead_id .'&v='. $venue_name .'&d='. $wedding_date .'&p='. $grand_total .'" style="text-decoration: none;"><div style="width: 100%; background: #007bff; padding: 20px 0px; border-radius: 10px; border: 0; line-height: 30px; font-size: 20px; color: #ffffff; cursor: pointer;">Book a Viewing with<br />the Venue Now</div></a></td></tr></table></td></tr></table></td></tr></table></body></html>';
        mail($to, $subject, $message, $headers);
        
        
        
        // SEND QUOTE TO WEDDING VENUE
        $to = $venue_email;
        $subject = "Estimated Quote issued by UK Wedding Savings";
        $headers = "From: matt@ukweddingsavings.co.uk\r\n";
        $headers.= "MIME-Version: 1.0\r\n";
        $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $message = '<html><body style="font-family: Arial, Helvetica, sans-serif; background: #cccccc;"><table width="700" cellpadding="20" cellspacing="0" border="0" style="background-color: #ffffff;"><tr><td><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center"><img src="https://www.ukweddingsavings.co.uk/images/mainlogo.jpg" alt="UK Wedding Savings" width="200px"></td></tr><tr><td><p><b>'. date("d/m/Y") .'</b></p><p>Please find below a copy of the estimated quote we have sent to <b>'. $first_name .' '. $last_name .'</b>.</p><p>We will advise you if they request a show around.</p><p>All of our quotations are estimated only and should be used a guide only.</p></td></tr></table><br /><table width="100%" cellpadding="10" cellspacing="0" border="0"><tr><td width="48%" valign="top" style="background: #a8d8ff;"><p style="text-align: center; font-size: 22px;"><b>ESTIMATED QUOTE SUMMARY</b></p><p><b>Venue Name</b><br />'. $venue_name .'</p><p><b>Wedding Date</b><br />'. $wedding_date .'</p><p><b>Base Package Price &#163;'. number_format($package_price) .'</b><br />Inc '. $package_guests .' Daytime & Evening Guests</p><p><b>Additional Daytime Total &#163;'. number_format($add_daytime_total) .'</b><br />'. $remaining_daytime .' Guests @ &#163;'. number_format($daytime_price) .' per person</p><p><b>Additional Evening Total &#163;'. number_format($add_evening_total) .'</b><br />'. $remaining_evening .' Guests @ &#163;'. number_format($evening_price) .' per person</p><p><b>Optional Extras</b><br />DJ Hire - &#163;'. number_format($ext_evening_entertain) .'</p><p style="font-size: 20px;"><b>Estimated Total - &#163;'. number_format($grand_total) .'</b></p><br /><p>All Prices are subject to change without notice and can exclude Bank Holidays, Sundays, Monday Public Holidays and Prime Dates.</p></td><td width="4%"></td><td width="48%" valign="top"><p style="text-align: center; font-size: 22px;"><b>PACKAGE HIGHLIGHTS</b></p>'. $package_details .'<p style="text-align: center;"><b>THIS VENUE HAS '. $venue_max_hotel_rooms .' HOTEL ROOMS STARTNG FROM &#163;'. number_format($venue_hotel_room_price) .'</b></p></td></tr></table></td></tr></table></body></html>';
        mail($to, $subject, $message, $headers);
    
    
    
        // CLOSE CONNECTION
        mysqli_close($connection);
        
        
    }
    
    
    
// IF LEAD WITH PROVIDED EMAIL DOES NOT EXIST
} else if ($lead_exists == "No") {
    
    
    
    // CREATE LEAD - LEAD DETAILS
    $source = "UKWS Quote Tool";
    $leadgroup = "45913";
    $site = "15186";
    $reference = "0";
    $introducer = "";
    $medium = "";
    $flg_post = "Yes";
    $flg_email = "Yes";
    $flg_phone = "Yes";
    $flg_text = "Yes";
    
    
    
    // CREATE LEAD - CREATE THE XML DOCUMENT
    $xmlDoc_create = new DOMDocument();
    
    
    
    // CREATE LEAD - CREATE THE XML ELEMENTS
    $root_create = $xmlDoc_create->appendChild(
    $xmlDoc_create->createElement("data"));
    $leadRequestTag = $root_create->appendChild($xmlDoc_create->createElement("lead"));
    $leadRequestTag->appendChild($xmlDoc_create->createElement("key", $api_key));
    $leadRequestTag->appendChild($xmlDoc_create->createElement("leadgroup", $leadgroup));
    $leadRequestTag->appendChild($xmlDoc_create->createElement("site", $site));
    $leadRequestTag->appendChild($xmlDoc_create->createElement("introducer", $introducer));
    $leadRequestTag->appendChild($xmlDoc_create->createElement("reference", $reference));
    $leadRequestTag->appendChild($xmlDoc_create->createElement("source", $source));
    $leadRequestTag->appendChild($xmlDoc_create->createElement("medium", $medium));
    $leadRequestTag->appendChild($xmlDoc_create->createElement("firstname", $first_name));
    $leadRequestTag->appendChild($xmlDoc_create->createElement("lastname", $last_name));
    $leadRequestTag->appendChild($xmlDoc_create->createElement("phone1", $contact_number));
    $leadRequestTag->appendChild($xmlDoc_create->createElement("email", $email_address));
    $leadRequestTag->appendChild($xmlDoc_create->createElement("Contactmail", $flg_post));
    $leadRequestTag->appendChild($xmlDoc_create->createElement("Contactemail", $flg_email));
    $leadRequestTag->appendChild($xmlDoc_create->createElement("Contactphone", $flg_phone));
    $leadRequestTag->appendChild($xmlDoc_create->createElement("Contactsms", $flg_text));
    $xmlDoc_create->formatOutput = true;
    $xml_create = $xmlDoc_create->saveXML();
    
    
    
    // CREATE LEAD - TRANSFER XML TO FLG 360
    $ch_create = curl_init($url_create);
    curl_setopt($ch_create, CURLOPT_URL, $url_create);
    curl_setopt($ch_create, CURLOPT_POST, count($lead));
    curl_setopt($ch_create, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
    curl_setopt($ch_create, CURLOPT_POSTFIELDS, $xml_create);
    curl_setopt($ch_create, CURLOPT_RETURNTRANSFER, 1);
    $result_create = curl_exec($ch_create);
    curl_close($ch_create);
    
    
    
    // CREATE LEAD - HANDLE XML FLG 360 RESULTS
    $string_create = $result_create;
    $xml_create = simplexml_load_string($string_create);
    
    
    
    // CREATE LEAD - FETCH LEAD ID
    $lead_id = $xml_create->item->id;
    
    
    
    // IF LEAD CREATE IS SUCCESSFUL FETCH FLG 360 THE FETCH DROPBOX EMAIL
    if (isset($xml_create)) {
        
        
        
        // READ LEAD - CREATE THE XML DOCUMENT
        $xmlDoc_read = new DOMDocument();
        
        
        
        // READ LEAD - CREATE THE XML ELEMENTS
        $root_read = $xmlDoc_read->appendChild(
        $xmlDoc_read->createElement("data"));
        $root_read->appendChild($xmlDoc_read->createElement("key", $api_key));
        $root_read->appendChild($xmlDoc_read->createElement("request", "read"));
        $root_read->appendChild($xmlDoc_read->createElement("id", $lead_id));
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
        
        
        
        // READ LEAD - FETCH LEAD DROPBOX EMAIL
        $lead_id = $xml_read->id;
        $dropbox = $xml_read->dropbox;
        
        
        
        // FETCH VENUE HIGHLIGHTS FROM DATABASE
        $query = "SELECT * FROM cms_venue_highlights WHERE venue_name = '". $venue_name ."' AND package_day = '". $wedding_day ."'";
        $get_highlights = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($get_highlights)) {
            $package_details = $row['package_details'];
        }
        
        
        
        // SEND QUOTE TO LEAD DROPBOX
        $to = $dropbox;
        $subject = "Estimated Quote for ". $venue_name ." Package";
        $headers = "From: matt@ukweddingsavings.co.uk\r\n";
        $headers.= "MIME-Version: 1.0\r\n";
        $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $message = '<html><body style="font-family: Arial, Helvetica, sans-serif; background: #cccccc;"><table width="700" cellpadding="20" cellspacing="0" border="0" style="background-color: #ffffff;"><tr><td><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center"><img src="https://www.ukweddingsavings.co.uk/images/mainlogo.jpg" alt="UK Wedding Savings" width="200px"></td></tr><tr><td><p><b>'. date("d/m/Y") .'</b></p><p><b>Hello '. $first_name .' '. $last_name .'</b></p><p>Thank you for visiting our website.</p><p>As you would have seen we have fantastic deals online at <b><a href="https://www.ukweddingsavings.co.uk">www.ukweddingsavings.co.uk</a></b> and with new deals being offered throughout the year for different venues and locations.</p><p>Our special offers are exclusive to us and will not be offered to you if you directly to the venue. All our quotations are estimated only and should be used as a guide only. The Wedding Venue will supply you with a full quotation upon viewing and will deal with the formal details of your wedding once your final arrangements have been finalised.</p></td></tr></table><br /><table width="100%" cellpadding="10" cellspacing="0" border="0"><tr><td width="48%" valign="top" style="background: #a8d8ff;"><p style="text-align: center; font-size: 22px;"><b>ESTIMATED QUOTE SUMMARY</b></p><p><b>Venue Name</b><br />'. $venue_name .'</p><p><b>Wedding Date</b><br />'. $wedding_date .'</p><p><b>Base Package Price &#163;'. number_format($package_price) .'</b><br />Inc '. $package_guests .' Daytime & Evening Guests</p><p><b>Additional Daytime Total &#163;'. number_format($add_daytime_total) .'</b><br />'. $remaining_daytime .' Guests @ &#163;'. number_format($daytime_price) .' per person</p><p><b>Additional Evening Total &#163;'. number_format($add_evening_total) .'</b><br />'. $remaining_evening .' Guests @ &#163;'. number_format($evening_price) .' per person</p><p><b>Optional Extras</b><br />DJ Hire - &#163;'. number_format($ext_evening_entertain) .'</p><p style="font-size: 20px;"><b>Estimated Total - &#163;'. number_format($grand_total) .'</b></p><br /><p>All Prices are subject to change without notice and can exclude Bank Holidays, Sundays, Monday Public Holidays and Prime Dates.</p></td><td width="4%"></td><td width="48%" valign="top"><p style="text-align: center; font-size: 22px;"><b>PACKAGE HIGHLIGHTS</b></p>'. $package_details .'<p style="text-align: center;"><b>THIS VENUE HAS '. $venue_max_hotel_rooms .' HOTEL ROOMS STARTNG FROM &#163;'. number_format($venue_hotel_room_price) .'</b></p></td></tr></table><br /><table width="100%" cellpadding="30" cellspacing="0" border="0"><tr><td width="48%" align="center" valign="top"><a href="https://www.ukweddingsavings.co.uk/tools/quotes/check-date.php?id='. $lead_id .'&v='. $venue_name .'&d='. $wedding_date .'&p='. $grand_total .'" style="text-decoration: none;"><div style="width: 100%; background: #007bff; padding: 20px 0px; border-radius: 10px; border: 0; line-height: 30px; font-size: 20px; color: #ffffff; cursor: pointer;">Please See If My Date<br />is Still Available</div></a></td><td width="4%"></td><td width="48%" align="center" valign="top"><a href="https://www.ukweddingsavings.co.uk/tools/quotes/book-viewing.php?id='. $lead_id .'&v='. $venue_name .'&d='. $wedding_date .'&p='. $grand_total .'" style="text-decoration: none;"><div style="width: 100%; background: #007bff; padding: 20px 0px; border-radius: 10px; border: 0; line-height: 30px; font-size: 20px; color: #ffffff; cursor: pointer;">Book a Viewing with<br />the Venue Now</div></a></td></tr></table></td></tr></table></td></tr></table></body></html>';
        mail($to, $subject, $message, $headers);
    
    
    
        // SEND QUOTE TO LEAD EMAIL ADDRESS
        $to = $email_address;
        $subject = "Estimated Quote for ". $venue_name ." Package";
        $headers = "From: matt@ukweddingsavings.co.uk\r\n";
        $headers.= "MIME-Version: 1.0\r\n";
        $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $message = '<html><body style="font-family: Arial, Helvetica, sans-serif; background: #cccccc;"><table width="700" cellpadding="20" cellspacing="0" border="0" style="background-color: #ffffff;"><tr><td><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center"><img src="https://www.ukweddingsavings.co.uk/images/mainlogo.jpg" alt="UK Wedding Savings" width="200px"></td></tr><tr><td><p><b>'. date("d/m/Y") .'</b></p><p><b>Hello '. $first_name .' '. $last_name .'</b></p><p>Thank you for visiting our website.</p><p>As you would have seen we have fantastic deals online at <b><a href="https://www.ukweddingsavings.co.uk">www.ukweddingsavings.co.uk</a></b> and with new deals being offered throughout the year for different venues and locations.</p><p>Our special offers are exclusive to us and will not be offered to you if you directly to the venue. All our quotations are estimated only and should be used as a guide only. The Wedding Venue will supply you with a full quotation upon viewing and will deal with the formal details of your wedding once your final arrangements have been finalised.</p></td></tr></table><br /><table width="100%" cellpadding="10" cellspacing="0" border="0"><tr><td width="48%" valign="top" style="background: #a8d8ff;"><p style="text-align: center; font-size: 22px;"><b>ESTIMATED QUOTE SUMMARY</b></p><p><b>Venue Name</b><br />'. $venue_name .'</p><p><b>Wedding Date</b><br />'. $wedding_date .'</p><p><b>Base Package Price &#163;'. number_format($package_price) .'</b><br />Inc '. $package_guests .' Daytime & Evening Guests</p><p><b>Additional Daytime Total &#163;'. number_format($add_daytime_total) .'</b><br />'. $remaining_daytime .' Guests @ &#163;'. number_format($daytime_price) .' per person</p><p><b>Additional Evening Total &#163;'. number_format($add_evening_total) .'</b><br />'. $remaining_evening .' Guests @ &#163;'. number_format($evening_price) .' per person</p><p><b>Optional Extras</b><br />DJ Hire - &#163;'. number_format($ext_evening_entertain) .'</p><p style="font-size: 20px;"><b>Estimated Total - &#163;'. number_format($grand_total) .'</b></p><br /><p>All Prices are subject to change without notice and can exclude Bank Holidays, Sundays, Monday Public Holidays and Prime Dates.</p></td><td width="4%"></td><td width="48%" valign="top"><p style="text-align: center; font-size: 22px;"><b>PACKAGE HIGHLIGHTS</b></p>'. $package_details .'<p style="text-align: center;"><b>THIS VENUE HAS '. $venue_max_hotel_rooms .' HOTEL ROOMS STARTNG FROM &#163;'. number_format($venue_hotel_room_price) .'</b></p></td></tr></table><br /><table width="100%" cellpadding="30" cellspacing="0" border="0"><tr><td width="48%" align="center" valign="top"><a href="https://www.ukweddingsavings.co.uk/tools/quotes/check-date.php?id='. $lead_id .'&v='. $venue_name .'&d='. $wedding_date .'&p='. $grand_total .'" style="text-decoration: none;"><div style="width: 100%; background: #007bff; padding: 20px 0px; border-radius: 10px; border: 0; line-height: 30px; font-size: 20px; color: #ffffff; cursor: pointer;">Please See If My Date<br />is Still Available</div></a></td><td width="4%"></td><td width="48%" align="center" valign="top"><a href="https://www.ukweddingsavings.co.uk/tools/quotes/book-viewing.php?id='. $lead_id .'&v='. $venue_name .'&d='. $wedding_date .'&p='. $grand_total .'" style="text-decoration: none;"><div style="width: 100%; background: #007bff; padding: 20px 0px; border-radius: 10px; border: 0; line-height: 30px; font-size: 20px; color: #ffffff; cursor: pointer;">Book a Viewing with<br />the Venue Now</div></a></td></tr></table></td></tr></table></td></tr></table></body></html>';
        mail($to, $subject, $message, $headers);
        
        
        
        // SEND QUOTE TO WEDDING VENUE
        $to = $venue_email;
        $subject = "Estimated Quote issued by UK Wedding Savings";
        $headers = "From: matt@ukweddingsavings.co.uk\r\n";
        $headers.= "MIME-Version: 1.0\r\n";
        $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $message = '<html><body style="font-family: Arial, Helvetica, sans-serif; background: #cccccc;"><table width="700" cellpadding="20" cellspacing="0" border="0" style="background-color: #ffffff;"><tr><td><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center"><img src="https://www.ukweddingsavings.co.uk/images/mainlogo.jpg" alt="UK Wedding Savings" width="200px"></td></tr><tr><td><p><b>'. date("d/m/Y") .'</b></p><p>Please find below a copy of the estimated quote we have sent to <b>'. $first_name .' '. $last_name .'</b>.</p><p>We will advise you if they request a show around.</p><p>All of our quotations are estimated only and should be used a guide only.</p></td></tr></table><br /><table width="100%" cellpadding="10" cellspacing="0" border="0"><tr><td width="48%" valign="top" style="background: #a8d8ff;"><p style="text-align: center; font-size: 22px;"><b>ESTIMATED QUOTE SUMMARY</b></p><p><b>Venue Name</b><br />'. $venue_name .'</p><p><b>Wedding Date</b><br />'. $wedding_date .'</p><p><b>Base Package Price &#163;'. number_format($package_price) .'</b><br />Inc '. $package_guests .' Daytime & Evening Guests</p><p><b>Additional Daytime Total &#163;'. number_format($add_daytime_total) .'</b><br />'. $remaining_daytime .' Guests @ &#163;'. number_format($daytime_price) .' per person</p><p><b>Additional Evening Total &#163;'. number_format($add_evening_total) .'</b><br />'. $remaining_evening .' Guests @ &#163;'. number_format($evening_price) .' per person</p><p><b>Optional Extras</b><br />DJ Hire - &#163;'. number_format($ext_evening_entertain) .'</p><p style="font-size: 20px;"><b>Estimated Total - &#163;'. number_format($grand_total) .'</b></p><br /><p>All Prices are subject to change without notice and can exclude Bank Holidays, Sundays, Monday Public Holidays and Prime Dates.</p></td><td width="4%"></td><td width="48%" valign="top"><p style="text-align: center; font-size: 22px;"><b>PACKAGE HIGHLIGHTS</b></p>'. $package_details .'<p style="text-align: center;"><b>THIS VENUE HAS '. $venue_max_hotel_rooms .' HOTEL ROOMS STARTNG FROM &#163;'. number_format($venue_hotel_room_price) .'</b></p></td></tr></table></td></tr></table></body></html>';
        mail($to, $subject, $message, $headers);
        
        
        
        // CLOSE CONNECTION
        mysqli_close($connection);
        
        
        
    }
}



?>