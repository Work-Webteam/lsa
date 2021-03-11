<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;

use OneLogin_Saml2_Utils;


class SamlMiddleware implements MiddlewareInterface
{
    public function process (ServerRequestInterface $request, RequestHandlerInterface $handler) :
    ResponseInterface {
        $response = $handler->handle($request);


        \OneLogin_Saml2_Utils::login();

    }
}
