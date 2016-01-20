<?php

namespace ExampleBundle\Enum;

use ReflectionClass;

/**
 * Class AbstractBaseEnum
 * @package ExampleBundle\Enum
 */
class AbstractBaseEnum
{
    private static $constCacheArray = null;

    /**
     * @return mixed
     */
    private static function getConstants()
    {
        if (self::$constCacheArray == null) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }

        return self::$constCacheArray[$calledClass];
    }

    /**
     * @param $name
     * @param bool|false $strict
     * @return bool
     */
    public static function isValidName($name, $strict = false)
    {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));

        return in_array(strtolower($name), $keys);
    }

    /**
     * @param $value
     * @return bool
     */
    public static function isValidValue($value)
    {
        $values = array_values(self::getConstants());

        return in_array($value, $values, true);
    }
}
