<?php

/*
 * @author: 布尔
 * @name: 通知jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2022-11-22 18:42:23
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Hyperf\Di\Annotation\Inject;
use Eykj\Base\JsonRpcInterface\NotifyServiceInterface;

class NotifyInterface
{

    #[Inject]
    protected NotifyServiceInterface $Service;

    /**
     * @author: 布尔
     * @name: 添加
     * @param {array} $param
     * @param {string} $type 对应service类
     * @return {array}
     */
    public function post_add(string $type, array $param, array $val = [])
    {
        try {
            return $this->Service->post_add($type, $param, $val);
        } catch (\Throwable $th) {
            alog($th->getMessage(), 2);
        }
    }
}
