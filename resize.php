<?php


if (PHP_SAPI != "cli") {
  exit;
}
echo "Resize v0.0.1";
echo "To resize your images, only .jpg at this time." . PHP_EOL;
echo "Type php resize.php -h to access help." . PHP_EOL;
echo PHP_EOL;
if ($argc === 1) {
  echo "Veuillez entrer les tailles souhaitées" . PHP_EOL;
  exit;
}


/**
 * Function to resize a .jpg image
 *
 * @param string $source path to image to resize
 * @param string $typeValue type of resize ("W" for width, "H" for height)
 * @param array $newValue array of news values of type_value (if "W" and "256", new image will have a width of 256 px)
 * @param integer $compression compression ration
 * @param string $newFileName if "", name of the new file will be <nameSource><new_value>.jpg
 * @return bool
 */
function resizeImage(string $source, string $typeValue = "W", array $newValues = ["256"],  int $compression = 70): bool
{

  /*
    Récupération des dimensions de l'image afin de vérifier
    que ce fichier correspond bel et bien à un fichier image.
    Stockage dans deux variables le cas échéant.
  */
  if (!(list($widthSource, $heightSource) = @getimagesize($source))) {
    return false;
  }

  // Traitement pour chaque résolution voulue
  foreach ($newValues as $newValue) {
    // nom du répertoire de sauvegarde
    $saveDirectory = "images" . $newValue;
    //si le dossier d'enregistrement n'existe pas, il faut le créer
    if (!is_dir($saveDirectory)) {
      mkdir($saveDirectory);
    }


    $sourceArray = explode(".", $source);
    if (count($sourceArray) === 2) {
      $newFileName = $saveDirectory . "/" . $sourceArray[0] . $newValue . "." . $sourceArray[1];
    } else {
      return false;
    }

    /*
    Calcul de la valeur dynamique en fonction des dimensions actuelles
    de l'image et de la dimension fixe que nous avons précisée en argument.
    */
    if ($typeValue == "H") {
      $newHeight = $newValue;
      $newWidth = intval($newValue / $heightSource * $widthSource);
    } else {
      $newWidth = $newValue;
      $newHeight = intval($newValue / $widthSource * $heightSource);
    }
    /*
    Création du conteneur, c'est-à-dire l'image qui va contenir la version
    redimensionnée. Elle aura donc les nouvelles dimensions.
    */
    $image = imagecreatetruecolor($newWidth, $newHeight);
    /*
    Importation de l'image source. Stockage dans une variable pour pouvoir
    effectuer certaines actions.
    */
    $source_image = imagecreatefromstring(file_get_contents($source));
    /*
    Copie de l'image dans le nouveau conteneur en la rééchantillonant. Ceci
    permet de ne pas perdre de qualité.
    */
    imagecopyresampled($image, $source_image, 0, 0, 0, 0, $newWidth, $newHeight, $widthSource, $heightSource);
    /*
    Si nous avons spécifié une sortie et qu'il s'agit d'un chemin valide (accessible
    par le script)
    */
    if (strlen($newFileName) > 0 and @touch($newFileName)) {
      /*
      Enregistrement de l'image et affichage d'une notification à l'utilisateur.
      */
      imagejpeg($image, $newFileName, $compression);
      echo "Fichier sauvegardé sous le nom " . $newFileName . "." . PHP_EOL;
      /*
      Sinon...
      */
    } else {
      /*
      ...Nous indiquons au navigateur que nous affichons une image en définissant le
      header et nous affichons l'image.
      */
      header("Content-Type: image/jpeg");
      imagejpeg($image, NULL, $compression);
    }
    /*
    Libération de la mémoire allouée aux deux images (sources et nouvelle).
    */
    imagedestroy($image);
  }
  imagedestroy($source_image);
  return true;
}


/**
 * Resize many images.jpg
 *
 * @param array $images an array of JPG images
 * @param string $typeValue type of resize ("W" for width, "H" for height)
 * @param string $newValue new value of type_value (if "W" and "256", new image will have a width of 256 px)
 * @return void
 */
function resizeAll(array $images, string $typeValue = "W", array $newValues = ["256"]): void
{
  foreach ($images as $image) {
    resizeImage($image, $typeValue, $newValues);
  }
}

/**
 * return files on actual directory
 *
 * @return array
 */
function getFilesOnDir(): array
{
  return scandir(".");
}

/**
 * return an arry of all .jpg files in current directory
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

$sizes = $argv; // récupération des arguments en CLI
unset($sizes[0]); // on efface la première valuer (qui est le nom du fichier.php)

if ($sizes[1] === "-h") {
  echo "Arguments after script name must be numeric. They are sizes you want resize yours pictures." . PHP_EOL;
  echo "This script version could only resize .jpg pictures" . PHP_EOL;
  exit;
}

foreach ($sizes as $size) {
  if (!is_numeric($size)) {
    echo "args MUST be numbers";
  }
}
/*
echo "Resize v0.0.1";
echo "To resize your images, only .jpg at this time." . PHP_EOL;
echo "Type php resize.php -h to access help." . PHP_EOL;
*/
resizeAll(getJPGOnDir(getFilesOnDir()), "W", $sizes);
