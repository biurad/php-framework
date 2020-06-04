<?php
/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types=1);

/*
 * This code is under BSD 3-Clause "New" or "Revised" License.
 *
 * ---------------------------------------------------------------------------
 * BiuradPHP Framework is a new scheme of php architecture which is simple,  |
 * yet has powerful features. The framework has been built carefully 	     |
 * following the rules of the new PHP 7.2 and 7.3 above, with no support     |
 * for the old versions of PHP. As this framework was inspired by            |
 * several conference talks about the future of PHP and its development,     |
 * this framework has the easiest and best approach to the PHP world,        |
 * of course, using a few intentionally procedural programming module.       |
 * This makes BiuradPHP framework extremely readable and usable for all.     |
 * BiuradPHP is a 35% clone of symfony framework and 30% clone of Nette	     |
 * framework. The performance of BiuradPHP is 300ms on development mode and  |
 * on production mode it's even better with great defense security.          |
 * ---------------------------------------------------------------------------
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

namespace App\Tests;

use App\Kernel;
use PHPUnit\Framework\TestCase as BaseTestCase;
use BiuradPHP\DependencyInjection\Interfaces\FactoryInterface;

use function BiuradPHP\Support\class_uses_recursive;

abstract class TestCase extends BaseTestCase
{
    use Traits\InteractsWithConsole;
    use Traits\InteractsWithHttp;

    /** @var FactoryInterface */
    protected $app;

    protected static $booted = false;

    protected function setUp(): void
    {
        $this->app = $this->makeApp();
        self::$booted = true;

        $this->setUpTraits();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->app = null;
        self::$booted = false;
    }

    protected function makeApp(): FactoryInterface
    {
        return Kernel::boot(dirname(__DIR__))->createContainer();
    }

    /**
     * Boot the testing helper traits.
     *
     * @return array
     */
    protected function setUpTraits(): array
    {
        $uses = array_flip(class_uses_recursive(static::class));

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
