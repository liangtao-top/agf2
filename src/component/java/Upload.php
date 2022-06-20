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
// | Date: 2021/7/7 13:46
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
 * 附件上传控件
 * @package com\agf\dp\component
 */
class Upload extends ComponentAbs
{

    /**
     * html
     * @param array $value
     * @param bool  $isEdit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 13:51
     */
    public static function html(array &$value, bool $isEdit = false): string
    {
        $data       = [];   // 表单数据
        $pit_ib     = 2;    // 标题行比
        $pit_ia     = 10;   // 内容行比
        $btf        = '';   // 字段名称
        $popper     = '';   // 帮助提示
        $class_name = '';   // 样式类名
        HtmlAbs::genFormFullVarAgr($value, $data, $btf, $pit_ib, $pit_ia, $class_name, $popper);
        $oae              = $data['uploadOddEvenType'] ?? 2;
        $multiple         = (int)$oae === 2 ? 'multiple' : '';
        $upd              = 'th:value="${#util.arrayToJSON(#util.column(info?.' . $btf . ',\'id\'))}"';
        $val              = $isEdit ? $upd : 'value=""';
        $readonly         = 'th:value="${#util.join(#util.column(info?.' . $btf . ',\'name\'),\', \')}"';
        $item             = !$isEdit ? '' : <<<TEXT
                            <th:block th:each="vo,key:\${info?.$btf}">
                                <div class="item" th:data-key="\${key.index}" th:data-id="\${vo?.id}">
                                    <span class="float-left" th:text="\${vo?.name}"></span>
                                    <span class="float-right"><i class="icon wb-close" aria-hidden="true"></i></span>
                                </div>
                            </th:block>
TEXT;
        $item             = empty($item) ? '' : PHP_EOL . $item . PHP_EOL . '                            ';
        $enclosure_action = '<div class="enclosure-action">' . $item . '</div>';
        return <<<HTML
                <div class="form-group col-md-{$value['row']} $class_name">
                    <div class="row">
                        <label class="col-sm-$pit_ib col-form-label">{$value['title']}$popper</label>
                        <div class="col-sm-$pit_ia">
                            <div class="input-group input-group-file" data-plugin="inputGroupFile">
                                <!--suppress HtmlFormInputWithoutLabel -->
                                <input type="text" class="form-control" readonly="" $readonly>
                                <input type="hidden" id="$btf" name="$btf" $val>
                                <div class="input-group-append">
                                    <span class="btn btn-outline btn-file">
                                        <i class="icon wb-upload" aria-hidden="true"></i>
                                        <input type="file" id="file_$btf" th:data-url="\${'/admin/base/Agf/uploadFile'}" $multiple>
                                    </span>
                                </div>
                            </div>
                            $enclosure_action
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
     * @date   2021/7/7 13:51
     */
    public static function view(array &$value): string
    {
        return ViewAbs::fileHtml($value);
    }

    /**
     * pageCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 13:54
     */
    public static function pageCss(array &$value): string
    {
        $class_name = HtmlAbs::genClassName($value);
        $style[]   = <<<TEXT
.$class_name .input-group-append{
    background-color: white;
}
TEXT;
        $popover   = CssAbs::genPopoverVarAgr($value);
        if (!empty($popover)) {
            $style[] = $popover;
        }
        return implode(PHP_EOL, array_unique($style));
    }

    /**
     * vendorCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 13:55
     */
    public static function vendorCss(array &$value): string
    {
        return ImportAbs::css('/assets/vendor/input-group-file-upload/input-group-file-upload.css');
    }

    /**
     * vendorJs
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 13:55
     */
    public static function vendorJs(array &$value): string
    {
        return ImportAbs::js('/assets/vendor/input-group-file-upload/input-group-file-upload.js');
    }

    /**
     * pageJsBefore
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 13:55
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
     * @date   2021/7/7 13:55
     */
    public static function pageJsAfter(array &$value): string
    {
        $data = [];   // 表单数据
        $btf  = '';   // 字段名称
        HtmlAbs::genBaseVarAgr($value, $data, $btf);
        $uploadOddEvenType = $data['uploadOddEvenType'] ?? 2;
        $js[]              = <<<TEXT
    // 初始化{$btf}文件上传控件
    dm.components.inputGroupFile("#file_$btf", $uploadOddEvenType);
TEXT;
        $popover           = JsAbs::genPopoverVarAgr($value);
        if (!empty($popover)) {
            $js[] = $popover;
        }
        return implode(PHP_EOL, array_unique($js));
    }

    /**
     * initialCode
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 13:58
     */
    public static function initialCode(array &$value): string
    {
        return ExtraAbs::empty($value);
    }
}
