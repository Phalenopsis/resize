<?php
require_once "crop.php";
require_once "resize.php";
require_once "classoptions.php";
require_once "classmodimg.php";

$options = new Options();
$modimg = new ModImg(getopt($options->getShortOptions(), $options->getLongOptions()));
