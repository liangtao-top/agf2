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
// | Date: 2021/7/7 9:47
// +----------------------------------------------------------------------
namespace com\agf2\component\java;

use com\agf2\abs\com\java\ComponentAbs;
use com\agf2\abs\com\java\CssAbs;
use com\agf2\abs\com\java\ExtraAbs;
use com\agf2\abs\com\java\HtmlAbs;
use com\agf2\abs\com\java\ImportAbs;
use com\agf2\abs\com\java\ViewAbs;
use com\agf2\util\Required;

/**
 * 日期框控件
 * @package com\agf\dp\component
 */
class Datepicker extends ComponentAbs
{

    /**
     * html
     * @param array $value
     * @param bool  $isEdit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/4/15 10:22
     */
    public static function html(array &$value, bool $isEdit = false): string
    {
        $data   = [];   // 表单数据
        $pit_ib = 2;    // 标题行比
        $pit_ia = 10;   // 内容行比
        $btf    = '';   // 字段名称
        $popper = '';   // 帮助提示
        HtmlAbs::genFormPopoverVarAgr($value, $data, $btf, $pit_ib, $pit_ia, $popper);
        $required = Required::parse($data['filedValidation']);
        if ($isEdit) {
            $date = 'th:value="${info?.'.$btf.'}"';
        }
        $html = '';
        if ($data['dateFormat'] == 1) { // 仅日期
            if(!$isEdit){
                $date     = match ((int)$data['defaultValue']) {
                    // 昨天
                    1 => 'th:value="${#dates.format(#util.date(5,-1), \'yyyy-MM-dd\')}"',
                    // 今天
                    2 => 'th:value="${#dates.format(#util.date(5,0), \'yyyy-MM-dd\')}"',
                    // 明天
                    3 => 'th:value="${#dates.format(#util.date(5,1), \'yyyy-MM-dd\')}"',
                    default => '',
                };
            }
            $html = '                <div class="form-group col-md-' . $value['row'] . '">
                    <div class="row">
                        <label class="col-sm-' . $pit_ib . ' col-form-label" for="' . $btf . '">' . $value['title'] . $required . $popper . '</label>
                        <div class="col-sm-' . $pit_ia . '">
                            <input data-plugin="datepicker" type="text" ' . $date . ' class="form-control" name="' . $btf . '" id="' . $btf . '" />
                        </div>
                    </div>
                </div>';
        } elseif ($data['dateFormat'] == 2) { // 日期和时间
            if(!$isEdit){
                $date     = match ((int)$data['defaultValue']) {
                    // 昨天
                    1 => 'th:value="${#dates.format(#util.date(5,-1), \'yyyy-MM-dd HH:mm\')}"',
                    // 今天
                    2 => 'th:value="${#dates.format(#util.date(5,0), \'yyyy-MM-dd HH:mm\')}"',
                    // 明天
                    3 => 'th:value="${#dates.format(#util.date(5,1), \'yyyy-MM-dd HH:mm\')}"',
                    default => '',
                };
            }
            $html = '                <div class="form-group col-md-' . $value['row'] . '">
                    <div class="row">
                        <label class="col-sm-' . $pit_ib . ' col-form-label" for="' . $btf . '">' . $value['title'] . $required . $popper . '</label>
                        <div class="col-sm-' . $pit_ia . '">
                            <input type="text" class="form-control" ' . $date . ' name="' . $btf . '" id="' . $btf . '" />
                        </div>
                    </div>
                </div>';
        }
        return $html;
    }

    /**
     * view
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/17 10:27
     */
    public static function view(array &$value): string
    {
        return ViewAbs::baseHtml($value);
    }

    /**
     * pageCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:15
     */
    public static function pageCss(array &$value): string
    {
        return CssAbs::genPopoverVarAgr($value);
    }

    /**
     * pageJsBefore
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:15
     */
    public static function pageJsBefore(array &$value): string
    {
        return '';
    }

    /**
     * pageJsAfter
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:15
     */
    public static function pageJsAfter(array &$value): string
    {
        $data = [];   // 表单数据
        $btf  = '';   // 字段名称
        HtmlAbs::genBaseVarAgr($value, $data, $btf);
        $js = [];
        if ($data['dateFormat'] == 1) {
            $js[] = <<<script
    // 初始化datepicker插件
    $('#$btf').datepicker({language: 'zh-CN', autoclose: true, format: "yyyy-mm-dd"});
script;
        } elseif ($data['dateFormat'] == 2) {
            $js[] = <<<script
    // 初始化datetimepicker插件    
    $('#$btf').datetimepicker({language: 'zh-CN', autoclose: true});
script;
        }
        $popover = CssAbs::genPopoverVarAgr($value);
        if (!empty($popover)) {
            $js[] = $popover;
        }
        return implode(PHP_EOL, $js);
    }

    /**
     * vendorCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:15
     */
    public static function vendorCss(array &$value): string
    {

        $import = '';
        $data   = $value['formData'] ?? [];
        if ($data['dateFormat'] == 1) {
            $import = ImportAbs::css('/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css');
        } elseif ($data['dateFormat'] == 2) {
            $import = ImportAbs::css('/assets/vendor/datetimepicker/bootstrap-datetimepicker.min.css');
        }
        return $import;
    }

    /**
     * vendorJs
     * @param array $value
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2020/6/16 19:15
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    public static function vendorJs(array &$value): string
    {
        $import = '';
        $data   = $value['formData'] ?? [];
        if ($data['dateFormat'] == 1) {
            $import = ImportAbs::js(['/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js',
                                     '/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.zh-CN.min.js']);
        } elseif ($data['dateFormat'] == 2) {
            $import = ImportAbs::js(['/assets/vendor/datetimepicker/bootstrap-datetimepicker.min.js',
                                     '/assets/vendor/datetimepicker/locales/bootstrap-datetimepicker.zh-CN.js']);
        }
        return $import;
    }

    /**
     * initialCode
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:36
     */
    public static function initialCode(array &$value): string
    {
        return ExtraAbs::empty($value);
    }
}
