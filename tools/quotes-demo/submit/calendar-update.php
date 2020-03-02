<?php
// CONNECT TO DATABASE
$connection = new PDO('mysql:host=10.16.16.8;dbname=SWuse-em1-u-255646','SWuse-em1-u-255646','Us/m6g6q2');



// UPDATE EVENT VIA ID NUMBER
if(isset($_POST["id"])) {
    $query = "UPDATE demo_viewings_booked SET event_label=:event_label, start_event=:start_event, end_event=:end_event WHERE id=:id";
    $statement = $connection->prepare($query);
    $statement->execute(array(':event_label'  => $_POST['title'],':start_event' => $_POST['start'],':end_event' => $_POST['end'],':id'   => $_POST['id']));
}



?>