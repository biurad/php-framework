<?php

declare(strict_types=1);

/*
 * This file is part of BiuradPHP opensource projects.
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

namespace App\Tests\Console;

use App\Tests\TestCase;
use BiuradPHP\Terminal\Commands\AboutCommand;

class CommandTest extends TestCase
{
    public function testCommandActionWorks(): void
    {
        $status = $this->getCommandStatusCode(AboutCommand::class);
        $this->assertIsInt($status);
        $this->assertEquals(0, $status);

        $command = $this->getCommand(AboutCommand::class);
        $this->assertEquals('about', $command->getName());
    }

    public function testCommandErrorStatus(): void
    {
        $command = $this->runCommandObject(new AboutCommand());
        $this->assertIsInt($command->getStatusCode());
        $this->assertEquals(1, $command->getStatusCode());
    }
}
