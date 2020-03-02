<?php
// SET TIMEZONE
date_default_timezone_set("Europe/London");



// CONNECT TO DATABASE
include "../../includes/connect.php";



// DISPLAY ALL VENUES FOR OFFICE IP ADDRESS
if ($_SERVER["REMOTE_ADDR"] == '212.139.32.146') {
    
    
    
    // SET EMPTY VARIABLE FOR COUNTY
    $selected_county = "";
    
    
    
    // FETCH ALL VENUE IN DATABASE
    $query = "SELECT * FROM cms_venue_packages";
    
    
    
} else {
    
    
    
    // START SESSION
    session_start();
    
    
    
    // ASSIGN SESSION DATA TO VARIABLES
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $contact_number = $_SESSION['contact_number'];
    $email_address = $_SESSION['email_address'];
    $selected_county = $_SESSION['county'];
    
    
    
    // FETCH ALL VENUE IN DATABASE FROM SELECTED COUNTY
    $query = "SELECT * FROM cms_venue_packages WHERE venue_county = '". $selected_county ."'";
    
    
    
}



?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="UTF-8" />
<title>UKWS - Wedding Quotations</title>
<meta name="description" content="UKWS - Wedding Quotations" />
<meta name="robots" content="noindex,nofollow,noodp,noydir" />
<meta name="author" content="Jason Cheeseborough" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
    
    
<!-- BOOTSTRAP / STYLE CSS -->
<link href="/css/quotation.css" rel="stylesheet">
<link href="/css/core/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="/css/core/bootstrap.min.css" rel="stylesheet">
<link href="/css/core/fontawesome.min.css" rel="stylesheet">
<link href="/images/favicon.ico" rel="icon" type="image/ico" />


