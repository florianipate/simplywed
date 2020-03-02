<?php
// SET TIMEZONE
date_default_timezone_set("Europe/London");



// CONNECT TO DATABASE
include "../../includes/connect.php";



// SET TEST COUNTY
$selected_county = "Essex";



?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="UTF-8" />
<title>Wedding Quotations (Demo)</title>
<meta name="description" content="Wedding Quotations (Demo)" />
<meta name="robots" content="noindex,nofollow,noodp,noydir" />
<meta name="author" content="Jason Cheeseborough" />
<meta name="viewport" content="width=device-width, initial-scale=1" />


<!-- BOOTSTRAP / STYLE CSS -->
<link href="/css/quotation.min.css" rel="stylesheet">
<link href="/css/core/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="/css/core/bootstrap.min.css" rel="stylesheet">
<link href="/images/favicon.ico" rel="icon" type="image/ico" />
    
    
<!-- FONT AWESOME CSS -->
<script src="https://kit.fontawesome.com/0781172ae7.js" crossorigin="anonymous"></script>


</head><body>
<section id="content" class="content">
<div class="container-fluid py-5 bck-white">
    <div class="container text-center">
        
        
        
        <?php
        // CHECK IF A COUNTY IS SELECTED
        if (isset($selected_county)) {
            
            
            
            // DISPLAY PAGE CONTENT
            echo '<h3 class="txt-red">Demo Purposes Only</h3><br />';
            echo '<h1>ALL WEDDING VENUES IN '. strtoupper($selected_county) .'</h1>';
            echo '<h2>Choose Your Venue</h2><br />';
            
            
            
            // FETCH VENUE PACKAGES FROM DATABASE
            $row_limit = 0;
            $package_number = 0;
            $query = "SELECT * FROM demo_venue_packages WHERE venue_county = '". $selected_county ."'";
            $get_packages = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($get_packages)) {
                $venue_active = $row['venue_active'];
                $venue_name = $row['venue_name'];
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
                $venue_video = $row['venue_video'];
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
                            <div class="card-body bck-grey pt-5" id="body-main-'. $package_number .'">
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
                                            <p class="card-text font-16 pt-3"><b>'. $venue_package .'</b></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col py-3">
                                    <div class="row mb-3">
                                        <div class="col-6 button">
                                            <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'"><b>PACKAGE<br />DETAILS</b></button>
                                        </div>
                                        <div class="col-6 button">
                                            <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'"><b>VIDEOS &<br />GALLERY</b></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col button">
                                            <a href="JavaScript:void(0);" onclick="startQuote('. $package_number .')"><button type="button" class="btn btn-purple"><b>GET PERSONAL<br />ESTIMATED QUOTE</b></button></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col font-14">
                                    <div class="row">
                                        <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-description-'. $package_number .'" class="txt-orange"><b>About the Venue</b></a></div>
                                    </div>
                                    <div class="row">
                                        <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-facilities-'. $package_number .'" class="txt-orange"><b>Facilities</b></a></div>
                                        <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-location-'. $package_number .'" class="txt-orange"><b>Location</b></a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bck-grey" id="body-quote-'. $package_number .'" style="display: none;">
                                <input type="hidden" id="venueName-'. $package_number .'" value="'. $venue_name .'">
                                <input type="hidden" id="venuePackageGuests-'. $package_number .'" value="'. $venue_package_guests .'">
                                <input type="hidden" id="venueMaxDaytime-'. $package_number .'" value="'. $venue_max_daytime .'">
                                <input type="hidden" id="venueMaxEvening-'. $package_number .'" value="'. $venue_max_evening .'">
                                <input type="hidden" id="venueMaxHotelRooms-'. $package_number .'" value="'. $venue_max_hotel_rooms .'">
                                <input type="hidden" id="venueHotelRoomPrice-'. $package_number .'" value="'. $venue_hotel_room_price .'">
                                <div id="quote-slide-'. $package_number .'-1">
                                    <div class="col form-group">
                                        <label>Date of Wedding</label>
                                        <p class="txt-red" id="error-'. $package_number .'-1"></p>
                                        <p class="txt-green" id="message-'. $package_number .'-1"></p>
                                        <div class="input-group date my-4">
                                            <input type="text" class="form-control" id="weddingDate-'. $package_number .'" placeholder="DD/MM/YYYY">
                                            <div class="input-group-append"><div class="input-group-text"><i class="fas fa-calendar-alt"></i></div></div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <span>1 of 8 Questions</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-1"><button type="button" class="btn btn-purple"><b><i class="fas fa-angle-left"></i> BACK</b></button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-1"><button type="button" class="btn btn-purple"><b>NEXT <i class="fas fa-angle-right"></i></b></button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row mb-3">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'"><b>PACKAGE<br />DETAILS</b></button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'"><b>VIDEOS &<br />GALLERY</b></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col font-14">
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-description-'. $package_number .'" class="txt-orange"><b>About the Venue</b></a></div>
                                        </div>
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-facilities-'. $package_number .'" class="txt-orange"><b>Facilities</b></a></div>
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-location-'. $package_number .'" class="txt-orange"><b>Location</b></a></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="quote-slide-'. $package_number .'-2" style="display: none;">
                                    <div class="col form-group">
                                        <label>Daytime Guest Numbers</label>
                                        <p class="txt-red" id="error-'. $package_number .'-2"></p>
                                        <p class="txt-green" id="message-'. $package_number .'-2"></p>
                                        <input type="number" class="form-control my-4" id="daytimeGuests-'. $package_number .'">
                                    </div>
                                    <div class="col form-group">
                                        <span>2 of 8 Questions</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 12.5%;" aria-valuenow="12.5" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-2"><button type="button" class="btn btn-purple"><b><i class="fas fa-angle-left"></i> BACK</b></button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-2"><button type="button" class="btn btn-purple"><b>NEXT <i class="fas fa-angle-right"></i></b></button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row mb-3">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'"><b>PACKAGE<br />DETAILS</b></button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'"><b>VIDEOS &<br />GALLERY</b></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col font-14">
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-description-'. $package_number .'" class="txt-orange"><b>About the Venue</b></a></div>
                                        </div>
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-facilities-'. $package_number .'" class="txt-orange"><b>Facilities</b></a></div>
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-location-'. $package_number .'" class="txt-orange"><b>Location</b></a></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="quote-slide-'. $package_number .'-3" style="display: none;">
                                    <div class="col form-group">
                                        <label>Evening Guest Numbers</label>
                                        <p class="txt-red" id="error-'. $package_number .'-3"></p>
                                        <p class="txt-green" id="message-'. $package_number .'-3"></p>
                                        <input type="number" class="form-control my-4" id="eveningGuests-'. $package_number .'">
                                    </div>
                                    <div class="col form-group">
                                        <span>3 of 8 Questions</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-3"><button type="button" class="btn btn-purple"><b><i class="fas fa-angle-left"></i> BACK</b></button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-3"><button type="button" class="btn btn-purple"><b>NEXT <i class="fas fa-angle-right"></i></b></button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row mb-3">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'"><b>PACKAGE<br />DETAILS</b></button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'"><b>VIDEOS &<br />GALLERY</b></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col font-14">
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-description-'. $package_number .'" class="txt-orange"><b>About the Venue</b></a></div>
                                        </div>
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-facilities-'. $package_number .'" class="txt-orange"><b>Facilities</b></a></div>
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-location-'. $package_number .'" class="txt-orange"><b>Location</b></a></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="quote-slide-'. $package_number .'-4" style="display: none;">
                                    <div class="col form-group">
                                        <label>Do you need a DJ?</label>
                                        <p class="txt-red" id="error-'. $package_number .'-4"></p>
                                        <p class="txt-green" id="message-'. $package_number .'-4"></p>
                                        <select class="form-control my-4" id="eveningEntertain-'. $package_number .'"><option value="">Please Select</option><option value="Yes">Yes</option><option value="No">No</option></select>
                                    </div>
                                    <div class="col form-group">
                                        <span>4 of 8 Questions</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 37.5%;" aria-valuenow="37.5" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-4"><button type="button" class="btn btn-purple"><b><i class="fas fa-angle-left"></i> BACK</b></button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-4"><button type="button" class="btn btn-purple"><b>NEXT <i class="fas fa-angle-right"></i></b></button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row mb-3">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'"><b>PACKAGE<br />DETAILS</b></button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'"><b>VIDEOS &<br />GALLERY</b></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col font-14">
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-description-'. $package_number .'" class="txt-orange"><b>About the Venue</b></a></div>
                                        </div>
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-facilities-'. $package_number .'" class="txt-orange"><b>Facilities</b></a></div>
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-location-'. $package_number .'" class="txt-orange"><b>Location</b></a></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="quote-slide-'. $package_number .'-5" style="display: none;">
                                    <div class="col form-group">
                                        <label>Your First Name</label>
                                        <p class="txt-red" id="error-'. $package_number .'-5"></p>
                                        <p class="txt-green" id="message-'. $package_number .'-5"></p>
                                        <input type="text" class="form-control my-4" id="firstName-'. $package_number .'" value="'. $first_name .'">
                                    </div>
                                    <div class="col form-group">
                                        <span>5 of 8 Questions</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-5"><button type="button" class="btn btn-purple"><b><i class="fas fa-angle-left"></i> BACK</b></button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-5"><button type="button" class="btn btn-purple"><b>NEXT <i class="fas fa-angle-right"></i></b></button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row mb-3">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'"><b>PACKAGE<br />DETAILS</b></button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'"><b>VIDEOS &<br />GALLERY</b></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col font-14">
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-description-'. $package_number .'" class="txt-orange"><b>About the Venue</b></a></div>
                                        </div>
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-facilities-'. $package_number .'" class="txt-orange"><b>Facilities</b></a></div>
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-location-'. $package_number .'" class="txt-orange"><b>Location</b></a></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="quote-slide-'. $package_number .'-6" style="display: none;">
                                    <div class="col form-group">
                                        <label>Your Last Name</label>
                                        <p class="txt-red" id="error-'. $package_number .'-6"></p>
                                        <p class="txt-green" id="message-'. $package_number .'-6"></p>
                                        <input type="text" class="form-control my-4" id="lastName-'. $package_number .'" value="'. $last_name .'">
                                    </div>
                                    <div class="col form-group">
                                        <span>6 of 8 Questions</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 62.5%;" aria-valuenow="62.5" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-6"><button type="button" class="btn btn-purple"><b><i class="fas fa-angle-left"></i> BACK</b></button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-6"><button type="button" class="btn btn-purple"><b>NEXT <i class="fas fa-angle-right"></i></b></button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row mb-3">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'"><b>PACKAGE<br />DETAILS</b></button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'"><b>VIDEOS &<br />GALLERY</b></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col font-14">
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-description-'. $package_number .'" class="txt-orange"><b>About the Venue</b></a></div>
                                        </div>
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-facilities-'. $package_number .'" class="txt-orange"><b>Facilities</b></a></div>
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-location-'. $package_number .'" class="txt-orange"><b>Location</b></a></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="quote-slide-'. $package_number .'-7" style="display: none;">
                                    <div class="col form-group">
                                        <label>Contact Number</label>
                                        <p class="txt-red" id="error-'. $package_number .'-7"></p>
                                        <p class="txt-green" id="message-'. $package_number .'-7"></p>
                                        <input type="text" class="form-control my-4" id="contactNumber-'. $package_number .'" value="'. $contact_number .'">
                                    </div>
                                    <div class="col form-group">
                                        <span>7 of 8 Questions</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-7"><button type="button" class="btn btn-purple"><b><i class="fas fa-angle-left"></i> BACK</b></button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-7"><button type="button" class="btn btn-purple"><b>NEXT <i class="fas fa-angle-right"></i></b></button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row mb-3">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'"><b>PACKAGE<br />DETAILS</b></button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'"><b>VIDEOS &<br />GALLERY</b></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col font-14">
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-description-'. $package_number .'" class="txt-orange"><b>About the Venue</b></a></div>
                                        </div>
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-facilities-'. $package_number .'" class="txt-orange"><b>Facilities</b></a></div>
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-location-'. $package_number .'" class="txt-orange"><b>Location</b></a></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="quote-slide-'. $package_number .'-8" style="display: none;">
                                    <div class="col form-group">
                                        <label>Email Address</label>
                                        <p class="txt-red" id="error-'. $package_number .'-8"></p>
                                        <p class="txt-green" id="message-'. $package_number .'-8"></p>
                                        <input type="email" class="form-control my-4" id="emailAddress-'. $package_number .'" value="'. $email_address .'">
                                    </div>
                                    <div class="col form-group">
                                        <span>Final Question</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 87.5%;" aria-valuenow="87.5" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row">
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="backSlide-'. $package_number .'-8"><button type="button" class="btn btn-purple"><b><i class="fas fa-angle-left"></i> BACK</b></button></a>
                                            </div>
                                            <div class="col-6 button">
                                                <a href="JavaScript:void(0);" id="nextSlide-'. $package_number .'-8"><button type="button" class="btn btn-purple"><b>SUBMIT</b></button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col form-group">
                                        <div class="row mb-3">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'"><b>PACKAGE<br />DETAILS</b></button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'"><b>VIDEOS &<br />GALLERY</b></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col font-14">
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-description-'. $package_number .'" class="txt-orange"><b>About the Venue</b></a></div>
                                        </div>
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-facilities-'. $package_number .'" class="txt-orange"><b>Facilities</b></a></div>
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-location-'. $package_number .'" class="txt-orange"><b>Location</b></a></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="quote-slide-'. $package_number .'-9" style="display: none;">
                                    <div class="col">
                                        <h2>THANK YOU</h2><br />
                                        <h4>Your Quote has been sent to you. Please check your email for details.</h4><br />
                                    </div>
                                    <div class="col form-group">
                                        <div class="row mb-3">
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-details-'. $package_number .'"><b>PACKAGE<br />DETAILS</b></button>
                                            </div>
                                            <div class="col-6 button">
                                                <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#package-gallery-'. $package_number .'"><b>VIDEOS &<br />GALLERY</b></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col font-14">
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-description-'. $package_number .'" class="txt-orange"><b>About the Venue</b></a></div>
                                        </div>
                                        <div class="row">
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-facilities-'. $package_number .'" class="txt-orange"><b>Facilities</b></a></div>
                                            <div class="col py-2"><a href="JavaScript:void(0);" data-toggle="modal" data-target="#venue-location-'. $package_number .'" class="txt-orange"><b>Location</b></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                    if ($row_limit == 3) {echo '</div>'; $row_limit = 0;}
                    
                    
                    
                    // FETCH PACKAGE DETAILS FROM DATABASE
                    $package_detail_limit = 30;
                    $query = "SELECT * FROM demo_venue_packages_details WHERE venue_name = '". $venue_name ."'";
                    $get_package_details = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($get_package_details)) {
                        $package_list = '<ul class="fa-ul">';
                        for($x = 1; $x <= $package_detail_limit; $x++) {
                            if ($row["package_item_$x"] != "") {
                                $package_list .= '<li><span class="fa-li"><i class="fas fa-check"></i></span> '. $row["package_item_$x"] .'</li>';
                            }
                        }
                        $package_list .= '</ul>';
                    }
                    
                    
                    
                    // FETCH VENUE DETAILS FROM DATABASE
                    $query = "SELECT * FROM demo_venue_details WHERE venue_name = '". $venue_name ."'";
                    $get_venue_details = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($get_venue_details)) {
                        $venue_description = $row['venue_description'];
                        $address_line_1 = $row['address_line_1'];
                        $address_line_2 = $row['address_line_2'];
                        $address_line_3 = $row['address_line_3'];
                        $town_city = $row['town_city'];
                        $county = $row['county'];
                        $postcode = $row['postcode'];
                        $google_maps = $row['google_maps'];
                    }
                    
                    
                    
                    // FETCH FACILITY DETAILS FROM DATABASE
                    $query = "SELECT * FROM demo_venue_facilities WHERE venue_name = '". $venue_name ."'";
                    $get_modal_content = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($get_modal_content)) {
                        $venue_facilities = $row['venue_facilities'];
                    }
                    
                    
                    
                    // CREATE PACKAGE DETAILS MODAL
                    echo '<div class="modal fade" id="package-details-'. $package_number .'" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog modal-dialog-centered modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">'. $venue_name .' in '. $selected_county .'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="col text-left mb-4"><h3>Package Details</h3><br />'. $package_list .'</div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div></div></div></div>';
                    
                    
                    
                    // VENUE IMAGE & VIDEO MODEL
                    echo '<div class="modal fade" id="package-gallery-'. $package_number .'" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog modal-dialog-centered modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">'. $venue_name .' in '. $selected_county .'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="col"><div id="carousel-main-'. $details_number .'" class="carousel slide" data-ride="carousel"><div class="carousel-inner">'; for ($x = 1; $x <= $venue_image_count; $x++) {if($x == 1) {$first = 'active';} else {$first = '';} echo '<div class="carousel-item '. $first .'"><img src="http://www.simplywed.co.uk/images/venues/'. $venue_image_name .''. $x .'.jpg" class="d-block w-100" alt="Image One"></div>'; } echo '</div><a class="carousel-control-prev" href="#carousel-'. $package_number .'" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carousel-main-'. $package_number .'" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a></div></div>'; if($venue_video == "Yes") {echo '<div class="col pt-4"><video width="100%" controls="controls"><source src="http://www.simplywed.co.uk/videos/venues/'. $venue_image_name .'.mp4" type="video/mp4">Your browser does not support HTML5 video.</video></div>';} echo '</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div></div></div></div>';
                    
                    
                    
                    // CREATE VENUE DESCRIPTION MODAL
                    echo '<div class="modal fade" id="venue-description-'. $package_number .'" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog modal-dialog-centered modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">'. $venue_name .' in '. $selected_county .'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="col text-left"><h3>About the Venue</h3><br />'. $venue_description .'</div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div></div></div></div>';
                    
                    
                    
                    // CREATE VENUE LOCATION MODAL
                    echo '<div class="modal fade" id="venue-location-'. $package_number .'" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog modal-dialog-centered modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">'. $venue_name .' in '. $selected_county .'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="col text-left mb-4"><h3>Venue Location</h3><br /><p>'; if($address_line_1 != "") {echo $address_line_1; echo '<br />';} if($address_line_2 != "") {echo $address_line_2; echo '<br />';} if($address_line_3 != "") {echo $address_line_3; echo '<br />';} if($town_city != "") {echo $town_city; echo '<br />';} if($county != "") {echo $county; echo '<br />';} if($postcode != "") {echo $postcode; echo '<br />';} echo '</p>'; if($google_maps != "") {echo $google_maps;} echo '</div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div></div></div></div>';
                    
                    
                    
                    // CREATE VENUE FACILITIES MODAL
                    echo '<div class="modal fade" id="venue-facilities-'. $package_number .'" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog modal-dialog-centered modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">'. $venue_name .' in '. $selected_county .'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="col text-left mb-4"><h3>Venue Facilities</h3><br />'. $venue_facilities .'</div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div></div></div></div>';
                    
                    
                    
                }
            }
            
            
            
        } else {
            
            
            
            // DISPLAY ERROR PAGE CONTENT
            echo '<h1>SORRY, THERE WAS A PROBLEM</h1>';
            echo '<h2>If you continue getting message please call us on <a href="tel:02038411045">0203 841 1045</a></h2><br />';
            echo '<h2>Alternatively, you can <a href="https://www.simplywed.co.uk/external/leads/">click here</a> to try again.</h2>';
            echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
            
            
            
        }
        ?>
        
        
        
    </div>
</div>
</section>


<!-- JAVASCRIPT FOR BOOTSTRAP ELEMENTS -->
<script src="/js/core/jquery-3.3.1.slim.min.js" type="text/javascript"></script>
<script src="/js/core/popper.min.js" type="text/javascript"></script>
<script src="/js/core/bootstrap.min.js" type="text/javascript"></script>
    
    
<!-- JAVASCRIPT FOR BOOTSTRAP DATE PICKER -->
<script src="/js/core/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script>$('.input-group.date').datepicker({format: "dd/mm/yyyy",maxViewMode: 2,clearBtn: true,autoclose: true});</script>
    

<!-- JAVASCRIPT FOR QUOTATION FORM HANDLING -->
<script src="/js/core/jquery.min.js" type="text/javascript"></script>
<script src="js/form-validation.min.js" type="text/javascript"></script>
<script src="js/quotation-form.min.js" type="text/javascript"></script>


</body></html>