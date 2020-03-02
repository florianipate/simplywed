<?php
// CONNECT TO DATABASE
include "../../includes/connect.php";


// FETCH DETAILS FROM AJAX REQUEST
$venue_county = "Essex";
$venue_name = "The Stamford";
$venue_max_hotel_rooms = "108";
$venue_hotel_room_price = "99";
$wedding_date = "01/02/2020";
$daytime_guests = "80";
$evening_guests = "100";
$evening_entertain = "Yes";
$title = "Mr";
$first_name = "Jason";
$last_name = "Test 1";
$contact_number = "01268686868";
$email_address = "test@test.co.uk";
$package_price = "3999";
$package_guests = "60";
$daytime_price = "68";
$evening_price = "30";
$ext_evening_entertain = "395";
$account_id = "149040633";


// COMBINE INTO FULL NAME
$full_name = $title .' '. $first_name .' '. $last_name;


// CHECK FOR OPTIONAL EXTRAS
if ($evening_entertain == "No") {$ext_evening_entertain = "0";}


// CALCULATE PACKAGE PRICES
$remaining_daytime = $daytime_guests - $package_guests;
$remaining_evening = $evening_guests - $package_guests;
$add_daytime_total = $remaining_daytime * $daytime_price;
$add_evening_total = $remaining_evening * $evening_price;
$grand_total = $package_price + $add_daytime_total + $add_evening_total + $ext_evening_entertain;


// FETCH VENUE HIGHLIGHTS FROM DATABASE
$package_detail_limit = 30;
$query = "SELECT * FROM demo_venue_packages_details WHERE venue_name = '". $venue_name ."'";
$get_packages = mysqli_query($connection, $query);
while($row = mysqli_fetch_assoc($get_packages)) {
$package_list = '<table border="0" width="100%" cellpadding="2">';for($x = 1; $x <= $package_detail_limit; $x++) {if ($row["package_item_$x"] != "") {$package_list .= '<tr><td valign="top"><img src="http://www.simplywed.co.uk/images/quotation/heart.png" alt="Pink Heart"></td><td><p>'. $row["package_item_$x"] .'</p></td></tr>';}}$package_list .= '</table><br />';}


// CREATE EMAIL (CUSTOMER)
echo '<html><body style="font-family: Arial, Helvetica, sans-serif; background: #cccccc;">
<table width="700" cellpadding="20" cellspacing="0" border="0" style="background-color: #ffffff;">
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td align="center">
                        <img src="http://www.simplywed.co.uk/images/logo.jpg" alt="UK Wedding Savings" width="400px">
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><b>'. date("d/m/Y") .'</b></p>
                        <p><b>Hello '. $full_name .'</b></p>
                        <p>Thank you for visiting our website.</p>
                        <p>As you would have seen we have fantastic deals online at <b><a href="http://www.simplywed.co.uk/">www.simplywed.co.uk</a></b> with new deals being offered throughout the year at different venues and locations.</p><p>All our prices are estimated and should be used as a guide only. On your visit to the wedding venues the wedding co-ordinator will be able to answer any questions you might have and will supply you with a full quotation once your arrangements have been finakised.</p>
                    </td>
                </tr>
            </table><br />
            <table width="100%" cellpadding="10" cellspacing="0" border="0">
                <tr>
                    <td width="48%" align="left" valign="top">
                        <p style="font-weight: bold; color: #5b2c86;">YOUR WEDDING MIGHT SEEM A LONG TIME AWAY, BUT DATES GET BOOKED FAST.</p>
                        <p style="font-weight: bold; color: #5b2c86;">DO NOT BE DISSAPPOINTED, BOOK YOUR VIEW NOW.</p>
                    </td>
                    <td width="4%"></td>
                    <td width="48%" align="center" valign="middle">
                        <a href="http://www.simplywed.co.uk/tools/quotes-demo-new/viewing.php?v='. rawurlencode(base64_encode($venue_name)) .'&n='. rawurlencode(base64_encode($full_name)) .'&e='. rawurlencode(base64_encode($email_address)) .'&p='. rawurlencode(base64_encode($contact_number)) .'" style="text-decoration: none;">
                            <div style="width: 100%; background: #5b2c86; padding: 20px 0px; border-radius: 10px; border: 0; line-height: 30px; font-size: 20px; color: #ffffff; cursor: pointer;">Book Your Viewing</div>
                        </a>
                    </td>
                </tr>
            </table><br />
            <table width="100%" cellpadding="10" cellspacing="0" border="0">
                <tr>
                    <td width="48%" valign="top" style="background: #bc84ca; color: #ffffff;">
                        <p style="text-align: center; font-size: 22px;"><b>OUOTE SUMMARY</b></p>
                        <p><b>Venue Name</b><br />'. $venue_name .'</p>
                        <p><b>Wedding Date</b><br />'. $wedding_date .'</p>
                        <p><b>Base Package Price &#163;'. number_format($package_price) .'</b><br />Inc '. $package_guests .' Daytime & Evening Guests</p>
                        <p><b>Additional Daytime Total &#163;'. number_format($add_daytime_total) .'</b><br />'. $remaining_daytime .' Guests @ &#163;'. number_format($daytime_price) .' per person</p>
                        <p><b>Additional Evening Total &#163;'. number_format($add_evening_total) .'</b><br />'. $remaining_evening .' Guests @ &#163;'. number_format($evening_price) .' per person</p>
                        <p><b>Optional Extras</b><br />DJ Hire - &#163;'. number_format($ext_evening_entertain) .'</p>
                        <p style="font-size: 20px;"><b>Estimated Total - &#163;'. number_format($grand_total) .'</b></p><br />
                        <p>All Prices are subject to change without notice and can exclude Bank Holidays, Sundays, Monday Public Holidays and Prime Dates.</p>
                        <p>Prices will change depending on the month and day of the week.</p>
                    </td>
                    <td width="4%"></td>
                    <td width="48%" valign="top">
                        <p style="text-align: center; font-size: 22px;"><b>PACKAGE HIGHLIGHTS</b></p>
                        '. $package_list .'
                        <p style="text-align: center;"><b>THIS VENUE HAS '. $venue_max_hotel_rooms .' HOTEL ROOMS STARTNG FROM &#163;'. number_format($venue_hotel_room_price) .'</b></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body></html>';


