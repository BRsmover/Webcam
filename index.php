<?php

// Require the Twig Autoloader
require_once('libraries/Twig/lib/Twig/Autoloader.php');
// Require the functions
require_once('siteManagement.php');

Twig_Autoloader::register();

$site = getSite();

// Home
if($site == "home") {
    echo(parseSite('home', array("panoramas" => getNewestPanorama())));
}

// Archiv
else if($site == "archiv") {
    echo(parseSite('archiv', array()));
}

// About
else if($site == "about") {
    echo(parseSite('about', array()));
}
?>
