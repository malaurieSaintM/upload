<?php
namespace app\Uploads;
class Upload
{
    public $error;
    public $destination;
    public $newImgName;
    public $success;
    public function upload($file, $name)
    {
        $this->image($file, $name);
    }
    //extensions de l'image
    protected function image($file, $name)
    {
        $extensions = ['jpg', 'jpeg', 'png'];
        $my_file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (in_array($my_file_extension, $extensions))
            $this->weight($file, $name, $my_file_extension);
        else $this->error = "le fichier choisi n'est pas une image, veuillez réessayer";

    }
    //poids du fichier
    protected function weight($file, $name, $fileExtension)
    {
        if ($file['size'] > 10000000) $this->error = 'le fichier doit faire moins de 10Mo !';
        else $this->Destination($file, $name, $fileExtension);
    }

    //destination de l'image
    protected function Destination($file, $newName, $fileExtension)
    {
        $imgDestination = '../../storage/' . $newName . '.' . $fileExtension;
        $this->NewImage($file, $newName, $fileExtension, $imgDestination);
    }


    protected function NewImage($file, $newName, $fileExtension, $imgDestination)
    {
        $newImg = $newName . '.' . $fileExtension;
        $this->alreadyExist($file, $imgDestination);
        $this->newImgName = $newImg;
    }

    //function qui regarde si la nouvelle que l'on souhaite a déja le meme nom qu'une autre image
    // si c'st le cas on ne l'ajoute pas
    // sinon on la met dans le dossier prévu pour.
    public function alreadyExist($file, $imgDestination)
    {
        $files = glob('../../storage/*');
        if (in_array($imgDestination, $files)) {
            $this->error = 'ce nom est déjà utilisé !';
            $this->destination = '';
        } else {
            $this->destination = $imgDestination;
            $this->success = 'upload ok !';
            $this->move($file, $imgDestination);
        }
    }
    //function qui permet de bouger les fichiers dans le dossier prévu
    protected function move($file, $imgDestination)
    {
        move_uploaded_file($file['tmp_name'], $imgDestination);
    }
}