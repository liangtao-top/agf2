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
// | Date: 2021/7/7 11:49
// +----------------------------------------------------------------------
namespace com\agf2\component\java;

use com\agf2\abs\com\java\ComponentAbs;
use com\agf2\abs\com\java\CssAbs;
use com\agf2\abs\com\java\ExtraAbs;
use com\agf2\abs\com\java\HtmlAbs;
use com\agf2\abs\com\java\ImportAbs;
use com\agf2\abs\com\java\JsAbs;

/**
 * 当前信息控件
 * @package com\agf\dp\component
 */
class Information extends ComponentAbs
{

    /**
     * html
     * @param array $value
     * @param bool  $isEdit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:21
     */
    public static function html(array &$value, bool $isEdit = false): string
    {
        $data   = [];   // 表单数据
        $pit_ib = 2;    // 标题行比
        $pit_ia = 10;   // 内容行比
        $btf    = '';   // 字段名称
        $popper = '';   // 帮助提示
        HtmlAbs::genFormPopoverVarAgr($value, $data, $btf, $pit_ib, $pit_ia, $popper);
        $val     = match ((int)$data['typeSelection']) {
            1, 2, 3 => '{:is_login()}',
            4 => '{:date(\'Y-m-d H:i:s\')}',
            default => '',
        };
        $is_hide = $data['isHide'] ? 'hidden' : '';
        return <<<HTML
                <div class="form-group col-md-{$value['row']}" $is_hide>
                    <div class="row">
                        <label class="col-sm-$pit_ib col-form-label" for="$btf">{$value['title']}$popper</label>
                        <div class="col-sm-$pit_ia">
                            <input type="text" class="form-control empty" readonly="readonly" name="$btf" id="$btf" placeholder="请输入{$value['title']}" value="$val" autocomplete="off">
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
     * @date   2021/7/7 11:45
     */
    public static function view(array &$value): string
    {
        $data   = [];   // 表单数据
        $pit_ib = 2;    // 标题行比
        $pit_ia = 10;   // 内容行比
        $btf    = '';   // 字段名称
        HtmlAbs::genFormVarAgr($value, $data, $btf, $pit_ib, $pit_ia);
        $val = match ((int)$data['typeSelection']) {
            1, 2, 3 => '{php}echo isset($info["' . $btf . '"]) && !empty($info["' . $btf . '"]) ? get_nickname($info["' . $btf . '"]) : "";{/php}',
            default => '{$info.' . $btf . '|default=\'\'}',
        };
        return <<<HTML
                <div class="form-group col-md-{$value['row']}">
                    <div class="row">
                        <label class="col-sm-$pit_ib col-form-label">{$value['title']}</label>
                        <div class="col-sm-$pit_ia">
                            <span class="view-content">$val</span>
                        </div>
                    </div>
                </div>
HTML;
    }

    /**
     * pageCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:21
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
     * @date   2021/7/7 11:41
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
     * @date   2021/7/7 11:40
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
     * @date   2021/7/7 11:39
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
     * @date   2021/7/7 11:39
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
     * @date   2021/7/7 11:40
     */
    public static function initialCode(array &$value): string
    {
        return ExtraAbs::empty($value);
    }
}
