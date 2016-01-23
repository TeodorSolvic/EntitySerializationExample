<?php

namespace ExampleBundle\Entity\EntityManager;

use Doctrine\Common\Persistence\ObjectManager;
use ExampleBundle\Entity\Image;
use ExampleBundle\Entity\Repository\ImageRepository;
use Grossum\CoreBundle\Entity\EntityTrait\SaveUpdateInManagerTrait;

/**
 * Class ImageManager
 * @package ExampleBundle\Entity\EntityManager
 */
class ImageManager
{
    use SaveUpdateInManagerTrait;

    /** @var ImageRepository $repository */
    private $repository;

    /** @var ObjectManager $objectManager */
    private $objectManager;

    /**
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->repository = $objectManager->getRepository('ExampleBundle:Image');
    }

    /**
     * @return ImageRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param Image $image
     */
    public function deleteImage(Image $image)
    {
        $this->objectManager->remove($image);
        $this->objectManager->flush();
    }
}
