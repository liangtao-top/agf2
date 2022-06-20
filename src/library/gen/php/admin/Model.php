<?php
// +----------------------------------------------------------------------
// | CodeEngine
// +----------------------------------------------------------------------
// | Copyright 艾邦
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: TaoGe <liangtao.gz@foxmail.com>
// +----------------------------------------------------------------------
// | Version: 2.0 2020/3/27 17:40
// +----------------------------------------------------------------------

namespace com\agf2\library\gen\php\admin;

use com\agf2\abs\lib\LibPHPAdminAbs;
use com\agf2\enum\AdminModule;
use com\agf2\exception\GenerateException;
use com\agf2\util\FileUtil;
use com\agf2\util\Helper;
use Throwable;

/**
 * Class Model
 * @package com\generator
 */
class Model extends LibPHPAdminAbs
{

    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getPhp()->getModel();
        return $this->setTemplate($path)
                    ->replaceAll([
                                     'acquirer' => self::acquirer($this->data),
                                     'modifier' => self::modifier($this->data),
                                 ])
                    ->getTemplate();
    }

    /**
     * write
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 9:12
     */
    public function write(): void
    {
        try {
            $this->setModule(AdminModule::MODEL);
            FileUtil::write($this->getFileName(), $this->getContent());
        } catch (Throwable $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }

    /**
     * clean
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 15:11
     */
    public function clean(): void
    {
        try {
            $this->setModule(AdminModule::MODEL);
            FileUtil::rm($this->getFileName());
        } catch (Throwable $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }

    // 获取器
    private static function acquirer(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($val) use (&$code) {
            // 如果是多选或日期区间
            if ((int)$val['type_id'] === 6 || (int)$val['type_id'] === 9) {
                $fieldName = parse_name($val['formData']['bindTableFiled'], 1);
                $code[]    = '
    // ' . $val['title'] . '获取器
    public function get' . $fieldName . 'Attr($value)
    {
        return json_decode($value,true);
    }
';
            } elseif ((int)$val['type_id'] === 8) { // 日期
                $his       = $val['formData']['dateFormat'] == 2 ? ' H:i' : '';
                $fieldName = parse_name($val['formData']['bindTableFiled'], 1);
                $code[]    = '
    // ' . $val['title'] . '获取器
    public function get' . $fieldName . 'Attr($value)
    {
        return $value ? date("Y-m-d' . $his . '", (int)$value) : \'\';
    }
';
            } elseif ((int)$val['type_id'] === 11) { // 单位组织
                // 人员/部门
                if ((int)$val['formData']['typeSelection'] === 3 || (int)$val['formData']['typeSelection'] === 2) {
                    $fieldName = parse_name($val['formData']['bindTableFiled'], 1);
                    $code[]    = '
    // ' . $val['title'] . '获取器
    public function get' . $fieldName . 'Attr($value)
    {
        return json_decode($value,true);
    }
';
                }
            } elseif ((int)$val['type_id'] === 12) { // 当前信息
                // 当前用户
                if ((int)$val['formData']['typeSelection'] === 3) {
                    $fieldName = parse_name($val['formData']['bindTableFiled'], 1);
                    $code[]    = '
    // ' . $val['title'] . '获取器
    public function get' . $fieldName . 'TextAttr($value, $data)
    {
        unset($value);
        return get_nickname($data[\'' . $val['formData']['bindTableFiled'] . '\']);
    }
';
                }
            } elseif ((int)$val['type_id'] === 13) { // 附件上传
                $fieldName = parse_name($val['formData']['bindTableFiled'], 1);
                $code[]    = '
    /**
     * ' . $val['title'] . '获取器
     * @param $value
     * @param $data
     * @return mixed|string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         ' . date('Y-m-d H:i:s') . '
     * @noinspection PhpMissingReturnTypeInspection,PhpFullyQualifiedNameUsageInspection
     */
    public function get' . $fieldName . 'TextAttr($value, $data)
    {
        unset($value);
        $value = $data[\'' . $val['formData']['bindTableFiled'] . '\'];
        if (is_numeric($value)) {
            return \think\facade\Db::name(\'file\')->where(\'id\', $value)->value(\'name\');
        }
        $array = json_decode($value, true);
        if (is_array($array) && !empty($array)) {
            $column = [];
            foreach ($array as $id) {
                $column[] = \think\facade\Db::name(\'file\')->where(\'id\', $id)->value(\'name\');
            }
            return implode(\', \', $column);
        }
        return \'\';
    }
';
            } elseif ((int)$val['type_id'] === 14) { // 编辑表格
                $fieldName = parse_name($val['formData']['bindTableFiled'], 1);
                $code[]    = '
    // ' . $val['title'] . '获取器
    public function get' . $fieldName . 'Attr($value)
    {
        return json_decode($value, true);
    }
';
            } elseif ((int)$val['type_id'] === 15) { // 图片上传
                $fieldName = parse_name($val['formData']['bindTableFiled'], 1);
                $code[]    = '
    /**
     * ' . $val['title'] . '获取器
     * @param $value
     * @param $data
     * @return array|false|string|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         ' . date('Y-m-d H:i:s') . '
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function get' . $fieldName . 'DefaultAttr($value, $data)
    {
        unset($value);
        $value = $data[\'' . $val['formData']['bindTableFiled'] . '\'];
        if (is_numeric($value)) {
            return get_picture_path($value);
        }
        $temp_array = json_decode($value, true);
        if (is_array($temp_array) && !empty($temp_array)) {
            $column = [];
            foreach ($temp_array as $id) {
                $column[$id] = get_picture_path($id);
            }
            return $column;
        }
        return \'\';
    }
';
            }
        });
        return Helper::format($code);
    }

    // 修改器
    private static function modifier(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($val) use (&$code) {
            // 如果是多选或日期区间
            if ((int)$val['type_id'] === 6 || (int)$val['type_id'] === 9 || (int)$val['type_id'] === 14) {
                $fieldName = parse_name($val['formData']['bindTableFiled'], 1);
                $code[]    = '
    // ' . $val['title'] . '修改器
    public function set' . $fieldName . 'Attr($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }
';
            } elseif ((int)$val['type_id'] === 8) { // 日期
                $fieldName = parse_name($val['formData']['bindTableFiled'], 1);
                $code[]    = '
    // ' . $val['title'] . '修改器
    public function set' . $fieldName . 'Attr($value)
    {
        return strtotime($value);
    }
';
            }
        });
        return Helper::format($code);
    }

}
