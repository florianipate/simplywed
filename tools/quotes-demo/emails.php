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
    $package_list = '<table border="0" width="100%" cellpadding="2">';
    for($x = 1; $x <= $package_detail_limit; $x++) {
        if ($row["package_item_$x"] != "") {
            $package_list .= '<tr><td valign="top"><img src="http://www.simplywed.co.uk/images/quotation/heart.png" alt="Pink Heart"></td><td><p>'. $row["package_item_$x"] .'</p></td></tr>';
        }
    }
    $package_list .= '</table><br />';
}



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
                        <p><b>Hello '. $first_name .' '. $last_name .'</b></p>
                        <p>Thank you for visiting our website.</p>
                        <p>As you would have seen we have fantastic deals online at <b><a href="http://www.simplywed.co.uk/">www.simplywed.co.uk</a></b> with new deals being offered throughout the year at different venues and locations.</p><p>Our special offers are exclusive to us and will not be offered to you if you go directly to the venue. All our quotations are estimated and should be used as a guide only. The Wedding Venue will supply you with a full quotation upon viewing and will deal with the formal details of your wedding once arrangements have been finalised.</p>
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
            </table><br />
            <table width="100%" cellpadding="30" cellspacing="0" border="0">
                <tr>
                    <td width="48%" align="center" valign="top">
                        <a href="http://www.simplywed.co.uk/tools/quotes-demo/?c='. $venue_county .'" style="text-decoration: none;">
                            <div style="width: 100%; background: #5b2c86; padding: 20px 0px; border-radius: 10px; border: 0; line-height: 30px; font-size: 20px; color: #ffffff; cursor: pointer;">Get a Revised Quote</div>
                        </a>
                    </td>
                    <td width="4%"></td>
                    <td width="48%" align="center" valign="top">
                        <a href="http://www.simplywed.co.uk/tools/quotes-demo/book-viewing.php?id='. $account_id .'&v='. $venue_name .'&d='. $wedding_date .'&p='. $grand_total .'" style="text-decoration: none;">
                            <div style="width: 100%; background: #5b2c86; padding: 20px 0px; border-radius: 10px; border: 0; line-height: 30px; font-size: 20px; color: #ffffff; cursor: pointer;">Book a Viewing</div>
                        </a>
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
                        <p><b>Full Name:</b> '. $first_name .' '. $last_name .'</p>
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


<!-- CANTLEY HOUSE - Monday to Thursday
<table border="0" width="100%" cellpadding="2"><tr><td valign="top" width="10%"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td width="90%"><p>60 Guest Package.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Venue Hire.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Glass of Sparkling Wine on Arrival.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Three Course Wedding Meal.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Glass of Sparkling Wine for Toasts.</p></td></tr></table><br /> -->


<!-- CANTLEY HOUSE - Sunday or Friday
<table border="0" width="100%" cellpadding="2"><tr><td valign="top" width="10%"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td width="90%"><p>50 Guest Package.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Dedicated Wedding Co-ordinator.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Complimentary Menu Tasting for Bride & Groom.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Red Carpet.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Ceremony Room Hire.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Room hire for all function rooms within the Hotel.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Glass of Mulled Wine or Pimms on arrival for 50 guests.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Two Course Wedding Meal with Tea & Coffee for 50 guests.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Half a Bottle of House wine per person for 50 guests.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Glass of sparkling Wine to Toast the Bride & Groom for 50 guests.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Silver Cake Stand & Knife.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Evening Baps for 50 guests.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Use of 36 bedrooms including continental breakfast the following day.</p></td></tr></table><br /> -->


<!-- HADLOW MANOR
<table border="0" width="100%" cellpadding="2"><tr><td valign="top" width="10%"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td width="90%"><p>60 Guest Package.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Reception Room Hire with private bar until midnight.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Three Course Wedding Meal with Coffee and Mints.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Glass of Wine with Meal.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Glass of Bucks Fizz on Arrival.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Cake Stand and Knife.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Table Linen and Napkins.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Jugs of Iced Water on all tables.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Table Plan and Place Cards.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Wedding Co-ordinator to help plan your day.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Dedicated Manager on the day to act as toastmaster.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Dance Floor.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Special Bedroom Rates for Guests.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Chair Covers available for an additional price.</p></td></tr></table><br /> -->


