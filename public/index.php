<?php

declare(strict_types=1);

/*
 * This file is part of Biurad opensource projects.
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

/*
 * --------------------------------------------------------------------------
 * The Directory Separator
 * --------------------------------------------------------------------------
 *
 * This is to shorten the full write of directory separator.
 */
\define('DS', \DIRECTORY_SEPARATOR) || \defined('DS');

/*
 * --------------------------------------------------------------------------
 * Use Full Paths for Better Performance
 * --------------------------------------------------------------------------
 *
 * The full path starting from the index.php file. Improves performance (a bit)
 */
\defined('BR_PATH') || \define('BR_PATH', \realpath(\dirname(__FILE__, 2)) . DS);

/*
 *--------------------------------------------------------------------------
 * Cli & CGI WebServer Booting
 *-------------------------------------------------------------------------
 *
 * Decline static file requests back to the PHP built-in web-server
 *
 */
if (\in_array(\PHP_SAPI, ['cli-server', 'cgi-fcgi'], true)) {
    $path = \realpath(__DIR__ . \parse_url($_SERVER['REQUEST_URI'], \PHP_URL_PATH));

    if (__FILE__ !== $path && \is_file((string) $path)) {
        return false;
    }

    unset($path);
}

/**
 * --------------------------------------------------------------------------
 * Register the Composer Autoloader                                         |
 * --------------------------------------------------------------------------
 *
 * Composer is our best friend. He maintains our dependencies and manage
 * the autoloader very well. Good guy Composer.
 */
require \dirname(__DIR__) . '/vendor/autoload.php';

// Execute programmatic/declarative application's pipelines.
App\Kernel::boot([
    'root'       => BR_PATH,
    'configDir'  => 'config',
    'tempDir'    => 'var',
]);
