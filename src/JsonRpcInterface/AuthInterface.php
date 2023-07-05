<?php

/*
 * @author: 布尔
 * @name: 授权中心
 * @desc: 介绍
 * @LastEditTime: 2022-09-05 18:54:15
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Hyperf\Di\Annotation\Inject;
use Eykj\Base\JsonRpcInterface\AuthServiceInterface;

class AuthInterface
{

    #[Inject]
    protected AuthServiceInterface $Service;
    /**
     * @author: 布尔
     * @name: 获取token
     * @param {array} $param
     * @param {string} $type 对应service类  Dtalk:钉钉 Modian:魔点
     * @return {array}
     */
    public function get_access_token(string $type, array $param)
    {
        try {
            return $this->Service->get_access_token($type, $param);
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
     * @name: 获取验证码
     * @param {array} $param
     * @return {string}
     */
    public function get_code(array $param): string
    {
        return $this->Service->get_code($param);
    }
    /**
     * @author: 布尔
     * @name: 删除证码
     * @param {array} $param
     * @return {string}
     */
    public function post_code_del(array $param): void
    {
        $this->Service->post_code_del($param);
    }
    /**
     * @author: 小豪
     * @name: 新增容量
     * @param {array} $param
     * @return {string}
     */
    public function post_capacity_add(array $param)
    {
        $this->Service->post_capacity_add($param);
    }
    /**
     * @author: 小豪
     * @name: 编辑容量
     * @param {array} $param
     * @return {string}
     */
    public function post_capacity_modify(array $param)
    {
        return $this->Service->post_capacity_modify($param);
    }
    /**
     * @author: 小豪
     * @name: 自增容量
     * @param {array} $param
     * @return {string}
     */
    public function post_capacity_increment(array $param)
    {
        return $this->Service->post_capacity_increment($param);
    }
    /**
     * @author: 小豪
     * @name: 自减容量
     * @param {array} $param
     * @return {string}
     */
    public function post_capacity_decrement(array $param)
    {
        return $this->Service->post_capacity_decrement($param);
    }
    /**
     * @author: 小豪
     * @name: 容量信息
     * @param {array} $param
     * @return {string}
     */
    public function get_capacity_info(array $param)
    {
        return $this->Service->get_capacity_info($param);
    }
    /**
     * @author: szh
     * @name: 发送短信
     * @param {array} $param {"corpid":"dingb961...","corp_product":"visitor","PhoneNumbers":"13253746250",
     * "TemplateCode":"SMS_242687180","TemplateParam":{"corpid":"dingb961...","address":"管城回族区中央大道","code":"952700",
     * "time":"2022年10月30日","name_corp_name":"狗蛋啊,一一科技内部开发平台"},"RegionId":"cn-beijing"}
     * @return {string}
     */
    public function post_sms_send(array $param)
    {
        return $this->Service->post_sms_send($param);
    }
    /**
     * @author: szh
     * @name: 获取短信余额
     * @param {array} $param {"corpid":"dingb961..."}
     * @return {array}
     */
    public function get_info_sms(array $param): array
    {
        return $this->Service->get_info_sms($param);
    }
    /**
     * @author szh
     * @name::获取短信消耗/充值记录
     * @param {array} $param {"corpid":"dingb961...","corp_product":"visitor","per_page":10,"page":1,"key":["id",
     * "status","..."]}
     * @return {array}
     */
    public function get_ls_smslog(array $param): array
    {
        return $this->Service->get_ls_smslog($param);
    }
}
