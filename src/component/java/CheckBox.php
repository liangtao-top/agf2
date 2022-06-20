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
// | Date: 2021/7/6 17:57
// +----------------------------------------------------------------------
namespace com\agf2\component\java;

use com\agf2\abs\com\java\ComponentAbs;
use com\agf2\abs\com\java\CssAbs;
use com\agf2\abs\com\java\ExtraAbs;
use com\agf2\abs\com\java\HtmlAbs;
use com\agf2\abs\com\java\ImportAbs;
use com\agf2\abs\com\java\JsAbs;
use com\agf2\abs\com\java\ViewAbs;

/**
 * 多选框控件
 * @package com\agf\dp\component
 */
class CheckBox extends ComponentAbs
{

    /**
     * html
     * @param array $value
     * @param bool  $isEdit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/4/13 15:20
     */
    public static function html(array &$value, bool $isEdit = false): string
    {
        $data       = [];   // 表单数据
        $pit_ib     = 2;    // 标题行比
        $pit_ia     = 10;   // 内容行比
        $btf        = '';   // 字段名称
        $popper     = '';   // 帮助提示
        $class_name = '';   // 样式类名
        HtmlAbs::genFormFullVarAgr($value, $data, $btf, $pit_ib, $pit_ia, $class_name,$popper,);
        $ds = 0;    // 数据来源
        $sf = '';   // 保存字段
        $df = '';   // 展示字段
        HtmlAbs::GenTripartiteVarAgr($value, $ds, $sf, $df);
/*        if ($ds === 1) {
            $val    = '$key';
            $option = '$vo';
        } else {
            $val    = '$vo[\'' . $sf . '\']';
            $option = '$vo.' . $df;
        }*/
        $id      = 'th:id="${\'' . $btf . '\'+vo.key}"';
        $for     = 'th:for="${\'' . $btf . '\'+vo.key}"';
        $val     = 'th:value="${vo.key}"';
        $checked = 'th:checked="' . ($isEdit ? '${info?.' . $btf . ' != \'\' ? #lists.contains(info?.' . $btf . ', vo.key) : vo.key == \'' . ($data['defaultValue'] ?? '') . '\'}' :
                '${vo.key == \'' . ($data['defaultValue'] ?? '') . '\'}') . '"';
        return '                <div class="form-group col-md-' . $value['row'] . ' ' . $class_name . '">
                    <div class="row">
                        <label class="col-sm-' . $pit_ib . ' col-form-label">' . $value['title'] . $popper . '</label>
                        <div class="col-sm-' . $pit_ia . '">
                            <th:block th:each="vo:${data?.' . $btf . '}">
                            <input type="checkbox" class="icheckbox-primary" ' . $id . ' ' . $val . ' name="' . $btf . '[]" data-plugin="iCheck" data-radio-class="icheckbox_minimal-blue" ' . $checked . '>
                            <label ' . $for . '>[[${vo.value}]]</label>
                            </th:block>
                        </div>
                    </div>
                </div>';
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
        return ViewAbs::optionHtml($value,true);
    }

    /**
     * pageCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:35
     */
    public static function pageCss(array &$value): string
    {
        $className = HtmlAbs::genClassName($value);
        $style[]   = <<<style
.{$className} > .row > :last-child > label {
    margin-right: 10px;
    margin-bottom: 0;
    vertical-align: middle;
}
.{$className} .icheckbox_minimal-blue{
    background-color: white;
}
style;
        $popover   = CssAbs::genPopoverVarAgr($value);
        if (!empty($popover)) {
            $style[] = $popover;
        }
        return implode(PHP_EOL, $style);
    }

    /**
     * pageJsBefore
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:34
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
     * @date   2020/6/16 19:34
     */
    public static function pageJsAfter(array &$value): string
    {
        $data = [];
        $btf  = '';
        HtmlAbs::GenBaseVarAgr($value, $data, $btf);
        $js[]    = <<<SCRIPT
    // 初始化{$value['title']}的iCheck插件
    $('[name="{$btf}[]"]').iCheck($.concatCpt('iCheck',{checkboxClass: 'icheckbox_minimal-blue'}));
SCRIPT;
        $popover = JsAbs::genPopoverVarAgr($value);
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
     * @date   2020/6/16 19:35
     */
    public static function vendorCss(array &$value): string
    {
        return ImportAbs::css('/assets/vendor/icheck/icheck.min.css');
    }

    /**
     * vendorJs
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:35
     */
    public static function vendorJs(array &$value): string
    {
        return ImportAbs::js('/assets/vendor/icheck/icheck.min.js');
    }

    /**
     * initialCode
     * @param array $value
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2020/6/16 19:34
     * @noinspection DuplicatedCode
     */
    public static function initialCode(array &$value): string
    {
        return ExtraAbs::initial($value);
    }

}
