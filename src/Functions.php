<?php
/*
 * @author: 布尔
 * @name: 通用函数
 * @desc: 介绍
 * @LastEditTime: 2024-04-29 14:11:37
 */

declare(strict_types=1);

use Firebase\JWT\JWT;
use Hyperf\Contract\SessionInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Context\Context;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Server\ServerFactory;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;
use App\Constants\ErrorCode;
use App\Exception\EyCException;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Context\ApplicationContext;
use function Hyperf\Support\env;

if (!function_exists('container')) {
    /**
     * 容器实例
     * @return \Psr\Container\ContainerInterface
     */
    function container()
    {
        return ApplicationContext::getContainer();
    }
}

if (!function_exists('redis')) {
    /**
     * redis 客户端实例 get(查询) set(设置) del(删除)
     * @return \Hyperf\Redis\Redis|mixed
     */
    function redis()
    {
        return container()->get(Hyperf\Redis\Redis::class);
    }
}

if (!function_exists('redis_factory')) {
    /**
     * redis 自定义redis库 客户端实例 get(查询) set(设置) del(删除)
     * @return \Hyperf\Redis\RedisFactory|mixed
     */
    function redis_factory(string $name)
    {
        return container()->get(Hyperf\Redis\RedisFactory::class)->get($name);
    }
}

if (!function_exists('server')) {
    /**
     * server 实例 基于 swoole server
     * @return \Swoole\Coroutine\Server|\Swoole\Server
     */
    function server()
    {
        return container()->get(ServerFactory::class)->getServer()->getServer();
    }
}

if (!function_exists('frame')) {
    /**
     * websocket frame 实例
     * @return mixed|Frame
     */
    function frame()
    {
        return container()->get(Frame::class);
    }
}

if (!function_exists('websocket')) {
    /**
     * websocket 实例
     * @return mixed|WebSocketServer
     */
    function websocket()
    {
        return container()->get(WebSocketServer::class);
    }
}

if (!function_exists('cache')) {
    /**
     * 缓存实例 简单的缓存
     * @return mixed|\Psr\SimpleCache\CacheInterface
     */
    function cache()
    {
        return container()->get(Psr\SimpleCache\CacheInterface::class);
    }
}

if (!function_exists('bug')) {
    /**
     * 向控制台输出日志
     * @return StdoutLoggerInterface|mixed
     */
    function bug()
    {
        return container()->get(StdoutLoggerInterface::class);
    }
}

if (!function_exists('logger')) {
    /**
     * 向日志文件记录日志
     * @return \Psr\Log\LoggerInterface
     */
    function logger()
    {
        return container()->get(LoggerFactory::class)->make();
    }
}

if (!function_exists('request')) {
    /**
     * 请求对象
     * @return mixed|RequestInterface
     */
    function request()
    {
        return container()->get(RequestInterface::class);
    }
}
/**
 * @author: 风源
 * @name: 直接获取前台发送的值
 * @param {*}
 * @return {*}
 */
if (!function_exists('eyv')) {
    /**
     * 请求对象
     * @return mixed|RequestInterface
     */
    function eyv(string $str)
    {
        return container()->get(RequestInterface::class)->input($str) ?? "";
    }
}
if (!function_exists('in_json')) {
    /**
     * @author: 风源
     * @name: 查找字符串是否在JSON字符串内
     * @param {string} $param 被查找关键字或数组
     * @param {string} $str  查找的字符串
     * @param {string} $val  被查找关数组中指定的字段
     * @param {string} $keyword  查找字符串指定值
     
     * @return {*}
     */
    function in_json($param, $str, string $val = "", string $keyword = "")
    {
        if ($val) {
            if (isset($param[$val])) {
                $key = $param[$val];
            } else {
                return false;
            }
        } else {
            $key = $param;
        }
        if (empty($key) && $key != 0 || empty($str)) {
            return false;
        }
        $keyword = $keyword ? "\"" . $keyword . "\"" : "";
        if (is_int($key)) {
            $r = preg_match('/' . $keyword . ':(\s*)+' . $key . '[,}]/i', $str);
        } else {
            $r = preg_match('/' . $keyword . ':(\s*)+"' . preg_quote((string)$key, '/') . '"/i', $str);
        }
        return $r;
    }
}

