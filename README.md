# BiuradPHP is a high performance framework with expressive, elegant syntax, and great security.

BiuradPHP is designed to provide modern and rapid development of websites, web applications and web services. Focusing on `Separation of Concerns`, not a strict complaint framework rule (eg: MVC). With BiuradPHP you enjoy maximum customization, and overall flexibility with no limitations. BiuradPHP is fast, light, secure and flexible.

**`Please note that this documentation is currently work-in-progress. Feel free to contribute.`**

## Features

-   [PSR-4 Autoloader](https://github.com/composer/composer).
-   [High Performance Http Router](https://github.com/divineniiquaye/flight-routing).
-   [Nette Dependency Injection Container](https://github.com/biurad/nette-di-bridge).
-   [Multi Level Caching with Doctrine Cache](https://github.com/biurad/biurad-caching).
-   [Symfony Cloned Session](https://github.com/biurad/biurad-sessions).
-   [Symfony Cloned Security](https://github.com/biurad/biurad-security).
-   [Symfony Cloned Scaffolding](https://github.com/biurad/biurad).
-   [Spiral Cloned Database](https://github.com/biurad/biurad-database).
-   [Cycle ORM for Spiral Cloned Database]('https://github.com/biurad/cycle-orm-bridge').
-   Managed servers:
    -   fpm/fastcgi with Apache or nginX.
    -   [Workerman](https://github.com/biurad/biurad-workerman) - (coming soon).
    -   [Swoole](https://github.com/biurad/biurad-swoole) - (coming soon).
    -   [Roadrunner](https://github.com/biurad/biurad-roadrunner) - (coming soon).
-   And MORE ...

## Installation

The recommended way to install BiuradPHP Framework is via Composer:

```bash
composer create-project biurad/php-framework my_project
```

It requires PHP version 7.2 and supports PHP up to 8. The dev-master version requires PHP 7.2.

## Need Some Help?

BiuradPHP is a recent project and does not yet have a large community.
In the meantime, you can consult:

-   [Quick-Start Guide](https://docs.biurad.com/biuradphp/framework) to discover the framework.
-   [Documentation](https://docs.biurad.com/biuradphp/getting-started) to go deeper.
-   [Examples Documentation](https://docs.birad.com/examples) for demo and examples.

## Changelog

The [CHANGELOG](CHANGELOG.md) file is avaliable for more information on what has changed recently.

## Testing

To run the tests you'll have to start the included node based server first if any in a separate terminal window.

With the server running, you can start testing.

```bash
composer test
```

## Want to be listed on our projects website

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a message on our website, mentioning which of our package(s) you are using.

Post Here: [Project Patreons - https://patreons.biurad.com](https://patreons.biurad.com)

We publish all received request's on our website.

## License

The BSD-3-Clause . Please see [License File](LICENSE.md) for more information.
