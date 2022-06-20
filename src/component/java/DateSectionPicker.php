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
// | Date: 2021/7/7 10:08
// +----------------------------------------------------------------------
namespace com\agf2\component\java;

use com\agf2\abs\com\java\ComponentAbs;
use com\agf2\abs\com\java\CssAbs;
use com\agf2\abs\com\java\ExtraAbs;
use com\agf2\abs\com\java\HtmlAbs;
use com\agf2\abs\com\java\ImportAbs;
use com\agf2\abs\com\java\JsAbs;
use com\agf2\util\Required;

/**
 * 日期区间控件
 * @package com\agf\dp\component
 */
class DateSectionPicker extends ComponentAbs
{

    /**
     * html
     * @param array $value
     * @param bool  $isEdit
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2020/4/15 11:21
     * @noinspection DuplicatedCode
     * @noinspection PhpUnnecessaryCurlyVarSyntaxInspection
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
        $start    = $isEdit?'th:value="${info?.' . $btf . '?.get(\'start\')}"':'';
        $end      = $isEdit?'th:value="${info?.' . $btf . '?.get(\'end\')}"':'';
        return <<<HTML
                <div class="form-group col-md-{$value['row']}">
                    <div class="row">
                        <label class="col-sm-$pit_ib col-form-label">{$value['title']}$required$popper</label>
                        <div class="col-sm-$pit_ia">
                            <div class="input-daterange" data-plugin="datepicker" data-language="zh-CN"  id="$btf">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="icon wb-calendar" aria-hidden="true"></i></span></div>
                                    <input type="text" class="form-control empty datepicker" id="{$btf}_start" name="{$btf}[start]" placeholder="开始时间" $start>
                                    <input type="text" class="form-control empty datepicker" id="{$btf}_end" name="{$btf}[end]" placeholder="结束时间" $end>
                                </div>
                            </div>
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
        $data   = [];   // 表单数据
        $pit_ib = 2;    // 标题行比
        $pit_ia = 10;   // 内容行比
        $btf    = '';   // 字段名称
        HtmlAbs::genFormVarAgr($value, $data, $btf, $pit_ib, $pit_ia);
        $start = '[[${info?.' . $btf . '?.get(\'start\')}]]';
        $end   = '[[${info?.' . $btf . '?.get(\'end\')}]]';
        return <<<HTML
                <div class="form-group col-md-{$value['row']}">
                    <div class="row">
                        <label class="col-sm-$pit_ib col-form-label">{$value['title']}</label>
                        <div class="col-sm-$pit_ia">
                            <span class="view-content">$start - $end</span>
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
     * @date   2020/6/16 19:16
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
        $btf     = HtmlAbs::genBindFiled($value);   // 字段名称
        $js[]    = <<<script
    // 初始化datepicker插件
    $('#$btf').datepicker({language: 'zh-CN', autoclose: true, format: "yyyy-mm-dd"});
script;
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
     * @date   2020/6/16 19:16
     */
    public static function vendorCss(array &$value): string
    {
        return ImportAbs::css('/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css');
    }

    /**
     * vendorJs
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:17
     */
    public static function vendorJs(array &$value): string
    {
        return ImportAbs::js(['/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js',
                              '/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.zh-CN.min.js']);
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
