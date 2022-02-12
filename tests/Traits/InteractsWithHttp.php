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

use Biurad\Http\ServerRequest;
use Flight\Routing\Route;
use Flight\Routing\Router;
use Psr\Http\Message\UriInterface;

trait InteractsWithHttp
{
    /**
     * This helper method abstracts the boilerplate code needed to test the
     * execution of a matched route.
     */
    public function matchRoute(
        string|UriInterface $uri,
        string $method = 'GET',
        array $attributes = [],
        array $query = [],
        array $headers = [],
        array $cookies = []
    ): Route {
        $request = $this->request($uri, $method, $query, $headers, $cookies);

        foreach ($attributes as $key => $value) {
            $request = $request->withAttribute($key, $value);
        }

        return $this->makeApp()->get(Router::class)->matchRequest($request);
    }

    /**
     * This helper method abstracts the boilerplate code needed to test the
     * execution of a server request.
     */
    public function request(
        string|UriInterface $uri,
        string $method = 'GET',
        array $query = [],
        array $headers = [],
        array $cookies = []
    ): ServerRequest {
        $servers = $_SERVER + ['SERVER_PROTOCOL' => 'HTTP/1.1'];

        return (new ServerRequest($method, $uri, $headers, 'php://input', '1.1', $servers))->withCookieParams($cookies)->withQueryParams($query);
    }
}
