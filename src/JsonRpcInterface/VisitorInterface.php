<?php

/*
 * @author: 布尔
 * @name: 云一访客
 * @desc: 介绍
 * @LastEditTime: 2023-03-10 11:06:14
 * @FilePath: \eyc3_canyin\app\Core\JsonRpcInterface\VisitorInterface.php
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Hyperf\Di\Annotation\Inject;
use App\Core\JsonRpcInterface\VisitorServiceInterface;

class VisitorInterface
{

    #[Inject]
    protected VisitorServiceInterface $Service;

    /**
     * @author: 布尔
     * @name: 初始化
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型,userid:1|管理员userid]
     */
    public function post_init(array $param)
    {
        try {
            return $this->Service->post_init($param);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
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
            error($e->getCode(), $e->getMessage());
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
            error($e->getCode(), $e->getMessage());
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
            error($e->getCode(), $e->getMessage());
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
            error($e->getCode(), $e->getMessage());
        }
    }
}
