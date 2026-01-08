<?php
// Script pour créer une image par défaut simple

// Créer une image de 400x400 pixels
$width = 400;
$height = 400;
$image = imagecreatetruecolor($width, $height);

// Couleurs
$black = imagecolorallocate($image, 0, 0, 0);
$green = imagecolorallocate($image, 0, 255, 0);
$darkGreen = imagecolorallocate($image, 0, 100, 0);

// Fond noir
imagefill($image, 0, 0, $black);

// Bordure verte
imagerectangle($image, 10, 10, $width-10, $height-10, $green);
imagerectangle($image, 15, 15, $width-15, $height-15, $darkGreen);

// Texte
$text = "IMAGE";
$text2 = "PRODUIT";

// Utiliser une fonte par défaut
imagestring($image, 5, ($width/2)-40, ($height/2)-20, $text, $green);
imagestring($image, 5, ($width/2)-50, ($height/2)+10, $text2, $green);

// Sauvegarder l'image
$outputPath = 'C:/xampp/htdocs/ecommerce/public/images/produits/default.jpg';

// Créer le dossier s'il n'existe pas
$dir = dirname($outputPath);
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

imagejpeg($image, $outputPath, 90);
imagedestroy($image);

echo "Image par défaut créée avec succès à : " . $outputPath;
?>