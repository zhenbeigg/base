<?php
/*
 * @author: 布尔
 * @name: 设备中心jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2022-09-07 16:49:04
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

interface  DeviceServiceInterface
{
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

    /**
     * @author: 风源
     * @name: 删除设备
     * @param {string} $type
     * @param {array} $filter
     * @return {*}
     */
    public function post_del(string $type, array $filter): int;

    /**
     * @author: 布尔
     * @name: 餐饮-收银机-详情
     * @param {array} $param [corpid:1|机构corpid,deviceSn:1|设备序列号,title|设备标题,type|类型,status|状态,lock|锁]
     * @return {int} $r
     */
    public function post_canyin_cashier_modify(array $param): int;

    /**
     * @author: 布尔
     * @name: 餐饮-收银机-详情
     * @param {array} $param [corpid|机构corpid,deviceSn:1|设备序列号]
     * @return {array} $r
     */
    public function get_canyin_cashier_info(array $param): array;

    /**
     * @author: 布尔
     * @name: 餐饮-收银机-列表
     * @param {array} $param [corpid:1|机构corpid,model|设备型号,type|类型,status|状态,keyword|搜索关键词,per_page|分页条数,page:1|页数]
     * @return {array} $r
     */
    public function get_canyin_cashier_ls(array $param): array;

    /**
     * @author: 布尔
     * @name: 餐饮-收银机-全部
     * @param {array} $param [corpid:1|机构corpid,model|设备型号,type|类型,status|状态,keyword|搜索关键词]
     * @return {array} $r
     */
    public function get_canyin_cashier_all(array $param): array;

    /**
     * @author: 布尔
     * @name: 餐饮-消费机-修改
     * @param {array} $param [corpid:1|机构corpid,deviceSn:1|设备序列号,title|设备标题,type|类型,status|状态,lock|锁,is_open_door|是否开启门禁 0 否 1 是,open_door_time|开门延迟时间单位秒,is_attence|是否开启考勤 0 否 1 是,volume|设备音量,show_index|开启欢迎屏,meal_code|开启取餐码]
     * @return {int} $r
     */
    public function post_canyin_consumption_modify(array $param): int;

    /**
     * @author: 布尔
     * @name: 餐饮-消费机-详情
     * @param {array} $param [corpid|机构corpid,deviceSn:1|设备序列号]
     * @return {array} $r
     */
    public function get_canyin_consumption_info(array $param): array;

    /**
     * @author: 布尔
     * @name: 餐饮-消费机-列表
     * @param {array} $param [corpid:1|机构corpid,model|设备型号,type|类型,status|状态,keyword|搜索关键词,per_page|分页条数,page:1|页数]
     * @return {array} $r
     */
    public function get_canyin_consumption_ls(array $param): array;

    /**
     * @author: 布尔
     * @name: 餐饮-消费机-全部
     * @param {array} $param [corpid:1|机构corpid,model|设备型号,type|类型,status|状态,keyword|搜索关键词]
     * @return {array} $r
     */
    public function get_canyin_consumption_all(array $param): array;

    /**
     * @author: 布尔
     * @name: 餐饮-打印机-详情
     * @param {array} $param [corpid:1|机构corpid,deviceSn:1|设备序列号,title|设备标题,type|类型,status|状态,lock|锁,voice|语音内容,voice_count|票据语音播放次数，0 不提示，1 播报1次，3 播报3次，999 循环播放,order_count|打印票据张数]
     * @return {int} $r
     */
    public function post_canyin_printer_modify(array $param): int;

    /**
     * @author: 布尔
     * @name: 餐饮-打印机-详情
     * @param {array} $param [corpid:1|机构corpid,deviceSn:1|设备序列号]
     * @return {array} $r
     */
    public function get_canyin_printer_info(array $param): array;

    /**
     * @author: 布尔
     * @name: 餐饮-打印机-列表
     * @param {array} $param [corpid|机构corpid,model|设备型号,type|类型,status|状态,keyword|搜索关键词,per_page|分页条数,page:1|页数]
     * @return {array} $r
     */
    public function get_canyin_printer_ls(array $param): array;

    /**
     * @author: 布尔
     * @name: 餐饮-打印机-全部
     * @param {array} $param [corpid:1|机构corpid,model|设备型号,type|类型,status|状态,keyword|搜索关键词]
     * @return {array} $r
     */
    public function get_canyin_printer_all(array $param): array;

    /**
     * @author: 布尔
     * @name: 人脸信息更新推送
     * @param {array} $param [corpid:1|机构corpid,type:1|类型,userid:1|用户id,face|人脸信息]
     */
    public function post_face_modify_send(array $param);
}
