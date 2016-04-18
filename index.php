<?php

// Require the Twig Autoloader
require_once('libraries/Twig/lib/Twig/Autoloader.php');
// Require the functions
require_once('functions.php');

Twig_Autoloader::register();

$site = getSite();

// Home
if($site == "home") {
    if(isset($_GET["success"])) {
        echo(parseSite('home', array("success" => "true")));
    } else {
        echo(parseSite('home', array()));
    }
}

// Archiv
else if($site == "archiv") {
    $currentDate = date('d-m-Y_H-i');
     // Split date
     $underscore = explode("_", $currentDate);
     $day = $underscore[0];
     $dash = explode("-", $underscore[1]);
     $hour = $dash[0];

    echo(parseSite('archiv', array("images" => getImages($day, $hour), "date" => getDateForArchive($day, $hour), "dateTwoWeeksAgo" => getDateTwoWeeksAgo())));
}

// Archiv not current day
else if($site == "archiv_individual") {
    $day = $_GET["date"];
    $hour = $_GET["hour"];
    echo(parseSite('archiv', array("images" => getImages($day, $hour), "date" => getDateForArchive($day, $hour), "dateTwoWeeksAgo" => getDateTwoWeeksAgo())));
}

// About
else if($site == "about") {
    echo(parseSite('about', array()));
}

// Error
else {
    echo(parseSite('error', array()));
}
?>
