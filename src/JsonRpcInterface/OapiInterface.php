<?php

/*
 * @author: 布尔
 * @name: 设备中心jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2022-09-07 16:51:46
 * @FilePath: \eyc3_user\app\Core\JsonRpcInterface\DeviceInterface.php
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Hyperf\Di\Annotation\Inject;
use App\Core\JsonRpcInterface\OapiServiceInterface;

class OapiInterface
{

    #[Inject]
    protected OapiServiceInterface $Service;
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
}
