<?php
/*
 * @author: 布尔
 * @name: 云一发布jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2022-09-07 19:45:02
 * @FilePath: \eyc3_user\app\Core\JsonRpcInterface\PublishServiceInterface.php
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;


interface PublishServiceInterface
{
    /**
     * @author: 布尔
     * @name: 初始化
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型,userid:1|管理员userid]
     */
    public function post_init(array $param);
}
