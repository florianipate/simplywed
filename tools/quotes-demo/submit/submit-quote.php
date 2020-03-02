<?php
// SET TIMEZONE
date_default_timezone_set("Europe/London");



// CONNECT TO DATABASE
include "../../../includes/connect.php";



// FETCH DETAILS FROM AJAX REQUEST
$date_added = date("d/m/Y H:i:s");
$venue_county = "Essex";
$venue_name = $_REQUEST["venue_name"];
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



// FETCH PACKAGE DETAILS FROM DATABASE
$package_detail_limit = 30;
$query = "SELECT * FROM demo_venue_packages_details WHERE venue_name = '". $venue_name ."'";
$get_packages = mysqli_query($connection, $query);
while($row = mysqli_fetch_assoc($get_packages)) {
    $package_list = '<table border="0" width="100%" cellpadding="2">';
    for($x = 1; $x <= $package_detail_limit; $x++) {
        if ($row["package_item_$x"] != "") {
            $package_list .= '<tr><td valign="top"><img src="http://www.simplywed.co.uk/images/quotation/heart.png" alt="Pink Heart"></td><td><p>'. $row["package_item_$x"] .'</p></td></tr>';
        }
    }
    $package_list .= '</table><br />';
}
    
    
    
// SEND USER ESTIMATED QUOTE EMAIL
$to = $email_address;
$subject = "Estimated Quote Email Received by Users";
$headers = "From: enquiries@simplywed.co.uk\r\n";
$headers.= "MIME-Version: 1.0\r\n";
$headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$message = '<html><body style="font-family: Arial, Helvetica, sans-serif; background: #cccccc;"><table width="700" cellpadding="20" cellspacing="0" border="0" style="background-color: #ffffff;"><tr><td><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center"><img src="http://www.simplywed.co.uk/images/logo.jpg" alt="UK Wedding Savings" width="400px"></td></tr><tr><td><p><b>'. date("d/m/Y") .'</b></p><p><b>Hello '. $first_name .' '. $last_name .'</b></p><p>Thank you for visiting our website.</p><p>As you would have seen we have fantastic deals online at <b><a href="http://www.simplywed.co.uk/">www.simplywed.co.uk</a></b> with new deals being offered throughout the year at different venues and locations.</p><p>Our special offers are exclusive to us and will not be offered to you if you go directly to the venue. All our quotations are estimated and should be used as a guide only. The Wedding Venue will supply you with a full quotation upon viewing and will deal with the formal details of your wedding once arrangements have been finalised.</p></td></tr></table><br /><table width="100%" cellpadding="10" cellspacing="0" border="0"><tr><td width="48%" valign="top" style="background: #bc84ca; color: #ffffff;"><p style="text-align: center; font-size: 22px;"><b>OUOTE SUMMARY</b></p><p><b>Venue Name</b><br />'. $venue_name .'</p><p><b>Wedding Date</b><br />'. $wedding_date .'</p><p><b>Base Package Price &#163;'. number_format($package_price) .'</b><br />Inc '. $package_guests .' Daytime & Evening Guests</p><p><b>Additional Daytime Total &#163;'. number_format($add_daytime_total) .'</b><br />'. $remaining_daytime .' Guests @ &#163;'. number_format($daytime_price) .' per person</p><p><b>Additional Evening Total &#163;'. number_format($add_evening_total) .'</b><br />'. $remaining_evening .' Guests @ &#163;'. number_format($evening_price) .' per person</p><p><b>Optional Extras</b><br />DJ Hire - &#163;'. number_format($ext_evening_entertain) .'</p><p style="font-size: 20px;"><b>Estimated Total - &#163;'. number_format($grand_total) .'</b></p><br /><p>All Prices are subject to change without notice and can exclude Bank Holidays, Sundays, Monday Public Holidays and Prime Dates.</p><p>Prices will change depending on the month and day of the week.</p></td><td width="4%"></td><td width="48%" valign="top"><p style="text-align: center; font-size: 22px;"><b>PACKAGE HIGHLIGHTS</b></p>'. $package_list .'<p style="text-align: center;"><b>THIS VENUE HAS '. $venue_max_hotel_rooms .' HOTEL ROOMS STARTNG FROM &#163;'. number_format($venue_hotel_room_price) .'</b></p></td></tr></table><br /><table width="100%" cellpadding="30" cellspacing="0" border="0"><tr><td width="48%" align="center" valign="top"><a href="http://www.simplywed.co.uk/tools/quotes-demo/?c='. $venue_county .'" style="text-decoration: none;"><div style="width: 100%; background: #5b2c86; padding: 20px 0px; border-radius: 10px; border: 0; line-height: 30px; font-size: 20px; color: #ffffff; cursor: pointer;">Get a Revised Quote</div></a></td><td width="4%"></td><td width="48%" align="center" valign="top"><a href="http://www.simplywed.co.uk/tools/quotes-demo/book-viewing.php?id='. $account_id .'&v='. $venue_name .'&d='. $wedding_date .'&p='. $grand_total .'" style="text-decoration: none;"><div style="width: 100%; background: #5b2c86; padding: 20px 0px; border-radius: 10px; border: 0; line-height: 30px; font-size: 20px; color: #ffffff; cursor: pointer;">Book a Viewing</div></a></td></tr></table></td></tr></table></body></html>';
mail($to, $subject, $message, $headers);



