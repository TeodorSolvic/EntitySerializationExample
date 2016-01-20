<?php

namespace ExampleBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use ExampleBundle\Entity\Image;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ImageController
 * @package ExampleBundle\Controller
 */
class ImageController extends FOSRestController
{
    /**
     * @param Image $image
     * @return Image
     */
    public function getImageAction(Image $image)
    {
        return ['image' => $image];
    }

    /**
     * @param Request $request
     * @return View
     */
    public function loadImagesAction(Request $request)
    {
        $imageLoader = $this->get('gig_core.image_loader');
        $images = $imageLoader->loadImages($request);

        return ['images' => $images ];
    }

    /**
     * @param Image $image
     * @return View
     */
    public function deleteImageAction(Image $image)
    {
        $this->get('gig_core.image_manager')->deleteImage($image);

        return $this->view([], Codes::HTTP_NO_CONTENT);
    }
}
