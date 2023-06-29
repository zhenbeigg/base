<?php
/*
 * @author: 布尔
 * @name: jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2022-06-16 17:40:32
 * @FilePath: \eyc3_car\app\Core\JsonRpcInterface\CarServiceInterface.php
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

interface CarServiceInterface
{
    /**
     * @author: 布尔
     * @name: 初始化
     * @param {array} $param
     * @return {array}
     */
    public function post_init(array $param);

    /**
     * @author: 布尔
     * @name: 添加
     * @param {array} $param
     * @param {string} $type 对应service类
     * @return {array}
     */
    public function post_add(string $type, array $param, array $val = []);

    /**
     * @author: 布尔
     * @name: 修改
     * @param {array} $param
     * @param {string} $type 对应service类
     * @return {array}
     */
    public function post_modify(string $type, array $param, array $val = []): int;

    /**
     * @author: 布尔
     * @name: 详情
     * @param {array} $param
     * @param {string} $type 对应service类
     * @return {array}
     */
    public function get_info(string $type, array $param, array $key = []): array;

    /**
     * @author: 布尔
     * @name: 列表
     * @param {array} $param
     * @param {string} $type 对应service类
     * @return {array}
     */
    public function get_ls(string $type, array $param, array $key = [], int $per_page = 10, array $order = [], ?int $page = 0): array;

    /**
     * @author: 布尔
     * @name: 全部
     * @param {array} $param
     * @param {string} $type 对应service类
     * @return {array}
     */
    public function get_all(string $type, array $param, array $key = []): array;

    /**
     * @author: 布尔
     * @name: 删除
     * @param {array} $param
     * @param {string} $type 对应service类
     * @return {array}
     */
    public function post_del(string $type, array $param): int;

    /**
     * @author: 布尔
     * @name: 用车申请审批回调
     * @param {array} $param
     * @return {array}
     */
    public function post_use_car_apply(array $param);
}
