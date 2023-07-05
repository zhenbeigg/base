<?php

/*
 * @author: 布尔
 * @name: 数据中心
 * @desc: 介绍
 * @LastEditTime: 2022-11-21 15:00:44
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Hyperf\Di\Annotation\Inject;
use Eykj\Base\JsonRpcInterface\DataServiceInterface;

class DataInterface
{

    #[Inject]
    protected DataServiceInterface $Service;
    /**
     * @author: 布尔
     * @name: 详情
     * @param {array} $param
     * @param {string} $type 对应service类
     * @return {array}
     */
    public function get_info(string $type, array $param, array $key = []): array
    {
        return $this->Service->get_info($type, $param, $key);
    }
}
