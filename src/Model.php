<?php

/*
 * @author: 布尔
 * @name: 数据模型类
 * @desc: 介绍
 * @LastEditTime: 2023-06-29 22:17:52
 */

declare(strict_types=1);

namespace Eykj\Base;

use Hyperf\DbConnection\Model\Model as BaseModel;
use Hyperf\Di\Annotation\Inject;
use Eykj\Base\CreateTable;
use Hyperf\HttpServer\Contract\RequestInterface;

abstract class Model extends BaseModel
{
    #[Inject]
    protected RequestInterface $request;

    #[Inject]
    protected CreateTable $CreateTable;
    /**
     * 是否做表拆分
     *
     * @var string
     */
    protected $split_table = 0;
    /**
     * @author: 布尔
     * @name: 拆分表
     */
    public function post_split_table(array $param = []): void
    {
        if ($this->split_table == 1 && (isset($param['corpid']) || get('corpid'))) {
            if (isset($param['corpid'])) {
                $table_name = $this->target_table . '_' . $param['corpid'];
            } else {
                $table_name = $this->target_table . '_' . get('corpid');
            }
            if (!redis()->get("split_table_" . $table_name)) {
                $this->CreateTable->post_create_table($table_name, $this->target_table, $this->table_comment);
                redis()->set("split_table_" . $table_name, true);
            }
            /* 修改表名*/
            $this->table = $table_name;
        }
    }
    /**
     * @author: 布尔
     * @name: 列表
     * @param array $filter   查询条件
     * @param array $key     查询字段
     * @param int $per_page   每页条数
     * @param int $page   每页条数
     * @param array $order   排序
     * @param string|bool $distinct   是否去重
     * @param array $add_select   追加字段
     * @param string|array $group   分组
     * @param array $having   分组筛选
     * @param array $having_raw  原生分组筛选
     * @param array $or_having_raw  原生分组筛选
     * @param string $select_raw  原生select
     * @param cache_switch $true 是否开启缓存
     * @return array $r  返回数据
     */
    public function get_ls(array $filter = [], array $key = [], int $per_page = 10, array $order = [], ?int $page = 0, string|bool $distinct = false, array $add_select = [], string|array $group = '', array $having = [], array $having_raw = [], array $or_having_raw = [], string $select_raw = '', bool $cache_switch = true): array
    {
        /* 检测是否拆分表 */
        $this->post_split_table($filter);
        if (isset($filter["keyword"])) {
            unset($filter["keyword"]);
        }
        /* 判断是否开启缓存 */
        if ($cache_switch) {
            /* 查询缓存 */
            $cache_key = [];
            if ($filter) {
                ksort($filter);
                $cache_key[] = $filter;
            }
            if ($key) {
                $cache_key[] = $key;
            }
            if ($per_page) {
                $cache_key[] = $per_page;
            }
            if ($order) {
                $cache_key[] = $order;
            }
            if (!$page) {
                $page = (int)$this->request->input('page');
            }
            $cache_key[] = $page;
            if ($distinct) {
                $cache_key[] = $distinct;
            }
            if ($add_select) {
                $cache_key[] = $add_select;
            }
            if ($group) {
                $cache_key[] = $group;
            }
            if ($having) {
                $cache_key[] = $having;
            }
            if ($having_raw) {
                $cache_key[] = $having_raw;
            }
            if ($or_having_raw) {
                $cache_key[] = $or_having_raw;
            }
            if ($select_raw) {
                $cache_key[] = $select_raw;
            }
            $cache = $this->get_cache('ls', $cache_key);
            /* 返回缓存 */
            if ($cache) {
                unset($cache_key);
                return $cache;
            }
        }
        //如果有搜索关键字，不在查询范围
        $query = $this->filter_format($this, $filter);
        if ($key) {
            $query = $query->select($key);
        }
        if ($select_raw) {
            $query = $query->selectRaw($select_raw);
        }
        if ($add_select) {
            $query = $query->addSelect($add_select);
        }
        if ($group) {
            $query = $query->groupBy($group);
        }
        if ($having) {
            $query = $query->having($having[0], $having[1], $having[2]);
        }
        if ($having_raw) {
            $query = $query->havingRaw($having_raw[0], $having_raw[1]);
        }
        if ($or_having_raw) {
            $query = $query->orHavingRaw($or_having_raw[0], $or_having_raw[1]);
        }
        if ($order) {
            $query = $this->order_format($query, $order);
        } else {
            $query = $query->orderBy('id', 'desc');
        }
        if ($distinct) {
            $query = $query->distinct();
        }
        $query = $page ? $query->paginate($per_page, ['*'], 'page', $page) : $query->paginate($per_page);
        $r = $query ? $query->toArray() : [];
        /* 判断是否开启缓存 */
        if ($cache_switch) {
            /* 写入缓存 */
            $this->set_cache('ls', $cache_key, $r);
        }
        return $r;
    }
    /**
     * @author: 布尔
     * @name: 获取随机数据
     * @param array $filter   查询条件
     * @param array $key     查询字段
     * @param int $take    获取条数
     * @return array $r  返回数据
     */
    public function get_rand(array $filter = [], array $key = [], int $take = 10): array
    {
        /* 检测是否拆分表 */
        $this->post_split_table($filter);
        $query = $this->filter_format($this, $filter);
        if ($key) {
            $query = $query->select($key);
        }
        $query = $take ? $query->take($take) : $query->take(10);
        $query = $query->inRandomOrder()->get();
        return $query ? $query->toArray() : [];
    }
    /**
     * @author: 布尔
     * @name: 全部
     * @param array $filter   查询条件
     * @param array $key     返回字段
     * @param array $order   排序
     * @param string|bool $distinct   是否去重
     * @param array $add_select   追加字段
     * @param string|array $group   分组
     * @param array $having   分组筛选
     * @param array $having_raw  原生分组筛选
     * @param array $or_having_raw  原生分组筛选
     * @param string $select_raw  原生select
     * @param string $offset  跳过数量
     * @param string $limit  取数量
     * @param cache_switch $true 是否开启缓存
     * @return array $r  返回数据
     */
    public function get_all(array $filter = [], array $key = [], array $order = [], string|bool $distinct = false, array $add_select = [], string|array $group = '', array $having = [], array $having_raw = [], array $or_having_raw = [], string $select_raw = '', int $offset = 0, int $limit = 0, bool $cache_switch = true): array
    {
        /* 检测是否拆分表 */
        $this->post_split_table($filter);
        if (isset($filter["keyword"])) {
            unset($filter["keyword"]);
        }
        /* 判断是否开启缓存 */
        if ($cache_switch) {
            /* 查询缓存 */
            $cache_key = [];
            if ($filter) {
                ksort($filter);
                $cache_key[] = $filter;
            }
            if ($key) {
                $cache_key[] = $key;
            }
            if ($order) {
                $cache_key[] = $order;
            }
            if ($distinct) {
                $cache_key[] = $distinct;
            }
            if ($add_select) {
                $cache_key[] = $add_select;
            }
            if ($group) {
                $cache_key[] = $group;
            }
            if ($having) {
                $cache_key[] = $having;
            }
            if ($having_raw) {
                $cache_key[] = $having_raw;
            }
            if ($or_having_raw) {
                $cache_key[] = $or_having_raw;
            }
            if ($select_raw) {
                $cache_key[] = $select_raw;
            }
            if ($offset) {
                $cache_key[] = $offset;
            }
            if ($limit) {
                $cache_key[] = $limit;
            }
            $cache = $this->get_cache('all', $cache_key);
            /* 返回缓存 */
            if ($cache) {
                unset($cache_key);
                return $cache;
            }
        }
        //如果有搜索关键字，不在查询范围
        $query = $this->filter_format($this, $filter);
        if ($key) {
            $query = $query->select($key);
        }
        if ($select_raw) {
            $query = $query->selectRaw($select_raw);
        }
        if ($add_select) {
            $query = $query->addSelect($add_select);
        }
        if ($group) {
            $query = $query->groupBy($group);
        }
        if ($having) {
            $query = $query->having($having[0], $having[1], $having[2]);
        }
        if ($having_raw) {
            $query = $query->havingRaw($having_raw[0], $having_raw[1]);
        }
        if ($or_having_raw) {
            $query = $query->orHavingRaw($or_having_raw[0], $or_having_raw[1]);
        }
        if ($offset) {
            $query = $query->offset($offset);
        }
        if ($limit) {
            $query = $query->limit($limit);
        }
        if ($order) {
            $query = $this->order_format($query, $order);
        } else {
            $query = $query->orderBy('id', 'desc');
        }
        $query = $distinct ? $query->distinct()->get() : $query->get();
        $r = $query ? $query->toArray() : [];
        /* 判断是否开启缓存 */
        if ($cache_switch) {
            /* 写入缓存 */
            $this->set_cache('all', $cache_key, $r);
        }
        return $r;
    }
    /**
     * @author: 布尔
     * @name: 详情
     * @param array $filter   查询条件
     * @param array $key     查询字段
     * @param array $add_select   追加字段
     * @param array $order   排序
     * @param bool $shared_lock 共享锁 
     * @param bool $lock_for_update 排他锁
     * @param string $select_raw 原生select
     * @param string|array $group   分组
     * @param cache_switch $true 是否开启缓存
     * @return array $r  返回数据
     */
    public function get_info(array $filter, array $key = [], array $add_select = [], array $order = [], bool $shared_lock = false, bool $lock_for_update = false, string $select_raw = '', string|array $group = '', bool $cache_switch = true): array
    {
        /* 检测是否拆分表 */
        $this->post_split_table($filter);
        if (!$shared_lock && !$lock_for_update && $cache_switch) {
            /* 查询缓存 */
            $cache_key = [];
            if ($filter) {
                /* 排序 */
                ksort($filter);
                $cache_key[] = $filter;
            }
            if ($key) {
                $cache_key[] = $key;
            }
            if ($add_select) {
                $cache_key[] = $add_select;
            }
            if ($order) {
                $cache_key[] = $order;
            }
            if ($select_raw) {
                $cache_key[] = $select_raw;
            }
            if ($group) {
                $cache_key[] = $group;
            }
            $cache = $this->get_cache('info', $cache_key);
            /* 返回缓存 */
            if ($cache) {
                unset($cache_key);
                return $cache;
            }
        }
        $query = $this->filter_format($this, $filter);
        if ($key) {
            $query = $query->select($key);
        }
        if ($select_raw) {
            $query = $query->selectRaw($select_raw);
        }
        if ($add_select) {
            $query = $query->addSelect($add_select);
        }
        if ($group) {
            $query = $query->groupBy($group);
        }
        if ($order) {
            $query = $this->order_format($query, $order);
        } else {
            $query = $query->orderBy('id', 'desc');
        }
        if ($shared_lock) {
            $query = $query->sharedLock();
        }
        if ($lock_for_update) {
            $query = $query->lockForUpdate();
        }
        $query = $query->first();
        $r = $query ? $query->toArray() : [];
        if (!$shared_lock && !$lock_for_update && $cache_switch) {
            /* 写入缓存 */
            $this->set_cache('info', $cache_key, $r);
        }
        return $r;
    }
    /**
     * @author: 布尔
     * @name: 获取指定条件的单字段值
     * @param array $filter   查询条件
     * @param string $key     查询字段
     * @return string|int|null $r 返回数据
     */
    public function get_value(array $filter, string $key, array $order = []): string|int|null
    {
        /* 检测是否拆分表 */
        $this->post_split_table($filter);
        $query = $this->filter_format($this, $filter);
        if ($order) {
            $query = $this->order_format($query, $order);
        } else {
            $query = $query->orderBy('id', 'desc');
        }
        return $query->value($key);
    }
    /**
     * @author: 布尔
     * @name: 是否存在存在
     * @param array $filter   查询条件
     * @return bool $r 返回数据
     */
    public function get_exists(array $filter): bool
    {
        /* 检测是否拆分表 */
        $this->post_split_table($filter);
        $query = $this->filter_format($this, $filter);
        return $query->exists();
    }
    /**
     * @author: 布尔
     * @name: 查询数量
     * @param array $filter   查询条件
     * @param string|bool $distinct   是否去重
     * @param string|array $group   分组
     * @return int|null $r 返回数据
     */
    public function get_count(array $filter, string|bool $distinct = false, string|array $group = ''): int|null
    {
        /* 检测是否拆分表 */
        $this->post_split_table($filter);
        $query = $this->filter_format($this, $filter);
        if ($group) {
            $query = $query->groupBy($group);
        }
        return $distinct ? $query->distinct()->count($distinct) : $query->count();
    }

