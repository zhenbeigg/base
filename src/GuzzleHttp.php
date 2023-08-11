<?php

/*
 * @author: 布尔
 * @name: GuzzleHttp请求类
 * @desc: 介绍
 * @LastEditTime: 2023-05-23 16:06:40
 */

namespace Eykj\Base;

use Hyperf\Guzzle\ClientFactory;

class GuzzleHttp
{

    private ?ClientFactory $clientFactory;

    // 通过设置参数为 nullable，表明该参数为一个可选参数
    public function __construct(?clientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    /**
     * @author: 布尔
     * @name: get请求方法
     * @param string $url 请求地址
     * @param array $options header参数
     * @param string $method 请求方式
     * @param bool $return_error_msg 返回错误信息
     * @return array
     */
    public function get(string $url, array $options = [], string $method = 'GET', bool $return_error_msg = false)
    {
        /* 请求节流 */
        if (redis()->get('sleep_time_' . $url)) {
            $request_count = (int) redis()->get('sleep_count_' . $url);
            if ($request_count >= 10) {
                /* 程序延迟一秒过期标识删除 */
                sleep(1);
            } else {
                /* 追加周期内请求次数 */
                redis()->set('sleep_count_' . $url, $request_count + 1, 1);
            }
        } else {
            /* 判断过期标识 */
            redis()->set('sleep_time_' . $url, 1, 1);
            /* 周期内请求次数 */
            redis()->set('sleep_count_' . $url, 1, 1);
        }
        /* Guzzle配置信息 */
        $options['headers']['Accept'] = 'application/json';
        $body = [];
        $client = $this->clientFactory->create($options);
        try {
            $resp = $client->request($method, $url, $body);
            $contents = $resp->getBody()->getContents();
            $r = json_decode($contents, true);
            if ($r) {
                return $r;
            } else {
                return $contents;
            }
        } catch (\Throwable $th) {
            alog($th->getMessage(), 2);
            /* 返回错误信息 */
            if ($return_error_msg) {
                return $th->getMessage();
            }
            return [];
        }
    }
    /**
     * @author: 布尔
     * @name: post请求方法
     * @param string $url 请求地址
     * @param array $data body参数
     * @param array $options header参数
     * @param string $en_type header类型
     * @param string $method 请求方式
     * @param bool $return_error_msg 返回错误信息
     * @return array
     */
    public function post(string $url, array $data, array $options = [], string $en_type = 'json', string $method = 'POST', bool $return_error_msg = false)
    {
        /* 请求节流 */
        if (redis()->get('sleep_time_' . $url)) {
            $request_count = (int) redis()->get('sleep_count_' . $url);
            if ($request_count >= 10) {
                /* 程序延迟一秒过期标识删除 */
                sleep(1);
            } else {
                /* 追加周期内请求次数 */
                redis()->set('sleep_count_' . $url, $request_count + 1, 1);
            }
        } else {
            /* 判断过期标识 */
            redis()->set('sleep_time_' . $url, 1, 1);
            /* 周期内请求次数 */
            redis()->set('sleep_count_' . $url, 1, 1);
        }
        /* Guzzle配置信息 */
        if ($en_type == 'json') {
            $options['headers']['Accept'] = 'application/json';
            $body = ['json' => $data];
        } elseif ($en_type == "file") {
            $options['headers']['Content-Type'] = 'multipart/form-data';
            $body = ['multipart' => $data];
        } elseif ($en_type == "form_params") {
            $body = ['form_params' => $data];
        }
        $client = $this->clientFactory->create($options);
        try {
            $resp = $client->request($method, $url, $body);
            $contents = $resp->getBody()->getContents();
            $r = json_decode($contents, true);
            if ($r) {
                return $r;
            } else {
                return $contents;
            }
        } catch (\Throwable $th) {
            alog($th->getMessage(), 2);
            /* 返回错误信息 */
            if ($return_error_msg) {
                return $th->getMessage();
            }
            return [];
        }
    }
}
