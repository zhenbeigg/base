<?php
/*
 * @author: 布尔
 * @name: 中间件-验证token
 * @desc: 介绍
 * @LastEditTime: 2025-01-22 12:00:49
 * @FilePath: \eyc3_oapi\vendor\eykj\base\src\Middleware\OTokenMiddleware.php
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

class OTokenMiddleware implements MiddlewareInterface
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
        $jwt = $this->request->input('token');
        $token = redis()->get("token_" . $jwt);
        if ($token) {
            $token = json_decode($token, true);
            set('token', $token);
            set('corpid', $token['corpid']);
            /* 获取企业ID的访问次数 */
            $redis_key = 'visit_limit:' . $token['corpid'];
            $count = redis()->get($redis_key);
            if ($count === false) {
                /* 如果是第一次访问,设置初始值为1,过期时间1秒 */
                redis()->setex($redis_key, 1, 1);
            } else {
                /* 判断访问次数是否超过限制 */
                if ((int)$count >= 20) {
                    error(16005);
                }
                /* 增加访问次数 */
                redis()->incr($redis_key);
            }
            return $handler->handle($request);
        } else {
            error(504);
        }
    }
}