// SEND VENUE QUOTE NOTIFICATION
$to = $email_address;
$subject = "Estimated Quote Notification Received by Venues";
$headers = "From: enquiries@simplywed.co.uk\r\n";
$headers.= "MIME-Version: 1.0\r\n";
$headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$message = '<html><body style="font-family: Arial, Helvetica, sans-serif; background: #cccccc;"><table width="700" cellpadding="20" cellspacing="0" border="0" style="background-color: #ffffff;"><tr><td><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center"><img src="http://www.simplywed.co.uk/images/logo.jpg" alt="UK Wedding Savings" width="400px"></td></tr><tr><td><p><b>'. date("d/m/Y") .'</b></p><p>Please find below a copy of the estimated quote sent to the following:</p><p><b>Full Name:</b> '. $first_name .' '. $last_name .'</p><p><b>Contact Number:</b> '. $contact_number .'</p><p><b>Email Address:</b> '. $email_address .'</p><p>We will advise you if they request a show around.</p><p>All of our quotations are estimated only and should be used a guide only.</p></td></tr></table><br /><table width="100%" cellpadding="10" cellspacing="0" border="0"><tr><td width="48%" valign="top" style="background: #bc84ca; color: #ffffff;"><p style="text-align: center; font-size: 22px;"><b>OUOTE SUMMARY</b></p><p><b>Venue Name</b><br />'. $venue_name .'</p><p><b>Wedding Date</b><br />'. $wedding_date .'</p><p><b>Base Package Price &#163;'. number_format($package_price) .'</b><br />Inc '. $package_guests .' Daytime & Evening Guests</p><p><b>Additional Daytime Total &#163;'. number_format($add_daytime_total) .'</b><br />'. $remaining_daytime .' Guests @ &#163;'. number_format($daytime_price) .' per person</p><p><b>Additional Evening Total &#163;'. number_format($add_evening_total) .'</b><br />'. $remaining_evening .' Guests @ &#163;'. number_format($evening_price) .' per person</p><p><b>Optional Extras</b><br />DJ Hire - &#163;'. number_format($ext_evening_entertain) .'</p><p style="font-size: 20px;"><b>Estimated Total - &#163;'. number_format($grand_total) .'</b></p><br /><p>All Prices are subject to change without notice and can exclude Bank Holidays, Sundays, Monday Public Holidays and Prime Dates.</p></td><td width="4%"></td><td width="48%" valign="top"><p style="text-align: center; font-size: 22px;"><b>PACKAGE HIGHLIGHTS</b></p>'. $package_list .'<p style="text-align: center;"><b>THIS VENUE HAS '. $venue_max_hotel_rooms .' HOTEL ROOMS STARTNG FROM &#163;'. number_format($venue_hotel_room_price) .'</b></p></td></tr></table></td></tr></table></body></html>';
mail($to, $subject, $message, $headers);



// CLOSE CONNECTION
mysqli_close($connection);



?>