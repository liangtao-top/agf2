<?php
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
// | Version: 2.0 2021/8/20 14:42
// +----------------------------------------------------------------------
namespace com\agf2\util;

use BadFunctionCallException;

class Helper
{

    /**
     * 遍历控件
     * @param array    $data
     * @param callable $fun
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 10:39
     */
    public static function each(array &$data, callable $fun): void
    {
        if (isset($data[1]['controls'])) {
            $controls = $data[1]['controls'];
            foreach ($controls as $control) {
                foreach ($control as $val) {
                    if (isset($val['type_id']) && (int)$val['type_id'] !== 1) {
                        $fun($val);
                    }
                }
            }
        }
    }

    /**
     * 代码片段格式化
     * @param array  $code   代码片段
     * @param string $glue   分割符
     * @param bool   $unique 是否去重
     * @param bool   $filter 是否过滤空元素
     * @param bool   $before 是否前置分隔符
     * @param bool   $after  是否后置分隔符
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 10:40
     */
    public static function format(array &$code, string $glue = PHP_EOL, bool $unique = true, bool $filter = true, bool $before = true, bool $after = false): string
    {
        if ($unique) {
            $code = array_unique($code);
        }
        if ($filter) {
            $code = array_filter($code);
        }
        $string = implode($glue, $code);
        return empty($string) ? '' : ($before ? $glue . $string : $string) . ($after ? $glue : '');
    }


    /**
     * 获取字段属性
     * @param string $name
     * @param array  $data
     * @return array
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 11:49
     */
    public static function getFieldAttr(string $name, array &$data): array
    {
        $attr = [];
        try {
            self::each($data, function ($value) use ($name, &$attr) {
                if (isset($value['formData'])
                    && is_array($value['formData'])
                    && !empty($value['formData'])
                    && isset($value['formData']['bingTableName'])
                    && isset($value['formData']['bindTableFiled'])
                    && $value['formData']['bingTableName'] . '.' . $value['formData']['bindTableFiled'] === $name) {
                    $attr = $value;
                    throw new BadFunctionCallException();
                }
            });
        } catch (BadFunctionCallException) {
        }
        return $attr;
    }

    /**
     * Java数据类型和MySql数据类型对应
     * @param string $type
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/25 10:40
     */
    public static function mysqlTypeToJavaType(string $type): string
    {
        return match ($type) {
            'blob' => 'byte[]',
            'integer', 'int' => 'Long',
            'tinyint', 'smallint', 'mediumint', 'boolean' => 'Integer',
            'bit' => 'Boolean',
            'bigint' => 'BigInteger',
            'float' => 'Float',
            'double' => 'Double',
            'decimal' => 'BigDecimal',
            'date', 'year' => 'java.sql.Date',
            'time' => 'java.sql.Time',
            'datetime', 'timestamp' => 'java.sql.Timestamp',
            default => 'String',
        };
    }
}
