<?php
// CONNECT TO DATABASE
$connection = new PDO('mysql:host=10.16.16.8;dbname=SWuse-em1-u-255646','SWuse-em1-u-255646','Us/m6g6q2');



// DELETE EVENT VIA ID NUMBER
if (isset($_POST["id"])) {
    $query = "DELETE from demo_viewings_booked WHERE id=:id";
    $statement = $connection->prepare($query);
    $statement->execute(array(':id' => $_POST['id']));
}



?>