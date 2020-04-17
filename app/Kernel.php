<?php

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
 * on production mode it's even better with great defense security.        |                                            |
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

namespace App;

use Laminas\Stdlib\Glob;
use BiuradPHP\MVC\CoreKernel;
use BiuradPHP\Locator\Interfaces\ResourceLocatorInterface;
use Flight\Routing\Interfaces\RouteCollectorInterface;
use Flight\Routing\Interfaces\RouterProxyInterface;

use function date_default_timezone_get;

use const DIRECTORY_SEPARATOR;

/**
 * The Kernel is the heart of the Biurad PHP Framework.
 *
 * It manages an environment made of application kernel, components, and extentions.
 *
 * @link      https://www.biurad.com/framework
 * @author    Divine Niiquaye Ibok <divineibok@gmail.com>
 * @license   BSD 3-Clause License
 */
class Kernel
{
    /**
     * {@inheritDoc}
     */
    public static function boot(): CoreKernel
    {
        $kernel = new CoreKernel();
        $paramters = $kernel->getDefaultParameters();

        // Paths for configurations
        $path = $paramters['path']['ROOT'];

        /*
         * Let's enable our debugger our exceptions first.
         */
        //$kernel->setDebugMode('23.75.345.200'); // enable for your remote IP
        //$kernel->setDebugMode(false); // uncomment to start in production mode
        $kernel->enableWhoops();

        /*
         * Getting setup a few settings.
         */
        $kernel->setTimeZone(date_default_timezone_get());
        $kernel->setTempDirectory($path . DIRECTORY_SEPARATOR . 'storage');
        $kernel->addConfig($path . DIRECTORY_SEPARATOR . 'config/framework.yaml');

        // We want to keep track of where each value came from so we don't
        // use CoreKernel::addConfig since it does merging internally.
        foreach (Glob::glob("{$path}/config/packages/_*.{yaml,yml,php}", Glob::GLOB_BRACE) as $file) {
            $kernel->addConfig($file);
        }

        return $kernel;
    }

    /**
     * Intialise Router for web routing on user's request.
     *
     * @internal This method is internally used and should always,
     *      return RouteCollectorInterface instance.
     *
     * @param RouteCollectorInterface $router
     * @param ResourceLocatorInterface $path
     *
     * @return RouteCollectorInterface
     */
    public static function handleRouting(RouteCollectorInterface $router, ResourceLocatorInterface $path)
    {
        // Defines the "web" routes for the application.
        // These routes all receive session state, CSRF protection, etc.
        $router->group([], function (RouterProxyInterface $route) use ($path) {
            require $path->findResource('routes://web.php');
        });

        // Defines the "auth" routes for the application.
        // These routes all authentications, etc.
        $router->group([], function (RouterProxyInterface $route) use ($path) {
            require $path->findResource('routes://auth.php');
        });

        // Defines the "api" routes for the application.
        // These routes are typically stateless.
        $router->group(['prefix' => 'api', 'name' => 'api'], function (RouterProxyInterface $route) use ($path) {
            require $path->findResource('routes://api.php');
        });

        return $router;
    }
}
