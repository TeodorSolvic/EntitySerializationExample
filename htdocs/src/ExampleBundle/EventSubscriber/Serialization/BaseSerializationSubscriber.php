<?php

namespace ExampleBundle\EventSubscriber\Serialization;

use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\JsonSerializationVisitor;
use ExampleBundle\Helper\Serialization\SerializationHelperInterface;

/**
 * Class BaseSerializationSubscriber
 * @package ExampleBundle\EventSubscriber\Serialization
 */
class BaseSerializationSubscriber
{
    /** @var SerializationHelperInterface $serializationHelper */
    private $serializationHelper;

    /**
     * @param SerializationHelperInterface $serializationHelper
     */
    public function __construct(SerializationHelperInterface $serializationHelper)
    {
        $this->serializationHelper = $serializationHelper;
    }

    /**
     * @param ObjectEvent $event
     */
    public function onObjectPostSerialize(ObjectEvent $event)
    {
        /** @var JsonSerializationVisitor $visitor */
        $visitor = $event->getVisitor();
        $additionalData = $this->serializationHelper->getAdditionalData($event->getObject());

        foreach ($additionalData as $key => $value) {
            $visitor->addData($key, $value);
        }
    }
}