</head><body style="background: #cccccc;">
<?php include_once ("includes/header.php"); ?>
<section id="content" class="content">
<div class="container-fluid py-5 bck-white">
    <div class="container text-center">
        
        
        
        
        <?php
        // CHECK IF A COUNTY IS SELECTED
        if (isset($selected_county)) {
            
            
            
            // DISPLAY PAGE CONTENT
            echo '<h1>ALL WEDDING VENUES IN '. strtoupper($selected_county) .'</h1>';
            echo '<h2>Choose Your Venue</h2><br />';
            
            
            
            // FETCH VENUE PACKAGES FROM DATABASE
            $row_limit = 0;
            $package_number = 0;
            $get_packages = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($get_packages)) {
                $venue_active = $row['venue_active'];
                $venue_name = $row['venue_name'];
                $venue_email = $row['venue_email'];
                $venue_title = $row['venue_title'];
                $venue_package = $row['venue_package'];
                $venue_package_guests = $row['venue_package_guests'];
                $venue_package_price = $row['venue_package_price'];
                $venue_max_daytime = $row['venue_max_daytime'];
                $venue_max_evening = $row['venue_max_evening'];
                $venue_max_hotel_rooms = $row['venue_max_hotel_rooms'];
                $venue_hotel_room_price = $row['venue_hotel_room_price'];
                $venue_image_name = $row['venue_image_name'];
                $venue_image_count = $row['venue_image_count'];
                if ($venue_active == 'Yes') {
                    $row_limit++;
                    $package_number++;
                    if ($row_limit == 1) {echo '<div class="row">';}
                    echo '<div class="col-md-4">
                        <div class="card mb-4">
                            <div id="carousel-'. $package_number .'" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">';


                                // DISPLAY ALL VENUE IMAGES IN GALLERY
                                for ($x = 1; $x <= $venue_image_count; $x++) {
                                    if($x == 1) {$first = 'active';} else {$first = '';}
                                    echo '<div class="carousel-item '. $first .'"><img src="http://www.simplywed.co.uk/images/venues/'. $venue_image_name .''. $x .'.jpg" class="d-block w-100" alt="Image One"></div>';
                                }


                                echo '</div>
                                <a class="carousel-control-prev" href="#carousel-'. $package_number .'" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carousel-'. $package_number .'" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a>
                            </div>
                            <div class="card-body bck-grey" id="body-main-'. $package_number .'">
                                <div class="col">
                                    <div class="row">
                                        <div class="col text-center">
                                            <p class="card-title font-19 txt-orange"><b>'. $venue_title .'</b></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-center">
                                            <p class="card-text font-19 txt-orange"><b>From £'. number_format($venue_package_price) .'</b></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-center">
                                            <p class="card-text font-16"><b>'. $venue_package .'</b></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col py-3">
                                    <div class="row mb-3">
                                        <div class="col-6 button">
                                            <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'">PACKAGE<br />DETAILS</button>
                                        </div>
                                        <div class="col-6 button">
                                            <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'">VIDEOS &<br />GALLERY</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col button">
                                            <a href="JavaScript:void(0);" onclick="startQuote('. $package_number .')"><button type="button" class="btn btn-purple">GET PERSONAL<br />ESTIMATED QUOTE</button></a>
                                        </div>
                                    </div>
                                </div>
                                <p><a href="JavaScript:void(0);" class="txt-orange"><b>Features & Amenities</b></a></p>
                                <p><a href="/privacy-policy.php" target="_blank" class="txt-orange"><b>Privacy Policy</b></a></p>
                            </div>
                            <div class="card-body bck-grey" id="body-quote-'. $package_number .'" style="display: none;">
                                <input type="hidden" id="venueName-'. $package_number .'" value="'. $venue_name .'">
                                <input type="hidden" id="venueEmail-'. $package_number .'" value="'. $venue_email .'">
                                <input type="hidden" id="venuePackageGuests-'. $package_number .'" value="'. $venue_package_guests .'">
                                <input type="hidden" id="venueMaxDaytime-'. $package_number .'" value="'. $venue_max_daytime .'">
                                <input type="hidden" id="venueMaxEvening-'. $package_number .'" value="'. $venue_max_evening .'">
                                <input type="hidden" id="venueMaxHotelRooms-'. $package_number .'" value="'. $venue_max_hotel_rooms .'">
                                <input type="hidden" id="venueHotelRoomPrice-'. $package_number .'" value="'. $venue_hotel_room_price .'">
                                <div id="quote-slide-'. $package_number .'-1">
                                    <div class="col form-group">
                                        <p id="GDPR_notice-'. $package_number .'"><b>We take GDPR seriously, please read our <a href="/privacy-policy.php" target="_blank">Privacy Policy</a> and tick the box above to continue</b></p>
                                        <p><input type="checkbox" class="checkmark" id="GDPR_check-'. $package_number .'"></p>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-1"><button type="button" class="btn btn-purple"><i class="fas fa-chevron-left"></i> BACK</button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-1"><button type="button" class="btn btn-purple">NEXT <i class="fas fa-chevron-right"></i></button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'">PACKAGE<br />DETAILS</button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'">VENUE<br />GALLERY</button>
                                            </div>
                                        </div>
                                    </div>
                                    <p><a href="/privacy-policy.php" target="_blank" class="txt-orange"><b>Privacy Policy</b></a></p>
                                </div>
                                <div id="quote-slide-'. $package_number .'-2" style="display: none;">
                                    <div class="col form-group">
                                        <label>Date of Wedding</label>
                                        <p class="txt-red" id="error-'. $package_number .'-2"></p>
                                        <p class="txt-green" id="message-'. $package_number .'-2"></p>
                                        <div class="input-group date my-4">
                                            <input type="text" class="form-control" id="weddingDate-'. $package_number .'" placeholder="DD/MM/YYYY">
                                            <div class="input-group-append"><div class="input-group-text"><i class="fas fa-calendar-alt"></i></div></div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-2"><button type="button" class="btn btn-purple"><i class="fas fa-chevron-left"></i> BACK</button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-2"><button type="button" class="btn btn-purple">NEXT <i class="fas fa-chevron-right"></i></button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'">PACKAGE<br />DETAILS</button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'">VENUE<br />GALLERY</button>
                                            </div>
                                        </div>
                                    </div>
                                    <p><a href="/privacy-policy.php" target="_blank" class="txt-orange"><b>Privacy Policy</b></a></p>
                                </div>
                                <div id="quote-slide-'. $package_number .'-3" style="display: none;">
                                    <div class="col form-group">
                                        <label>Daytime Guest Numbers</label>
                                        <p class="txt-red" id="error-'. $package_number .'-3"></p>
                                        <p class="txt-green" id="message-'. $package_number .'-3"></p>
                                        <input type="number" class="form-control my-4" id="daytimeGuests-'. $package_number .'">
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-3"><button type="button" class="btn btn-purple"><i class="fas fa-chevron-left"></i> BACK</button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-3"><button type="button" class="btn btn-purple">NEXT <i class="fas fa-chevron-right"></i></button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'">PACKAGE<br />DETAILS</button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'">VENUE<br />GALLERY</button>
                                            </div>
                                        </div>
                                    </div>
                                    <p><a href="/privacy-policy.php" target="_blank" class="txt-orange"><b>Privacy Policy</b></a></p>
                                </div>
                                <div id="quote-slide-'. $package_number .'-4" style="display: none;">
                                    <div class="col form-group">
                                        <label>Evening Guest Numbers</label>
                                        <p class="txt-red" id="error-'. $package_number .'-4"></p>
                                        <p class="txt-green" id="message-'. $package_number .'-4"></p>
                                        <input type="number" class="form-control my-4" id="eveningGuests-'. $package_number .'">
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-4"><button type="button" class="btn btn-purple"><i class="fas fa-chevron-left"></i> BACK</button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-4"><button type="button" class="btn btn-purple">NEXT <i class="fas fa-chevron-right"></i></button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'">PACKAGE<br />DETAILS</button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'">VENUE<br />GALLERY</button>
                                            </div>
                                        </div>
                                    </div>
                                    <p><a href="/privacy-policy.php" target="_blank" class="txt-orange"><b>Privacy Policy</b></a></p>
                                </div>
                                <div id="quote-slide-'. $package_number .'-5" style="display: none;">
                                    <div class="col form-group">
                                        <label>Do you need a DJ?</label>
                                        <p class="txt-red" id="error-'. $package_number .'-5"></p>
                                        <p class="txt-green" id="message-'. $package_number .'-5"></p>
                                        <select class="form-control my-4" id="eveningEntertain-'. $package_number .'"><option value="">Please Select</option><option value="Yes">Yes</option><option value="No">No</option></select>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-5"><button type="button" class="btn btn-purple"><i class="fas fa-chevron-left"></i> BACK</button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-5"><button type="button" class="btn btn-purple">NEXT <i class="fas fa-chevron-right"></i></button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'">PACKAGE<br />DETAILS</button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'">VENUE<br />GALLERY</button>
                                            </div>
                                        </div>
                                    </div>
                                    <p><a href="/privacy-policy.php" target="_blank" class="txt-orange"><b>Privacy Policy</b></a></p>
                                </div>
                                <div id="quote-slide-'. $package_number .'-6" style="display: none;">
                                    <div class="col form-group">
                                        <label>Your First Name</label>
                                        <p class="txt-red" id="error-'. $package_number .'-6"></p>
                                        <p class="txt-green" id="message-'. $package_number .'-6"></p>
                                        <input type="text" class="form-control my-4" id="firstName-'. $package_number .'" value="'. $first_name .'">
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-6"><button type="button" class="btn btn-purple"><i class="fas fa-chevron-left"></i> BACK</button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-6"><button type="button" class="btn btn-purple">NEXT <i class="fas fa-chevron-right"></i></button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'">PACKAGE<br />DETAILS</button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'">VENUE<br />GALLERY</button>
                                            </div>
                                        </div>
                                    </div>
                                    <p><a href="/privacy-policy.php" target="_blank" class="txt-orange"><b>Privacy Policy</b></a></p>
                                </div>
                                <div id="quote-slide-'. $package_number .'-7" style="display: none;">
                                    <div class="col form-group">
                                        <label>Your Last Name</label>
                                        <p class="txt-red" id="error-'. $package_number .'-7"></p>
                                        <p class="txt-green" id="message-'. $package_number .'-7"></p>
                                        <input type="text" class="form-control my-4" id="lastName-'. $package_number .'" value="'. $last_name .'">
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-7"><button type="button" class="btn btn-purple"><i class="fas fa-chevron-left"></i> BACK</button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-7"><button type="button" class="btn btn-purple">NEXT <i class="fas fa-chevron-right"></i></button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'">PACKAGE<br />DETAILS</button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'">VENUE<br />GALLERY</button>
                                            </div>
                                        </div>
                                    </div>
                                    <p><a href="/privacy-policy.php" target="_blank" class="txt-orange"><b>Privacy Policy</b></a></p>
                                </div>
                                <div id="quote-slide-'. $package_number .'-8" style="display: none;">
                                    <div class="col form-group">
                                        <label>Contact Number</label>
                                        <p class="txt-red" id="error-'. $package_number .'-8"></p>
                                        <p class="txt-green" id="message-'. $package_number .'-8"></p>
                                        <input type="text" class="form-control my-4" id="contactNumber-'. $package_number .'" value="'. $contact_number .'">
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-8"><button type="button" class="btn btn-purple"><i class="fas fa-chevron-left"></i> BACK</button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-8"><button type="button" class="btn btn-purple">NEXT <i class="fas fa-chevron-right"></i></button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'">PACKAGE<br />DETAILS</button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'">VENUE<br />GALLERY</button>
                                            </div>
                                        </div>
                                    </div>
                                    <p><a href="/privacy-policy.php" target="_blank" class="txt-orange"><b>Privacy Policy</b></a></p>
                                </div>
                                <div id="quote-slide-'. $package_number .'-9" style="display: none;">
                                    <div class="col form-group">
                                        <label>Email Address</label>
                                        <p class="txt-red" id="error-'. $package_number .'-9"></p>
                                        <p class="txt-green" id="message-'. $package_number .'-9"></p>
                                        <input type="email" class="form-control my-4" id="emailAddress-'. $package_number .'" value="'. $email_address .'">
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-9"><button type="button" class="btn btn-purple"><i class="fas fa-chevron-left"></i> BACK</button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-9"><button type="button" class="btn btn-purple">SUBMIT</button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'">PACKAGE<br />DETAILS</button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'">VENUE<br />GALLERY</button>
                                            </div>
                                        </div>
                                    </div>
                                    <p><a href="/privacy-policy.php" target="_blank" class="txt-orange"><b>Privacy Policy</b></a></p>
                                </div>
                                <div id="quote-slide-'. $package_number .'-10" style="display: none;">
                                    <div class="col">
                                        <h2>THANK YOU</h2><br />
                                        <h4>Your Quote has been sent to you. Please check your email for details.</h4><br />
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'">PACKAGE<br />DETAILS</button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'">VENUE<br />GALLERY</button>
                                            </div>
                                        </div>
                                    </div>
                                    <p><a href="/privacy-policy.php" target="_blank" class="txt-orange"><b>Privacy Policy</b></a></p>
                                </div>
                            </div>
                        </div>
                    </div>';
                    if ($row_limit == 3) {echo '</div>'; $row_limit = 0;}
                }
            }
            
            
            
            // PACKAGE DETAILS MODAL
            $details_number = 0;
            if ($_SERVER["REMOTE_ADDR"] == '212.139.32.146') {
                $query = "SELECT * FROM cms_venue_packages";
            } else {
                $query = "SELECT * FROM cms_venue_packages WHERE venue_county = '". $selected_county ."'";
            }
            $get_details = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($get_details)) {
                $venue_active = $row['venue_active'];
                $venue_county = $row['venue_county'];
                $venue_name = $row['venue_name'];
                if ($venue_active == 'Yes') {
                    $details_number++;
                    echo '<div class="modal fade" id="package-details-'. $details_number .'" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog modal-dialog-centered modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">'. $venue_name .' in '. $venue_county .'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">';


                    // DISPLAY VENUE PACKAGE DETAILS
                    $venue_name = preg_replace("/[\s_]/", "-", $venue_name);
                    include ("includes/packages/". strtolower($venue_name) .".php");


                    echo '</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div></div></div></div>';
                }
            }
            
            
            
            // PACKAGE GALLERY MODAL
            $details_number = 0;
            if ($_SERVER["REMOTE_ADDR"] == '212.139.32.146') {
                $query = "SELECT * FROM cms_venue_packages";
            } else {
                $query = "SELECT * FROM cms_venue_packages WHERE venue_county = '". $selected_county ."'";
            }
            $get_gallery = mysqli_query($connection,$query);
            while($row = mysqli_fetch_assoc($get_gallery)) {
                $venue_active = $row['venue_active'];
                $venue_county = $row['venue_county'];
                $venue_name = $row['venue_name'];
                $venue_image_name = $row['venue_image_name'];
                $venue_image_count = $row['venue_image_count'];
                if ($venue_active == 'Yes') {
                    $details_number++;
                    echo '<div class="modal fade" id="package-gallery-'. $details_number .'" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog modal-dialog-centered modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">'. $venue_name .' in '. $venue_county .'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="col"><div id="carousel-main-'. $details_number .'" class="carousel slide" data-ride="carousel"><div class="carousel-inner">';


                    // DISPLAY ALL VENUE IMAGES IN GALLERY
                    for ($x = 1; $x <= $venue_image_count; $x++) {
                        if($x == 1) {$first = 'active';} else {$first = '';}
                        echo '<div class="carousel-item '. $first .'"><img src="http://www.simplywed.co.uk/images/venues/'. $venue_image_name .''. $x .'.jpg" class="d-block w-100" alt="Image One"></div>';
                    }


                    echo '</div><a class="carousel-control-prev" href="#carousel-'. $details_number .'" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carousel-main-'. $details_number .'" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a></div></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div></div></div></div>';
                }
            }
            
            
            
        } else {
            
            
            
            // DISPLAY PAGE CONTENT
            echo '<h1>SORRY, THERE WAS A PROBLEM</h1>';
            echo '<h2>If you continue getting message please call us on <a href="tel:02038411045">0203 841 1045</a></h2><br />';
            echo '<h2>Alternatively, you can <a href="https://www.ukweddingsavings.co.uk/leads-new/">click here</a> to try again.</h2>';
            echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
            
            
            
        }
        ?>
        
        
        
        
    </div>
</div>
</section>
<?php include_once ("includes/footer.php"); ?>


<!-- JAVASCRIPT FOR BOOTSTRAP ELEMENTS -->
<script src="/js/core/jquery-3.3.1.slim.min.js" type="text/javascript"></script>
<script src="/js/core/popper.min.js" type="text/javascript"></script>
<script src="/js/core/bootstrap.min.js" type="text/javascript"></script>
    
    
<!-- JAVASCRIPT FOR BOOTSTRAP DATE PICKER -->
<script src="/js/core/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script>$('.input-group.date').datepicker({format: "dd/mm/yyyy",maxViewMode: 2,clearBtn: true,autoclose: true});</script>
    

<!-- JAVASCRIPT FOR QUOTATION FORM HANDLING -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/form-validation.min.js" type="text/javascript"></script>
<script src="js/quotation-form.min.js" type="text/javascript"></script>


</body></html>