<?php
/*
 * @author: 布尔
 * @name: 连接器中间件
 * @desc: 介绍
 * @LastEditTime: 2023-03-23 16:56:46
 */

declare(strict_types=1);

namespace Eykj\Base\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Eykj\Base\JsonRpcInterface\OapiInterface;

class ConnectorMiddleware implements MiddlewareInterface
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
     * @var OapiInterface
     */
    protected $OapiInterface;

    public function __construct(ContainerInterface $container, OapiInterface $OapiInterface, RequestInterface $request)
    {
        $this->container = $container;
        $this->request = $request;
        $this->OapiInterface = $OapiInterface;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /* 验证账号 */
        $apikey = $this->request->getHeader('apikey')[0];
        if (!$apikey) {
            error(523);
        }
        /* 查询账号 */
        $apikey_info = $this->OapiInterface->get_apikey_info(['apikey' => $apikey, 'corp_product' => 'visitor']);
        /* 删除变量回收内存 */
        unset($apikey);
        if (!$apikey_info) {
            error(523);
        }
        set('corpid', $apikey_info['corpid']);
        set('corp_product', $apikey_info['corp_product']);
         /* 删除变量回收内存 */
        unset($apikey_info);
        return $handler->handle($request);
    }
}
