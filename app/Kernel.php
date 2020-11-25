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

namespace App;

use Biurad\Framework\Directory;
use Biurad\Framework\Kernel as AppKernel;

class Kernel extends AppKernel
{
    /**
     * {@inheritdoc}
     */
    public static function boot(Directory $directories, bool $handleErrors = true, bool $return = false)
    {
        return self::initializeApp($directories, $handleErrors, $return);
    }

    /**
     * {@inheritdoc}
     */
    protected static function initializeEnv(string $envFile): void
    {
        //
    }
}
