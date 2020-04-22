<?php

declare(strict_types=1);

/*
 * This code is under BSD 3-Clause "New" or "Revised" License.
 *
 * ------------------------------------------------------------------------
 * BiuradPHP Framework is a new sheme of php artitecture which is simple,  |
 * yet has powerful features. The framework has been built carefully 	   |
 * following the rules of the new PHP 7.2 and 7.3 above, with no support   |
 * for the old versions of PHP. As this framework was inspired by          |
 * several conference talks about the future of PHP and its development,   |
 * this framework has the easiest and best approach to the PHP world,      |
 * of course, using a few intentinally procedural programming module.      |
 * This makes BiuradPHP framework extremely reable and usuable for all.    |
 * BiuradPHP is a 35% clone of symfony framwork and 30% clone of Nette	   |
 * framework. The perfomance of BiuradPHP is 600ms on development mode and |
 * on production mode it's even better with great defense security.        |
 * ------------------------------------------------------------------------
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

use BiuradPHP\Http\Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Flight\Routing\Interfaces\RouteCollectorInterface;

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

    public function get(
        $uri,
        array $query = [],
        array $headers = [],
        array $cookies = []
    ): ResponseInterface {
        return $this->router->setRequest($this->request($uri, 'GET', $query, $headers, $cookies))
            ->dispatch();
    }

    public function getWithAttributes(
        $uri,
        array $attributes,
        array $headers = []
    ): ResponseInterface {
        $r = $this->request($uri, 'GET', [], $headers, []);
        foreach ($attributes as $k => $v) {
            $r = $r->withAttribute($k, $v);
        }

        return $this->router->setRequest($r)->dispatch();
    }


    public function post(
        $uri,
        array $data = [],
        array $headers = [],
        array $cookies = []
    ): ResponseInterface {
        return $this->router->setRequest(
            $this->request($uri, 'POST', [], $headers, $cookies)->withParsedBody($data)
        )->dispatch();
    }

    public function request(
        $uri,
        string $method,
        array $query = [],
        array $headers = [],
        array $cookies = []
    ): ServerRequestInterface {
        return (new Request(
            $method,
            $uri,
            $headers,
            'php://input',
            '1.1',
            array_merge($_SERVER, ['SERVER_PROTOCOL' => 'HTTP/1.1'])
        ))->withCookieParams($cookies)->withQueryParams($query);
    }

    public function fetchCookies(array $header)
    {
        $result = [];
        foreach ($header as $line) {
            $cookie = explode('=', $line);
            $result[$cookie[0]] = rawurldecode(substr($cookie[1], 0, strpos($cookie[1], ';')));
        }

        return $result;
    }
}
