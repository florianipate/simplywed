<?php
// CONNECT TO DATABASE
$connection = new PDO('mysql:host=10.16.16.8;dbname=SWuse-em1-u-255646','SWuse-em1-u-255646','Us/m6g6q2');



// INSERT NEW EVENT INTO DATABASE
if (isset($_POST["venue"], $_POST["title"])) {
    $query = "INSERT INTO demo_viewings_booked (venue_name, event_label, start_event, end_event) VALUES (:venue_name, :event_label, :start_event, :end_event)";
    $statement = $connection->prepare($query);
    $statement->execute(array(':venue_name' => $_POST['venue'],':event_label' => $_POST['title'],':start_event' => $_POST['start'],':end_event' => $_POST['end']));
}



?>