<?php
/*
 * @author: 布尔
 * @name: 云一工作jsonrpc接口类
 * @desc: 介绍
 * @LastEditTime: 2022-09-14 08:50:18
 * @FilePath: \eyc3_device\app\Core\JsonRpcInterface\WorkInterface.php
 */

declare(strict_types=1);

namespace Eykj\Base\JsonRpcInterface;

use Hyperf\Di\Annotation\Inject;
use App\Core\JsonRpcInterface\WorkServiceInterface;

class WorkInterface
{

    #[Inject]
    protected WorkServiceInterface $Service;
    /**
     * @author: 布尔
     * @name: 初始化
     * @param {array} $param [corpid:1|机构corpid,types:1|授权类型,corp_product:1|应用类型,userid:1|管理员userid]
     */
    public function post_init(array $param)
    {
        try {
            return $this->Service->post_init($param);
        } catch (\Throwable $th) {
            alog($th->getMessage(), 2);
        }
    }
}
