<?php
/*
 * @author: 布尔
 * @name: 中间件-验证token
 * @desc: 介绍
 * @LastEditTime: 2022-08-16 22:07:44
 */

declare(strict_types=1);

namespace Eykj\Base\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;

class TokenMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var HttpResponse
     */
    protected $response;

    public function __construct(ContainerInterface $container, HttpResponse $response, RequestInterface $request)
    {
        $this->container = $container;
        $this->response = $response;
        $this->request = $request;
    }


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // 根据具体业务判断逻辑走向，这里假设用户携带的token有效        
        $jwt = $this->request->getHeader('AUTHORIZATION');
        if (!$jwt || $jwt[0] == 'undefined') {
            error(504);
        } else {
            $token =  json_decode(json_encode(jwt_decode((string)$jwt[0])), true);
        }
        /* 删除变量回收内存 */
        unset($jwt);
        if (!$token || !$token['corpid']) {
            error(504);
        }
        set('token', $token);
        if (isset($token['corpid'])) {
            set('corpid', $token['corpid']);
        }
        /* 存储管理员状态到全局 */
        if (isset($token['admin'])) {
            set('admin', $token['admin']);
        } else {
            set('admin', 0);
        }
        /* 删除变量回收内存 */
        unset($token);
        return $handler->handle($request);
    }
}
