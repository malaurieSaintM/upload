<?php
require_once __DIR__ . '../../vendor/autoload.php';
use app\Uploads\upload;
$newImage = new upload;
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../app/views');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);


if (isset($_POST['submit'])) {
    if ($_FILES['image']['error'] == 0 && !empty($_POST['name'])) {
        $newImage->upload($_FILES['image'], $_POST['name']);
    } else if ($_FILES['image']['error'] == 1 && !empty($_POST['name'])) {
        $oneFile = 'Veuillez choisir un fichier';
    } else if ($_FILES['image']['error'] == 0 && empty($_POST['name'])) {
        $aName = 'Veuillez remplir ce champs pour choisir le nom du fichier';
    } else {
        $error = 'Veuillez remplir tous les champs';
    }
} else {
    $_POST['name'] = '';
}
echo $twig->render('../views/index.html', [

    'imgName' => $newImage->newImgName,
    'img' => $newImage->destination,
    'requireFile' => $oneFile,
    'requireName' => $aName,
    'defect' => $error,
    'success' => $newImage->success,
]);