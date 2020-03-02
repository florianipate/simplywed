/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* START QUOTATION FUNCTION */
function startQuote(number) {
    var n = number;
    document.getElementById("body-main-" + n).style.display = "none";
    document.getElementById("body-quote-" + n).style.display = "block";
    $(document).ready(function() {
        $("#nextSlide-" + n + "-1").click(function() {
            valPrivacyPolicy(n);
        });
        $("#backSlide-" + n + "-1").click(function() {
            document.getElementById("body-main-" + n).style.display = "block";
            document.getElementById("body-quote-" + n).style.display = "none";
        });
        $("#nextSlide-" + n + "-2").click(function() {
            valWeddingDate(n);
        });
        $("#backSlide-" + n + "-2").click(function() {
            $("#quote-slide-" + n + "-1").show();
            $("#quote-slide-" + n + "-2").hide();
        });
        $("#nextSlide-" + n + "-3").click(function() {
            valDaytimeGuests(n);
        });
        $("#backSlide-" + n + "-3").click(function() {
            $("#quote-slide-" + n + "-2").show();
            $("#quote-slide-" + n + "-3").hide();
        });
        $("#nextSlide-" + n + "-4").click(function() {
            valEveningGuests(n);
        });
        $("#backSlide-" + n + "-4").click(function() {
            $("#quote-slide-" + n + "-3").show();
            $("#quote-slide-" + n + "-4").hide();
        });
        $("#nextSlide-" + n + "-5").click(function() {
            valEveningEntertain(n);
        });
        $("#backSlide-" + n + "-5").click(function() {
            $("#quote-slide-" + n + "-4").show();
            $("#quote-slide-" + n + "-5").hide();
        });
        $("#nextSlide-" + n + "-6").click(function() {
            valFirstName(n);
        });
        $("#backSlide-" + n + "-6").click(function() {
            $("#quote-slide-" + n + "-5").show();
            $("#quote-slide-" + n + "-6").hide();
        });
        $("#nextSlide-" + n + "-7").click(function() {
            valLastName(n);
        });
        $("#backSlide-" + n + "-7").click(function() {
            $("#quote-slide-" + n + "-6").show();
            $("#quote-slide-" + n + "-7").hide();
        });
        $("#nextSlide-" + n + "-8").click(function() {
            valContactNumber(n);
        });
        $("#backSlide-" + n + "-8").click(function() {
            $("#quote-slide-" + n + "-7").show();
            $("#quote-slide-" + n + "-8").hide();
        });
        $("#nextSlide-" + n + "-9").click(function() {
            valEmailAddress(n);
        });
        $("#backSlide-" + n + "-9").click(function() {
            $("#quote-slide-" + n + "-8").show();
            $("#quote-slide-" + n + "-9").hide();
        });
    });
}




