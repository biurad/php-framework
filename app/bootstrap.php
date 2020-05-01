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

//Load the environmental file.
if (!class_exists(Symfony\Component\Dotenv\Dotenv::class)) {
    throw new RuntimeException('Please run "composer require symfony/dotenv" to load the ".env" files configuring the application.');
}

// load all the .env files
(new Symfony\Component\Dotenv\Dotenv(false))->loadEnv(dirname(__DIR__).'/.env');

/*
 * --------------------------------------------------------------------------
 * Setup Main Kernel                                                        |
 * --------------------------------------------------------------------------
 *
 * Creates a Kernel of classed classes for reading.
 * Self-called anonymous function that creates its own scope and keep the global namespace clean.
 */
$kernel = App\Kernel::boot(BR_PATH);

/*
 * --------------------------------------------------------------------------
 * Setup Custom Class Loaders                                               |
 * --------------------------------------------------------------------------
 *
 * Incase you need to load classes externally in your application,
 * Just add your directory in the `addDirectory()` method and if
 * you want to exclude some directory do same in `excludeDirectory` method
 */
if (file_exists($modulePath = dirname(__DIR__) . '/modules')) {
    $kernel->createRobotLoader()
        ->excludeDirectory()
        ->addDirectory($modulePath)
    ->register(true);
}

/*
 * Next, we need to bind some important interfaces into the container so
 * we will be able to resolve them when needed. The kernels serve the
 * incoming requests to this application from both the web and CLI.
 */
//$container->bind('kernel', $this instanceof CoreKernel ? $this : $kernel);
$kernel->addServices(['kernel' => $kernel]);

// Boot the container...
$container = $kernel->createContainer();

// Execute programmatic/declarative application's pipelines.
$container->getByType(App::class)->serve();
