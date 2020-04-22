<?php

declare(strict_types=1);

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
 * on production mode it's even better with great defense security.        |
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

namespace App\Tests\Traits;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Tester\CommandTester;

trait InteractsWithConsole
{
    /** @var \Symfony\Component\Console\Application */
    protected $console;

    /**
     * Setup up the Router instance.
     *
     * @return void
     */
    protected function setUpConsole()
    {
        $this->console = $this->app->get(Application::class);
    }

    public function runCommand(string $command, array $args = [], array $options = []): string
    {
        $commandTester = new CommandTester($this->app->get($command));
        $commandTester->execute($args, $options);

        return $commandTester->getDisplay();
    }

    public function runCommandDebug(string $command, array $args = []): string
    {
        return $this->runCommand($command, $args, ['verbosity' => OutputInterface::VERBOSITY_VERBOSE]);
    }

    public function runCommandVeryVerbose(string $command, array $args = []): string
    {
        return $this->runCommand($command, $args, ['verbosity' => OutputInterface::VERBOSITY_DEBUG]);
    }

    public function getCommandStatusCode(string $command, array $args = [], array $options = []): int
    {
        $commandTester = new CommandTester($this->app->get($command));
        $commandTester->execute($args, $options);

        return $commandTester->getStatusCode();
    }
}
