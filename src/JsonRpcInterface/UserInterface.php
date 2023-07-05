<?php

/*
 * @author: 布尔
 * @name: 用户中心jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2023-01-02 16:32:33
 * @FilePath: \eyc3_canyin\app\Core\JsonRpcInterface\UserInterface.php
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Hyperf\Di\Annotation\Inject;
use App\Core\JsonRpcInterface\UserServiceInterface;

class UserInterface
{

    #[Inject]
    protected UserServiceInterface $Service;
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
     * @name: 查询access_token
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型]
     * @return {string} $r
     */
    public function get_access_token(array $param): string
    {
        try {
            return $this->Service->get_access_token($param);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 布尔
     * @name: 查询应用信息
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型]
     * @return {array} $r
     */
    public function get_auth_info(array $param): array
    {
        try {
            return $this->Service->get_auth_info($param);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 布尔
     * @name: 登录
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型,code:1登录code,corp_type:1机构类型 dtalk 钉钉  wechat  微信]
     * @return {array} $r
     */
    public function get_login(array $param): array
    {
        try {
            return $this->Service->get_login($param);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 布尔
     * @name: 用户-详情
     * @param {array} $param [corpid:1|机构corpid,userid:1|用户useid]
     * @return {array} $r
     */
    public function get_user_info(array $param): array
    {
        try {
            return $this->Service->get_user_info($param);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 风源
     * @name: 获取用户详情（带部门路径）
     * @param {array} $param [corpid:1|机构corpid,userid:1|用户useid]
     * @return {*}
     */
    public function get_user_detail(array $param): array
    {
        try {
            return $this->Service->get_user_detail($param);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 布尔
     * @name: 用户-列表
     * @param {array} $param [corpid:1|机构corpid,dept_id|部门id,isleave|是否查询离职人员,userlst|用户及部门信息,keyword|搜索关键词,per_page|分页条数,page:1|页数,where|特殊查询条件]
     * @return {array} $r
     */
    public function get_user_ls(array $param): array
    {
        try {
            return $this->Service->get_user_ls($param);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 布尔
     * @name: 用户-全部
     * @param {array} $param [corpid:1|机构corpid,dept_id|部门id,isleave|是否查询离职人员,userlst|用户及部门信息,keyword|搜索关键词,where|特殊查询条件]
     * @return {array} $r
     */
    public function get_user_all(array $param): array
    {
        try {
            return $this->Service->get_user_all($param);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 布尔
     * @name: 部门-列表
     * @param {array} $param [corpid:1|机构corpid,dept_id|父部门id,keyword|搜索关键词,per_page|分页条数,page:1|页数,where|特殊查询条件]
     * @return {array} $r
     */
    public function get_dept_ls(array $param): array
    {
        try {
            return $this->Service->get_dept_ls($param);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 布尔
     * @name: 部门-列表
     * @param {array} $param [corpid:1|机构corpid,dept_id|父部门id,keyword|搜索关键词,where|特殊查询条件]
     * @return {array} $r
     */
    public function get_dept_all(array $param): array
    {
        try {
            return $this->Service->get_dept_all($param);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 布尔
     * @name: 部门-详情
     * @param {array} $param [corpid:1|机构corpid,dept_id:1|部门id]
     * @return {array} $r
     */
    public function get_dept_info(array $param): array
    {
        try {
            return $this->Service->get_dept_info($param);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 布尔
     * @name: 部门-全部子部门
     * @param {array} $param [corpid:1|机构corpid,dept_id:1|部门id]
     * @return {array} $r
     */
    public function get_dept_sun_all(array $param): array
    {
        try {
            return $this->Service->get_dept_sun_all($param);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 布尔
     * @name:  查询部门路径
     * @param {array} $param [corpid:1|机构corpid,dept_id:1|部门id]
     * @return {array} $r
     */
    public function get_dept_partent_list(array $param): string
    {
        try {
            return $this->Service->get_dept_partent_list($param);
        } catch (\Exception $e) {
            alog($e->getMessage(), 2);
            return '';
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
            error($e->getCode(), $e->getMessage());
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
    public function get_all(string $type, array $param, array $key = [], array $order = [], $distinct = false, array $add_select = [], $group = '', array $having = [], array $having_raw = [], array $or_having_raw = [], string $select_raw = ''): array
    {
        try {
            return $this->Service->get_all($type, $param, $key, $order, $distinct, $add_select, $group, $having, $having_raw, $or_having_raw, $select_raw);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 布尔
     * @name: 总和
     * @param {string} $type 对应model类
     * @param {array} $param 筛选条件
     * @param {string} $val 计算字段
     * @return {float}
     */
    public function get_sum(string $type, array $param, string $val): float
    {
        try {
            return $this->Service->get_sum($type, $param, $val);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 布尔
     * @name: 查询数量
     * @param array $param   查询条件
     * @param string|bool $distinct   是否去重
     * @return int|null $r 返回数据
     */
    public function get_count(string $type, array $param, $distinct = false): int|null
    {
        try {
            return $this->Service->get_count($type, $param, $distinct);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 布尔
     * @name: 扣款
     * @param {array} $param
     * @return {array}
     */
    public function post_debit(array $param): array
    {
        try {
            return $this->Service->post_debit($param);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 布尔
     * @name: 退款
     * @param {array} $param
     * @return {array}
     */
    public function post_refund(array $param): array
    {
        try {
            return $this->Service->post_refund($param);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 布尔
     * @name: 在线支付
     * @param {string} $type
     * @return {array}
     */
    public function post_pay(string $type, array $param): array
    {
        try {
            return $this->Service->post_pay($type, $param);
        } catch (\Exception $e) {
            error($e->getCode(), $e->getMessage());
        }
    }
    /**
     * @author: 布尔
     * @name: 解码
     * @param {string} $type
     * @return {array}
     */
    public function post_decode(string $type, array $param): array
    {
        try {
            return $this->Service->post_decode($type, $param);
        } catch (\Exception $e) {
            alog($e->getMessage(), 2);
            return [];
        }
    }
}
