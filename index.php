<?php

// Require the Twig Autoloader
require_once('libraries/Twig/lib/Twig/Autoloader.php');
// Require the functions
require_once('functions.php');

Twig_Autoloader::register();

$site = getSite();

// Home
if($site == "home") {
    echo(parseSite('home', array()));
}

// Archiv
else if($site == "archiv") {
    $currentDate = date('d-m-Y_H-i');
     // Split date
     $underscore = explode("_", $currentDate);
     $day = $underscore[0];
     $dash = explode("-", $underscore[1]);
     $hour = $dash[0];

    echo(parseSite('archiv', array("images" => getImages($day, $hour), "date" => getDateForArchive($day, $hour), "days" => getDays())));
}

// About
else if($site == "about") {
    echo(parseSite('about', array()));
}
?>
