<?php
/*
 * @author: 布尔
 * @name: 中间件-全局中间件
 * @desc: 介绍
 * @LastEditTime: 2023-08-04 18:27:15
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

class BaseMiddleware implements MiddlewareInterface
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
        $response = $handler->handle($request);
        $result = $response->getBody()->getContents();
        /* 判断是不是模板输出 */
        if (strstr($result, 'html')) {
            /* 删除变量回收内存 */
            unset($result);
            return $response;
        }
        /* 删除变量回收内存 */
        unset($response);
        $r = json_decode($result, true);
        /* 判断是不是下载文件 */
        if (isset($r['download']) && isset($r['file_path'])) {
            /* 删除变量回收内存 */
            unset($result);
            return $this->response->download($r['file_path']);
        }
        /* 判断是不是原样输出 */
        if (isset($r['output'])) {
            if (is_string($r['result'])) {
                return $this->response->raw($r['result']);
            } else {
                return $this->response->json($r['result']);
            }
        }
        if (!is_array($r)) {
            /* 删除变量回收内存 */
            unset($r);
            return $this->response->json(['errcode' => 0, 'result' => $result, 'errmsg' => 'ok']);
        }
        /* 删除变量回收内存 */
        unset($result);
        if (!isset($r['errcode']) || !isset($r['errmsg'])) {
            return $this->response->json(['errcode' => 0, 'result' => $r, 'errmsg' => 'ok']);
        }
        return $this->response->json($r);
    }
}