if (!function_exists('response')) {
    /**
     * 请求回应对象
     * @return ResponseInterface|mixed
     */
    function response()
    {
        return container()->get(ResponseInterface::class);
    }
}

if (!function_exists('session')) {
    /**
     * session 对象
     * @return SessionInterface|mixed
     */
    function session()
    {
        return container()->get(SessionInterface::class);
    }
}

if (!function_exists('set')) {
    /**
     * session 插入全局变量
     * @param string $key  键
     * @param string|array $val  值
     * @return string|array
     */
    function set(string $key, $val = null)
    {
        $con = container()->get(Context::class);
        return $con::set($key, $val);
    }
}

if (!function_exists('get')) {
    /**
     * session 获取全局变量
     * @param  string $key  键
     * @return string|array
     */
    function get(string $key)
    {
        $con = container()->get(Context::class);
        return $con::get($key);
    }
}

if (!function_exists('has')) {
    /**
     * session 检测环境变量是否被设置
     * @param  string $key  键
     * @return string|array
     */
    function has(string $key)
    {
        $con = container()->get(Context::class);
        return $con::has($key);
    }
}

if (!function_exists('eyc_array_key')) {
    /**
     * @brief 返回数据指定值的键值对
     * @param array $arr   数组
     * @param string $key   指定键值用, 分割 如字段不一致 用 新键名|原键名
     * @param bool  $empty_value   是否取空值
     * @return array
     */
    function eyc_array_key(array $arr, string $key, bool $empty_value = true): array
    {
        $array = explode(",", $key);
        $v = array();
        foreach ($array as $rs) {
            if (substr_count($rs, "|")) {
                $c = explode("|", $rs);
                if (isset($arr[$c[1]])) {
                    /* 是否取空值 */
                    if (!empty($arr[$c[1]]) || empty($arr[$c[1]]) && $empty_value) {
                        $v[$c[0]] = $arr[$c[1]];
                    }
                }
            } else {
                if (isset($arr[$rs])) {
                    /* 是否取空值 */
                    if (!empty($arr[$rs]) || empty($arr[$rs]) && $empty_value) {
                        $v[$rs] = $arr[$rs];
                    }
                }
            }
        }
        return $v;
    }
}
if (!function_exists('eyc_array_insert')) {
    /**
     * @brief 插入指定数据相应的键值对
     * @param array $new   新数组   
     * @param array $old   原数组
     * @param string $key  指定键值用, 分割 如字段不一致 用 新键名|原键名
     * @param bool  $empty_value   是否取空值
     * @return array
     */
    function eyc_array_insert(array $new, array $old, string $key, bool $empty_value = true): array
    {
        $array = explode(",", $key);
        foreach ($array as $rs) {
            if (substr_count($rs, "|")) {
                $c = explode("|", $rs);
                if (isset($old[$c[1]])) {
                    if (!empty($old[$c[1]]) || empty($old[$c[1]]) && $empty_value) {
                        $new[$c[0]] = $old[$c[1]];
                    }
                }
            } else {
                if (isset($old[$rs])) {
                    if (!empty($old[$rs]) || empty($old[$rs]) && $empty_value) {
                        $new[$rs] = $old[$rs];
                    }
                }
            }
        }
        return $new;
    }
}

if (!function_exists('eydj')) {
    /**
     * @brief jsonrpc数据接收过滤
     * @param array $param   接收数据
     * @param string $key   建字符串,分割 :1 必穿
     * @return array 
     */
    function eydj(array $param, string $key): array
    {
        $array = explode(",", $key);
        $r = array();
        foreach ($array as $rs) {
            if (substr_count($rs, ":")) {
                $c = explode(":", $rs);
                if ($c[1] == 1 && $param[$c[0]] === null) {
                    error(501, '缺少必要参数:' . $c[0]);
                }
                $r[$c[0]] = $param[$c[0]];
            } else {
                if (isset($param[$rs])) {
                    $r[$rs] = $param[$rs];
                }
            }
        }
        return $r;
    }
}

