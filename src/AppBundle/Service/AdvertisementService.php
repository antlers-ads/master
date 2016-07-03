<?php

namespace AppBundle\Service;

use AppBundle\Entity\Advertisement;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Advertisement service used to DRY up controller's code.
 */
class AdvertisementService
{
    /** @var string */
    protected $imagesDirectory;

    /** @var EntityManager */
    protected $entityManager;

    /**
     * Injects dependencies.
     *
     * @param EntityManager $entityManager
     * @param string $imagesDirectory
     */
    public function __construct(EntityManager $entityManager, $imagesDirectory)
    {
        $this->entityManager = $entityManager;
        $this->imagesDirectory = $imagesDirectory;
    }

    /**
     * Saves advertisement along with image.
     *
     * @param Advertisement $entity
     * @param File $oldFile
     */
    public function saveAdvertisement(Advertisement $entity, File $oldFile = null)
    {
        /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $entity->getImage();

        if (is_uploaded_file($file->getPathname())) {
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->imagesDirectory, $fileName);
            list($width, $height) = getimagesize($this->imagesDirectory . '/' . $fileName);

            $entity->setWidth($width);
            $entity->setHeight($height);
            $entity->setImage($fileName);

            if ($oldFile) {
                unlink($oldFile->getPathname());
            }
        } else {
            $entity->setImage($file->getFilename());
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * Deletes advertisement along with image.
     *
     * @param Advertisement $entity
     */
    public function deleteAdvertisement(Advertisement $entity)
    {
        unlink($this->imagesDirectory . '/' . $entity->getImage());
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}
