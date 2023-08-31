<?php
/*
 * @author: 布尔
 * @name: 中间件-验证token
 * @desc: 介绍
 * @LastEditTime: 2023-08-31 16:50:29
 * @FilePath: \base\src\Middleware\OTokenMiddleware.php
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
        $token = redis()->get("token_".$jwt);
        if($token){
            $token=json_decode($token,true);
            set('token',$token);
            set('corpid',$token['corpid']);
            return $handler->handle($request);
        }else{
            error(504);
        }
        
    }
}