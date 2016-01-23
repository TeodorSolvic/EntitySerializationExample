<?php

namespace ExampleBundle\Helper\Serialization;

use ExampleBundle\Entity\Image;
use Sonata\MediaBundle\Provider\Pool;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class ImageSerializationHelper
 * @package ExampleBundle\Helper\Serialization
 */
class ImageSerializationHelper implements SerializationHelperInterface
{
    /** @var Pool $sonataMediaPool */
    private $sonataMediaPool;

    /** @var Router $router */
    private $router;

    /**
     * @param Pool $sonataMediaPool
     * @param Router $router
     */
    public function __construct(
        Pool $sonataMediaPool,
        Router $router
    ) {
        $this->sonataMediaPool = $sonataMediaPool;
        $this->router = $router;
    }

    /**
     * {@Inheritdoc}
     * @param Image $image
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function getAdditionalData($image)
    {
        $media = $image->getFile();

        $provider = $this->sonataMediaPool->getProvider($media->getProviderName());
        $formatNames = $this->sonataMediaPool->getFormatNamesByContext($media->getContext());

        $thumbnails = [];
        foreach ($formatNames as $formatName => $details) {
            $thumbnails[$formatName] = $this->generateFullPublicUrl(
                $provider->generatePublicUrl($media, $formatName)
            );
        }

        $reference = $this->generateFullPublicUrl(
            $provider->generatePublicUrl($media, 'reference')
        );

        return [
            'url'        => $reference,
            'thumbnails' => $thumbnails
        ];
    }

    /**
     * @param string $publicUrl
     * @return string
     */
    private function generateFullPublicUrl($publicUrl)
    {
        $scheme = $this->router->getContext()->getScheme() . '://';
        $host = $this->router->getContext()->getHost();

        return $scheme . $host . $publicUrl;
    }
}
