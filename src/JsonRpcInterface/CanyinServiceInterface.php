<?php
/*
 * @author: 布尔
 * @name: 就餐jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2024-11-22 16:31:00
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

interface CanyinServiceInterface
{
    /**
     * @author: 布尔
     * @name: 初始化
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型,userid:1|管理员userid]
     */
    public function post_init(array $param);

    /**
     * @author: 布尔
     * @name: 产品授权初始化
     * @param {array} $param [corpid:1|机构corpid,product_type:1|产品类型]
     */
    public function post_product_auth_init(array $param);

    /**
     * @author: 布尔
     * @name: 魔点设备回调
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型,userid:1|人员userid,device_info:1|设备信息]
     */
    public function post_device_modian_callback(array $param);

    /**
     * @author: 布尔
     * @name: 在线支付回调
     * @param {array} $param [corpid:1|机构corpid]
     */
    public function post_online_pay_callback(array $param);

    /**
     * @author: 布尔
     * @name: 添加
     * @param {array} $param
     * @param {string} $type 对应service类
     * @return {array}
     */
    public function post_add(string $type, array $param, array $val = []): int;

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
     * @name: 删除开放平台数据授权
     * @param {array} $param
     * @return {array}
     */
    public function post_oapi_datav_auth_del(array $param);

    /**
     * @author: 布尔
     * @name: 添加开放平台数据授权
     * @param {array} $param
     * @return {array}
     */
    public function post_oapi_datav_auth_add(array $param);

    /**
     * @author: 布尔
     * @name: 修改开放平台授权组
     * @param {array} $param
     * @return {array}
     */
    public function post_oapi_datav_auth_data_modify(array $param);
    /**
     * @author: 布尔
     * @name: 查询日餐时就餐数据
     * @param {array} $param
     * @return {array}
     */
    public function get_date_repast_dine_data(array $param);
    /**
     * @author: 布尔
     * @name: 三方支付-发起支付
     * @param {array} $param
     * @return {array}
     */
    public function post_pay_scanpay(array $param);
    /**
     * @author: 布尔
     * @name: 三方支付-查询
     * @param {array} $param
     * @return {array}
     */
    public function get_pay_query(array $param);
    /**
     * @author: 布尔
     * @name: 访客充值
     * @param {array} $param
     * @return {array}
     */
    public function post_visitor_recharge(array $param);
    /**
     * @author: 布尔
     * @name: 访客扣款
     * @param {array} $param
     * @return {array}
     */
    public function post_visitor_deduction(array $param);
    /**
     * @author: 布尔
     * @name: 访客清空余额
     * @param {array} $param
     * @return {array}
     */
    public function post_visitor_empty_balance(array $param);
    /**
     * @author: 布尔
     * @name: 访客清空余额
     * @param {array} $param
     * @return {array}
     */
    public function post_visitor_empty_balance(array $param);
    /**
     * @author: 布尔
     * @name: 用户离职
     * @param {array} $param
     */
    public function post_user_leave(array $param);
}
