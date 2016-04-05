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
// Copy second onto first 100px from left side, on bottom, at beginning of second image, merge gradient is 50
imagecopymerge($first, $second, 100, 0, 0, 0, 150, 150, 50);

// Copy third onto already merged image
$third = imagecreatefromjpeg("images/temp/3.jpeg");
imagecopymerge($first, $third, 200, 0, 0, 0, 150, 150, 50);

// Copy fourth onto already merged image
$fourth = imagecreatefromjpeg("images/temp/4.jpeg");
imagecopymerge($first, $fourth, 300, 0, 0, 0, 150, 150, 50);

// Delete the temporary files
for($i = 1; $i <= 4; $i++) {
    unlink("images/temp/" . $i . ".jpeg");
}

// ---------------------------- Step 4 ----------------------------
// Save them into above specified path - Format: "panorama-webcam_d-m-Y_h-i.png" and return to homepage
imagejpeg($first, "images/" . $day . "/" . $hour . "/panorama-webcam_" . $day . "-" . $hour . "-" . $minute);

// All resources get destroyed automatically when the script ends
?>
