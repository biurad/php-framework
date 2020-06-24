<?php

declare(strict_types=1);

/*
 * This file is part of BiuradPHP opensource projects.
 *
 * PHP version 7.2 and above required
 *
 * @author    Divine Niiquaye Ibok <divineibok@gmail.com>
 * @copyright 2019 Biurad Group (https://biurad.com/)
 * @license   https://opensource.org/licenses/BSD-3-Clause License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Traits;

use ReflectionClass;
use ReflectionException;

/**
 * Include functionality for accessing protected/private members and methods
 */
trait ReflectionAccess
{
    /**
     * Set a property for a class.
     *
     * @param object|string $object
     * @param string        $propertyName
     * @param mixed         $propertyValue
     *
     * @throws ReflectionException
     */
    protected static function setProperty($object, $propertyName, $propertyValue): void
    {
        $reflection          = new ReflectionClass($object);
        $reflection_property = $reflection->getProperty($propertyName);
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($object, $propertyValue);
    }

    /**
     * Get a class property's value.
     *
     * @param object|string $object
     * @param mixed         $propertyName
     *
     * @throws ReflectionException
     * @return mixed
     */
    protected static function getProperty($object, $propertyName)
    {
        $reflection          = new ReflectionClass($object);
        $reflection_property = $reflection->getProperty($propertyName);
        $reflection_property->setAccessible(true);

        return $reflection_property->getValue($object);
    }

    /**
     * Invoke a class method with arguments.
     *
     * @param object|string $object
     * @param string        $methodName
     * @param array         $arguments
     *
     * @throws ReflectionException
     * @return mixed
     */
    protected static function callMethod($object, $methodName, $arguments = [])
    {
        $reflection        = new ReflectionClass($object);
        $reflection_method = $reflection->getMethod($methodName);
        $reflection_method->setAccessible(true);

        return $reflection_method->invokeArgs($object, $arguments);
    }
}
