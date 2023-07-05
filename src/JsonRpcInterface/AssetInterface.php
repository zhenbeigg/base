<?php
/*
 * @author: 布尔
 * @name: 云一工作jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2022-09-14 08:50:18
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Eykj\Base\JsonRpcInterface\WorkServiceInterface;

class AssetInterface
{
    private ?WorkServiceInterface $Service;

    // 通过设置参数为 nullable，表明该参数为一个可选参数
    public function __construct(?WorkServiceInterface $Service)
    {
        $this->Service = $Service;
    }
    /**
     * @author: 布尔
     * @name: 初始化
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型,userid:1|管理员userid]
     */
    public function post_init(array $param)
    {
        try {
            return $this->Service->post_init($param);
        } catch (\Throwable $th) {
            alog($th->getMessage(), 2);
        }
    }
}
