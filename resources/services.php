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

namespace Rade\DI\Loader;

return static function (\Rade\DI\DefinitionBuilder $builder): void {
    // Write service definitions here ...
    $c = $builder->getContainer();

    // This should be the last definition
    if ($c->isDebug() && \class_exists(\Tracy\Debugger::class)) {
        $c->set('tracy.bar', service('Tracy\Debugger::getBar'))
           ->bind('addPanel', wrap(\Rade\Debug\Tracy\ContainerPanel::class, [1 => \array_keys($c->definitions())]))
           ->bind('addPanel', wrap(\Rade\Debug\Tracy\RoutesPanel::class))
           //->bind('addPanel', wrap(\Rade\Debug\Tracy\TemplatesPanel::class))
        ;
    }
};
