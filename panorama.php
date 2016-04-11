<?php
// In this file the pictures are shot, copied together and saved in a directory
// IP of webcam -> IP: 10.142.126.155 MAC: 00-11-6B-80-53-B8
$ip = "10.142.126.155";

// ---------------------------- Step 1 ----------------------------
// Get date, check if folder for day exists (create if not), check if folder for hour exists (create if not) and set
// this one as path
$date = date('d-m-Y_H-i');
// Split date
$underscore = explode("_", $date);
$day = $underscore[0];
$dash = explode("-", $underscore[1]);
$hour = $dash[0];
$minute = $dash[1];

// Check if folder of day exists
$theUmask = umask(0);
if(!is_dir("images/" . $day)) {
    if(mkdir("images/" . $day, 0777, true)) {
        echo "Directory was created!";
    } else {
        echo "Directory couldn't be created!";
    }
}

// Check if folder of hour exists
if(!is_dir("images/" . $day . "/" . $hour)) {
    if(mkdir("images/" . $day . "/" . $hour, 0777, true)) {
        echo "Directory was created!";
    } else {
        echo "Directory couldn't be created!";
    }
}

// Set path
$path = "images/" . $day . "/" . $hour;

// ---------------------------- Step 2 ----------------------------
// Shoot photos with webcam
$left = "http://" . $ip . "/cgi-bin/camctrl.cgi?move=left";
$right = "http://" . $ip . "/cgi-bin/camctrl.cgi?move=right";
$home = "http://" . $ip . "/cgi-bin/camctrl.cgi?move=home";
$setSpeedPan = "http://" . $ip . "/cgi-bin/camctrl.cgi?speedpan=2";
$enableSnapshot = "http://" . $ip . "/cgi-bin/admin/gen-eventd-conf.cgi?snapshot_enable=1";

// Set turning speed
fopen($setSpeedPan, "r");
// Enable snapshots
fopen($enableSnapshot, "r");

// Turn to home position then turn to the far left
fopen($home, "r");
sleep(2);
for($q = 0; $q < 4; ++$q) {
    fopen($left, "r");
    sleep(2);
}

// Loop to move right, make a picture, save it to temp and repeat that four times
for($i = 1; $i <= 4; $i++) {
    $img = file_put_contents("images/temp/" . $i . ".jpeg", fopen("http://" . $ip . "/cgi-bin/video.jpg", "r"));
    fopen($right, "r");
    sleep(2);
    fopen($right, "r");
    sleep(2);
}

// ---------------------------- Step 3 ----------------------------
// Put them together with GD Library
$first = imagecreatefromjpeg("images/temp/1.jpeg");
$second = imagecreatefromjpeg("images/temp/2.jpeg");
$third = imagecreatefromjpeg("images/temp/3.jpeg");
$fourth = imagecreatefromjpeg("images/temp/4.jpeg");

// Get width and height
$width = imagesx($first);
$height = imagesy($first);

// Make blank space
$panorama = imagecreate(4 * $width, $height);

// Copy them onto blank space
imagecopy($panorama, $first, 0, 0, 0, 0, $width, $height);
imagecopy($panorama, $second, 0 + $width, 0, 0, 0, $width + $width, $height);
imagecopy($panorama, $third, 0 + 2 * $width, 0, 0, 0, $width, $height);
imagecopy($panorama, $fourth, 0 + 3* $width, 0, 0, 0, $width, $height);

// Delete the temporary files
for($i = 1; $i <= 4; $i++) {
    unlink("images/temp/" . $i . ".jpeg");
}

// ---------------------------- Step 4 ----------------------------
// Save them into above specified path - Format: "panorama-webcam_d-m-Y_h-i.png" and return to homepage
imagejpeg($panorama, "images/" . $day . "/" . $hour . "/panorama-webcam_" . $day . "-" . $hour . "-" . $minute);

// Destroy resources
imagedestroy($first);
imagedestroy($second);
imagedestroy($third);
imagedestroy($fourth);
imagedestroy($panorama);

// ---------------------------- Step 5 ----------------------------
// Redirect to home where newest image is shown
header("Location: index.php");
die();
?>
