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

namespace App\Tests\Traits;

use Biurad\Framework\Router;
use Biurad\Http\ServerRequest;
use Biurad\Http\Traits\ServerRequestDecoratorTrait;
use Flight\Routing\RouteHandler;
use Flight\Routing\RoutePipeline;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

trait InteractsWithHttp
{
    /** @var Router */
    protected $router;

    /** @var RoutePipeline */
    protected $pipeline;

    /**
     * This helper method abstracts the boilerplate code needed to test the
     * execution of a matched route.
     *
     * @param string|UriInterface $uri
     */
    public function matchRoute(
        $uri,
        string $method = 'GET',
        array $query = [],
        array $headers = [],
        array $cookies = []
    ): RouteHandler {
        $request = $this->request($uri, $method, $query, $headers, $cookies);

        return $this->router->match($request);
    }

    /**
     * This helper method abstracts the boilerplate code needed to test the
     * execution of a matched route and return it's response.
     *
     * @param string|UriInterface $uri
     */
    public function runRoute(
        $uri,
        string $method = 'GET',
        array $query = [],
        array $headers = [],
        array $cookies = []
    ): ResponseInterface {
        return $this->pipeline->process($this->request($uri, $method, $query, $headers, $cookies), $this->router);
    }

    public function runRouteWithAttributes(
        $uri,
        array $attributes,
        array $query = [],
        array $headers = []
    ): ResponseInterface {
        $request = $this->request($uri, 'GET', $query, $headers, []);

        foreach ($attributes as $key => $value) {
            $request = $request->withAttribute($key, $value);
        }

        return $this->pipeline->process($request, $this->router);
    }

    /**
     * This helper method abstracts the boilerplate code needed to test the
     * execution of a server request.
     *
     * @param string|UriInterface $uri
     *
     * @return ServerRequestDecoratorTrait|ServerRequestInterface
     */
    public function request($uri, string $method, array $query = [], array $headers = [], array $cookies = [])
    {
        $servers = \array_merge($_SERVER, ['SERVER_PROTOCOL' => 'HTTP/1.1']);

        return (new ServerRequest($method, $uri, $headers, 'php://input', '1.1', $servers))
            ->withCookieParams($cookies)->withQueryParams($query);
    }

    /**
     * Setup up the Router instance.
     */
    protected function setUpRouter(): void
    {
        $this->router = $this->app->get(Router::class);
        $this->pipeline = $this->app->get(RoutePipeline::class);
    }

    protected function fetchCookies(array $header): array
    {
        $result = [];

        foreach ($header as $line) {
            $cookie             = \explode('=', $line);
            $result[$cookie[0]] = \rawurldecode(\substr($cookie[1], 0, \strpos($cookie[1], ';')));
        }

        return $result;
    }
}
