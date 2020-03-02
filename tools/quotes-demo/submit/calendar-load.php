<?php
// START SESSION
session_start();



// CONNECT TO DATABASE
$connection = new PDO('mysql:host=10.16.16.8;dbname=SWuse-em1-u-255646','SWuse-em1-u-255646','Us/m6g6q2');



// LOAD EVENTS FROM DATABASE
$data = array();
$query = "SELECT * FROM demo_viewings_booked ORDER BY id";
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row) {
    if ($row["venue_name"] == $_SESSION["venue"]) {
        $data[] = array('id' => $row["id"],'venue' => $row["venue_name"],'title' => $row["event_label"],'start' => $row["start_event"],'end' => $row["end_event"]);
    }
}
echo json_encode($data);



?>