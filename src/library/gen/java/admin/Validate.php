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
// | Version: 2.0 2021/8/25 10:35
// +----------------------------------------------------------------------
namespace com\agf2\library\gen\java\admin;

use com\agf2\abs\lib\LibJavaAdminAbs;
use com\agf2\util\Helper;

class Validate extends LibJavaAdminAbs
{

    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getJava()->getValidate();
        return $this->setTemplate($path)
                    ->replaceAll([
                                     'fields' => self::fields($this->data),
                                     'import' => self::import($this->data),
                                 ])
                    ->getTemplate();
    }

    // 字段列表
    private static function fields(array &$data): string
    {
        $code      = [];
        $fields    = $data[0]['selected'][0]['fields'];
        $whitelist = ['id', 'sort', 'status', 'create_time', 'update_time'];
        foreach ($fields as $field) {
            if (!in_array($field['COLUMN_NAME'], $whitelist)) {
                $column_name = parse_name($field['COLUMN_NAME'], 1, false);
                $data_type   = self::typeConversion($data, $column_name) ?: Helper::mysqlTypeToJavaType($field['DATA_TYPE']);
//                @NotBlank(message = "应用名称必填", groups = {FormData.save.class, FormData.update.class})
//    @Length(max = 25, message = "应用名称最大长度为25个字符", groups = {FormData.save.class, FormData.update.class})
                $code      [] = <<<java
    private $data_type $column_name;
java;

            }
        }
        return implode(PHP_EOL . PHP_EOL, $code);
    }

    // 控件自定义字段类型
    private static function typeConversion(array &$data, string $column_name): string
    {
        $result = '';
        Helper::each($data, function ($value) use (&$result, $column_name) {
            $btf = parse_name($value['formData']['bindTableFiled'], 1, false);
            if ($btf === $column_name) {
                $result = match ((int)$value['type_id']) {
                    6 => 'String[]',
                    9 => 'Map<String,Object>',
                    default => ''
                };
            }
        });
        return $result;
    }

    // 引用
    private static function import(array &$data): string
    {
        $import = [];
        Helper::each($data, function ($value) use (&$import) {
            $import[] = match ((int)$value['type_id']) {
                9 => 'import java.util.Map;',
                default => ''
            };
        });
        return Helper::format($import);
    }
}
