<?php
/*
 * @author: 布尔
 * @name:  创建表类
 * @desc: 介绍
 * @LastEditTime: 2023-06-16 13:10:05
 * @FilePath: \eyc3_canyin\app\Core\CreateTable.php
 */

declare(strict_types=1);

namespace Eykj\Base;

use Hyperf\Database\Schema\Schema;
use Hyperf\DbConnection\Db;

class CreateTable
{
    /**
     * 数据库字段类型对照表.
     *
     * @var array
     */
    protected $type_array = ['int' => ['func' => 'integer', 'length' => '', 'default' => NULL], 'bigint' => ['func' => 'bigInteger', 'length' => '', 'default' => NULL], 'char' => ['func' => 'char', 'length' => '', 'default' => ''], 'decimal' => ['func' => 'decimal', 'length' => '', 'default' => 0], 'tinyint' => ['func' => 'tinyInteger', 'length' => '', 'default' => 0], 'json' => ['func' => 'json', 'length' => '', 'default' => NULL], 'varchar' => ['func' => 'string', 'length' => '', 'default' => ''], 'timestamp' => ['func' => 'timestamp', 'length' => '', 'default' => NULL], 'date' => ['func' => 'date', 'length' => '', 'default' => NULL], 'datetime' => ['func' => 'dateTime', 'length' => '', 'default' => NULL], 'time' => ['func' => 'time', 'length' => '', 'default' => NULL], 'text' => ['func' => 'text', 'length' => '', 'default' => NULL], 'float' => ['func' => 'float', 'length' => '', 'default' => 0], 'longtext' => ['func' => 'longText', 'length' => '', 'default' => NULL]];

    /**
     * @author: 布尔
     * @name: 创建表
     * @param string $table_name 表名
     * @param string $target_table 目标表
     * @param string $table_comment 表注解
     */
    public function post_create_table(string $table_name, string $target_table, string $table_comment)
    {
        if (!Schema::hasTable($table_name)) {
            /* 查询目标表结构 */
            $table_type_list = Schema::getColumnTypeListing($target_table);
            $type_array = $this->type_array;
            Schema::create($table_name, function ($table) use ($table_type_list, $type_array, $table_comment, $target_table) {
                $table->comment($table_comment); //表注释
                foreach ($table_type_list as $v) {
                    if ($v['column_name'] == 'id') {
                        $table->bigIncrements('id');
                    } elseif ($v['column_name'] != 'created_at' && $v['column_name'] != 'updated_at') {
                        $func = $type_array[$v['data_type']]['func'];
                        $default = $type_array[$v['data_type']]['default'];
                        $length = $type_array[$v['data_type']]['length'];
                        if ($v['data_type'] == 'varchar') {
                            $length = str_replace(['varchar(', ')'], ['', ''], $v['column_type']);
                        } elseif ($v['data_type'] == 'char') {
                            $length = str_replace(['char(', ')'], ['', ''], $v['column_type']);
                        }
                        if ($length) {
                            $table->$func($v['column_name'], $length)->default($default)->comment($v['column_comment'])->nullable();
                        } else {
                            $table->$func($v['column_name'])->default($default)->comment($v['column_comment'])->nullable();
                        }
                    }
                }
                /* 添加 created_at updated_at */
                $table->timestamp('created_at')->useCurrent()->comment('添加时间');
                $table->timestamp('updated_at')->useCurrent()->comment('最后修改时间');
                /* 添加索引 */
                $index_data = Db::select("show index from " . env('DB_PREFIX') . $target_table);
                if ($index_data) {
                    $index = [];
                    foreach ($index_data as $v) {
                        /* 对象转数组 */
                        $v = y_get_object_vars($v);
                        if ($v['Key_name'] == 'PRIMARY') {
                            continue;
                        }
                        if (isset($index[$v['Key_name']])) {
                            $index[$v['Key_name']]['value'][] = $v['Column_name'];
                        } else {
                            $index[$v['Key_name']]['func']  = $v['Non_unique'] == 0 ? 'unique' : 'index';
                            $index[$v['Key_name']]['title'] = $v['Key_name'];
                            $index[$v['Key_name']]['value'][] = $v['Column_name'];
                        }
                    }
                    $index = array_values($index);
                    if ($index) {
                        foreach ($index as $v1) {
                            $func = $v1['func'];
                            $table->$func($v1['value'], $v1['title']);
                        }
                    }
                }
            });
        }
    }
}
