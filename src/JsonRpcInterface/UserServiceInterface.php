<?php
/*
 * @author: 布尔
 * @name: 用户中心jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2024-12-31 12:18:24
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

interface UserServiceInterface
{
    /**
     * @author: 布尔
     * @name: 初始化
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型,userid:1|管理员userid]
     */
    public function post_init(array $param);

    /**
     * @author: 布尔
     * @name: 查询access_token
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型]
     * @return {string} $r
     */
    public function get_access_token(array $param): string;

    /**
     * @author: 布尔
     * @name: 查询应用信息
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型]
     * @return {array} $r
     */
    public function get_auth_info(array $param): array;

    /**
     * @author: 布尔
     * @name: 登录
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型,code:1登录code,corp_type:1机构类型 dtalk 钉钉  wechat  微信]
     * @return {array} $r
     */
    public function get_login(array $param): array;

    /**
     * @author: 布尔
     * @name: 用户-详情
     * @param {array} $param [corpid:1|机构corpid,userid:1|用户useid]
     * @return {array} $r
     */
    public function get_user_info(array $param): array;

    /**     * 
     * @author: 风源
     * @name: 获取用户详情（带部门路径）
     * @param {array} $param [corpid:1|机构corpid,userid:1|用户useid]
     * @return {*}
     * 
     */
    public function get_user_detail(array $param): array;

    /**
     * @author: 布尔
     * @name: 用户-列表
     * @param {array} $param [corpid:1|机构corpid,dept_id|部门id,isleave|是否查询离职人员,userlst|用户及部门信息,keyword|搜索关键词,per_page|分页条数,page:1|页数,where|特殊查询条件]
     * @return {array} $r
     */
    public function get_user_ls(array $param): array;

    /**
     * @author: 布尔
     * @name: 用户-全部
     * @param {array} $param [corpid:1|机构corpid,dept_id|部门id,isleave|是否查询离职人员,userlst|用户及部门信息,keyword|搜索关键词,where|特殊查询条件]
     * @return {array} $r
     */
    public function get_user_all(array $param, array $key = []): array;

    /**
     * @author: 布尔
     * @name: 部门-列表
     * @param {array} $param [corpid:1|机构corpid,dept_id|父部门id,keyword|搜索关键词,per_page|分页条数,page:1|页数,where|特殊查询条件]
     * @return {array} $r
     */
    public function get_dept_ls(array $param): array;

    /**
     * @author: 布尔
     * @name: 部门-列表
     * @param {array} $param [corpid:1|机构corpid,dept_id|父部门id,keyword|搜索关键词,where|特殊查询条件]
     * @return {array} $r
     */
    public function get_dept_all(array $param): array;

    /**
     * @author: 布尔
     * @name: 部门-详情
     * @param {array} $param [corpid:1|机构corpid,dept_id:1|部门id]
     * @return {array} $r
     */
    public function get_dept_info(array $param): array;

    /**
     * @author: 布尔
     * @name: 部门-全部子部门
     * @param {array} $param [corpid:1|机构corpid,dept_id:1|部门id]
     * @return {array} $r
     */
    public function get_dept_sun_all(array $param): array;

    /**
     * @author: 布尔
     * @name:  查询部门路径
     * @param {array} $param [corpid:1|机构corpid,dept_id:1|部门id]
     * @return {array} $r
     */
    public function get_dept_partent_list(array $param): string;

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
    public function get_all(string $type, array $param, array $key = [], array $order = [], $distinct = false, array $add_select = [], $group = '', array $having = [], array $having_raw = [], array $or_having_raw = [], string $select_raw = ''): array;

    /**
     * @author: 布尔
     * @name: 查询数量
     * @param array $param   查询条件
     * @param string|bool $distinct   是否去重
     * @return int|null $r 返回数据
     */
    public function get_count(string $type, array $param, $distinct = false): int|null;

    /**
     * @author: 布尔
     * @name: 总和
     * @param {string} $type 对应model类
     * @param {array} $param 筛选条件
     * @param {string} $val 计算字段
     * @return {float}
     */
    public function get_sum(string $type, array $param, string $val): float;

    /**
     * @author: 布尔
     * @name: 扣款
     * @param {string} $type 类型 User 用户 Visitor 访客
     * @param {array} $param
     * @return {array}
     */
    public function post_debit(string $type,array $param): array;

    /**
     * @author: 布尔
     * @name: 退款
     * @param {string} $type 类型 User 用户 Visitor 访客
     * @param {array} $param
     * @return {array}
     */
    public function post_refund(string $type,array $param): array;

    /**
     * @author: 布尔
     * @name: 在线支付
     * @param {string} $type
     * @param {array} $param
     * @return {array}
     */
    public function post_pay(string $type, array $param): array;

    /**
     * @author: 布尔
     * @name: 解码
     * @param {string} $type
     * @param {array} $param
     * @return {array}
     */
    public function post_decode(string $type, array $param): array;
    /**
     * @author: 布尔
     * @name: 成员、部门变更通知
     * @param {array} $param
     */
    public function post_change_contact(array $param): void;
}
