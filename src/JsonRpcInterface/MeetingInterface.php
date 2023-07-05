<?php

/*
 * @author: 布尔
 * @name: 云一会议jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2022-08-08 02:41:10
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Eykj\Base\JsonRpcInterface\MeetingServiceInterface;

class MeetingInterface
{
    private ?MeetingServiceInterface $Service;

    // 通过设置参数为 nullable，表明该参数为一个可选参数
    public function __construct(?MeetingServiceInterface $Service)
    {
        $this->Service = $Service;
    }
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
     * @name: 魔点设备回调
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型,userid:1|人员userid,device_info:1|设备信息]
     */
    public function post_device_modian_callback(array $param): array
    {
        try {
            return $this->Service->post_device_modian_callback($param);
        } catch (\Throwable $th) {
            alog($th->getMessage(), 2);
            return ['errcode' => $th->getCode(), 'message' => $th->getMessage()];
        }
    }
    /**
     * @author: 风源
     * @name: 获取设备列表
     * @param {array} $param
     * @param {string} $type
     * @return {*}
     */
    public function get_all(string $type, array $param, array $key = []): array
    {
        return $this->Service->get_all($type, $param, $key);
    }
    /**
     * @author: 风源
     * @name: 获取设备列表
     * @param {array} $param
     * @param {string} $type
     * @return {*}
     */
    public function get_ls(string $type, array $param, array $key = []): array
    {
        return $this->Service->get_ls($type, $param, $key);
    }
    /**
     * @author: 风源
     * @name: 获取设备详情
     * @param {string} $type
     * @param {array} $filter
     * @param {array} $key
     * @return {*}
     */
    public function get_info(string $type, array $filter, array $key = []): array
    {
        return $this->Service->get_info($type, $filter, $key);
    }
    /**
     * @author: 风源
     * @name: 修改设备
     * @param {string} $type
     * @param {array} $filter
     * @param {array} $val
     * @return {*}
     */
    public function post_modify(string $type, array $filter, array $val): int
    {
        return $this->Service->post_modify($type, $filter, $val);
    }
    /**
     * @author: 风源
     * @name: 增加设备
     * @param {string} $type
     * @param {array} $filter
     * @param {array} $val
     * @return {*}
     */
    public function post_add(string $type, array $filter, array $val = []): int
    {
        return $this->Service->post_add($type, $filter, $val);
    }
}
