<?php

// Get values from url
$date = $_GET["date"];
$time = $_GET["time"];

// Format date
$formattedDate = date("d-m-Y", strtotime($date));

// Explode hour and minute
$separateTime = explode(":", $time);
$hour = $separateTime[0];

// Head to archive
header("Location: index.php?site=archiv_individual&date={$formattedDate}&hour={$hour}");
die();
?>
