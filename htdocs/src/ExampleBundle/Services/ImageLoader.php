<?php

namespace ExampleBundle\Services;

use Application\Sonata\MediaBundle\Entity\Media;
use ExampleBundle\Entity\EntityManager\ImageManager;
use ExampleBundle\Entity\Image;
use Sonata\MediaBundle\Entity\MediaManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ImageLoader
 * @package ExampleBundle\Services
 */
class ImageLoader
{
    /** @var ImageManager $imageManager */
    private $imageManager;

    /** @var MediaManager $mediaManager */
    private $mediaManager;

    /**
     * @param ImageManager $imageManager
     * @param MediaManager $mediaManager
     */
    public function __construct(
        ImageManager $imageManager,
        MediaManager $mediaManager
    ) {
        $this->imageManager = $imageManager;
        $this->mediaManager = $mediaManager;
    }

    /**
     * @param Request $request
     * @return Image[]
     */
    public function loadImages(Request $request)
    {
        $images = [];
        $context = $request->get('context', 'exampleContext');

        /** @var UploadedFile $uploadedFile */
        foreach ($request->files->all() as $uploadedFile) {
            $images[] = $this->saveImage($uploadedFile, $context);
        }

        return $images;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string $context
     * @return Image
     */
    private function saveImage(UploadedFile $uploadedFile, $context)
    {
        $media = new Media();
        $media->setBinaryContent($uploadedFile);
        $media->setContext($context);
        $media->setProviderName('sonata.media.provider.image');
        $this->mediaManager->save($media);

        $image = new Image();
        $image->setFile($media);
        $this->imageManager->save($image);

        return $image;
    }
}
