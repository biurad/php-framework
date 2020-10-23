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

namespace App\Tests\Feature;

use App\Tests\TestCase;
use Flight\Routing\Exceptions\RouteNotFoundException;
use Flight\Routing\Route;
use Generator;
use Psr\Http\Server\RequestHandlerInterface;

class BasicTest extends TestCase
{
    /**
     * PHPUnit's data providers allow to execute the same tests repeated times
     * using a different set of data each time.
     *
     * @dataProvider getPublicUrls
     */
    public function testRoutingActionWorks(string $uri, string $body): void
    {
        $this->router->addRoute(
            new Route('test', ['GET', 'HEAD'], $uri, function () use ($body) {
                return $body;
            })
        );

        $matched  = $this->matchRoute(\ltrim($uri, '/'));
        $response = $this->runRoute(\ltrim($uri, '/'));

        $this->assertInstanceOf(RequestHandlerInterface::class, $matched);

        $this->assertIsString((string) $response->getBody());
        $this->assertEquals('text/plain; charset=utf-8', $response->getHeaderLine('Content-Type'));
        $this->assertEquals(
            200,
            $response->getStatusCode(),
            \sprintf('The %s public URL loads correctly.', $uri)
        );
    }

    public function testRouteNotFoundError(): void
    {
        $this->expectException(RouteNotFoundException::class);
        $this->expectErrorMessage(
            'Unable to find the controller for path "not-found". The route is wrongly configured.'
        );

        $this->runRoute('not-found');
    }

    public function getPublicUrls(): ?Generator
    {
        yield ['/site/hello', 'I ♥ Biurad PHP Framework'];

        yield ['/site/blog/', 'Welcome To A Blog HomePage'];

        yield ['site/login', 'Welcome To Login Page'];
    }
}
