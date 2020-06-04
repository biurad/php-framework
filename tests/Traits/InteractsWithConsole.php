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

namespace App\Tests\Traits;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Tester\CommandTester;

trait InteractsWithConsole
{
    /** @var Application */
    protected $console;

    /**
     * Setup up the Router instance.
     *
     * @return void
     */
    protected function setUpConsole(): void
    {
        $this->console = $this->app->get(Application::class);
    }

    /**
     * This helper method abstracts the boilerplate code needed to test the
     * execution of a command.
     *
     * Available execution options:
     *  - interactive: Sets the input interactive flag
     *  - decorated: Sets the output decorated flag
     *  - verbosity: Sets the output verbosity flag
     *  - capture_stderr_separately: Make output of stdOut and stdErr separately available
     *
     * @param string $command The cammand class
     * @param array $arguments All the arguments passed when executing the command
     * @param array $options An array of execution options
     *
     * @return CommandTester
     */
    public function runCommand(string $command, array $arguments = [], array $options = []): CommandTester
    {
        if (!class_exists($command) || !is_subclass_of($command, Command::class)) {
            throw new CommandNotFoundException(sprintf('It looks like your command %s isn\'t valid', $command));
        }

        // this uses container that allows you to fetch services.
        $command = $this->app->get($command);
        $command->setApplication($this->console);

        $commandTester = new CommandTester($command);
        $commandTester->execute($arguments, $options);

        return $commandTester;
    }

    public function runCommandObject(Command $command, array $arguments = [], array $options = []): CommandTester
    {
        $command->setApplication($this->console);
        $commandTester = new CommandTester($command);
        $commandTester->execute($arguments, $options);

        return $commandTester;
    }

    public function runCommandDebug(string $command, array $arguments = []): CommandTester
    {
        $commandTester =  $this->runCommand(
            $command,
            $arguments,
            ['verbosity' => OutputInterface::VERBOSITY_DEBUG]
        );

        return $commandTester;
    }

    public function runCommandVeryVerbose(string $command, array $arguments = []): CommandTester
    {
        $commandTester = $this->runCommand(
            $command,
            $arguments,
            ['verbosity' => OutputInterface::VERBOSITY_VERY_VERBOSE]
        );

        return $commandTester;
    }

    public function runCommandError(string $command, array $arguments = [], array $options = [], bool $normalize = false): string
    {
        $commandTester = $this->runCommand($command, $arguments, $options);

        return $commandTester->getErrorOutput($normalize);
    }

    /**
     * This helper method abstracts the boilerplate code needed to test the
     * execution of a command and return it's class object.
     *
     * @param string|Command $command
     * @param array $arguments
     * @param array $options
     * 
     * @return Command
     */
    public function getCommand($command, array $arguments = [], array $options = []): Command
    {
        $command = is_object($command) ? $command : $this->app->get($command);
        $command->setApplication($this->console);

        $commandTester = new CommandTester($command);
        $commandTester->execute($arguments, $options);

        return $command;
    }

    public function getCommandStatusCode(string $command, array $arguments = [], array $options = []): int
    {
        $commandTester = $this->runCommand($command, $arguments, $options);

        return $commandTester->getStatusCode();
    }
}
