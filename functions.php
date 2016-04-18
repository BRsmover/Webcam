<?php
ob_start();

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
    if(!empty($images)) {
        return $images;
     } else {
        header("Location: index.php?site=error");
        die();
     }
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

function getDateTwoWeeksAgo() {
    // Determine date 14 days ago
    $dateBefore = date("m/d/Y", strtotime("-2 weeks"));
    return $dateBefore;
}
?>
