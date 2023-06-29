<?php
/*
 * @author: 布尔
 * @name: 人脸服务jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2022-09-07 19:45:02
 * @FilePath: \eyc3_user\app\Core\JsonRpcInterface\FaceServiceInterface.php
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;


interface FaceServiceInterface
{
    /**
     * @author: 布尔
     * @name: 添加人脸
     * @param {array} $param 
     * @return {string} $r
     */
    public function post_face_add_v3($param);

    /**
     * @author: 布尔
     * @name: 删除人脸
     * @param {array} $param 
     * @return {string} $r
     */
    public function post_delete($param);
}
