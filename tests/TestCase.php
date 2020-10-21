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

namespace App\Tests;

use App\Kernel;
use BiuradPHP\DependencyInjection\Interfaces\FactoryInterface;
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

    protected function makeApp(): FactoryInterface
    {
        return Kernel::boot(\dirname(__DIR__))->createContainer();
    }

    /**
     * Boot the testing helper traits.
     */
    protected function setUpTraits(): array
    {
        $uses = \array_flip(class_uses_recursive(static::class));

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
}