// CREATE EMAIL (VENUE)
echo '<html><body style="font-family: Arial, Helvetica, sans-serif; background: #cccccc;">
<table width="700" cellpadding="20" cellspacing="0" border="0" style="background-color: #ffffff;">
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td align="center">
                        <img src="http://www.simplywed.co.uk/images/logo.jpg" alt="UK Wedding Savings" width="400px">
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><b>'. date("d/m/Y") .'</b></p>
                        <p>Please find below a copy of the estimated quote sent to the following:</p>
                        <p><b>Full Name:</b> '. $full_name .'</p>
                        <p><b>Contact Number:</b> '. $contact_number .'</p>
                        <p><b>Email Address:</b> '. $email_address .'</p>
                        <p>We will advise you if they request a show around.</p>
                        <p>All of our quotations are estimated only and should be used a guide only.</p>
                    </td>
                </tr>
            </table><br />
            <table width="100%" cellpadding="10" cellspacing="0" border="0">
                <tr>
                    <td width="48%" valign="top" style="background: #bc84ca; color: #ffffff;">
                        <p style="text-align: center; font-size: 22px;"><b>OUOTE SUMMARY</b></p>
                        <p><b>Venue Name</b><br />'. $venue_name .'</p>
                        <p><b>Wedding Date</b><br />'. $wedding_date .'</p>
                        <p><b>Base Package Price &#163;'. number_format($package_price) .'</b><br />Inc '. $package_guests .' Daytime & Evening Guests</p>
                        <p><b>Additional Daytime Total &#163;'. number_format($add_daytime_total) .'</b><br />'. $remaining_daytime .' Guests @ &#163;'. number_format($daytime_price) .' per person</p>
                        <p><b>Additional Evening Total &#163;'. number_format($add_evening_total) .'</b><br />'. $remaining_evening .' Guests @ &#163;'. number_format($evening_price) .' per person</p>
                        <p><b>Optional Extras</b><br />DJ Hire - &#163;'. number_format($ext_evening_entertain) .'</p>
                        <p style="font-size: 20px;"><b>Estimated Total - &#163;'. number_format($grand_total) .'</b></p><br />
                        <p>All Prices are subject to change without notice and can exclude Bank Holidays, Sundays, Monday Public Holidays and Prime Dates.</p>
                        <p>Prices will change depending on the month and day of the week.</p>
                    </td>
                    <td width="4%"></td>
                    <td width="48%" valign="top">
                        <p style="text-align: center; font-size: 22px;"><b>PACKAGE HIGHLIGHTS</b></p>
                        '. $package_list .'
                        <p style="text-align: center;"><b>THIS VENUE HAS '. $venue_max_hotel_rooms .' HOTEL ROOMS STARTNG FROM &#163;'. number_format($venue_hotel_room_price) .'</b></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body></html>';


?>