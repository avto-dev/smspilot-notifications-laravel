<?php

namespace AvtoDev\SmsPilotNotifications\Tests\Traits;

use ReflectionClass;

/**
 * Trait AdditionalAssertsTrait.
 *
 * Trait with additional asserts methods.
 */
trait AdditionalAssertsTrait
{
    /**
     * Extract protected property
     *
     * @param object $object
     * @param string $property_name
     *
     * @return mixed
     */
    public function getPropertyValue($object, $property_name)
    {
        $reflectionClass = new ReflectionClass($object);
        $property        = $reflectionClass->getProperty($property_name);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
