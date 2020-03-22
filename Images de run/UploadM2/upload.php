<?php

header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: *");

$toReturn =  "[";

foreach ($_FILES as $value){
    $extension = strtolower(strrchr($value['name'], '.'));
    $fichier = time()."_".rand(10000,99999) . $extension;

    $dossier = 'images/';
    $dossierfiles = 'files/';

    $taille_maxi = 30000000;
    $taille = filesize($value['tmp_name']);

    $extensionimageredim = array('.png', '.jpg', '.jpeg', '.jpe', '.jfif', '.gif');
    $extensionjpg = array('.jpg','.jpeg','.jpe','.jfif');

    if($taille>$taille_maxi) {
        http_response_code(400);
        die;
    }

    if (in_array($extension, $extensionimageredim) && $taille_maxi >= $taille) {
        if (move_uploaded_file($value['tmp_name'], $dossier.$fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
        {
            $source=(in_array($extension, $extensionjpg))?
                imagecreatefromjpeg($dossier.$fichier):
                imagecreatefrompng($dossier.$fichier);

            $largeur_source = imagesx($source);
            $hauteur_source = imagesy($source);
            if($largeur_source>1920 || $hauteur_source>1080) {
                if ($largeur_source >= $hauteur_source) {
                    $largeur_dest = 1920;
                    $hauteur_dest = $hauteur_source / ($largeur_source / 1920);
                    $destination = imagecreatetruecolor(1920, $hauteur_dest);
                } else {
                    $hauteur_dest = 1080;
                    $largeur_dest = $largeur_source / ($hauteur_source / 1080);
                    $destination = imagecreatetruecolor($largeur_dest, 1080);
                }

                if (!in_array($extension, $extensionjpg)) {
                    imagealphablending($destination, FALSE);
                    imagesavealpha($destination, TRUE);
                }

                $largeur_destination = imagesx($destination);
                $hauteur_destination = imagesy($destination);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);

                in_array($extension, $extensionjpg)?
                    imagejpeg($destination, $dossier . $fichier):
                    imagepng($destination, $dossier . $fichier);

                imagedestroy($destination);
            }
            imagedestroy($source);

            $toReturn = $toReturn. "\"https://uploadm2.artheriom.fr/". $dossier . $fichier."\",";
        }
    }
}

$toReturn = substr($toReturn, 0, -1);
echo $toReturn . "]";

?>
