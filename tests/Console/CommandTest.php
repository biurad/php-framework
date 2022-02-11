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

namespace App\Tests\Console;

use App\Tests\TestCase;
use App\Tests\Traits\InteractsWithConsole;
use Rade\Commands\AboutCommand;

class CommandTest extends TestCase
{
    use InteractsWithConsole;

    public function testCommandActionWorks(): void
    {
        $status = $this->getCommandStatusCode(AboutCommand::class);
        $this->assertIsInt($status);
        $this->assertEquals(0, $status);

        $command = $this->getCommand(AboutCommand::class);
        $this->assertEquals('about', $command->getName());
    }
}