if (!function_exists('jwt_encode')) {
    /**
     * @brief jwt加密
     * @param array $payload  加密数据
     * @return string $jwt 加密结果
     */
    function jwt_encode(array $payload): string
    {
        return JWT::encode($payload, env('JWT_KEY'));
    }
}
if (!function_exists('jwt_decode')) {
    /**
     * @brief jwt解密
     * @param string $jwt jwt加密字符串
     * @return array $payload 解密数据
     */
    function jwt_decode(string $jwt)
    {
        return JWT::decode($jwt, env('JWT_KEY'), array('HS256'));
    }
}
if (!function_exists('output')) {
    /**
     * @brief 原样输出
     * @param mixed $result 输出内容
     * @return array $r 返回数据
     */
    function output(mixed $result): array
    {
        return array('output' => 1, 'result' => $result);
    }
}

if (!function_exists('error')) {
    /**
     * @brief 异常返回
     * @param int $errcode 错误状态
     * @param string $errmsg 提示信息
     * @return array $r 返回数据
     */
    function error(int $errcode = ErrorCode::SERVER_ERROR, ?string $errmsg = null)
    {
        throw new EyCException($errcode, $errmsg);
    }
}

if (!function_exists('get_number')) {
    /**
     * @brief 获取编号
     * @return string $prefix  编号前缀
     * @return string $r 返回数据
     */
    function get_number($prefix = ''): string
    {
        do {
            $number = $prefix . date('YmdHis', time()) . mt_rand(111111, 999999);
            /* 检测一秒内是否重复 */
        } while (redis()->get($number));
        /* 插入一秒缓存 */
        redis()->set($number, 1, 1);
        return $number;
    }
}

if (!function_exists('get_rand_str')) {
    /**
     * @brief 获取随机字符串
     * @return string $length  字符串长度
     * @return string $r 返回数据
     */
    function get_rand_str($length = 32): string
    {
        do {
            $str = '';
            $str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
            $max = strlen($str_pol) - 1;
            for ($i = 0; $i < $length; $i++) {
                $str .= $str_pol[rand(0, $max)]; //rand($min,$max)生成介于min和max两个数之间的一个随机整数
            }
            /* 检测一秒内是否重复 */
        } while (redis()->get($str));
        /* 插入一秒缓存 */
        redis()->set($str, 1, 1);
        return $str;
    }
}

if (!function_exists('get_week')) {
    /**
     * @author: 布尔
     * @name: 获取某一天当前周日期信息
     * @param {string} $date 查询日期 
     * @param {string} $format 返回日期格式
     * @return {array} $r
     */
    function get_week(string $date = '', string $format = 'Y-m-d'): array
    {
        $time = $date != '' ? strtotime($date) : time();
        //获取当前周几
        $week = date('w', $time);
        $r = [];
        for ($i = 1; $i <= 7; $i++) {
            $r[$i] = date($format, strtotime('+' . $i - $week . ' days', $time));
        }
        return $r;
    }
}

if (!function_exists('get_month')) {
    /**
     * @author: 布尔
     * @name: 获取某一天当前月日期信息
     * @param {string} $date 查询日期 
     * @param {string} $format 返回日期格式
     * @return {array} $r
     */
    function get_month(string $date = '', string $format = 'Y-m-d'): array
    {
        $r = [];
        if ($date) {
            $firstDay = date('Y-m-01', strtotime($date));
        } else {
            $firstDay = date('Y-m-01', time());
        }
        $i = 0;
        $lastDay = date('Y-m-d', strtotime("$firstDay +1 month -1 day"));
        while (date('Y-m-d', strtotime("$firstDay +$i days")) <= $lastDay) {
            $r[] = date($format, strtotime("$firstDay +$i days"));
            $i++;
        }
        return $r;
    }
}

if (!function_exists('timech')) {
    /**
     * @author: 布尔
     * @name: 时间处理
     * @param {string|int} $time 时间
     * @param {string} $type 返回时间格式
     * @param {string} $endtime 结束时间(增加或减少时间值只能为int类型，不能为ffloat类型)
     * @return {string|int} $r 返回数据
     */
    function timech($time, string $type = "", string $endtime = "")
    {
        if (is_numeric($time) && !is_int($time)) {
            $time = (int)$time;
        } else {
            if (!ctype_digit($time)) $time = strtotime($time);
        }
        if ($endtime) {
            $f = explode(",", $endtime);
            $tp = match ($f[0]) {
                "y" => "years",
                "m" => "months",
                "d" => "days",
                "w" => "weeks",
                "h" => "hours",
                "i" => "minutes",
            };
            $time = strtotime($f[1] . $tp, $time);
        }
        return $type ? date($type, $time) : $time;
    }
}

