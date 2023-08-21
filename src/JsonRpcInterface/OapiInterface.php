<?php

/*
 * @author: 布尔
 * @name: 设备中心jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2022-09-07 16:51:46
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Eykj\Base\JsonRpcInterface\OapiServiceInterface;

class OapiInterface
{
    private ?OapiServiceInterface $Service;

    // 通过设置参数为 nullable，表明该参数为一个可选参数
    public function __construct(?OapiServiceInterface $Service)
    {
        $this->Service = $Service;
    }
    /**
     * @author: 风源
     * @name: 获取设备列表
     * @param {array} $param    参数名为   apikey , corp_product
     * @return {*}
     */
    public function get_apikey_info(array $param): array
    {
        return $this->Service->get_apikey_info($param);
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
        } catch (\Throwable $th) {
            error(500, $th->getMessage());
        }
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
        try {
            return $this->Service->get_all($type, $param, $key);
        } catch (\Throwable $th) {
            error(500, $th->getMessage());
        }
    }

    /**
     * @author: 布尔
     * @name: 回调授权详情
     * @param {array} $param
     * @return {array}
     */
    public function get_notify_info(array $param): array
    {
        try {
            return $this->Service->get_notify_info($param);
        } catch (\Throwable $th) {
            error(500, $th->getMessage());
        }
    }
}
