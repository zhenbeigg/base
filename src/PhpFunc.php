<?php
/*
 * @author: 布尔
 * @name: 通用函数
 * @desc: 介绍
 * @LastEditTime: 2023-06-26 17:03:07
 */

declare(strict_types=1);

if (!function_exists('y_json_decode')) {
    /**
     * @author: 布尔
     * @name: 内部定制json解码
     * @param {*} $json 待解码json字符串
     * @param {bool} $type 是否转译为数组 
     * @return {array} array
     */
    function y_json_decode($json, bool $type = true): array
    {
        if (isset($json)) {
            if (!empty($json) && $json != "null") {
                return json_decode($json, $type);
            }
        }
        return array();
    }
}

if (!function_exists('y_array_unique')) {
    /**
     * @author: 布尔
     * @name: 内部定制数组去重
     * @param {array} $arr 待处理数组
     * @param {int} $level 数组层级
     * @param {string} $key 去重关键词
     * @return {array} $r
     */
    function y_array_unique(array $arr, int $level = 1, string $key = 'id'): array
    {
        switch ($level) {
            case '1':
                return array_unique($arr);
                break;
            case '2':
                return array_values(array_column($arr, NUll, $key));
                break;
            default:
                return array_unique($arr);
                break;
        }
    }
}

if (!function_exists('y_get_object_vars')) {
    /**
     * @author: 布尔
     * @name: 内部定制对象转数组
     * @param {array|object} $object 待处理对象
     * @return {array} $r
     */
    function y_get_object_vars(object|array $object): array
    {
        if (is_object($object)) {
            return get_object_vars($object);
        }
        return $object;
    }
}

if (!function_exists('y_explode')) {
    /**
     * @author: 布尔
     * @name: 内部定制字符串转数组
     * @param {string} $string 待处理字符串
     * @param {string} $separator 规定在哪里分割字符串
     * @return {array} $r
     */
    function y_explode($string = '', string $separator = ','): array
    {
        if (is_string($string) && $string) {
            return explode($separator, $string);
        }
        return [];
    }
}

if (!function_exists('y_trim')) {
    /**
     * @author: 布尔
     * @name: 内部定制去除字符串两侧的字符
     * @param {string} $string 待处理字符串
     * @param {string|null} $charlist 规定从字符串中删除哪些字符
     * @return  $r
     */
    function y_trim($string, string|null $charlist = null)
    {
        if (is_string($string)) {
            return $charlist !== null ? trim($string, $charlist) : trim($string);
        }
        return $string;
    }
}

if (!function_exists('y_str_replace')) {
    /**
     * @author: 布尔
     * @name: 内部定制字符串替换
     * @param  $string 待处理字符串
     * @param {string} $find 规定要查找的值
     * @param {string} $replace 规定替换 find 中的值的值
     * @return {string} $r
     */
    function y_str_replace($string = '', string $find = '?x-oss-process=image/resize,w_300/format,webp', string $replace = ''): string
    {
        if ($string) {
            return str_replace($find, $replace, $string);
        }
        return $string;
    }
}

if (!function_exists('y_microtime')) {
    /**
     * @author: 布尔
     * @name: 内部定制获取毫秒时间戳
     * @return {int} $r
     */
    function y_microtime(): int
    {
        return (int)(microtime(true) * 1000);
    }
}
