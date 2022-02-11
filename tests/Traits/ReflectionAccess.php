<?php

declare(strict_types=1);

/*
 * This file is part of Biurad opensource projects.
 *
 * PHP version 8.0 and above required
 *
 * @author    Divine Niiquaye Ibok <divineibok@gmail.com>
 * @copyright 2019 Biurad Group (https://biurad.com/)
 * @license   https://opensource.org/licenses/BSD-3-Clause License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Traits;

/**
 * Include functionality for accessing protected/private members and methods.
 */
trait ReflectionAccess
{
    /**
     * Set a property for a class.
     *
     * @throws \ReflectionException
     */
    protected static function setProperty(object|string $object, string $propertyName, mixed $propertyValue): void
    {
        $reflection = new \ReflectionClass($object);
        $reflection_property = $reflection->getProperty($propertyName);
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($object, $propertyValue);
    }

    /**
     * Get a class property's value.
     *
     * @throws \ReflectionException
     */
    protected static function getProperty(object|string $object, mixed $propertyName): mixed
    {
        $reflection = new \ReflectionClass($object);
        $reflection_property = $reflection->getProperty($propertyName);
        $reflection_property->setAccessible(true);

        return $reflection_property->getValue($object);
    }

    /**
     * Invoke a class method with arguments.
     *
     * @throws \ReflectionException
     */
    protected static function callMethod(object|string $object, string $methodName, array $arguments = []): mixed
    {
        $reflection = new \ReflectionClass($object);
        $reflection_method = $reflection->getMethod($methodName);
        $reflection_method->setAccessible(true);

        return $reflection_method->invokeArgs($object, $arguments);
    }
}
