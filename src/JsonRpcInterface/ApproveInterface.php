<?php

/*
 * @author: 布尔
 * @name: 审批中心
 * @desc: 介绍
 * @LastEditTime: 2022-11-02 15:20:23
 * @FilePath: \eyc3_canyin\app\Core\JsonRpcInterface\ApproveInterface.php
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Hyperf\Di\Annotation\Inject;
use Eykj\Base\JsonRpcInterface\ApproveServiceInterface;

class ApproveInterface
{

    #[Inject]
    protected ApproveServiceInterface $Service;
    /**
     * @author: 布尔
     * @name: 添加
     * @param {array} $param
     * @param {string} $type 对应service类
     * @return {array}
     */
    public function post_add(string $type, array $param, array $val = [])
    {
        return $this->Service->post_add($type, $param, $val);
    }
    /**
     * @author: 布尔
     * @name: 修改
     * @param {array} $param
     * @param {string} $type 对应service类
     * @return {array}
     */
    public function post_modify(string $type, array $param, array $val = []): int
    {
        return $this->Service->post_modify($type, $param, $val);
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
        try {
            return $this->Service->get_info($type, $param, $key);
        } catch (\Exception $e) {
            alog($e->getMessage(), 2);
            return [];
        }
    }
    /**
     * @author: 布尔
     * @name: 列表
     * @param {array} $param
     * @param {string} $type 对应service类
     * @return {array}
     */
    public function get_ls(string $type, array $param, array $key = [], int $per_page = 10, array $order = [], ?int $page = 0): array
    {
        return $this->Service->get_ls($type, $param, $key, $per_page, $order, $page);
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
