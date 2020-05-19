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

namespace App\Tests\Traits;

use BiuradPHP\Http\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Flight\Routing\Interfaces\RouteCollectorInterface;
use Flight\Routing\RouteResults;
use Psr\Http\Message\UriInterface;

trait InteractsWithHttp
{
    /** @var \BiuradPHP\Routing\RouteCollection */
    protected $router;

    /**
     * Setup up the Router instance.
     *
     * @return void
     */
    protected function setUpRouter()
    {
        $this->router = $this->app->get(RouteCollectorInterface::class);
    }

    /**
     * This helper method abstracts the boilerplate code needed to test the
     * execution of a matched route.
     *
     * @param string|UriInterface $uri
     * @param string $method
     * @param array $query
     * @param array $headers
     * @param array $cookies
     *
     * @return RouteResults
     */
    public function matchRoute($uri, string $method = 'GET', array $query = [], array $headers = [], array $cookies = []): RouteResults
    {
        $request = $this->request($uri, $method, $query, $headers, $cookies);

        return $this->router->getRouter()->match($request);
    }

    /**
     * This helper method abstracts the boilerplate code needed to test the
     * execution of a matched route and return it's response.
     *
     * @param string|UriInterface $uri
     * @param string $method
     * @param array $query
     * @param array $headers
     * @param array $cookies
     *
     * @return ResponseInterface
     */
    public function runRoute($uri, string $method = 'GET', array $query = [], array $headers = [], array $cookies = []): ResponseInterface
    {
        $request = $this->request($uri, $method, $query, $headers, $cookies);

        return $this->router->setRequest($request)->dispatch();
    }

    public function runRouteWithAttributes($uri, array $attributes, array $query = [], array $headers = []): ResponseInterface
    {
        $request = $this->request($uri, 'GET', $query, $headers, []);
        foreach ($attributes as $key => $value) {
            $request = $request->withAttribute($key, $value);
        }

        return $this->router->setRequest($request)->dispatch();
    }

    /**
     * This helper method abstracts the boilerplate code needed to test the
     * execution of a server request.
     *
     * @param string|UriInterface $uri
     * @param string $method
     * @param array $query
     * @param array $headers
     * @param array $cookies
     *
     * @return ServerRequestInterface
     */
    public function request($uri, string $method, array $query = [], array $headers = [], array $cookies = []): ServerRequestInterface
    {
        $servers = array_merge($_SERVER, ['SERVER_PROTOCOL' => 'HTTP/1.1']);

        return (new ServerRequest($method, $uri, $headers, 'php://input', '1.1', $servers))
            ->withCookieParams($cookies)->withQueryParams($query);
    }

    protected function fetchCookies(array $header)
    {
        $result = [];
        foreach ($header as $line) {
            $cookie = explode('=', $line);
            $result[$cookie[0]] = rawurldecode(substr($cookie[1], 0, strpos($cookie[1], ';')));
        }

        return $result;
    }
}
