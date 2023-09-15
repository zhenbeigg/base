<?php

/*
 * @author: 布尔
 * @name: 数据中心
 * @desc: 介绍
 * @LastEditTime: 2022-11-21 15:00:44
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Eykj\Base\JsonRpcInterface\DataServiceInterface;

class DataInterface
{
    private ?DataServiceInterface $Service;

    // 通过设置参数为 nullable，表明该参数为一个可选参数
    public function __construct(?DataServiceInterface $Service)
    {
        $this->Service = $Service;
    }
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
    /**
     * @author: 布尔
     * @name: 全部
     * @param {array} $param
     * @param {string} $type 对应service类
     * @return {array}
     */
    public function get_all(string $type, array $param, array $key = []): array
    {
        return $this->Service->get_all($type, $param, $key);
    }
}
