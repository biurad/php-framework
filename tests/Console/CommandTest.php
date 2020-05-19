<?php

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
        $command = $this->runCommandObject(new AboutCommand);
        $this->assertIsInt($command->getStatusCode());
        $this->assertEquals(1, $command->getStatusCode());
    }
}
