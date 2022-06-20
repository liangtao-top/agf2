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
// | Date: 2021/7/7 14:02
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
 * 图片上传控件
 * @package com\agf\dp\component
 */
class UploadPicture extends ComponentAbs
{

    /**
     * html
     * @param array $value
     * @param bool  $isEdit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 14:01
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
        $oae          = $data['uploadOddEvenType'] ?? 1;
        $multiple     = ((int)$oae) === 2 ? 'data-multiple="true"' : '';
        $default      = ((int)$oae) === 2 ? '[]' : '';
        $data_default = $isEdit ? 'th:data-default="${#util.arrayToJSON(#util.column(info?.' . $btf . ',\'url\'))}"' : 'data-default="' . $default . '"';
        $upd          = 'th:value="${#util.arrayToJSON(#util.column(info?.' . $btf . ',\'id\'))}"';
        $val          = $isEdit ? $upd : 'value="' . $default . '"';
        return <<<HTML
                <div class="form-group col-md-{$value['row']}">
                    <div class="row">
                        <label class="col-sm-$pit_ib col-form-label">{$value['title']}$popper</label>
                        <div class="col-sm-$pit_ia">
                            <input type="hidden" id="$btf" name="$btf" $val
                                   th:data-url="\${'/admin/base/Agf/uploadPicture'}"
                                   data-width="{$data['rd_width']}" data-height="{$data['rd_height']}" $multiple
                                   $data_default/>
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
     * @date   2021/7/7 14:01
     */
    public static function view(array &$value): string
    {
        return ViewAbs::pictureHtml($value);
    }

    /**
     * viewCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 14:04
     * @noinspection PhpUnusedParameterInspection
     */
    public static function viewCss(array &$value): string
    {
        return ImportAbs::css();
    }

    /**
     * vendorCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:30
     */
    public static function vendorCss(array &$value): string
    {
        return ImportAbs::css('/assets/vendor/jquery-picture-upload/jquery-picture-upload.css');
    }

    /**
     * vendorJs
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:30
     */
    public static function vendorJs(array &$value): string
    {
        return ImportAbs::js([
                                 '/assets/vendor/blueimp-file-upload/vendor/jquery.ui.widget.js',
                                 '/assets/vendor/blueimp-file-upload/jquery.iframe-transport.js',
                                 '/assets/vendor/blueimp-file-upload/jquery.fileupload.js',
                                 '/assets/vendor/jquery-picture-upload/jquery-picture-upload.js',
                             ]);
    }

    /**
     * pageCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 14:04
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
     * @date   2021/7/7 14:04
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
     * @date   2020/6/16 19:30
     */
    public static function pageJsAfter(array &$value): string
    {
        $data = [];   // 表单数据
        $btf  = '';   // 字段名称
        HtmlAbs::genBaseVarAgr($value, $data, $btf);
        $js[]    = <<<TEXT
    // 初始化{$btf}图片上传控件
    dm.components.jQueryPictureUpload("#$btf");
TEXT;
        $popover = JsAbs::genPopoverVarAgr($value);
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
     * @date   2020/6/16 19:30
     */
    public static function initialCode(array &$value): string
    {
        return ExtraAbs::empty($value);
    }
}
