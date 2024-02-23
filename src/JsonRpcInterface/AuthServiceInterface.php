<?php
/*
 * @author: 布尔
 * @name: 授权中心
 * @desc: 介绍
 * @LastEditTime: 2022-09-05 18:52:58
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

interface AuthServiceInterface
{
    /**
     * @author: 布尔
     * @name: 查询access_token
     * @param {string} $type 对应service类 对应service类  Dtalk:钉钉 Modian:魔点
     * @param {array} $param
     * @return {array}
     */
    public function get_access_token(string $type, array $param);

    /**
     * @author: 布尔
     * @name: 获取第三方应用凭证
     * @param {string} $type 对应service类 对应service类  Dtalk:钉钉 Modian:魔点
     * @param {array} $param
     * @return {array}
     */
    public function get_suite_token(string $type, array $param);

    /**
     * @author: 布尔
     * @name: 获取服务商的token
     * @param {string} $type 对应service类 对应service类  Dtalk:钉钉 Modian:魔点
     * @param {array} $param
     * @return {array}
     */
    public function get_provider_token(string $type, array $param);

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
     * @name: 获取验证码
     * @param {array} $param
     * @return {string}
     */
    public function get_code(array $param): string;

    /**
     * @author: 布尔
     * @name: 删除证码
     * @param {array} $param
     * @return {string}
     */
    public function post_code_del(array $param): void;
    /**
     * @author: 小豪
     * @name: 新增容量
     * @param {array} $param
     * @return {string}
     */
    public function post_capacity_add(array $param);
    /**
     * @author: 小豪
     * @name: 编辑容量
     * @param {array} $param
     * @return {string}
     */
    public function post_capacity_modify(array $param);
    /**
     * @author: 小豪
     * @name: 自增容量
     * @param {array} $param
     * @return {string}
     */
    public function post_capacity_increment(array $param);
    /**
     * @author: 小豪
     * @name: 自减容量
     * @param {array} $param
     * @return {string}
     */
    public function post_capacity_decrement(array $param);

    /**
     * @author: szh
     * @name: 发送短信
     * @param {array} $param
     * @return {string}
     */
    public function post_sms_send(array $param);

    /**
     * @author: szh
     * @name: 获取短信余额
     * @param {array} $param
     * @return {array}
     */
    public function get_info_sms(array $param): array;

    /**
     * @author: 布尔
     * @name: 列表
     * @param {array} $param
     * @return {array}
     */
    public function get_ls_smslog(array $param): array;
    /**
     * @author: 小豪
     * @name: 容量信息
     * @param {array} $param
     * @return {string}
     */
    public function get_capacity_info(array $param);
}
