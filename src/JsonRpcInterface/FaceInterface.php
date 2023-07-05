<?php

/*
 * @author: 布尔
 * @name: 设备中心jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2022-09-14 08:50:18
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Hyperf\Di\Annotation\Inject;
use Eykj\Base\JsonRpcInterface\FaceServiceInterface;

class FaceInterface
{

    #[Inject]
    protected FaceServiceInterface $Service;
    /**
     * @author: 风源
     * @name: 添加人脸
     * @param {string} $type 
     * @param {array} $param
     * @return {*}
     */
    public function post_face_add_v3(array $param)
    {
        try {
            return $this->Service->post_face_add_v3($param);
        } catch (\Throwable $th) {
            alog($th->getMessage(), 2);
            error(500, $th->getMessage());
        }
    }

    /**
     * @author: 风源
     * @name: 删除人脸
     * @param {string} $type 
     * @param {array} $param
     * @return {*}
     */
    public function post_delete(array $param)
    {
        try {
            return $this->Service->post_delete($param);
        } catch (\Throwable $th) {
            alog($th->getMessage(), 2);
            error(500, $th->getMessage());
        }
    }
}
