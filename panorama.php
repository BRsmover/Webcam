<?php
// In this file the pictures are shot, copied together and saved in a directory

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
// turn to the far left

// loop to move right, make a picture and repeat that


// ---------------------------- Step 3 ----------------------------
// Put them together with GD Library


// ---------------------------- Step 4 ----------------------------
// Save them into above specified path - Format: "panorama-webcam_d-m-Y_h-i.png"

?>
