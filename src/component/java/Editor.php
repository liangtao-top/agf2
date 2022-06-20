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
// | Date: 2021/7/7 10:18
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
 * 编辑器控件
 * @package com\agf\dp\component
 */
class Editor extends ComponentAbs
{

    /**
     * html
     * @param array $value
     * @param bool  $isEdit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 10:25
     */
    public static function html(array &$value, bool $isEdit = false): string
    {
        $data   = [];   // 表单数据
        $pit_ib = 2;    // 标题行比
        $pit_ia = 10;   // 内容行比
        $btf    = '';   // 字段名称
        $popper = '';   // 帮助提示
        HtmlAbs::genFormPopoverVarAgr($value, $data, $btf, $pit_ib, $pit_ia, $popper);
        $md5         = 'UEditor_' . md5(serialize($value));
        $required    = Required::parse($data['filedValidation']);
        $area_height = is_numeric($data['areaHeight']) ? $data['areaHeight'] - 138 . 'px' : $data['areaHeight'];
        $url         = "/admin/base/Agf/uEditor";
        $add         = $data['defaultValue'];
        $upd         = 'th:utext="${info?.' . $btf . '}"';
        $val         = $isEdit ? $upd : $add;
        return <<<HTML
                <div class="form-group col-md-{$value['row']}">
                    <div class="row">
                        <label class="col-sm-$pit_ib col-form-label" for="$md5">{$value['title']}$required$popper</label>
                        <div class="col-sm-$pit_ia" >
                            <!-- 加载编辑器的容器 -->
                            <script type="text/plain" id="$md5" name="$btf" data-u-editor-url="$url" style="height: $area_height;width: 100%;" $val></script>
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
     * @date   2021/7/7 10:25
     */
    public static function view(array &$value): string
    {
        return ViewAbs::articleHtml($value);
    }

    /**
     * pageCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 10:26
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
     * @date   2021/7/7 10:26
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
     * @date   2021/7/7 11:06
     */
    public static function pageJsAfter(array &$value): string
    {
        $md5     = 'UEditor_' . md5(serialize($value));
        $js[]    = <<<JS
    // 百度编辑器初始化
    UE.getEditor('$md5');
JS;
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
     * @date   2021/7/7 11:06
     */
    public static function vendorCss(array &$value): string
    {
        return ImportAbs::js();
    }

    /**
     * vendorJs
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 11:06
     */
    public static function vendorJs(array &$value): string
    {
        return ImportAbs::js(['/assets/vendor/ueditor/ueditor.config.js',
                              '/assets/vendor/ueditor/ueditor.all.min.js',
                              '/assets/vendor/ueditor/lang/zh-cn/zh-cn.js']);
    }

    /**
     * initialCode
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 11:06
     */
    public static function initialCode(array &$value): string
    {
        return ExtraAbs::empty($value);
    }
}