    /**
     * @author: 布尔
     * @name: 计算总和
     * @param array $filter   查询条件
     * @param string $val   计算总和字段
     * @return float $r 返回数据
     */
    public function get_sum(array $filter, string $val): float
    {
        /* 检测是否拆分表 */
        $this->post_split_table($filter);
        $query = $this->filter_format($this, $filter);
        return (float) $query->sum($val);
    }
    /**
     * @author: 布尔
     * @name: 更新添加
     * @param array $key   查询条件/插入内容
     * @param array $val   更新内容
     * @return int $r 返回数据
     */
    public function post_add(array $key, array $val = []): int
    {
        /* 检测是否拆分表 */
        $this->post_split_table($key);
        if ($val) {
            $this->updateOrInsert($key, $val);
            /* 删除缓存 */
            $this->del_cache('ls');
            $this->del_cache('all');
            return 1;
        } else {
            $r = $this->insertGetId($key);
            /* 删除缓存 */
            $this->del_cache('ls');
            $this->del_cache('all');
            return $r;
        }
    }
    /**
     * @author: 布尔
     * @name: 批量添加
     * @param array $val 添加内容
     * @return bool $r 返回数据
     */
    public function post_batch_add(array $val)
    {
        /* 检测是否拆分表 */
        $this->post_split_table($val[0]);
        $r = $this->insert($val);
        if ($r) {
            /* 删除缓存 */
            $this->del_cache('ls');
            $this->del_cache('all');
        }
        return $r;
    }
    /**
     * @author: 布尔
     * @name: 更新
     * @param array $filter   查询条件
     * @param array $val     更新内容
     * @param bool $lock    是否检测数据锁
     * @return int $r 返回数据
     */
    public function post_modify(array $filter, array $val, bool $lock = true): int
    {
        /* 检测是否拆分表 */
        $this->post_split_table($filter);
        $query = $this->filter_format($this, $filter);
        /* 检测数据锁 */
        $this->check_lock($query, $lock);
        $r = $query->update($val);
        if ($r) {
            /* 删除缓存 */
            $this->del_cache();
        }
        return $r;
    }
    /**
     * @author: 布尔
     * @name: 删除
     * @param array $filter   查询条件
     * @param bool $lock    是否检测数据锁
     * @return int $r 返回数据
     */
    public function post_del(array $filter, bool $lock = true): int
    {
        /* 检测是否拆分表 */
        $this->post_split_table($filter);
        $query = $this->filter_format($this, $filter);
        /* 检测数据锁 */
        $this->check_lock($query, $lock);
        $r = $query->delete();
        if ($r) {
            /* 删除缓存 */
            $this->del_cache();
        }
        return $r;
    }
    /**
     * @author: 布尔
     * @name: 自增
     * @param string $key   更新字段
     * @param float   $val    修改量
     * @param array $filter  查询条件
     * @return int $r 返回数据
     */
    public function post_increment(string $key, float $val = 1, array $filter = []): int
    {
        /* 检测是否拆分表 */
        $this->post_split_table($filter);
        if ($filter) {
            $query = $this->filter_format($this, $filter);
            $r = $query->increment($key, $val);
        } else {
            $r = $this->increment($key, $val);
        }
        if ($r) {
            /* 删除缓存 */
            $this->del_cache();
        }
        return $r;
    }
    /**
     * @author: 布尔
     * @name: 自减
     * @param string $key    更新字段
     * @param float   $val     修改量
     * @param array $filter  查询条件
     * @return int $r  返回数据
     */
    public function post_decrement(string $key, float $val = 1, array $filter = []): int
    {
        /* 检测是否拆分表 */
        $this->post_split_table($filter);
        if ($filter) {
            $query = $this->filter_format($this, $filter);
            $r = $query->decrement($key, $val);
        } else {
            $r = $this->decrement($key, $val);
        }
        if ($r) {
            /* 删除缓存 */
            $this->del_cache();
        }
        return $r;
    }
    /**
     * @author: 布尔
     * @name: filter格式化
     * @param object $query model类实例
     * @param array $fiter 条件
     * @return object 
     */
    public function filter_format(object $query, array $filter): object
    {
        $where = [];
        foreach ($filter as $k => $v) {
            $arr = [];
            if (is_array($v)) {
                switch ($v['act']) {
                    case 'in':
                        $query = $query->whereIn($k, $v['val']);
                        break;
                    case 'not_in':
                        $query = $query->whereNotIn($k, $v['val']);
                        break;
                    case 'json':
                        $query = $query->whereJsonContains($k, $v['val']);
                        break;
                    case 'between':
                        $query = $query->whereBetween($k, $v['val']);
                        break;
                    case 'not_between':
                        $query = $query->whereNotBetween($k, $v['val']);
                        break;
                    case 'raw':
                        $query = $query->whereRaw($v['val']);
                        break;
                    case '>=':
                        $query = $query->where($k, '>=', $v['val']);
                        break;
                    case '<>':
                        $query = $query->where($k, '<>', $v['val']);
                        break;
                    case '<=':
                        $query = $query->where($k, '<=', $v['val']);
                        break;
                    case 'null':
                        $query = $query->whereNull($v['val']);
                        break;
                    case 'notnull':
                        $query = $query->whereNotNull($v['val']);
                        break;
                    default:
                        $arr[] = $k;
                        $arr[] = $v['act'];
                        $arr[] = $v['val'];
                        $where[] = $arr;
                        break;
                }
            } else {
                $arr[] = $k;
                $arr[] = '=';
                $arr[] = $v;
                $where[] = $arr;
            }
        }
        if ($where) {
            $query = $query->where($where);
        }
        return $query;
    }
    /**
     * @author: 布尔
     * @name: order格式化
     * @param object $query model类实例
     * @param array $order 排序数据
     */
    public function order_format(object $query, array $order)
    {
        if (is_array($order[0])) {
            foreach ($order as $k => $v) {
                $query = $query->orderBy($v[0], $v[1]);
            }
            return $query;
        } else {
            return  $query->orderBy($order[0], $order[1]);
        }
    }
    /**
     * @author: 布尔
     * @name: 检测数据锁
     * @param {object} $query
     * @param {bool} $lock
     */
    public function check_lock(object $query, bool $lock): void
    {
        if ($lock) {
            $lock_query = clone $query;
            $info = $lock_query->orderBy('id', 'desc')->first();
            unset($lock_query);
            if (isset($info['lock'])) {
                if ($info['lock'] == 1) {
                    /* 检测是否为管理员 */
                    $admin = get('admin');
                    if ($admin != 1) {
                        error(505);
                    }
                }
            }
        }
    }

