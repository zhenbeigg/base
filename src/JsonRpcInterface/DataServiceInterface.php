<?php
/*
 * @author: 布尔
 * @name: 数据中心
 * @desc: 介绍
 * @LastEditTime: 2022-11-21 15:08:29
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

interface DataServiceInterface
{
    /**
     * @author: 布尔
     * @name: 详情
     * @param {array} $param [fid:1|上级区域id,第一季传0]
     * @param {string} $type 对应service类 
     * @return {array}
     */
    public function get_info(string $type, array $param, array $key = []): array;

    /**
     * @author: 布尔
     * @name: 全部
     * @param {array} $param [fid:1|上级区域id,第一季传0]
     * @param {string} $type 对应service类 
     * @return {array}
     */
    public function get_all(string $type, array $param, array $key = []): array;
}