/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* FETCH QUOTATION PRICING FUNCTION */
function submitQuote(number) {
    
    
    /* FETCH QUOTATION DETAILS */
    var n = number;
    var venueName = $("#venueName-" + n).val();
    var venueEmail = $("#venueEmail-" + n).val();
    var venueMaxDaytime = $("#venueMaxDaytime-" + n).val();
    var venueMaxEvening = $("#venueMaxEvening-" + n).val();
    var venueMaxHotelRooms = $("#venueMaxHotelRooms-" + n).val();
    var venueHotelRoomPrice = $("#venueHotelRoomPrice-" + n).val();
    var weddingDate = $("#weddingDate-" + n).val();
    var daytimeGuests = $("#daytimeGuests-" + n).val();
    var eveningGuests = $("#eveningGuests-" + n).val();
    var eveningEntertain = $("#eveningEntertain-" + n).val();
    var firstName = $("#firstName-" + n).val();
    var lastName = $("#lastName-" + n).val();
    var contactNumber = $("#contactNumber-" + n).val();
    var emailAddress = $("#emailAddress-" + n).val();
    
    
    /* CONVERT DATE STRING INTO DATE OBJECT */
    var dateParts = weddingDate.split("/");
    var dateObject = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]);
    
    
    /* CONVERT DATE OBJECT (DAY) FROM INTERGER TO STRING */
    if (dateObject.getDay() == 1) {
        var weddingDay = "Monday";
    } else if (dateObject.getDay() == 2) {
        var weddingDay = "Tuesday";
    } else if (dateObject.getDay() == 3) {
        var weddingDay = "Wednesday";
    } else if (dateObject.getDay() == 4) {
        var weddingDay = "Thursday";
    } else if (dateObject.getDay() == 5) {
        var weddingDay = "Friday";
    } else if (dateObject.getDay() == 6) {
        var weddingDay = "Saturday";
    } else if (dateObject.getDay() == 0) {
        var weddingDay = "Sunday";
    }
    
    
    /* CONVERT DATE OBJECT (MONTH) FROM INTERGER TO STRING */
    if (dateObject.getMonth() == 0) {
        var weddingMonth = "January";
    } else if (dateObject.getMonth() == 1) {
        var weddingMonth = "February";
    } else if (dateObject.getMonth() == 2) {
        var weddingMonth = "March";
    } else if (dateObject.getMonth() == 3) {
        var weddingMonth = "April";
    } else if (dateObject.getMonth() == 4) {
        var weddingMonth = "May";
    } else if (dateObject.getMonth() == 5) {
        var weddingMonth = "June";
    } else if (dateObject.getMonth() == 6) {
        var weddingMonth = "July";
    } else if (dateObject.getMonth() == 7) {
        var weddingMonth = "August";
    } else if (dateObject.getMonth() == 8) {
        var weddingMonth = "September";
    } else if (dateObject.getMonth() == 9) {
        var weddingMonth = "October";
    } else if (dateObject.getMonth() == 10) {
        var weddingMonth = "November";
    } else if (dateObject.getMonth() == 11) {
        var weddingMonth = "December";
    }
    
    
    /* SEND WEDDING QUOTATION DETAILS TO FETCH PRICING VIA AJAX */
    var dataString = 'venue_number='+n+'&venue_name='+venueName+'&venue_email='+venueEmail+'&venue_max_daytime='+venueMaxDaytime+'&venue_max_evening='+venueMaxEvening+'&venue_max_hotel_rooms='+venueMaxHotelRooms+'&venue_hotel_room_price='+venueHotelRoomPrice+'&wedding_date='+weddingDate+'&wedding_month='+weddingMonth+'&wedding_day='+weddingDay+'&daytime_guests='+daytimeGuests+'&evening_guests='+eveningGuests+'&evening_entertain='+eveningEntertain+'&first_name='+firstName+'&last_name='+lastName+'&contact_number='+contactNumber+'&email_address='+emailAddress;
    $.ajax({
        type: "POST",
        url: "https://www.ukweddingsavings.co.uk/tools/quotes/submit/get-prices.php",
        data: dataString,
        cache: false,
        complete: function (response) {
            processQuote(response.responseText);
        }, error: function () {
            alert("Sorry, there was a problem fetching venue pricing for your selected date.\nPlease refresh and try again.");
        }
    });
    
    
}




/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* CALCULATE QUOTATION FUNCTION */
function processQuote(pricing) {
    
    
    /* PULL DATA OUT OF AJAX RESPONSE */
    var array = JSON.parse(pricing);
    var n = array["venue_number"];
    var venueName = array["venue_name"];
    var venueEmail = array["venue_email"];
    var venueMaxHotelRooms = array["venue_max_hotel_rooms"];
    var venueHotelRoomPrice = array["venue_hotel_room_price"];
    var weddingDate = array["wedding_date"];
    var weddingDay = array["wedding_day"];
    var daytimeGuests = array["daytime_guests"];
    var eveningGuests = array["evening_guests"];
    var eveningEntertain = array["evening_entertain"];
    var firstName = array["first_name"];
    var lastName = array["last_name"];
    var contactNumber = array["contact_number"];
    var emailAddress = array["email_address"];
    var packagePrice = array["package_price"];
    var packageGuests = array["package_guests"];
    var daytimePrice = array["daytime_price"];
    var eveningPrice = array["evening_price"];
    var extEveningEntertain = array["ext_evening_entertain"];
    
    
    /* SEND COMPLETE WEDDING QUOTATION FOR SUBMISSION VIA AJAX */
    var dataString = 'venue_name='+venueName+'&venue_email='+venueEmail+'&venue_max_hotel_rooms='+venueMaxHotelRooms+'&venue_hotel_room_price='+venueHotelRoomPrice+'&wedding_date='+weddingDate+'&wedding_day='+weddingDay+'&daytime_guests='+daytimeGuests+'&evening_guests='+eveningGuests+'&evening_entertain='+eveningEntertain+'&first_name='+firstName+'&last_name='+lastName+'&contact_number='+contactNumber+'&email_address='+emailAddress+'&package_price='+packagePrice+'&package_guests='+packageGuests+'&daytime_price='+daytimePrice+'&evening_price='+eveningPrice+'&ext_evening_entertain='+extEveningEntertain;
    $.ajax({
        type: "POST",
        url: "https://www.ukweddingsavings.co.uk/tools/quotes/submit/submit-quote.php",
        data: dataString,
        cache: false,
        complete: function (response) {
            calculateQuote(response.responseText);
        }, error: function () {
            alert("Sorry, there was a problem submitting your quotation to us.\nPlease refresh and try again.");
        }
    });
    
    
}