    /**
     * @author: 布尔
     * @name:  获取缓存
     * @param {string} $act
     * @param {array} $cache_key
     * @return {*}
     */
    public function get_cache(string $act, array $cache_key)
    {
        $key = $this->table . ':' . $act . ':' . md5(json_encode($cache_key));
        $value = redis_get($key);
        if ($value) {
            return y_json_decode($value);
        }
        return [];
    }

    /**
     * @author: 布尔
     * @name:  写入缓存
     * @param {string} $act
     * @param {array} $cache_key
     * @param {array} $value
     * @param {int} $time 超时时间
     * @return {*}
     */
    public function  set_cache(string $act, array $cache_key, array $value, int $time = 0)
    {
        /* 判断是否达到最大缓存数量 */
        if ($act == 'ls' and count($value['data']) > env('CACHE_COUNT_MAX', 200)) {
            return false;
        } elseif ($act == 'all' and count($value) > env('CACHE_COUNT_MAX', 200)) {
            return false;
        }
        $key = $this->table . ':' . $act . ':' . md5(json_encode($cache_key));
        return redis_set($key, json_encode($value, 320), $time);
    }

    /**
     * @author: 布尔
     * @name:  删除缓存
     * @param {string} $act
     * @return {*}
     */
    public function del_cache(string $act = '')
    {
        $key = $this->table . ':' . $act . '*';
        return redis_del($key);
    }
}
