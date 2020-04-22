<?php
/** @noinspection NullPointerExceptionInspection */

declare(strict_types=1);

/**
 * --------------------------------------------------------------------------
 * Register the Composer Autoloader                                         |
 * --------------------------------------------------------------------------
 *
 * Composer is our best friend. He maintains our dependencies and manage
 * the autoloader very well. Good guy Composer.
 */
$loader = require dirname(__DIR__) . '/vendor/autoload.php';

// Just For Development Mode
$autoloadProject = [
    'BiuradPHP\\API\\'                      => dirname(__DIR__) . '/vendor/biurad/biurad-api/src',
    'BiuradPHP\\Cache\\'                    => dirname(__DIR__) . '/vendor/biurad/biurad-caching/src',
    'BiuradPHP\\Database\\'                 => dirname(__DIR__) . '/vendor/biurad/biurad-database/src',
    'BiuradPHP\\'                           => dirname(__DIR__) . '/vendor/biurad/biurad-developer-tools/src',
    'BiuradPHP\\Events\\'                   => dirname(__DIR__) . '/vendor/biurad/biurad-events-bus/src',
    'BiuradPHP\\MVC\\'                      => dirname(__DIR__) . '/vendor/biurad/biurad-framework/src',
    'BiuradPHP\\Support\\'                  => dirname(__DIR__) . '/vendor/biurad/biurad-helpers/src',
    'BiuradPHP\\'                           => dirname(__DIR__) . '/vendor/biurad/biurad-i18n/src',
    'BiuradPHP\\Loader\\'                   => dirname(__DIR__) . '/vendor/biurad/biurad-loader/src',
    'BiuradPHP\\Security\\'                 => dirname(__DIR__) . '/vendor/biurad/biurad-security/src',
    'BiuradPHP\\Session\\'                  => dirname(__DIR__) . '/vendor/biurad/biurad-sessions/src',
    'BiuradPHP\\Template\\'                 => dirname(__DIR__) . '/vendor/biurad/biurad-templating/src',
    'BiuradPHP\\'                           => dirname(__DIR__) . '/vendor/biurad/cycle-orm-bridge/src',
    'BiuradPHP\\Routing\\'                  => dirname(__DIR__) . '/vendor/biurad/flight-routing-bridge/src',
    'BiuradPHP\\Http\\'                     => dirname(__DIR__) . '/vendor/biurad/biurad-http/src',
    'BiuradPHP\\FileManager\\'              => dirname(__DIR__) . '/vendor/biurad/biurad-flysystem/src',
    'BiuradPHP\\DependencyInjection\\'      => dirname(__DIR__) . '/vendor/biurad/nette-di-bridge/src/',
    'BiuradPHP\\'                           => dirname(__DIR__) . '/vendor/biurad/biurad-terminal/src',
    'BiuradPHP\\'                           => dirname(__DIR__) . '/vendor/biurad/biurad-scaffolder/src',
    'Cycle\\'                               => dirname(__DIR__) . '/vendor/divineniiquaye/cycle-orm/src',
    'Cycle\\'                               => dirname(__DIR__) . '/vendor/divineniiquaye/cycle-annotation/src',
    'Cycle\\'                               => dirname(__DIR__) . '/vendor/divineniiquaye/cycle-proxy-factory/src',
    'Cycle\\'                               => dirname(__DIR__) . '/vendor/divineniiquaye/cycle-schema-builder/src',
    'Flight\\Routing\\'  => dirname(__DIR__) . '/vendor/divineniiquaye/flight-routing/src',
    'Prush\\'            => dirname(__DIR__) . '/vendor/divineniiquaye/prush-finder/src'
];

foreach ($autoloadProject as $namspace => $paths) {
    $loader->setPsr4($namspace, $paths);
}

$loader->register(true);

return $loader;
