<?php

/**
 * return an array of all .jpg images in the array passed in argument
 *
 * @param array $filesOnDir
 * @return array
 */
function getJPGOnDir(array $filesOnDir): array
{
    $jpegs = [];
    foreach ($filesOnDir as $file) {
        if (str_ends_with($file, ".jpg")) {
            $jpegs[] = $file;
        }
    }
    return $jpegs;
}

/**
 * return all files who are in the directory
 * current directory by default
 *
 * @param string $dir target directory
 * @return array an array 
 */
function getFilesOnDir($dir = '.'): array
{
    $files = [];
    foreach (scandir($dir) as $file) {
        $files[] = $dir . "/" . $file;
    }
    return $files;
}

//var_dump(getJPGOnDir(getFilesOnDir("./crop")));

/**
 * crée un nouveau nom  pour sauvegarder une image dans un dossier crop
 *
 * @param string $name
 * @param string $saveDirectory
 * @return string
 */
function createNewImgName(string $name, string $saveDirectory): string
{
    //$arrayForName = explode(".", $name); // inutile pour le moment, à voir si utile d'insérer un -cropped dans le nom
    //$saveDirectory = "crop";
    if (!is_dir($saveDirectory)) {
        mkdir($saveDirectory);
    }
    $newName = $saveDirectory . "/" . $name;
    return $newName;
}
