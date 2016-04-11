<?php

// Get current site
function getSite() {
	$site = "home";
	if(isset($_GET['site'])) {
		$site = $_GET['site'];
	}
	return $site;
}

// Parse site
function parseSite($site, $data) {
	$loader = new Twig_Loader_Filesystem('html');
	$twig = new Twig_Environment($loader, array('debug' => true));
	$twig->addExtension(new Twig_Extension_Debug());
	$template = $twig->loadTemplate($site . ".html");
	return $template->render($data);
}

// Get panorama for home
function getNewestPanorama() {
    $date = date('d-m-Y_H-i');
    // Split date
    $underscore = explode("_", $date);
    $day = $underscore[0];
    $dash = explode("-", $underscore[1]);
    $hour = $dash[0];
    $minute = $dash[1];

    // Get days
    $days = array_diff(scandir("images", 0), array("..", ".", "temp"));

    // Get hours
    $hours = array_diff(scandir("images/" . $days[2], 0), array("..", "."));

    // Get images
    $images = array_diff(scandir("images/" . $days[2] . "/" . $hours[2], 0), array("..", "."));

    $newestPanorama = imagecreatefromjpeg("images/" . $days[2] . "/" . $hours[2] . "/" . $images[2]);
    imagejpeg($newestPanorama, "images/newest.jpeg");
}
?>
