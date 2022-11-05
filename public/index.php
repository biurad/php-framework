<?php declare(strict_types=1);

/*
 * This file is part of Biurad opensource projects.
 *
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
    \class_exists(\Symfony\Component\Dotenv\Dotenv::class) && (new \Symfony\Component\Dotenv\Dotenv())->load($env);
}

// Enable the error handler
\Tracy\Debugger::enable($debug = $_SERVER['APP_PROD'] ?? $_ENV['APP_PROD'] ?? false, BR_PATH.'var/logs');

/**
 * --------------------------------------------------------------------------
 * Create The Application
 * --------------------------------------------------------------------------
 *
 * Using the APP_COMPILE environment variable, we can run cacheable or non-cacheable version of the application.
 * Uncomment the last part of the $compilable to enable non-cacheable as default
 */
$compilable = isset($_SERVER['APP_COMPILE']) || isset($_ENV['APP_COMPILE']) || true;

$app = $compilable ? Flange\AppBuilder::build(
    static function (Flange\AppBuilder $creator): void {
        [$extensions, $config] = require $bootstrap = BR_PATH.'resources/bootstrap.php';
        $creator->loadExtensions($extensions, $config, BR_PATH.'var/config');
        $creator->load($services = BR_PATH.'resources/services.php');

        // Add resource to re-compile if changes are made to this file.
        $creator->addResource(new \Symfony\Component\Config\Resource\FileResource(__FILE__));
        $creator->addResource(new \Symfony\Component\Config\Resource\FileResource($bootstrap));
        $creator->addResource(new \Symfony\Component\Config\Resource\FileResource($services));
    },
    [
        'debug' => !$debug,
        'cacheDir' => BR_PATH.'var/app',
    ]
) : (static function () use ($debug): Flange\Application {
    [$extensions, $config] = require BR_PATH.'resources/bootstrap.php';
    $app = new Flange\Application(debug: !$debug);
    $app->loadExtensions($extensions, $config);
    $app->load(BR_PATH.'resources/services.php');

    return $app;
})();

try {
    $app->run(); // A kernel for dispatching application
} finally {
    if ($app->has('tracy.bar')) {
        $app->get('tracy.bar');
    }
}
