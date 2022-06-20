<?php /** @noinspection PhpDynamicAsStaticMethodCallInspection */
declare(strict_types=1);
// +----------------------------------------------------------------------
// | CodeEngine
// +----------------------------------------------------------------------
// | Copyright 艾邦
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: TaoGe <liangtao.gz@foxmail.com>
// +----------------------------------------------------------------------
// | Version: 2.0 2022/6/17 10:36
// +----------------------------------------------------------------------
namespace com\agf2\util;

use com\agf2\exception\GenerateException;
use com\agf2\library\Config;
use think\facade\Db;

class DbUtil
{

    /**
     * createTable
     * @throws \com\agf2\exception\GenerateException
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2022/6/17 13:54
     * @noinspection SqlResolve SqlNoDataSourceInspection
     */
    public static function createTable(): void
    {
        $params = Config::instance()->getData()[0]['selected'][0] ?? null;
        if (empty($params)) {
            throw new GenerateException('参数异常，导致生成数据库失败');
        }
        $fields = '';
        foreach ($params['fields'] as $value) {
            $nullable = $value['IS_NULLABLE'] === 'NO' ? 'NOT NULL' : 'NULL';
            $default  = match ($value['DATA_TYPE']) {
                'blob', 'text', 'geometry', 'json' => '',
                default => $value['COLUMN_DEFAULT'] === 'null' ? '' : "DEFAULT '{$value['COLUMN_DEFAULT']}'",
            };
            $extend   = $value['COLUMN_NAME'] === 'id' ? 'AUTO_INCREMENT' : '';
            $fields   .= "`{$value['COLUMN_NAME']}` {$value['COLUMN_TYPE']} $nullable $default $extend COMMENT '{$value['COLUMN_COMMENT']}',";
        }
        $database = config('database.connections')[config('database.default')]['database'];    // 数据库名
        $prefix   = config('database.connections')[config('database.default')]['prefix'];      // 数据库表前缀
        $sql      = [
            "DROP TABLE IF EXISTS `$database`.`$prefix{$params['name']}`;",
            "CREATE TABLE `$database`.`$prefix{$params['name']}` ( $fields PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='{$params['comment']}';",
        ];
        array_map([Db::class, 'execute'], $sql);
    }

    /**
     * deleteTable
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 14:57
     * @noinspection SqlResolve SqlNoDataSourceInspection
     */
    public static function deleteTable(): void
    {
        $params = Config::instance()->getData()[0]['selected'][0] ?? null;
        if (empty($params)) {
            throw new GenerateException('参数异常，导致删除数据库失败');
        }
        $database = config('database.connections')[config('database.default')]['database'];    // 数据库名
        $prefix   = config('database.connections')[config('database.default')]['prefix'];      // 数据库表前缀
        $sql      = ["DROP TABLE IF EXISTS `$database`.`$prefix{$params['name']}`;"];
        array_map([Db::class, 'execute'], $sql);
    }
}
