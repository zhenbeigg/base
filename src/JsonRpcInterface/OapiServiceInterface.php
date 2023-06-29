<?php
/*
 * @author: 布尔
 * @name: 设备中心jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2023-03-22 21:27:41
 * @FilePath: \eyc3_oapi\app\Core\JsonRpcInterface\OapiServiceInterface.php
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

interface  OapiServiceInterface
{
    /**
     * @author: 风源
     * @name: 获取apikey信息
     * @param {array} $param
     * @return {array}
     */
    public function get_apikey_info(array $param): array;

    /**
     * @author: 风源
     * @name: 获取详情
     * @param {string} $type
     * @param {array} $param
     * @param {array} $key
     * @return {array}
     */
    public function get_info(string $type, array $param, array $key = []): array;

    /**
     * @author: 风源
     * @name: 全部
     * @param {string} $type
     * @param {array} $param
     * @param {array} $key
     * @return {array}
     */
    public function get_all(string $type, array $param, array $key = []): array;
}
