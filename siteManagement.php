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
?>
