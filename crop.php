
<?php
require_once "functions.php";


/**
 * recadrer une image
 *
 * @param string $img adresse de l'image
 * @param integer $margin taille des marges en %
 * @return void
 */
function crop(string $img, int $marginPercent): void
{
    $newName = createNewImgName($img, "crop");

    $im = imagecreatefromjpeg($img);
    //$size = min(imagesx($im), imagesy($im));
    $margin = imagesx($im) * $marginPercent / 100;
    $size = imagesx($im) - 2 * $margin;
    $im2 = imagecrop($im, ['x' => $margin, 'y' => $margin, 'width' => $size, 'height' => $size]);
    if ($im2 !== FALSE) {
        imagejpeg($im2, $newName, 100);
        imagedestroy($im2);
    }
    imagedestroy($im);
}

function cropAll(array $images): void
{
    foreach ($images as $image) {
        crop($image, 30);
    }
}


//$size = $argv;
//crop();

//cropAll(GetJPGOnDir(getFilesOnDir()));

//crop("nicolas.jpg", 30);
