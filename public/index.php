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

define('BR_START', microtime(true)) || defined('BR_START');

/*
 * --------------------------------------------------------------------------
 * The Directory Seperator
 * --------------------------------------------------------------------------
 *
 * This is to shorten the full write of directory seperator.
 */
define('DS', DIRECTORY_SEPARATOR) || defined('DS');

/**
 * --------------------------------------------------------------------------
 * Use Full Paths for Better Performance
 * --------------------------------------------------------------------------
 *
 * The full path starting from the index.php file. Improves performance (a bit)
 */
define('BR_PATH', realpath(dirname(__FILE__, 2)) . DS) || defined('BR_PATH');

/**
 * --------------------------------------------------------------------------
 * Include the Bootstrap File
 * --------------------------------------------------------------------------
 *
 * This script returns the application instance. The instance is given to
 * the calling script so we can separate the building of the instances
 * from the actual running of the application and sending responses.
 */
$app = require BR_PATH . 'app' . DS . 'bootstrap.php';

/*
 *--------------------------------------------------------------------------
 * Cli & CGI WebServer Booting
 *-------------------------------------------------------------------------
 *
 * Decline static file requests back to the PHP built-in webserver
 *
 */
if (in_array(php_sapi_name(), ['cli-server', 'cgi-fcgi'], true)) {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }

    unset($path);
}

return $app; // Return The Application.
