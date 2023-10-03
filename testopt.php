<?php
$shortops = "";
$shortops .= "h::";
$shortops .= "";
$longopts  = array(
    //"required:",     // Valeur requise
    "resize:",
    "crop::",
    "h::",
    "help::",
    //"optional::",    // Valeur optionnelle
    //"option",        // Aucune valeur
    //"opt",           // Aucune valeur
);

$options = getopt($shortops, $longopts);
var_dump($options);
if (array_key_exists("h", $options)) {
    echo "l'aide doit s'afficher" . PHP_EOL;
}
if (array_key_exists("help", $options)) {
    echo "l'aide s'affiche" . PHP_EOL;
}
if (empty($options)) {
    echo "taper l'aide ici";
}
var_dump($argv);


/// test ...
$array = [1, 2, 3, 4, 5, 6];
