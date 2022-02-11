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

namespace App\Tests;

use App\Kernel;
use Biurad\DependencyInjection\Container;
use Biurad\Framework\Directory;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use Traits\InteractsWithConsole;
    use Traits\InteractsWithHttp;

    /** @var FactoryInterface */
    protected $app;

    protected static $booted = false;

    protected function setUp(): void
    {
        $this->app    = $this->makeApp();
        self::$booted = true;

        $this->setUpTraits();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->app    = null;
        self::$booted = false;
    }

    protected function makeApp(): Container
    {
        // Directories needed to boot the application
        $directories = new Directory([
            'root'       => \dirname(__DIR__),
            'configDir'  => 'config',
            'tempDir'    => 'var',
        ]);

        return Kernel::boot($directories, true); // Boot Application ...
    }

    /**
     * Boot the testing helper traits.
     */
    protected function setUpTraits(): array
    {
        $results = [];
        $class   = static::class;

        foreach (\array_reverse(\class_parents($class)) + [$class => $class] as $class) {
            $results += $this->addTrait($class);
        }

        $uses = \array_flip(\array_unique($results));

        if (isset($uses[Traits\InteractsWithHttp::class])) {
            $this->setUpRouter();
        }

        if (isset($uses[Traits\InteractsWithConsole::class])) {
            $this->setUpConsole();
        }

        if (isset($uses[Traits\InteractsWithFaker::class])) {
            $this->setUpFaker();
        }

        return $uses;
    }

    /**
     * Returns all traits used by a trait and its traits.
     *
     * @param string $trait
     *
     * @return array<string,string>
     */
    private function addTrait(string $trait): array
    {
        $traits = \class_uses($trait);

        foreach ($traits as $trait) {
            $traits += $this->addTrait($trait);
        }

        return $traits;
    }
}
