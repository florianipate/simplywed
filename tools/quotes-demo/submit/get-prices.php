<?php
// SET TIMEZONE
date_default_timezone_set("Europe/London");



// CONNECT TO DATABASE
include "../../../includes/connect.php";



// FETCH DETAILS FROM AJAX REQUEST
$venue_number = $_REQUEST["venue_number"];
$venue_name = $_REQUEST["venue_name"];
$venue_max_daytime = $_REQUEST["venue_max_daytime"];
$venue_max_evening = $_REQUEST["venue_max_evening"];
$venue_max_hotel_rooms = $_REQUEST["venue_max_hotel_rooms"];
$venue_hotel_room_price = $_REQUEST["venue_hotel_room_price"];
$wedding_date = $_REQUEST["wedding_date"];
$wedding_month = $_REQUEST["wedding_month"];
$wedding_day = $_REQUEST["wedding_day"];
$daytime_guests = $_REQUEST["daytime_guests"];
$evening_guests = $_REQUEST["evening_guests"];
$evening_entertain = $_REQUEST["evening_entertain"];
$first_name = $_REQUEST["first_name"];
$last_name = $_REQUEST["last_name"];
$contact_number = $_REQUEST["contact_number"];
$email_address = $_REQUEST["email_address"];



// CONNECT TO VENUE PRICING DATABASE
$query = "SELECT * FROM demo_venue_pricing WHERE venue_name = '". $venue_name ."' AND package_month = '". $wedding_month ."' AND package_day = '". $wedding_day ."'";
$get_pricing = mysqli_query($connection, $query);



// FETCH ALL DATA ON THE SPECIFIED DAY VENUE PRICING
while($row = mysqli_fetch_assoc($get_pricing)) {
    $package_price = $row['package_price'];
    $package_guests = $row['package_guests'];
    $daytime_price = $row['daytime_price'];
    $evening_price = $row['evening_price'];
    $ext_evening_entertain = $row['ext_evening_entertain'];
}



// CREATE ARRAY FROM THE SPECIFIED DAY VENUE PRICING
$venue_pricing = array(
    "venue_number" => $venue_number,
    "venue_name" => $venue_name,
    "venue_max_daytime" => $venue_max_daytime,
    "venue_max_evening" => $venue_max_evening,
    "venue_max_hotel_rooms" => $venue_max_hotel_rooms,
    "venue_hotel_room_price" => $venue_hotel_room_price,
    "wedding_date" => $wedding_date,
    "wedding_day" => $wedding_day,
    "daytime_guests" => $daytime_guests,
    "evening_guests" => $evening_guests,
    "evening_entertain" => $evening_entertain,
    "first_name" => $first_name,
    "last_name" => $last_name,
    "contact_number" => $contact_number,
    "email_address" => $email_address,
    "package_price" => $package_price,
    "package_guests" => $package_guests,
    "daytime_price" => $daytime_price,
    "evening_price" => $evening_price,
    "ext_evening_entertain" => $ext_evening_entertain
);



// RETURN VENUE PRICING ARRAY
echo json_encode($venue_pricing);



?>