<!-- HARTSFIELD MANOR
<table border="0" width="100%" cellpadding="2"><tr><td valign="top" width="10%"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td width="90%"><p>50 Guest Package.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Red Carpet Arrival with a Glass of Prosecco.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Three Course Wedding Meal with Tea and Coffee.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Half Bottle of House Wine with Wedding Meal.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>A Glass of Prosecco for Toast.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Chair Covers and Sashes of your colour.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Evening Buffet of Sausage or Bacon Baps.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Dance Floor for your Evening Reception.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Bridal Suite on your Wedding Night.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Menu Tasting for Bride and Groom.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Dedicated Wedding Coordinator.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Use of Silver Cake Stand and Knife.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Table Linen, Chairs, Table and Cutlery are included.</p></td></tr></table><br /> -->


<!-- HORSLEY ESTATE
<table border="0" width="100%" cellpadding="2"><tr><td valign="top" width="10%"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td width="90%"><p>50 Guest Package.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Exclusive use of the The Towers from 12 noon on your wedding day until 7am next morning.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Full Venue Hire including 3 Function Rooms, Private Bar and Dressing Rooms.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Use of the cloisters, unique ornamental chapel, soaring Tower and serene lake for photographs.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Use of the terrace complete with garden furniture and the large croquet lawn.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Exclusivity of all our newly refurbished Towers bedrooms.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Guest Room for your stay the night before the Wedding.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Use of the De Vere Suite on the night of the Wedding.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Fully Certified Toastmaster with attire.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Flower arrangements worth £300.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Elegant lime-washed Chiavari Chairs.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Red Carpet Arrival for you and your guests.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Civil Ceremony room if required at no additional cost with chairs and cream aisle runner.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Use of ceremonial cake knife and sterling silver stand.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Mirrored table centre pieces.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>White table clothes & linen with all crockery, cutlery & glassware are included.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Use of a Wooden 14ft by 14ft Dance Floor with Disco & DJ from 9pm to Midnight.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>PA System & Handheld Mic for Speeches.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Menu Tasting for the Wedding Couple.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Evening meal with a bed & breakfast stay on your 1st Wedding anniversary. (Not Guaranteed)</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>A welcome package with 2 glasses of Pimms & 1 glass of orange juice plus a choice of 2 canapes.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>A Three Course Wedding Meal followed by fresh coffee or teas with after dinner chocolates.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Half Bottle of House Wine per a person from our in cellar.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>A Glass of Sparkling Wine for the toast.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Evening Finger Buffet.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>21 Bedrooms included.</p></td></tr></table><br /> -->


<!-- LATIMER ESTATE
<table border="0" width="100%" cellpadding="2"><tr><td valign="top" width="10%"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td width="90%"><p>70 Guest Package.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Exclusive use of the brand new Cavendish suite, including a private bar & lobby.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Mansion House Gardens for Photographs & drinks reception.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Glass of Sparkling Wine or Bucks Fizz served upon arrival.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Three Course Wedding Meal Including Tea, Coffee & Mints.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Wine with dinner and jugs of water.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Complimentary Menu tasting for the happy couple.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Raise a glass of sparkling wine to toast the newlyweds during speeches.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Grey & white table linens & white napkins providing a classic, crisp room set up.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Silver round cake stand and silver cutting knife for the wedding cake.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Wooden professional dance floor.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Evening food of bacon or sausage baps for 75% of total evening guests.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Six contracted deluxe bedrooms in Manor House for close family & friends.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Junior Suite on the wedding night for newlyweds to end your wedding in style.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Discounted guest accommodation = 20% discount off best available/pay later rate bed & breakfast for the night of the wedding.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Dedicated Wedding Team offering advice and guidance throughout the planning process.</p></td></tr></table><br /> -->


<!-- MANOR OF GROVES
<table border="0" width="100%" cellpadding="2"><tr><td valign="top" width="10%"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td width="90%"><p>70 Guest Package.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Civil Ceremony Room Hire.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Wedding Breakfast Room Hire.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Use of the gardens adjacent to your function room.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Tables, chairs, crockery & cutlery.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>White linen.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Designated wedding co-ordinator.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Experienced function manager to run your event on the day.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>One glass of Pimms, Bucks Fizz, or Orange Juice per person on arrival.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Delicious there course Wedding Breakfast followed by coffee and mints.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Half Bottle of House Wine with the wedding breakfast.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Glass of Prosecco for the speeches.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Finger buffet for the Evening Reception, additional evening guests will be charged separately.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Complimentary Four Poster room on a bed and breakfast basis for the night of your wedding.</p></td></tr>
<tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Up to 15 rooms available on a preferential bed and breakfast rate for your guests (all bedrooms subject to availability).</p></td></tr></table><br /> -->


