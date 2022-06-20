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
// | Date: 2021/7/6 17:21
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
 * 下拉框控件
 * @package com\agf\dp\component
 */
class Select extends ComponentAbs
{
    /**
     * html
     * @param array $value
     * @param bool  $isEdit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:28
     */
    public static function html(array &$value, bool $isEdit = false): string
    {
        $data   = [];   // 表单数据
        $pit_ib = 2;    // 标题行比
        $pit_ia = 10;   // 内容行比
        $btf    = '';   // 字段名称
        $popper = '';   // 帮助提示
        HtmlAbs::genFormPopoverVarAgr($value, $data, $btf, $pit_ib, $pit_ia, $popper);
        $required   = Required::parse(($data['filedValidation'] ?? 0));
        $liveSearch = (int)($data['liveSearch'] ?? 0);
        $selectType = (int)($data['selectType'] ?? 0);
        $select     = $selectType === 0 ?
            '<select id="' . $btf . '" name="' . $btf . '" class="form-control" data-plugin="selectpicker" title="请选择' . $value['title'] . '" ' . ($liveSearch === 1 ? 'data-live-search="true"' : '') . ' >' :
            '<select id="' . $btf . '" name="' . $btf . '" class="form-control" data-plugin="select2" >' . '<option></option>';
        $selected   = 'th:selected="'.($isEdit ? '${info?.' . $btf . ' != \'\' ? vo.key == info?.' . $btf . '+\'\' : vo.key == \'' . ($data['defaultValue'] ?? '') . '\'}' :
            '${vo.key == \'' . ($data['defaultValue'] ?? '') . '\'}').'"';
        $val = 'th:value="${vo.key}"';
        return  '                <div class="form-group col-md-' . $value['row'] . '">
                    <div class="row">
                        <label class="col-sm-' . $pit_ib . ' col-form-label" for="' . $btf . '">' . $value['title'] . $required . $popper . '</label>
                        <div class="col-sm-' . $pit_ia . '">
                            ' . $select . '
                            <th:block th:each="vo:${data?.' . $btf . '}">
                                <option '.$val.' ' . $selected . '>[[${vo.value}]]</option>
                            </th:block>
                            </select>
                        </div>
                    </div>
                </div>';
    }

    /**
     * view
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/17 11:01
     */
    public static function view(array &$value): string
    {
        return ViewAbs::optionHtml($value);
    }

    /**
     * vendorCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/6 17:53
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    public static function vendorCss(array &$value): string
    {
        $data        = $value['formData'] ?? [];
        $select_type = (int)($data['selectType'] ?? 0);
        return $select_type === 0 ?
            ImportAbs::css('/assets/vendor/bootstrap-select/bootstrap-select.min.css') :
            ImportAbs::css('/assets/vendor/select2/select2.min.css');
    }

    /**
     * vendorJs
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/6 17:53
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    public static function vendorJs(array &$value): string
    {
        $data       = $value['formData'] ?? [];
        $selectType = (int)($data['selectType'] ?? 0);
        return $selectType === 0 ?
            ImportAbs::js('/assets/vendor/bootstrap-select/bootstrap-select.min.js') :
            ImportAbs::js(['/assets/vendor/select2/select2.full.min.js', '/assets/vendor/select2/i18n/zh-CN.js']);
    }

    /**
     * pageJsBefore
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:28
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
     * @date   2020/6/16 19:28
     */
    public static function pageJsAfter(array &$value): string
    {
        $data = [];   // 表单数据
        $btf  = '';   // 字段名称
        HtmlAbs::genBaseVarAgr($value, $data, $btf);
        $ds = 0;    // 数据来源
        $sf = '';   // 保存字段
        $df = '';   // 展示字段
        HtmlAbs::GenTripartiteVarAgr($value, $ds, $sf, $df);
        $popper = JsAbs::genPopoverVarAgr($value);   // 帮助提示
        if (!empty($popper)) {
            $html[] = $popper;
        }
        $liveSearch              = (int)($data['liveSearch'] ?? 0);
        $selectType              = (int)($data['selectType'] ?? 0);
        $minimumResultsForSearch = $liveSearch === 0 ? ', minimumResultsForSearch: -1' : '';
        $relationScript          = '';
        // 上级控件
        $relationTo = $data['relationTo'] ?? null;
        // 本地表外键
        $relationshipField = $data['relationshipField'] ?? null;
        if (!empty($relationTo) && !empty($relationshipField)) {
            $url            = '/admin/base/Control/getTableData';
            $_refreshScript = $selectType === 0 ?
                <<<SCRIPT
selectpicker('refresh');
SCRIPT
                :
                <<<SCRIPT
select2($.concatCpt('select2', {placeholder: '请选择{$value['title']}'$minimumResultsForSearch}));
SCRIPT;
            $_refreshOption = $selectType === 1 ? <<<SCRIPT
<option value=""></option>
SCRIPT
                : '';
            $isComment      = function ($type, $val) {
                return $type === 1 ? PHP_EOL . '        ' . ($val === 'true' ? '' : '    ') . '$field.attr(\'disabled\', ' . $val . ');' : '';
            };
//            if (!empty($relationshipField)) {
            /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
            $relationScript .= <<<TEXT
    // 初始化{$value['title']}的关联关系插件
      .on('change', function(){
        var \$field = $('#$btf');
        // noinspection DuplicatedCode{$isComment($selectType, 'true')}
        dm.request({
          type: 'get',
          url: '$url',
          data: {tableName: '{$data['dataOption']}', field: '$df, $sf', where: {{$relationshipField}: this.value}},
          success: function (res) {
            if (res.code) {
              var h = '$_refreshOption';
              if (res.hasOwnProperty('data')) {
                _.forEach(res.data, function (value) {
                  h += '<option value="' + value[ '$sf' ] + '"' + (String(\$field.val()) === String(value[ '$sf' ]) ? ' selected' : '') + '>' + value['$df' ] + '</option>';
                })
              }
              \$field.html(h).$_refreshScript
            }
          },
          complete: function () {{$isComment($selectType, 'false')}
          }
        });
      }).trigger('change');
TEXT;
//            }
        }
        $_script = $selectType === 0 ?
            <<<SCRIPT
    // 初始化{$value['title']}的Bootstrap Select插件
    $('#$btf').selectpicker($.concatCpt('selectpicker'))
SCRIPT
            :
            <<<SCRIPT
    // 初始化{$value['title']}的Select2插件
    $('#$btf').select2($.concatCpt('select2', {placeholder: '请选择{$value['title']}'$minimumResultsForSearch}))
SCRIPT;
        if (!empty($relationScript)) {
            $html[] = $relationScript;
        }
        $html[] = $_script;
        return implode(PHP_EOL, array_unique($html));
    }

    /**
     * pageCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:28
     */
    public static function pageCss(array &$value): string
    {
        return CssAbs::genPopoverVarAgr($value);
    }

    /**
     * initialCode
     * @param array $value
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2020/6/16 19:28
     * @noinspection DuplicatedCode
     */
    public static function initialCode(array &$value): string
    {
        return ExtraAbs::initial($value);
    }

}
