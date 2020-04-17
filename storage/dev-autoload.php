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
require dirname(__DIR__) . '/vendor/autoload.php';

// Just For Development Mode
$loader = new Nette\Loaders\RobotLoader();
$loader->setTempDirectory(__DIR__.'/caches/biurad.robotLoader');
$loader->setAutoRefresh(true);
$loader->excludeDirectory(
    dirname(__DIR__).'/vendor/divineniiquaye/cycle-proxy-factory/tests',
    dirname(__DIR__).'/vendor/biurad/symfony-security-bridge-old'
);
$loader->addDirectory(dirname(__DIR__).'/vendor/biurad', dirname(__DIR__).'/vendor/divineniiquaye')->register();
