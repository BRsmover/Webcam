<?php
// In this file the pictures are shot, copied together and saved in a directory
// IP of webcam
$ip = "127.0.0.1";

// ---------------------------- Step 1 ----------------------------
// Get date, check if folder for day exists (create if not), check if folder for hour exists (create if not) and set
// this one as path
$date = date('d-m-Y_h-i');
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
echo $path;

// ---------------------------- Step 2 ----------------------------
// Shoot photos with webcam
// Set turning speed
header("Location: http://" . $ip . "/cgi-bin/camtrl.cgi?speedpan=2");
// Enable snapshots
header("Location: http://" . $ip . "/cgi-bin/admin/gen-eventd-conf.cgi?snashot_enable=1");

// Turn to home position then turn to the far left
header("Location: http://" . $ip . "/cgi-bin/camtrl.cgi?move=home");
header("Location: http://" . $ip . "/cgi-bin/camtrl.cgi?move=left");
header("Location: http://" . $ip . "/cgi-bin/camtrl.cgi?move=left");

// Loop to move right, make a picture, save it to temp and repeat that four times
for($i = 1; $i <= 4; $i++) {
    $i = file_put_contents("images/temp/" . $i, fopen("http://" . $ip . "/cgi-bin/video.jpg", "r"));
    header("Location: http://" . $ip . "/cgi-bin/camtrl.cgi?move=right");
}

// ---------------------------- Step 3 ----------------------------
// Put them together with GD Library
$first = imagecreatefromjpeg("images/temp/1.jpg");
$second = imagecreatefromjpeg("images/temp/2.jpg");
// Copy second onto first 100px from left side, on bottom, at beginning of second image, merge gradient is 50
imagecopymerge($first, $second, 100, 0, 0, 0, 150, 150, 50);

// Copy third onto already merged image
$third = imagecreatefromjpeg("images/temp/3.jpg");
imagecopymerge($first, $third, 200, 0, 0, 0, 150, 150, 50);

// Copy fourth onto already merged image
$fourth = imagecreatefromjpeg("images/temp/4.jpg");
imagecopymerge($first, $fourth, 300, 0, 0, 0, 150, 150, 50);

// Delete the temporary files
for($i = 1; $i <= 4; $i++) {
    unlink("images/temp/" . $i . ".jpg");
}

// ---------------------------- Step 4 ----------------------------
// Save them into above specified path - Format: "panorama-webcam_d-m-Y_h-i.png" and return to homepage
imagejpeg($first, "images/" . $day . "/" . $hour . "/panorama-webcam_" . $day . "-" . $hour . "-" . $minute);

// All resources get destroyed automatically when the script ends
?>
