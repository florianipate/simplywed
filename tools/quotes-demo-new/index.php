<?php
// SET TIMEZONE
date_default_timezone_set("Europe/London");


// CONNECT TO DATABASE
include "../../includes/connect.php";


// START SESSION
session_start();


// STORE DATA IN SESSION
$_SESSION["county"] = $_REQUEST["c"];
$_SESSION["daytime_guests"] = $_REQUEST["d"];
$_SESSION["evening_guests"] = $_REQUEST["e"];
$_SESSION["sort_order"] = $_REQUEST["s"];


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
<link href="css/style.css" rel="stylesheet">
<link href="/css/core/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="/css/core/bootstrap.min.css" rel="stylesheet">
<link href="/images/favicon.ico" rel="icon" type="image/ico" />
    
    
<!-- FONT AWESOME CSS -->
<script src="https://kit.fontawesome.com/0781172ae7.js" crossorigin="anonymous"></script>


</head><body>
<?php include "includes/header.php"; ?>
<section id="content" class="content">
<div class="container-fluid">
    <div class="container pt-5">
        <div class="row">
            <div class="col p-3 mb-5 bck-orange rounded">
            
                
                <?php
                // DISPLAY FILTER BAR
                include "includes/filter.php";
                ?>
                
                
            </div>
        </div>
        <div class="row">
            <div class="col pb-4 text-center">
                
                
                <?php
                // CHECK SESSION CONDITIONS
                if (isset($_SESSION['county']) && !empty($_SESSION['county'])) {


                    // SET/DISPLAY HEADING AND SEARCH QUERY
                    $query = "SELECT * FROM demo_venue_packages WHERE venue_county = '". $_SESSION['county'] ."'";
                    echo '<h1 class="font-30">ALL WEDDING VENUES IN '. strtoupper($_SESSION['county']) .'</h1><p class="font-18 txt-red">Demo Purposes Only</p>';


                } else {


                    // SET/DISPLAY HEADING AND SEARCH QUERY
                    $query = "SELECT * FROM demo_venue_packages";
                    echo '<h1 class="font-30">ALL WEDDING VENUES FROM AROUND THE UK</h1><p class="font-18 txt-red">Demo Purposes Only</p>';


                }
                ?>
                
                
            </div>
        </div>
        <div class="row">
            <div class="col pb-4">
                
                
                <?php
                // CHECK IF A QUERY IS SET
                if (isset($query)) {
                    
                    
                    // FETCH VENUE PACKAGES
                    $get_packages = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($get_packages)) {
                        $venue_active = $row['venue_active'];
                        $venue_name = $row['venue_name'];
                        $venue_name_full = $row['venue_name_full'];
                        $venue_package = $row['venue_package'];
                        $venue_package_price = $row['venue_package_price'];
                        $venue_media_name = $row['venue_media_name'];
                        if ($venue_active == 'Yes') {
                            
                            
                            // FETCH VENUE ADDRESS
                            $query = "SELECT * FROM demo_venue_details WHERE venue_name = '". $venue_name ."'";
                            $get_address = mysqli_query($connection, $query);
                            while($row = mysqli_fetch_assoc($get_address)) {
                                $address_line_1 = $row['address_line_1'];
                                $address_line_2 = $row['address_line_2'];
                                $address_line_3 = $row['address_line_3'];
                                $town_city = $row['town_city'];
                                $county = $row['county'];
                            }
                            
                            
                            // DISPLAY VENUE PACKAGES
                            echo'<div class="row"><div class="col"><div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative"><div class="col-md-3"><img src="http://www.simplywed.co.uk/images/venues/'. $venue_media_name .'1.jpg" width="100%" height="100%" class="d-block" alt="'. $venue_name_full .'"></div><div class="col-md-9 p-3 d-flex flex-column position-static"><div class="row"><div class="col"><p class="font-26 mb-2">'. $venue_name_full .'</p><p class="font-16 txt-purple mb-2">'; if ($address_line_2 != "") {echo $address_line_2; echo ', ';} if ($address_line_3 != "") {echo $address_line_3; echo ', ';} if ($town_city != "") {echo $town_city; echo ', ';} if ($county != "") {echo $county; echo '.';} echo '</p><p class="font-18 txt-purple mb-2"><b>'. $venue_package .'</b></p></div></div><div class="row"><div class="col-md-8 pb-3 pb-lg-0"><p class="font-20 txt-purple mb-auto"><b>From £'. number_format($venue_package_price) .'</b></p></div><div class="col-md-4"><a href="venue.php?v='. rawurlencode(base64_encode($venue_name)) .'" style="text-decoration:none;"><div class="button btn-orange">Get Your Price <i class="fas fa-angle-right" style="float:right;"></i></div></a></div></div></div></div></div></div>';
                            
                            
                        }
                    }
                    
                    
                } else {
                    
                    
                    // DISPLAY ERROR PAGE CONTENT
                    echo '<div class="col text-center"><h2>SORRY, THERE WAS A PROBLEM</h2><h4>If you continue getting message please call us on <a href="tel:02038411045">0203 841 1045</h4></div>';
                    
                    
                }
                ?>
                
                
            </div>
        </div>
    </div>
</div>
</section>
<?php include "includes/footer.php"; ?>


<!-- JAVASCRIPT FOR BOOTSTRAP ELEMENTS -->
<script src="/js/core/jquery-3.3.1.slim.min.js" type="text/javascript"></script>
<script src="/js/core/popper.min.js" type="text/javascript"></script>
<script src="/js/core/bootstrap.min.js" type="text/javascript"></script>
    
    
<script type="text/javascript">
function venueSearch() {
    var countyName = document.getElementById("county").value;
    var maxDaytime = document.getElementById("daytime_guests").value;
    var maxEvening = document.getElementById("evening_guests").value;
    var sortOrder = document.getElementById("sort_order").value;
    window.location.href = "http://www.simplywed.co.uk/tools/quotes-demo-new/?c=" + countyName + "&d=" + maxDaytime + "&e=" + maxEvening + "&s=" + sortOrder;
}
</script>


</body></html>