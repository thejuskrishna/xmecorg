<?php

$imgdir="gallery/big";
$imghandle=opendir($imgdir);
$thumbdir="gallery/thumbnails";
$thumbhandle=opendir($thumbdir);

$imgFiles = array();
if ($imghandle = opendir($imgdir)) {
    while (false !== ($file = readdir($imghandle))) {

        $crap   = array(".jpg", ".jpeg", ".JPG", ".JPEG", ".png", ".PNG", ".gif", ".GIF", ".bmp", ".BMP", "_", "-");
        $newstring = str_replace($crap, " ", $file );
        if ($file != "." && $file != ".." && $file != "index.php" && $file != "Thumbnails") {
                $imgFiles[] = $file;
        }
    }
    closedir($imghandle);
}

sort($imgFiles);
foreach($imgFiles as $file)
{
    echo "$file<br>";
    //echo "<li><a href=\"$imgdir/$file\" title=\"$newstring\"><img src=\"$thumbdir/$file\" alt=\"$newstring\" width=\"300\"  </a></li>\n";
}

$thumbFiles = array();
if ($thumbhandle = opendir($thumbdir)) {
    while (false !== ($file = readdir($thumbhandle))) {

        // strips files extensions
        $crap   = array(".jpg", ".jpeg", ".JPG", ".JPEG", ".png", ".PNG", ".gif", ".GIF", ".bmp", ".BMP", "_", "-");

        $newstring = str_replace($crap, " ", $file );

        // hides folders, writes out ul of images and thumbnails from two folders

        if ($file != "." && $file != ".." && $file != "index.php" && $file != "Thumbnails") {
                $thumbFiles[] = $file;
        }
    }
    closedir($thumbhandle);
}

sort($thumbFiles);
echo "<br><br>";
foreach($thumbFiles as $file)
{
    echo "$file<br>";
    //echo "<li><a href=\"$imgdir/$file\" title=\"$newstring\"><img src=\"$thumbdir/$file\" alt=\"$newstring\" width=\"300\"  </a></li>\n";
}

?>