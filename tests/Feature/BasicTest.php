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

namespace App\Tests\Feature;

use App\Tests\TestCase;
use Flight\Routing\Exceptions\RouteNotFoundException;
use Flight\Routing\RouteResults;

class BasicTest extends TestCase
{
    /**
     * PHPUnit's data providers allow to execute the same tests repeated times
     * using a different set of data each time.
     *
     * @dataProvider getPublicUrls
     *
     * @return void
     */
    public function testRoutingActionWorks(string $uri, string $body): void
    {
        $this->router->get($uri, function () use ($body): string {
            return (string) $body;
        });

        $matched    = $this->matchRoute(ltrim($uri, '/'));
        $response   = $this->runRoute(ltrim($uri, '/'));

        $this->assertNull($matched->getRedirectLink());
        $this->assertTrue(RouteResults::FOUND === $matched->getRouteStatus());

        $this->assertIsString((string) $response->getBody());
        $this->assertEquals('text/plain; charset=utf-8', $response->getHeaderLine('Content-Type'));
        $this->assertEquals(200, $response->getStatusCode(), sprintf('The %s public URL loads correctly.', $uri));
    }

    public function testRouteNotFoundError(): void
    {
        $this->expectException(RouteNotFoundException::class);
        $this->expectErrorMessage('Unable to find the controller for path "not-found". The route is wrongly configured.');
        $this->runRoute('not-found');

        $this->assertNull($this->router->currentRoute());
    }

    public function getPublicUrls()
    {
        yield ['/site/hello', 'Welcome To BiuradPHP Framework'];
        yield ['/site/blog/', 'Welcome To A Blog HomePage'];
        yield ['site/login', 'Welcome To Login Page'];
    }
}