<!-- MILTON HILL HOUSE
<table border="0" width="100%" cellpadding="2"><tr><td valign="top" width="10%"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td width="90%"><p>80 Daytime Guests.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Reception Room Hire.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Red Carpet Arrival.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Wedding Coordinator.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Dedicated Banqueting Manager.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>A Glass of Prosecco for Reception.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>A Three course menu followed by tea, coffee and mints.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Half a bottle of house wine per person.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>A Glass of Prosecco for the Toasts.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Silver Cake Stand and Knife.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Menu Tasting for Bride & Groom.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Complimentary delux double bedroom for the happy couple inclusive of Prosecco and breakfast.</p></td></tr></table><br /> -->


<!-- REGENCY PARK HOTEL
<table border="0" width="100%" cellpadding="2"><tr><td valign="top" width="10%"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td width="90%"><p>60 Guest Package.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Ceremony & Wedding Breakfast Rooms.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Duty Manager to Run your Day.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Arrival Glass of Pimms.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Red Carpet.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Three Course Wedding Meal.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Glass of House Wine during Wedding Meal.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Tea, Coffee & Truffles.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Glass of Fizz for Toasts.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Cake Stand, Knife & Napkins.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>White Linen and Napkins for all Tables.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Table Number/Name Stands.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Easel for Displaying Table Plan.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Dancefloor.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Menu Tasting for Couple.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Preferential Guest Accommodation Rates.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Reduced Rate on Bridal Suite on the night of your wedding.</p></td></tr></table><br /> -->


<!-- REIGATE MANOR
<table border="0" width="100%" cellpadding="2"><tr><td valign="top" width="10%"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td width="90%"><p>60 Guest Package.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Room Hire.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Welcome drink of Pimm’s, Bucks Fizz or sparkling wine.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Three Course Wedding Meal with Coffee and Mints.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Half a bottle of house wine.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>A glass of sparkling wine to toast.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Table plan & name cards.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Cake stand & knife.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Table linen & napkins.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Duty Manager to act as Toastmaster.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Top table flower arrangement.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Bridal suite for your wedding night.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>White chair covers and sashes in a choice of colours.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Menu tasting for the wedding couple.</p></td></tr></table><br /> -->


<!-- SHENDISH MANOR
<table border="0" width="100%" cellpadding="2"><tr><td valign="top" width="10%"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td width="90%"><p>60 Guest Package.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Exclusive use of the Manor House or Apsley Suite until midnight.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Glass of Pimms, Sparkling Wine or Fruit Juice.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Canapés. (3 options)</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Three Course Wedding Meal including Tea & Coffee.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Two Glasses of House Wine per person.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Glass of Sparkling Wine to toast.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Menu Tasting for the happy couple.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Red Carpet arrival.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Chair Covers & Sashes.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>PA System & Microphone for speeches.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Easel for Table Plan, Table Numbers & Stands.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Cake Stand & Knife.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Dance Floor.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Finger Buffet. (4 options)</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Manor Superior for the night of the Wedding.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Dedicated Wedding Coordinator to help plan your day.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Dedicated Event Manager & Team to run your day.</p></td></tr></table><br /> -->


<!-- DEVONPORT HOUSE
<table border="0" width="100%" cellpadding="2"><tr><td valign="top" width="10%"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td width="90%"><p>50 Guest Package.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Reception Room Hire.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Red Carpet Welcome.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>One Arrival Drink – Bucks Fizz.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Three Course Wedding Meal with coffee and mints.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Half bottle of House Wine with Meal.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>A Glass of Prosecco for the Toasts.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Natural Chiavari Chairs.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Evening Reception mini fish and chip cones.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>White Linin Table cloths and napkins.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>Wedding Co-ordinator to help you plan your special day.</p></td></tr><tr><td valign="top"><img src="https://www.ukweddingsavings.co.uk/tools/quotes/images/heart.png" alt="Pink Heart"></td><td><p>A Complimentary Honeymoon Suite for the married couple on the wedding night.</p></td></tr></table><br /> -->