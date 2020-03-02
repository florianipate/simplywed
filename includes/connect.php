<?php
// CONNECT TO DATABASE
// $db['db_host'] = "10.16.16.8";
// $db['db_user'] = "SWuse-em1-u-255646";
// $db['db_pass'] = "Us/m6g6q2";
// $db['db_name'] = "SWuse-em1-u-255646";

// CONNECT TO DATABASE ON THE LOCAL SERVER
$db['db_host'] = "127.0.0.1";
$db['db_user'] = "root";
$db['db_pass'] = "";
$db['db_name'] = "simplywed_v2";
foreach($db as $key => $value) {define (strtoupper($key), $value);}
$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);


// CHECK DATABASE CONNECTION
//if ($connection) {echo "Connected to Database";} else {echo "NOT Connected to Database";}
?>