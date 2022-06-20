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
// | Version: 2.0 2021/8/25 14:57
// +----------------------------------------------------------------------
namespace com\agf2\util;

class ValidationRule
{

    /**
     * 解析验证规则
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 16:57
     */
    private static function parse(array $value): string
    {
        $html = '';
        $id   = (int)$value['formData']['filedValidation'];
        if (isset($value['formData']['bindTableFiled'])) {
            $html = match ($id) {
                1, 6 => <<<JSON
        {$value['formData']['bindTableFiled']}: {
          required: true
        }
JSON,
                2 => <<<JSON
        {$value['formData']['bindTableFiled']}: {
          required: true,
          digits:true
        }
JSON,
                3 => <<<JSON
        {$value['formData']['bindTableFiled']}: {
          digits:true
        }
JSON,
                4 => <<<JSON
        {$value['formData']['bindTableFiled']}: {
          required: true,
          email:true
        }
JSON,
                5 => <<<JSON
        {$value['formData']['bindTableFiled']}: {
          email:true
        }
JSON,
                7 => <<<JSON
        {$value['formData']['bindTableFiled']}: {

        }
JSON,
                8 => <<<JSON
        {$value['formData']['bindTableFiled']}: {
          required: true,
          aboard:true
        }
JSON,
                9 => <<<JSON
        {$value['formData']['bindTableFiled']}: {
          aboard:true
        }
JSON,
                10 => <<<JSON
        {$value['formData']['bindTableFiled']}: {
          required: true,
          fax:true
        }
JSON,
                11 => <<<JSON
        {$value['formData']['bindTableFiled']}: {
          fax:true
        }
JSON,
                12 => <<<JSON
        {$value['formData']['bindTableFiled']}: {
          required: true,
          mobile:true
        }
JSON,
                13 => <<<JSON
        {$value['formData']['bindTableFiled']}: {
          mobile:true
        }
JSON,
                14 => <<<JSON
        {$value['formData']['bindTableFiled']}: {
          required: true,
          tel:true
        }
JSON,
                15 => <<<JSON
        {$value['formData']['bindTableFiled']}: {
          tel:true
        }
JSON,
                16 => <<<JSON
        {$value['formData']['bindTableFiled']}: {
          required: true,
          url:true
        }
JSON,
                17 => <<<JSON
        {$value['formData']['bindTableFiled']}: {
          url:true
        }
JSON,
                default => '',
            };
        }
        return $html;
    }

    /**
     * 表单字段验证
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/3/30 11:54
     */
    public static function filedValidation(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($value) use (&$code) {
            if (isset($value['formData']) && is_array($value['formData']) && !empty($value['formData']) && isset($value['formData']['filedValidation']) && (string)$value['formData']['filedValidation'] !== '-1') {
                $rule = ValidationRule::parse($value);
                if (!empty($rule)) {
                    $code[] = $rule;
                }
            }
        });
        $code = Helper::format($code, ',' . PHP_EOL, true, true, false);
        return empty($code) ? "" : PHP_EOL . $code . PHP_EOL . '  ';
    }
}
