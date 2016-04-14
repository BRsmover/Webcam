<?php
// This script can be called to delete pictures which are older than 14 days

// Get date
$date = date('d-m-Y');

// Determine date 14 days ago
$dateBefore = date("d-m-Y", strtotime("-2 weeks"));

// Get folders of the days in images except hidden folders and temp directory
$days = array_diff(scandir("images"), array("..", ".", "temp"));
print_r($days);
echo "<br>";

// Delete those folders of days that are older than 2 weeks
for($i = 2; $i < count($days); $i++) {
    if($days[$i] == $dateBefore) {
        deleteDirectory("images/" . $days[$i]);
    } else {
        // Separate dates into day, month and year
        $date = explode("-", $days[$i]);
        $arrayBefore = explode("-", $dateBefore);

        // Check if day is smaller, if month is equal or smaller and if year is equal or smaller
        if($date[0] < $arrayBefore[0] && $date[1] <= $arrayBefore[1] && $date[2] <= $arrayBefore[2]) {
            deleteDirectory("images/" . $days[$i]);
        }
    }
}

// Check if there are files in the selected directory - if yes delete them recursively
function deleteDirectory($directory) {
    echo "Directory: " . $directory . "<br>";
    // Check if given path is a directory
    if(!is_dir($directory)) {
        echo "That's not a directory!";
    } else {
        // Get hours in the given day
        $hours = array_diff(scandir($directory), array(".", ".."));
        print_r($hours);
        echo "<br>";

        foreach($hours as $hour) {
            $images = array_diff(scandir($directory . "/" . $hour), array(".", ".."));
            print_r($images);
            echo "<br>";
            foreach($images as $image) {
                if(unlink($directory . "/" . $hour . "/" . $image)) {
                    echo "Deleting successful!";
                } else {
                    echo "Deleting failed!";
                }
            }
            rmdir($directory . "/" . $hour);
        }
        rmdir($directory);
    }
}
?>
