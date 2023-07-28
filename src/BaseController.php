<?php

/*
 * @author: 布尔
 * @name: 接口基类
 * @desc: 介绍
 * @LastEditTime: 2022-12-19 11:27:26
 */

declare(strict_types=1);

namespace Eykj\Base;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

abstract class BaseController
{

    private ?RequestInterface $request;

    private ?ResponseInterface $response;

    // 通过设置参数为 nullable，表明该参数为一个可选参数
    public function __construct(?RequestInterface $request, ?ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @author: 布尔
     * @name: 获取request数据插入数组
     * @param  string $data 键字符串11111
     * @param  string $token_key token值键字符串
     * @return array $r 
     */
    public function eyd(string $qr_key = "", string $token_key = ""): array
    {
        /* 获取token */
        $token = get('token') ?? [];
        $arr = [];
        $d = explode(",", $qr_key);
        foreach ($d as $val) {
            /*必穿参数验证*/
            if (substr_count($val, ":")) {
                $c = explode(":", $val);
                $key = $c[0];
                /* 判断是否重命名变量 */
                if (substr_count($c[0], "|")) {
                    $cc = $c = explode("|", $c[0]);
                    $c[0] = $cc[1];
                    /* 定义新的key */
                    $key = $cc[0];
                }
                /* 毕传参数验证 */
                if ($c[1] == 1 && ($this->request->input($c[0]) === null || $this->request->input($c[0]) === 'null') && !isset($token[$c[0]]) || $c[1] == 2 && $this->request->file($c[0]) === null) {
                    error(501, '缺少必要参数:' . $c[0]);
                }
                $val = $c[0];
            } else {
                $key = $val;
            }
            /* 判断是不是文件上传 */
            if ($key == 'file') {
                $arr[$key] = $this->request->file($val);
                /* 判断是不是分页字段 */
            } elseif ($key == 'per_page') {
                $arr[$key] = $this->request->input($val) ?: 10;
            } elseif ($this->request->input($val) !== null && $this->request->input($val) !== 'null' && $this->request->input($val) !== '') {
                $arr[$key] = y_trim($this->request->input($val));
            }
        }
        $array = explode(",", $token_key);
        if (!$token_key) {
            $arr = array_merge($token, $arr);
        } else {
            foreach ($array as $rs) {
                /* 判断是否重置键名 */
                if (substr_count($rs, "|")) {
                    $c = explode("|", $rs);
                    if (isset($token[$c[1]])) {
                        $arr[$c[0]] = $token[$c[1]];
                    }
                } else {
                    if (isset($token[$rs])) {
                        $arr[$rs] = $token[$rs];
                    }
                }
            }
        }
        return $arr ?? [];
    }
    /**
     * @author: 布尔
     * @name: 数据库查询字段
     * @param string $data 
     * @return array $r 
     */
    public function key($data): array
    {
        $d = explode(",", $data);
        foreach ($d as $key => $val) {
            $arr[$key] = $val;
        }
        return $arr ?? [];
    }
}