if (!function_exists('get_config')) {
    /**
     * @brief 获取系统配置(同内置函数config()作用一样)
     * @param string $key 关键词
     * @return {*} $value 配置内容
     */
    function get_config(string $key)
    {
        return container()->get(ConfigInterface::class)->get($key);
    }
}

if (!function_exists('set_config')) {
    /**
     * @brief 设置系统配置
     * @param string $key 关键词
     * @param string $val 值
     * @return {*} $r
     */
    function set_config(string $key, $val)
    {
        return container()->get(ConfigInterface::class)->set($key, $val);
    }
}

if (!function_exists('download_remote_file')) {
    /**
     * @brief 下载远程文件至本地返回文件本地相对路径
     * @param string $file 远程文件
     * @param string $download_path 文件本地存储相对路径
     * @param string $file_name 文件名称
     * @param string $val 值
     * @return {*} $r
     */
    function download_remote_file(string $file, string $download_path = '/public/download', string $file_name = ''): string
    {
        /* 判断目录是否存在 */
        $dir = BASE_PATH . $download_path;
        if (!is_dir($dir)) {
            /* 创建目录 */
            mkdir($dir, 0755, true);
        }
        /* 获取文件资源 */
        $file_obj = file_get_contents($file);
        $file_url = $dir . '/' . $file_name;
        /* 写入文件到本地 */
        file_put_contents($file_url, $file_obj);
        /*删除文件资源 */
        unset($image_obj);
        return $file_url;
    }
}
if (!function_exists('get_base64img_info')) {
    /**
     * @brief 获取base64图片的后缀和大小
     */
    function get_base64img_info($base64img)
    {
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64img, $result)) {
            $img_result['suffix'] = $result[2];
            $base_img = str_replace($result[1], '', $base64img);
            $base_img = str_replace('=', '', $base_img);
            $img_len = strlen($base_img);
            $file_size = intval($img_len - ($img_len / 8) * 2);
            $img_result['size'] = $file_size; //B
            return $img_result;
        }
    }
}

if (!function_exists('get_ip')) {
    /**
     * @brief 获取来访客户端ip
     * @return {string} $r
     */
    function get_ip(): string
    {
        $res = container()->get(RequestInterface::class)->getServerParams();
        if (isset($res['http_client_ip'])) {
            return $res['http_client_ip'];
        } elseif (isset($res['http_x_real_ip'])) {
            return $res['http_x_real_ip'];
        } elseif (isset($res['http_x_forwarded_for'])) {
            //部分CDN会获取多层代理IP，所以转成数组取第一个值
            $arr = explode(',', $res['http_x_forwarded_for']);
            return $arr[0];
        } else {
            return $res['remote_addr'];
        }
    }
}

if (!function_exists('download')) {
    /**
     * @brief 文件下载
     * @param mixed $result 输出内容
     * @return array $r 返回数据
     */
    function download(string $file_path): array
    {
        return array('download' => 1, 'file_path' => $file_path);
    }
}

