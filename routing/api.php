<?php

use BiuradPHP\Http\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Security\Core\Security;
use Flight\Routing\Interfaces\RouterProxyInterface;
use Symfony\Component\Security\Core\User\UserInterface;

 /**
 * Setup routes with a single request method:
 *
 * $this->get('/', App\MVC\Controllers\HomePageHandler::class)->setName('home');
 * $this->post('/album', AlbumCreateHandler::class)->setName('album.create');
 * $this->put('/album/{id}', [AlbumController::class, 'updateHandler'])->setName('album.put');
 * $this->patch('/album/{id}', 'AlbumController::class@updateHandler')->setName('album.patch');
 * $this->delete('/album/{id}', 'AlbumController::class:deleteHandler')->setName('album.delete');
 *
 * Or with multiple request methods:
 *
 * $this->map(['GET', 'POST', ...], '/contact', App\MVC\Controllers\ContactHandler::class)->setName('contact');
 *
 * Or handling all request methods:
 *
 * $this->any('/contact', App\MVC\Controllers\ContactHandler::class)->setName('contact');
 *
 * or using callback function:
 * Can pass all classes into function except interfaces not registered in container.
 *
 * $this->any('contact', function (ContainerInterface $container, ServerRequestInterface $request) {
 *      return $container->get(App\MVC\Controllers\ContactHandler::class)->handle($request);
 * });
 */

/*
 * API Routes
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded within a group which
 * is assigned the "api". Enjoy building your API!
 */

// Use can use Ruuting, declare routes using a $this;
assert($this instanceof RouterProxyInterface);

/**
 * Basic Api Demonstration
 *
 * This is to demonstrate getting api info from a response
 * Navigate to "api/" to see what happens.
 */
$this->get('/{number<[0-9-]+>?}/', function (ResponseInterface $response, ?int $number) {
    return [
        'data'      => 'Welcome to Api Implementation!',
        'message'   => $response->getReasonPhrase(),
        'response'  => $response->getStatusCode(),
        'page_id'   => $number ?? 'No page id specified?',
    ];
})->setName('home');

// An example to demonstrated a json_login response posted on api token.
// Login with a post request through "api/login" to see what happens.
$this->post('login', function (Security $security) {
    // On failure
    if (!$security->getUser() instanceof UserInterface) {
        return new JsonResponse([
            'status'    => 'FALIED',
            'username'  => 'annon.',
        ], 401);
    }

    // On success/
    return new JsonResponse([
        'status'    => 'PASSED',
        'username'  => $security->getToken()->getUsername() ?? $security->getUser()->getEmail()
    ]);
})->setName('login');

