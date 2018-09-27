<?php
namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderService
{
    private $_targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->_targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file, $name)
    {
        $fileName =  $file->getClientOriginalName();

        $file->move($this->getTargetDirectory($name), $fileName);

        return $fileName;
    }

    /**
     * @param $name|null
     * @return mixed
     */
    public function getTargetDirectory($name = null)
    {
        return $this->_targetDirectory.'/'.$name;
    }

    public function deletePdf($name)
    {
        $dir = $this->getTargetDirectory($name);
        if (is_dir($dir)) { // si le paramètre est un dossier
        $objects = scandir($dir); // on scan le dossier pour récupérer ses objets
        foreach ($objects as $object) { // pour chaque objet
            if ($object != "." && $object != "..") { // si l'objet n'est pas . ou ..
                if (filetype($dir."/".$object) == "dir") rmdir($dir."/".$object);else unlink($dir."/".$object); // on supprime l'objet
            }
        }
        reset($objects); // on remet à 0 les objets
        rmdir($dir); // on supprime le dossier
    }
    }
}