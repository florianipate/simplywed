<?php
// CONNECT TO DATABASE
include "../../includes/connect.php";


// FETCH DETAILS FROM URL STRING
$venue_name = base64_decode($_REQUEST["v"]);
$contact_name = base64_decode($_REQUEST["n"]);
$email_address = base64_decode($_REQUEST["e"]);
$phone_number = base64_decode($_REQUEST["p"]);


?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="UTF-8" />
<title>Book Viewing (Demo)</title>
<meta name="description" content="Book Viewing (Demo)" />
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


</head><body class="text-center">
<section id="content" class="content">
<div class="container-fluid py-5">
    <div class="container">
        
        
        
        <?php
        if ($venue_name != "") {
            
            
            
            echo '<h3 class="txt-red">Demo Purposes Only</h3><br />
            <h1>Thanks for using Simply Wed</h1>
            <h3>Please complete the form below to book a viewing date with the venue</h3><br />
            <p class="txt-red" id="error"></p>
            <p class="txt-green" id="message"></p>
            <div class="col mt-4">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-5">
                        <div class="col form-group">
                            <p><b>Venue Name</b></p>
                            <input type="text" class="form-control" id="venuename" value="'. $venue_name .'">
                        </div>
                        <div class="col form-group">
                            <p><b>Venue Name</b></p>
                            <input type="text" class="form-control" id="contactname" value="'. $contact_name .'">
                        </div>
                        <div class="col form-group">
                            <p><b>Venue Name</b></p>
                            <input type="email" class="form-control" id="emailaddress" placeholder="EMAIL ADDRESS" value="'. $email_address .'">
                        </div>
                        <div class="col form-group">
                            <p><b>Venue Name</b></p>
                            <input type="text" class="form-control" id="contactnumber" placeholder="CONTACT NUMBER" value="'. $phone_number .'">
                        </div>
                        <div class="col form-group">
                            <p><b>Venue Name</b></p>
                            <div class="input-group date">
                                <input type="text" class="form-control" id="viewingdate" placeholder="DD/MM/YYYY">
                                <div class="input-group-append"><div class="input-group-text"><i class="fas fa-calendar-alt"></i></div></div>
                            </div>
                        </div>
                        <div class="col form-group">
                            <p><b>Venue Name</b></p>
                            <select class="form-control" id="viewingtime">
                                <option value="">SELECT A TIME</option>
                                <option value="TEST">TEST</option>
                            </select>
                        </div>
                        <div class="col form-group">
                            <button class="btn btn-lg btn-purple btn-block" type="submit" onclick="bookViewing()">BOOK VIEWING</button>
                        </div>
                    </div>
                </div>
            </div>';
            
            
            
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
    
    
<!-- -->
<script type="text/javascript">
function bookViewing() {
    
    
    /* FETCH REQUIRED DATA */
    var venueName = document.getElementById("venuename").value;
    var contactName = document.getElementById("contactname").value;
    var emailAddress = document.getElementById("emailaddress").value;
    var contactNumber = document.getElementById("contactnumber").value;
    var viewingDate = document.getElementById("viewingdate").value;
    var viewingTime = document.getElementById("viewingtime").value;

    
    /* CHECK IF VIEWING DATE & TIME FIELD ARE BLANK */
    if (viewingDate == "" || viewingTime == "") {
        if (viewingDate == "") {var dateError = '<b>Please enter a Viewing Date</b><br />';} else {var dateError = '';}
        if (viewingTime == "") {var timeError = '<b>Please enter a Viewing Time</b>';} else {var timeError = '';}
        document.getElementById("error").innerHTML = dateError + timeError;
    } else {
        document.getElementById("error").innerHTML = '';
        document.getElementById("message").innerHTML = "<b>SUCCESS</b>";
    }
    
    
}
</script>


<!-- JAVASCRIPT FOR BOOTSTRAP ELEMENTS -->
<script src="/js/core/jquery-3.3.1.slim.min.js" type="text/javascript"></script>
<script src="/js/core/popper.min.js" type="text/javascript"></script>
<script src="/js/core/bootstrap.min.js" type="text/javascript"></script>
    
    
<!-- JAVASCRIPT FOR BOOTSTRAP DATE PICKER -->
<script src="/js/core/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script>$('.input-group.date').datepicker({format: "dd/mm/yyyy",maxViewMode: 2,clearBtn: true,autoclose: true});</script>


</body></html>