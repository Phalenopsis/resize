
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
    $marginWidth = imagesx($im) * $marginPercent / 100;
    $marginHeight = imagesx($im) * $marginPercent / 100;
    $newWidth = imagesx($im) - 2 * $marginWidth;
    $newHeight = imagesy($im) - 2 * $marginHeight;
    $im2 = imagecrop($im, ['x' => $marginWidth, 'y' => $marginHeight, 'width' => $newWidth, 'height' => $newHeight]);
    if ($im2 !== FALSE) {
        imagejpeg($im2, $newName, 100);
        imagedestroy($im2);
    }
    imagedestroy($im);
}

function cropAll(array $images, int $value): void
{
    foreach ($images as $image) {
        crop($image, $value);
    }
}


//$size = $argv;
//crop();

//cropAll(GetJPGOnDir(getFilesOnDir()));

//crop("nicolas.jpg", 30);
