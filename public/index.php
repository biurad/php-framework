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

/*
 * --------------------------------------------------------------------------
 * The Directory Separator
 * --------------------------------------------------------------------------
 *
 * This is to shorten the full write of directory separator.
 */
\defined('DS') || \define('DS', \DIRECTORY_SEPARATOR);

/*
 * --------------------------------------------------------------------------
 * Use Full Paths for Better Performance
 * --------------------------------------------------------------------------
 *
 * The full path starting from the index.php file. Improves performance (a bit)
 */
\defined('BR_PATH') || \define('BR_PATH', $_SERVER['APP_DIR'] ?? $_ENV['APP_DIR'] ?? __DIR__ . '/../');

/**
 * --------------------------------------------------------------------------
 * Register the Composer Autoloader                                         |
 * --------------------------------------------------------------------------.
 *
 * Composer is our best friend. He maintains our dependencies and manage
 * the autoloader very well. Good guy Composer.
 */
require BR_PATH . 'vendor/autoload.php';

// Load environment variables
if (\is_file($env = BR_PATH . '.env')) {
    (new \Symfony\Component\Dotenv\Dotenv())->load($env);
}

// Enable the error handler
\Tracy\Debugger::enable($debug = $_SERVER['APP_DEBUG'] ?? $_ENV['APP_DEBUG'] ?? null, BR_PATH . 'var/logs');

// PSR-11 Container instance
$app = \Rade\AppBuilder::build(
    static function (\Rade\AppBuilder $creator): void {
        // Add resource to re-compile if changes are made to this file.
        $creator->addResource(new \Symfony\Component\Config\Resource\FileResource(__FILE__));
        [$extensions, $config] = require BR_PATH . 'resources/bootstrap.php';

        $creator->loadExtensions($extensions, $config, BR_PATH . 'var/config');
        $creator->load(BR_PATH . 'resources/services.php');
    },
    [
        'debug' => $debug ?? true,
        'cacheDir' => BR_PATH . '/var/cache',
    ]
);

// A kernel for dispatching application
$app->run();
