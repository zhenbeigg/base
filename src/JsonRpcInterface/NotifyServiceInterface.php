<?php
/*
 * @author: 布尔
 * @name: 通知jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2022-11-22 19:34:38
 * @FilePath: \eyc3_canyin\app\Core\JsonRpcInterface\NotifyServiceInterface.php
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

interface NotifyServiceInterface
{
    /**
     * @author: 布尔
     * @name: 添加
     * @param {array} $param
     * @param {string} $type 对应service类
     * @return {array}
     */
    public function post_add(string $type, array $param, array $val = []);
}
