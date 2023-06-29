<?php
/*
 * @author: 布尔
 * @name: 类名
 * @desc: 介绍
 * @LastEditTime: 2023-05-12 16:29:13
 * @FilePath: \eyc3_car\app\Core\JsonRpcInterface\FileInterface.php
 */

/*
 * @author: 
 * @name: 云一文件
 * @desc: 
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Hyperf\Di\Annotation\Inject;
use App\Core\JsonRpcInterface\FileServiceInterface;

class FileInterface
{

    #[Inject]
    protected FileServiceInterface $Service;
    /**
     * @author: 布尔
     * @name: 文件上传
     * @return {string} $r
     */
    public function post_upload(array $param)
    {
        try {
            return $this->Service->post_upload($param);
        } catch (\Throwable $th) {
            alog($th->getMessage(), 2);
        }
    }
    /**
     * author: xiaohao
     * name: 文件删除
     * @return bool|null
     * @throws \League\Flysystem\FilesystemException
     */
    public function post_del(array $param)
    {
        return $this->Service->post_del($param);
    }
    /**
     * author: xiaohao
     * name: 所有图片信息
     */
    public function get_ls(array $param)
    {
        return $this->Service->get_ls($param);
    }
}
