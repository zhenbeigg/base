<?php

/*
 * @author: 布尔
 * @name: 审批中心
 * @desc: 介绍
 * @LastEditTime: 2023-07-05 22:09:33
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Eykj\Base\JsonRpcInterface\ApproveServiceInterface;

class ApproveInterface
{
    private ?ApproveServiceInterface $Service;

    // 通过设置参数为 nullable，表明该参数为一个可选参数
    public function __construct(?ApproveServiceInterface $Service)
    {
        $this->Service = $Service;
    }

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
        } catch (\Exception $e) {
            alog($e->getMessage(), 2);
            return false;
        }
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
        try {
            return $this->Service->post_modify($type, $param, $val);
        } catch (\Exception $e) {
            alog($e->getMessage(), 2);
            return false;
        }
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
        try {
            return $this->Service->get_ls($type, $param, $key, $per_page, $order, $page);
        } catch (\Exception $e) {
            alog($e->getMessage(), 2);
            return [];
        }

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
        try {
            return $this->Service->get_all($type, $param, $key);
        } catch (\Exception $e) {
            alog($e->getMessage(), 2);
            return [];
        }
    }
}
