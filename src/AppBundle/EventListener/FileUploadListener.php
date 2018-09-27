<?php
namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Service\FileUploaderService;
use AppBundle\Entity\Document;

class FileUploadListener
{
    private $_uploader;

    public function __construct(FileUploaderService $_uploader)
    {
        $this->_uploader = $_uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->_uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->_uploadFile($entity);
    }

    private function _uploadFile($entity)
    {
        if (!$entity instanceof Document) {
            return;
        }

        $file = $entity->getCarRegistration();
        $name = $entity->getLastName();

        if ($file instanceof UploadedFile) {
            $fileName[] = $this->_uploader->upload($file, $name);
            $entity->setCarRegistration($fileName);
        } elseif ($file instanceof File) {
            $fileName[] = $file->getFilename();
            $entity->setCarRegistration($fileName);
        }
    }
}