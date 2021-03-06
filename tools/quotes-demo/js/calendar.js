$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar( {
        editable:true,
        header:{left:'prev,next today',center:'title',right:'month,agendaWeek,agendaDay'},
        eventColor: '#378006',
        eventTextColor: '#ffffff',
        selectable:true,
        selectHelper:true,
        displayEventTime: false,
        events: 'submit/calendar-load.php',
        select:function(start, end, allDay) {
            var venue = document.getElementById("venue").value;
            var title = prompt("Enter Event Title","Unavailable");
            if(title) {
                var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                $.ajax({
                    url:"submit/calendar-insert.php",
                    type:"POST",
                    data:{venue:venue, title:title, start:start, end:end},
                    success:function() {
                        calendar.fullCalendar('refetchEvents');
                        alert("Added Successfully");
                    }
                })
            }
        },
        editable:true,
        eventResize:function(event) {
            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
            var title = event.title;
            var id = event.id;
            $.ajax({
                url:"submit/calendar-update.php",
                type:"POST",
                data:{title:title, start:start, end:end, id:id},
                success:function() {
                    calendar.fullCalendar('refetchEvents');
                    alert('Event Updated');
                }
            })
        },
        eventDrop:function(event) {
            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
            var title = event.title;
            var id = event.id;
            $.ajax({
                url:"submit/calendar-update.php",
                type:"POST",
                data:{title:title, start:start, end:end, id:id},
                success:function() {
                    calendar.fullCalendar('refetchEvents');
                    alert("Event Updated");
                }
            });
        },
        eventClick:function(event) {
            if(confirm("Are you sure you want to remove it?")) {
                var id = event.id;
                $.ajax({
                    url:"submit/calendar-delete.php",
                    type:"POST",
                    data:{id:id},
                    success:function() {
                        calendar.fullCalendar('refetchEvents');
                        alert("Event Removed");
                    }
                })
            }
        }
    });
});