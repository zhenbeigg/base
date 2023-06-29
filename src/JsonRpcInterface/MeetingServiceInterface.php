<?php
/*
 * @author: 布尔
 * @name: 云一会议jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2022-12-17 15:47:35
 * @FilePath: \eyc3_meeting\app\Core\JsonRpcInterface\MeetingServiceInterface.php
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

interface MeetingServiceInterface
{
    /**
     * @author: 布尔
     * @name: 初始化
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型,userid:1|管理员userid]
     */
    public function post_init(array $param);

    /**
     * @author: 布尔
     * @name: 魔点设备回调
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型,userid:1|人员userid,device_info:1|设备信息]
     */
    public function post_device_modian_callback(array $param);

    /**
     * @author: 风源
     * @name: 获取设备列表
     * @param {array} $param
     * @param {string} $type
     * @return {*}
     */
    public function get_all(string $type, array $param, array $key = []): array;
    /**
     * @author: 风源
     * @name: 获取设备列表
     * @param {array} $param
     * @param {string} $type
     * @return {*}
     */
    public function get_ls(string $type, array $param, array $key = []): array;
    /**
     * @author: 风源
     * @name: 获取设备详情
     * @param {string} $type
     * @param {array} $filter
     * @param {array} $key
     * @return {*}
     */
    public function get_info(string $type, array $filter, array $key = []): array;

    /**
     * @author: 风源
     * @name: 修改设备
     * @param {string} $type
     * @param {array} $filter
     * @param {array} $val
     * @return {*}
     */
    public function post_modify(string $type, array $filter, array $val): int;

    /**
     * @author: 风源
     * @name: 增加设备
     * @param {string} $type
     * @param {array} $filter
     * @param {array} $val
     * @return {*}
     */
    public function post_add(string $type, array $filter, array $val = []): int;
}
