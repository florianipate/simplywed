/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* START QUOTATION FUNCTION */
$(document).ready(function() {
    $("#nextSlide-1").click(function() {
        valTitle();
    });
    $("#nextSlide-2").click(function() {
        valFirstName();
    });
    $("#nextSlide-3").click(function() {
        valLastName();
    });
    $("#nextSlide-4").click(function() {
        valWeddingDate();
    });
    $("#nextSlide-5").click(function() {
        valDaytimeGuests();
    });
    $("#nextSlide-6").click(function() {
        valEveningGuests();
    });
    $("#nextSlide-7").click(function() {
        valEveningEntertain();
    });
    $("#nextSlide-8").click(function() {
        valEmailAddress();
    });
    $("#nextSlide-9").click(function() {
        valContactNumber();
    });
    $("#nextSlide-10").click(function() {
        $("#quote-slide-10").hide();
        $("#quote-slide-11").show();
        submitQuote();
    });
    $("#backSlide-2").click(function() {
        $("#quote-slide-2").hide();
        $("#quote-slide-1").show();
    });
    $("#backSlide-3").click(function() {
        $("#quote-slide-3").hide();
        $("#quote-slide-2").show();
    });
    $("#backSlide-4").click(function() {
        $("#quote-slide-4").hide();
        $("#quote-slide-3").show();
    });
    $("#backSlide-5").click(function() {
        $("#quote-slide-5").hide();
        $("#quote-slide-4").show();
    });
    $("#backSlide-6").click(function() {
        $("#quote-slide-6").hide();
        $("#quote-slide-5").show();
    });
    $("#backSlide-7").click(function() {
        $("#quote-slide-7").hide();
        $("#quote-slide-6").show();
    });
    $("#backSlide-8").click(function() {
        $("#quote-slide-8").hide();
        $("#quote-slide-7").show();
    });
    $("#backSlide-9").click(function() {
        $("#quote-slide-9").hide();
        $("#quote-slide-8").show();
    });
    $("#backSlide-10").click(function() {
        $("#quote-slide-10").hide();
        $("#quote-slide-9").show();
    });
});




/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* FETCH QUOTATION PRICING FUNCTION */
function submitQuote(number) {
    
    
    /* FETCH QUOTATION DETAILS */
    var venueName = $("#venueName").val();
    var venueMaxDaytime = $("#venueMaxDaytime").val();
    var venueMaxEvening = $("#venueMaxEvening").val();
    var venueMaxHotelRooms = $("#venueMaxHotelRooms").val();
    var venueHotelRoomPrice = $("#venueHotelRoomPrice").val();
    var weddingDate = $("#weddingDate").val();
    var daytimeGuests = $("#daytimeGuests").val();
    var eveningGuests = $("#eveningGuests").val();
    var eveningEntertain = $("#eveningEntertain").val();
    var title = $("#title").val();
    var firstName = $("#firstName").val();
    var lastName = $("#lastName").val();
    var contactNumber = $("#contactNumber").val();
    var emailAddress = $("#emailAddress").val();
    
    
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
    var dataString = 'venue_name=' + venueName + '&venue_max_daytime=' + venueMaxDaytime + '&venue_max_evening=' + venueMaxEvening + '&venue_max_hotel_rooms=' + venueMaxHotelRooms + '&venue_hotel_room_price=' + venueHotelRoomPrice + '&wedding_date=' + weddingDate + '&wedding_month=' + weddingMonth + '&wedding_day=' + weddingDay + '&daytime_guests=' + daytimeGuests + '&evening_guests=' + eveningGuests + '&evening_entertain=' + eveningEntertain + '&title=' + title + '&first_name=' + firstName + '&last_name=' + lastName + '&contact_number=' + contactNumber + '&email_address=' + emailAddress;
    $.ajax({
        type: "POST",
        url: "http://www.simplywed.co.uk/tools/quotes-demo-new/submit/get-pricing.php",
        data: dataString,
        cache: false,
        error: function () {
            alert("Sorry, there was a problem fetching venue pricing for your selected date. Please refresh and try again.");
        }, complete: function (response) {
            processQuote(response.responseText);
        }
    });
    
    
}




/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* CALCULATE QUOTATION FUNCTION */
function processQuote(pricing) {
    
    
    /* PULL DATA OUT OF AJAX RESPONSE */
    var array = JSON.parse(pricing);
    var venueName = array["venue_name"];
    var venueMaxHotelRooms = array["venue_max_hotel_rooms"];
    var venueHotelRoomPrice = array["venue_hotel_room_price"];
    var weddingDate = array["wedding_date"];
    var weddingDay = array["wedding_day"];
    var daytimeGuests = array["daytime_guests"];
    var eveningGuests = array["evening_guests"];
    var eveningEntertain = array["evening_entertain"];
    var title = array["title"];
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
    var dataString = 'venue_name=' + venueName + '&venue_max_hotel_rooms=' + venueMaxHotelRooms + '&venue_hotel_room_price=' + venueHotelRoomPrice + '&wedding_date=' + weddingDate + '&wedding_day=' + weddingDay + '&daytime_guests=' + daytimeGuests + '&evening_guests=' + eveningGuests + '&evening_entertain=' + eveningEntertain + '&title=' + title + '&first_name=' + firstName + '&last_name=' + lastName + '&contact_number=' + contactNumber + '&email_address=' + emailAddress + '&package_price=' + packagePrice + '&package_guests=' + packageGuests + '&daytime_price=' + daytimePrice + '&evening_price=' + eveningPrice + '&ext_evening_entertain=' + extEveningEntertain;
    $.ajax({
        type: "POST",
        url: "http://www.simplywed.co.uk/tools/quotes-demo-new/submit/submit-quote.php",
        data: dataString,
        cache: false,
        complete: function (response) {
            calculateQuote(response.responseText);
        }, error: function () {
            alert("Sorry, there was a problem submitting your quotation to us. Please refresh and try again.");
        }
    });
    
    
}




/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* FORMAT PRICE INTEGER FUNCTION */
function formatNumber(number) {
    var num_parts = number.toString().split(".");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return num_parts.join(".");
}