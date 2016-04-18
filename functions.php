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


// Get images for archive
function getImages($day, $hour) {
    $images = array_diff(scandir("images/" . $day . "/" . $hour), array(".", ".."));

    return $images;
}

function getDateForArchive($day, $hour) {
    $data = array("day" => $day, "hour" => $hour);
    return $data;
}

// Get days for dropdown
function getDays() {
    $days = array_diff(scandir("images/"), array(".", "..", "newest.jpeg", "temp"));
    return $days;
}

/*// Get date two weeks ago
function getDateTwoWeeksAgo() {
    // Determine date 14 days ago
    $dateBefore = date("d-m-Y", strtotime("-2 weeks"));
    $formattedDate = date_format("Y-m-d H:i:s", $dateBefore);

    return $formattedDate;
}*/

/*// Get hours for image titles
function getHours($day, $hour) {
    $array[] = $hours;
    $images = array_diff(scandir("images/" . $day . "/" . $hour), array(".", ".."));
    foreach($images as $image) {
        $date = explode("_", $image);
        $time = explode("-", $date);
        array_push($hours, $time[3]);
    }
    return $hours;
}

// Get minutes for image titles
function getMinutes($day, $hour) {
    $array[] = $minutes;
    $images = array_diff(scandir("images/" . $day . "/" . $hour), array(".", ".."));
    foreach($images as $image) {
        $date = explode("_", $image);
        $time = explode("-", $date);
        array_push($minutes, $time[4]);
    }
    return $minutes;
}*/
?>
