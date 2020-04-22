<?php

declare(strict_types=1);

/*
 * This code is under BSD 3-Clause "New" or "Revised" License.
 *
 * ------------------------------------------------------------------------
 * BiuradPHP Framework is a new sheme of php artitecture which is simple,  |
 * yet has powerful features. The framework has been built carefully 	   |
 * following the rules of the new PHP 7.2 and 7.3 above, with no support   |
 * for the old versions of PHP. As this framework was inspired by          |
 * several conference talks about the future of PHP and its development,   |
 * this framework has the easiest and best approach to the PHP world,      |
 * of course, using a few intentinally procedural programming module.      |
 * This makes BiuradPHP framework extremely reable and usuable for all.    |
 * BiuradPHP is a 35% clone of symfony framwork and 30% clone of Nette	   |
 * framework. The perfomance of BiuradPHP is 600ms on development mode and |
 * on production mode it's even better with great defense security.        |
 * ------------------------------------------------------------------------
 *
 * PHP version 7.2 and above required
 *
 * @category  BiuradPHP-Framework
 *
 * @author    Divine Niiquaye Ibok <divineibok@gmail.com>
 * @copyright 2019 Biurad Group (https://biurad.com/)
 * @license   https://opensource.org/licenses/BSD-3-Clause License
 *
 * @link      https://www.biurad.com/projects/biuradphp-framework
 */

namespace App\Tests\Traits;

use ReflectionClass;

/**
 * Include functionality for accessing protected/private members and methods
 */
trait ReflectionAccess
{
    /**
     * Set a property for a class.
     *
     * @param string|object $object
     * @param string        $propertyName
     * @param mixed         $propertyValue
     *
     * @return void
     */
    protected static function setProperty($object, $propertyName, $propertyValue)
    {
        $reflection = new ReflectionClass($object);
        $reflection_property = $reflection->getProperty($propertyName);
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($object, $propertyValue);
    }

    /**
     * Get a class property's value.
     *
     * @param string|object $object
     * @param mixed         $propertyName
     *
     * @return void
     */
    protected static function getProperty($object, $propertyName)
    {
        $reflection = new ReflectionClass($object);
        $reflection_property = $reflection->getProperty($propertyName);
        $reflection_property->setAccessible(true);

        return $reflection_property->getValue($object);
    }

    /**
     * Invoke a class method with arguments.
     *
     * @param string|object $object
     * @param string        $methodName
     * @param array         $arguments
     *
     * @return void
     */
    protected static function callMethod($object, $methodName, $arguments = [])
    {
        $reflection = new ReflectionClass($object);
        $reflection_method = $reflection->getMethod($methodName);
        $reflection_method->setAccessible(true);

        return $reflection_method->invokeArgs($object, $arguments);
    }
}
