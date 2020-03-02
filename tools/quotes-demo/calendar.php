<?php
// CONNECT TO DATABASE
include "../../includes/connect.php";



// FETCH DETAILS FROM URL STRING
$venue_name = $_REQUEST["v"];
$wedding_date = $_REQUEST["d"];
$wedding_price = $_REQUEST["p"];



?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="UTF-8" />
<title>Calendar (Demo)</title>
<meta name="description" content="Calendar (Demo)" />
<meta name="robots" content="noindex,nofollow,noodp,noydir" />
<meta name="author" content="Jason Cheeseborough" />
<meta name="viewport" content="width=device-width, initial-scale=1" />


<!-- BOOTSTRAP / STYLE CSS -->
<link href="/css/quotation.min.css" rel="stylesheet">
<link href="/css/fullcalendar.min.css" rel="stylesheet">
<link href="/css/core/bootstrap.min.css" rel="stylesheet">
<link href="/images/favicon.ico" rel="icon" type="image/ico" />
    
    
<!-- FONT AWESOME CSS -->
<script src="https://kit.fontawesome.com/0781172ae7.js" crossorigin="anonymous"></script>


</head><body>
<section id="content" class="content">
<div class="container-fluid py-5">
    <div class="container text-center">
        <h3 class="txt-red">Demo Purposes Only</h3><br />
        <h1>Thanks for using Simply Wed</h1>
        <h3>Please use the calendar below to book a viewing date with the venue</h3><br />
        <div id="calendar"></div>
    </div>
</div>
</section>
    
    
<!-- CALENDAR JAVASCRIPT -->
<script src="/js/core/jquery.min.js" type="text/javascript"></script>
<script src="/js/core/jquery-ui.min.js" type="text/javascript"></script>
<script src="/js/core/moment.min.js" type="text/javascript"></script>
<script src="/js/fullcalendar.min.js" type="text/javascript"></script>
<script src="js/calendar.js" type="text/javascript"></script>


<!-- JAVASCRIPT FOR BOOTSTRAP ELEMENTS -->
<script src="/js/core/popper.min.js" type="text/javascript"></script>
<script src="/js/core/bootstrap.min.js" type="text/javascript"></script>


</body></html>