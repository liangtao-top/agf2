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
// | Date: 2021/7/7 13:44
// +----------------------------------------------------------------------
namespace com\agf2\component\java;

use com\agf2\abs\com\java\ComponentAbs;
use com\agf2\abs\com\java\CssAbs;
use com\agf2\abs\com\java\ExtraAbs;
use com\agf2\abs\com\java\HtmlAbs;
use com\agf2\abs\com\java\ImportAbs;
use com\agf2\abs\com\java\JsAbs;
use com\agf2\abs\com\java\ViewAbs;
use com\agf2\util\Required;

/**
 * 文本框控件
 * @package com\agf\dp\component
 */
class Textarea extends ComponentAbs
{

    /**
     * html
     * @param array $value
     * @param bool  $isEdit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 13:44
     */
    public static function html(array &$value, bool $isEdit = false): string
    {
        $data   = [];   // 表单数据
        $pit_ib = 2;    // 标题行比
        $pit_ia = 10;   // 内容行比
        $btf    = '';   // 字段名称
        $popper = '';   // 帮助提示
        HtmlAbs::genFormPopoverVarAgr($value, $data, $btf, $pit_ib, $pit_ia, $popper);
        $required    = Required::parse($data['filedValidation']);
        $area_height = is_numeric($data['areaHeight']) ? $data['areaHeight'] . 'px' : $data['areaHeight'];
        $add         = $data['defaultValue'];
        $upd         = 'th:utext="${info?.' . $btf . '}"';
        $val         = $isEdit ? $upd : $add;
        return <<<HTML
                <div class="form-group col-md-{$value['row']}">
                    <div class="row">
                        <label class="col-sm-$pit_ib col-form-label" for="$btf">{$value['title']}$required$popper</label>
                        <div class="col-sm-$pit_ia">
                            <textarea class="form-control" rows="3" name="$btf" id="$btf" placeholder="请输入{$value['title']}" style="height: $area_height;" $val></textarea>
                        </div>
                    </div>
                </div>
HTML;
    }

    /**
     * view
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 13:44
     */
    public static function view(array &$value): string
    {
        return ViewAbs::baseHtml($value);
    }

    /**
     * vendorCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 13:45
     */
    public static function vendorCss(array &$value): string
    {
        return ImportAbs::css();
    }

    /**
     * vendorJs
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 13:45
     */
    public static function vendorJs(array &$value): string
    {
        return ImportAbs::js();
    }

    /**
     * pageCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 13:45
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
     * @date   2021/7/7 13:45
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
     * @date   2021/7/7 13:45
     */
    public static function pageJsAfter(array &$value): string
    {
        return JsAbs::genPopoverVarAgr($value);
    }

    /**
     * initialCode
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 13:45
     */
    public static function initialCode(array &$value): string
    {
        return ExtraAbs::empty($value);
    }

}
