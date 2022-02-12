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

namespace App\Tests\Traits;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Tester\CommandTester;

trait InteractsWithConsole
{
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
     * @param string $command   The command class
     * @param array  $arguments All the arguments passed when executing the command
     * @param array  $options   An array of execution options
     */
    public function runCommand(string $command, array $arguments = [], array $options = []): CommandTester
    {
        if (!\class_exists($command) || !\is_subclass_of($command, Command::class)) {
            throw new CommandNotFoundException(\sprintf('It looks like your command %s isn\'t valid', $command));
        }

        // this uses container that allows you to fetch services.
        $command = $this->makeApp()->get($command);
        $command->setApplication($this->getConsole());

        $commandTester = new CommandTester($command);
        $commandTester->execute($arguments, $options);

        return $commandTester;
    }

    public function runCommandObject(Command $command, array $arguments = [], array $options = []): CommandTester
    {
        $command->setApplication($this->getConsole());
        $commandTester = new CommandTester($command);
        $commandTester->execute($arguments, $options);

        return $commandTester;
    }

    public function runCommandDebug(string $command, array $arguments = []): CommandTester
    {
        return $this->runCommand(
            $command,
            $arguments,
            ['verbosity' => OutputInterface::VERBOSITY_DEBUG]
        );
    }

    public function runCommandVeryVerbose(string $command, array $arguments = []): CommandTester
    {
        return $this->runCommand(
            $command,
            $arguments,
            ['verbosity' => OutputInterface::VERBOSITY_VERY_VERBOSE]
        );
    }

    public function runCommandError(CommandTester $commandTester, bool $normalize = false): string
    {
        return $commandTester->getErrorOutput($normalize);
    }

    /**
     * This helper method abstracts the boilerplate code needed to test the
     * execution of a command and return it's class object.
     */
    public function getCommand(Command|string $command, array $arguments = [], array $options = []): Command
    {
        $command = \is_object($command) ? $command : $this->makeApp()->get($command);
        $command->setApplication($this->getConsole());

        $commandTester = new CommandTester($command);
        $commandTester->execute($arguments, $options);

        return $command;
    }

    public function getCommandStatusCode(string $command, array $arguments = [], array $options = []): int
    {
        $commandTester = $this->runCommand($command, $arguments, $options);

        return $commandTester->getStatusCode();
    }

    /**
     * Setup up the Router instance.
     */
    protected function getConsole(): Application
    {
        return $this->makeApp()->get(Application::class);
    }
}
