<?php
/*
 * @author: 布尔
 * @name: 类名
 * @desc: 介绍
 * @LastEditTime: 2023-07-27 20:26:48
 */

declare(strict_types=1);

namespace Eykj\Base\Middleware;

use Hyperf\Context\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CorsMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = Context::get(ResponseInterface::class);
        $origin = $request->getHeader('Origin');
        if (!$origin) {
            $origin = $request->getHeader('Access-Control-Allow-Origin');
        }
        $response = $response->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            // Headers 可以根据实际情况进行改写。
            ->withHeader('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, Authorization,content-type,accept,Access-Control-Allow-Origin,responseType,satoken');

        Context::set(ResponseInterface::class, $response);

        if ($request->getMethod() == 'OPTIONS') {

            return $response;
        }

        return $handler->handle($request);
    }
}
