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

namespace App;

use BiuradPHP\MVC\CoreKernel;
use RuntimeException;
use Symfony\Component\Dotenv\Dotenv;

/**
 * The Kernel is the heart of the Biurad PHP Framework.
 *
 * It manages an environment made of application kernel, components, and extensions.
 *
 * @see      https://www.biurad.com/framework
 *
 * @author    Divine Niiquaye Ibok <divineibok@gmail.com>
 * @license   BSD 3-Clause License
 */
class Kernel
{
    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public static function boot(string $rootPath): CoreKernel
    {
        //Load the environmental file.
        if (!\class_exists(Dotenv::class)) {
            throw new RuntimeException(
                'Please run "composer require symfony/dotenv" to load the ".env" files configuring the application.'
            );
        }

        $rootPath    = \rtrim($rootPath, '\\/');
        $storagePath = $rootPath . \DIRECTORY_SEPARATOR . 'storage';
        $configPath  = $rootPath . \DIRECTORY_SEPARATOR . 'config';

        // load all the .env files
        (new Dotenv(false))->loadEnv($rootPath . '/.env');

        // Boot the CoreKenel for processes to begin...
        $kernel = new CoreKernel($rootPath);

        // Let's enable our debugger our exceptions first.
        //$kernel->setDebugMode('23.75.345.200'); // enable for your remote IP
        //$kernel->setDebugMode(false); // uncomment to start in production mode
        $kernel->enableTracy($storagePath . \DIRECTORY_SEPARATOR . 'logs');

        // Getting setup a few settings.
        $kernel->setTimeZone(\date_default_timezone_get());
        $kernel->setTempDirectory($storagePath);
        $kernel->addConfig($configPath . \DIRECTORY_SEPARATOR . 'parameters.yaml');

        // We want to keep track of where each value came from so we don't
        // use CoreKernel::addConfig since it does merging internally.
        $packagesConfig = \glob("{$configPath}/{packages}/_*" . self::CONFIG_EXTS, \GLOB_BRACE);
        \array_walk($packagesConfig, [$kernel, 'addConfig']);

        return $kernel;
    }
}
