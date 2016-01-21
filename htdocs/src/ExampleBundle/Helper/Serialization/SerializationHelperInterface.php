<?php

namespace ExampleBundle\Helper\Serialization;

/**
 * Interface SerializationHelperInterface
 * @package ExampleBundle\Helper\Serialization
 */
interface SerializationHelperInterface
{
    /**
     * @param Object $entity
     * @return array
     */
    public function getAdditionalData($entity);
}
