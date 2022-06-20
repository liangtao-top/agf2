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
// | Date: 2021/7/7 9:46
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
 * 编码控件
 * @package com\agf\dp\component
 */
class Code extends ComponentAbs
{
    /**
     * 编码输入框
     * @param array $value
     * @param bool  $isEdit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/3/30 15:13
     */
    public static function html(array &$value, bool $isEdit = false): string
    {
        $data       = [];   // 表单数据
        $pit_ib     = 2;    // 标题行比
        $pit_ia     = 10;   // 内容行比
        $btf        = '';   // 字段名称
        $popper     = '';   // 帮助提示
        HtmlAbs::genFormPopoverVarAgr($value, $data, $btf, $pit_ib, $pit_ia, $popper);
        $required = Required::parse($data['filedValidation']);
        $is_hide  = $data['isHide'] ? 'hidden' : '';
        $add      = 'value="' . $data['defaultValue'] . '"';
        $upd      = 'th:value="${info?.' . $btf . '}"';
        $val      = $isEdit ? $upd : $add;
        return <<<HTML
                <div $is_hide class="form-group col-md-{$value['row']}">
                    <div class="row">
                        <label class="col-sm-$pit_ib col-form-label" for="$btf">{$value['title']}$required$popper</label>
                        <div class="col-sm-$pit_ia">
                            <input type="text" class="form-control empty" name="$btf" id="$btf" placeholder="请输入{$value['title']}" $val autocomplete="off">
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
     * @date   2020/6/16 19:16
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
     * @date   2020/6/16 19:16
     */
    public static function pageJsAfter(array &$value): string
    {
        return JsAbs::genPopoverVarAgr($value);
    }

    /**
     * vendorCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:16
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
     * @date   2020/6/16 19:16
     */
    public static function vendorJs(array &$value): string
    {
        return ImportAbs::js();
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
