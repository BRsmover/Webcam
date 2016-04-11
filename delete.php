<?php
// This script can be called to delete pictures which are older than 14 days

// Get date
$date = date('d-m-Y');

// Determine date 14 days ago
$dateBefore = date("d-m-Y", strtotime("-2 weeks"));

// Get folders in images except hidden folders and temp directory
$folders = array_diff(scandir("images"), array("..", ".", "temp"));
print_r($folders);

// Delete those that are older than 2 weeks
for($i = 2; $i < count($folders); $i++) {
    if($folders[$i] == $dateBefore) {
        deleteDirectory($folders[$i]);
    } else {
        $folder = explode("-", $folders[$i]);
        $arrayBefore = explode("-", $dateBefore);

        // Check if day is smaller, if month is equal or smaller and if year is equal or smaller
        if($folder[0] < $arrayBefore[0] && $folder[1] <= $arrayBefore[1] && $folder[2] <= $arrayBefore[2]) {
            deleteDirectory($folders[$i]);
        }
    }
}

// Check if there are files in the selected directory - if yes delete them recursively
// -> inspired (not copied) by http://stackoverflow.com/questions/3349753/delete-directory-with-files-in-it
function deleteDirectory($directory) {
    if(!is_dir($directory)) {
        echo "That's not a directory!";
    }

    $filesInDir = scandir($directory);

    foreach($filesInDir as $file) {
        if(is_dir($file)) {
            self::deleteDirectory($file);
        } else {
            unlink($file);
        }
    }
    rmdir($directory);
}
?>
