<?php

namespace AppBundle\Service;

use AppBundle\Entity\Advertisement;
use Doctrine\ORM\EntityManager;

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
     */
    public function saveAdvertisement(Advertisement $entity)
    {
        /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $entity->getImage();

        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $file->move($this->imagesDirectory, $fileName);
        list($width, $height) = getimagesize($this->imagesDirectory . '/' . $fileName);

        $entity->setWidth($width);
        $entity->setHeight($height);
        $entity->setImage($fileName);

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
        //unlink
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}
