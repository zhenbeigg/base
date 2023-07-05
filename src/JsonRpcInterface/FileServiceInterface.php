<?php
/*
 * @author: 
 * @name: jsonrpc接口类
 * @desc: 文件服务
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;


interface FileServiceInterface
{
    /**
     * @author: 布尔
     * @name: 文件上传
     * @return {string} $r
     */
    public function post_upload(array $param);

    /**
     * author: xiaohao
     * name: 类名
     * @return bool|null
     * @throws \League\Flysystem\FilesystemException
     */
    public function post_del(array $param);
    /**
     * author: xiaohao
     * name: 所有图片信息
     */
    public function get_ls(array $param);
    /**
     * author: xiaohao
     * name: 图片详情
     */
    public function get_info(array $param);
}
