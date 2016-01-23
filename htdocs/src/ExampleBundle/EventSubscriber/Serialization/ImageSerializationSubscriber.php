<?php

namespace ExampleBundle\EventSubscriber\Serialization;

use JMS\Serializer\EventDispatcher\EventSubscriberInterface;

/**
 * Class ImageSerializationSubscriber
 * @package ExampleBundle\EventSubscriber\Serialization
 */
class ImageSerializationSubscriber extends BaseSerializationSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            [
                'event'  => 'serializer.post_serialize',
                'method' => 'onObjectPostSerialize',
                'class'  => 'ExampleBundle\Entity\Image',
                'format' => 'json'
            ]
        ];
    }
}
