<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 26/09/18
 * Time: 20:19
 */

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderService
{
    private $_targetDirectory;
    private $_nameCanonical;

    public function __construct($targetDirectory)
    {
        $this->_targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file, $type, $name)
    {
        $fileName = $this->setNameCanonical(
                $file->getClientOriginalExtension(), $file->getClientOriginalName()
            ) . '_' . md5(uniqid()) . '.' . $file->guessExtension();

        $file->move($this->getTargetDirectory($type, $name), $fileName);

        return $fileName;
    }

    /**
     * @param $type
     * @param $name
     * @return mixed
     */
    public function getTargetDirectory($type, $name)
    {
        return $this->_targetDirectory.'/'.$type.'/'.$name;
    }
}