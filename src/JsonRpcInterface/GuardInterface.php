<?php

/*
 * @author: 布尔
 * @name: 云一门岗
 * @desc: 介绍
 * @LastEditTime: 2022-08-08 02:45:03
 * @FilePath: \eyc3_device\app\Core\JsonRpcInterface\GuardInterface.php
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Hyperf\Di\Annotation\Inject;
use App\Core\JsonRpcInterface\GuardServiceInterface;

class GuardInterface
{

    #[Inject]
    protected GuardServiceInterface $Service;
    /**
     * @author: 布尔
     * @name: 获取全部明细数据
     * @param {array} $param
     * @return {array}
     */
    public function get_log_all(array $param): array
    {
        return $this->Service->get_log_all($param);
    }
    /**
     * @author: 风源
     * @name: 获取全部区域显示
     * @param {array} $param
     * @return {*}
     */
    public function get_area_all(array $param): array
    {
        return $this->Service->get_area_all($param);
    }
    /**
     * @author: 风源
     * @name: 获取当前区域人数
     * @param {array} $param
     * @return {*}
     */
    public function get_area_count(array $param): array
    {
        return $this->Service->get_area_count($param);
    }
    /**
     * @author: 风源
     * @name: 获取考勤设备列表
     * @param {array} $param
     * @return {*}
     */
    public function get_device_attence_ls(array $param): array
    {
        return $this->Service->get_device_attence_ls($param);
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
     * @author: 
     * @name: 防疫设备回调
     * @param {array} $param
     */
    public function post_device_fy_callback(array $param): array
    {
        return $this->Service->post_device_fy_callback($param);
    }
    /**
     * @author:
     * @name: 自动派房回调
     * @param {array} $param
     */
    public function post_auto_assign(array $param): int
    {
        return $this->Service->post_auto_assign($param);
    }
}
