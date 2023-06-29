<?php

/*
 * @author: 布尔
 * @name: 云一门岗
 * @desc: 介绍
 * @LastEditTime: 2022-11-11 22:53:05
 * @FilePath: \eyc3_visitor\app\Core\JsonRpcInterface\CarInterface.php
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Hyperf\Di\Annotation\Inject;
use App\Core\JsonRpcInterface\CarServiceInterface;

class CarInterface
{

    #[Inject]
    protected CarServiceInterface $Service;
    /**
     * @author: 布尔
     * @name: 初始化
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型,userid:1|管理员userid]
     */
    public function post_init(array $param)
    {
        return $this->Service->post_init($param);
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
        } catch (\Throwable $th) {
            alog($th->getMessage(), 2);
            return 0;
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
        return $this->Service->get_info($type, $param, $key);
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
    /**
     * @author: 布尔
     * @name: 删除
     * @param {array} $param
     * @param {string} $type 对应service类
     * @return {array}
     */
    public function post_del(string $type, array $param): int
    {
        return $this->Service->post_del($type, $param);
    }

    /**
     * @author: 布尔
     * @name: 用车申请审批回调
     * @param {array} $param
     * @return {array}
     */
    public function post_use_car_apply(array $param)
    {
        return $this->Service->post_use_car_apply($param);
    }
}