if (!function_exists('string_character_handle')) {
    /**
     * @brief 字符串特殊符号处理函数
     * @param string $string 输入字符串
     * @param bool $replace 是否替换,替换模式返回替换后字符串,不替换返回是否包含特殊字符
     * @param bool $replacement 用于替换的字符串
     * @return mixed $r 返回数据
     */
    function string_character_handle(string $string, $replace = false, string $replacement = ""): string|bool
    {
        //中文标点
        $char = "。、！？：；﹑•＂…‘’“”〝〞∕¦‖—　〈〉﹞﹝「」‹›〖〗】【»«』『〕〔》《﹐¸﹕︰﹔！¡？¿﹖﹌﹏﹋＇´ˊˋ―﹫︳︴¯＿￣﹢﹦﹤‐­˜﹟﹩﹠﹪﹡﹨﹍﹉﹎﹊ˇ︵︶︷︸︹︿﹀︺︽︾ˉ﹁﹂﹃﹄︻︼（）";
        /* 正则数组 */
        $pattern = array(
            "/[[:punct:]]/i", //英文标点符号
            '/[' . $char . ']/u', //中文标点符号
            '/[ ]{2,}/'
        );
        $r = preg_replace($pattern, $replacement, $string);
        /* 替换模式 */
        if ($replace) {
            return $r;
        }
        /* 判断是否包含特殊字符 */
        if ($r == $string) {
            return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('get_md5_sign')) {
    /**
     * @author: 布尔
     * @name: md5加密签名
     * @param {array} $params 请求参数
     * @param {string} $appsecret 密钥
     * @return {string} 签名
     */
    function get_md5_sign(array $params, string $appsecret): string
    {
        /* ASCII对请求参数排序 */
        if (!empty($params)) {
            $p =  ksort($params);
            if ($p) {
                $str = '';
                foreach ($params as $k => $val) {
                    $str .= $k . '=' . $val . '&';
                }
                /* 拼接密钥 */
                $str .= $appsecret;
                /* MD5加密并 转为大写 */
                return strtoupper(MD5($str));
            }
        }
        return '';
    }
}

if (!function_exists('amqp_producer')) {
    /**
     * Amqp Producer 客户端实例
     * @return \Hyperf\Amqp\Producer|mixed
     */
    function amqp_producer()
    {
        return container()->get(Hyperf\Amqp\Producer::class);
    }
}

if (!function_exists('redis_get')) {
    /**
     * @author: 布尔
     * @name: 内部定制redis get方法
     * @param {string} $key key
     * @param {string} $service 服务
     * @return  $r
     */
    function redis_get(string $key, string $service = '')
    {
        return false;
        if (!$service) {
            $service = env('APP_NAME');
        }
        $cache_key = $service . ':' . $key;
        return redis()->get($cache_key);
    }
}

if (!function_exists('redis_set')) {
    /**
     * @author: 布尔
     * @name: 内部定制redis set方法
     * @param {string} $key key
     * @param {string} $value value
     * @param {int} $time 过期时间
     * @param {string} $service 服务
     * @return  $r
     */
    function redis_set(string $key, string $value, int $time = 0, string $service = '')
    {
        return false;
        if (!$service) {
            $service = env('APP_NAME');
        }
        $cache_key = $service . ':' . $key;
        if ($time) {
            return redis()->set($cache_key, $value, $time);
        } else {
            return redis()->set($cache_key, $value);
        }
    }
}

if (!function_exists('redis_del')) {
    /**
     * @author: 布尔
     * @name: 内部定制redis del方法
     * @param {string} $key key
     * @param {string} $service 服务
     * @return  $r
     */
    function redis_del(string $key, string $service = '')
    {
        return false;
        if (!$service) {
            $service = env('APP_NAME');
        }
        $cache_key = $service . ':' . $key;
        $iterator = null;
        $del_cache_key = [];
        do {
            $keys = redis()->scan($iterator, $cache_key); // 使用SCAN命令迭代元素
            if ($keys) {
                $del_cache_key = array_merge($del_cache_key, $keys);
            }
        } while ($iterator > 0);
        return redis()->del($del_cache_key);
    }
}

if (!function_exists('check_time')) {
    /**
     * @author: 布尔
     * @name: 检测时间格式是否正确
     * @param {array} $time 传入时间
     * @param {string} $format 时间格式 Y-m-d H:i:s
     * @return {bool} bool
     */
    function check_time($time, $format = 'Y-m-d H:i:s')
    {
        $dateTime = DateTime::createFromFormat($format, $time);
        return $dateTime && $dateTime->format($format) === $time;
    }
}

if (!function_exists('check_mobile')) {
    /**
     * @author: 布尔
     * @name: 检测手机号格式是否正确
     * @param {int} $mobile 手机号
     * @return {bool} bool
     */
    function check_mobile($mobile)
    {
        // 中国手机号通常以1开头，第二位是3,4,5,6,7,8,9中的一个，后面跟着9个数字
        $pattern = '/^1[3456789]\d{9}$/';
        if (preg_match($pattern, $mobile)) {
            return true;
        } else {
            return false;
        }
    }
}
