<?php

use Flight\Routing\Interfaces\RouterProxyInterface;

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
 * Just to avoid conflict in locating Authetication routes, We will define
 * Thes routes here. Route your user logins, signup and other authentication
 * On this file.
 */

// Use can use Ruuting, declare routes using a $this;
assert($this instanceof RouterProxyInterface);
