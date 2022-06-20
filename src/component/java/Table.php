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
// | Date: 2021/7/7 11:06
// +----------------------------------------------------------------------
namespace com\agf2\component\java;

use com\agf2\abs\com\java\ComponentAbs;
use com\agf2\abs\com\java\ExtraAbs;
use com\agf2\abs\com\java\HtmlAbs;
use com\agf2\abs\com\java\ImportAbs;

/**
 * 编辑表格控件
 * @package com\generator\lib
 */
class Table extends ComponentAbs
{

    /**
     * html
     * @param array $value
     * @param bool  $isEdit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 11:15
     */
    public static function html(array &$value, bool $isEdit = false): string
    {
        $btf  = HtmlAbs::genBindFiled($value);   // 字段名称
        $data = '[]';
        if ($isEdit) {
            $data = '{$info.' . $btf . '|raw|json_encode}';
        }
        $md5        = substr(strtolower(md5(json_encode($value))), 0, 9);
        $id         = 'table_' . $md5;
        $class_name = HtmlAbs::genClassName($value);
        //data-height="{$data['areaHeight']}"
        return <<<HTML
                <div class="form-group col-md-{$value['row']} $class_name">
                    <table id="$id" data-data='$data'></table>
                    <div class="toolbar">
                        <span data-event="add"><i class="fa wb-plus"></i></span><span data-event="del"><i class="fa wb-minus"></i></span>
                    </div>
                </div>
HTML;
    }

    /**
     * view
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 11:15
     */
    public static function view(array &$value): string
    {
        $btf        = HtmlAbs::genBindFiled($value);   // 字段名称
        $data       = '{$info.' . $btf . '|raw|json_encode}';
        $md5        = substr(strtolower(md5(json_encode($value))), 0, 9);
        $id         = 'table_' . $md5;
        $class_name = HtmlAbs::genClassName($value);
        return <<<HTML
                <div class="form-group col-md-{$value['row']} $class_name">
                    <table id="$id" data-data='$data'></table>
                </div>
HTML;
    }

    /**
     * pageCss
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 11:19
     */
    public static function pageCss(array &$value): string
    {
        $class_name = HtmlAbs::genClassName($value);
        return <<<STYLE
.$class_name .toolbar {
    background: rgba(243, 247, 249, 0.5);
    height: 34px;
    border-right: 1px solid #e4eaec;
    border-left: 1px solid #e4eaec;
    border-bottom: 1px solid #e4eaec;
}

.$class_name .toolbar span{
    color: #76838f;
    cursor: pointer;
    line-height: 34px;
    margin-left:0.75rem;
}

.$class_name .bootstrap-table .fixed-table-container .table thead th .th-inner {
    padding-top: 0.4642857142857143rem;
    padding-bottom: 0.4642857142857143rem;
}

.$class_name .bootstrap-table .table th, .$class_name .bootstrap-table .table td {
    padding: 0;
}

.$class_name .bootstrap-table .table th span.text, .$class_name .bootstrap-table .table td span.text {
    padding: 0 0.75rem;
}

.$class_name .bootstrap-table table input, 
.$class_name .bootstrap-table table select, 
.$class_name .bootstrap-table table .select2-container--default .select2-selection--single, 
.$class_name .bootstrap-table table .select2-container--default .select2-selection {
    border-radius: 0;
    padding-left: .75rem;
    padding-right: .75rem;
    border: none;
}
STYLE;
    }

    /**
     * pageJsBefore
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 11:19
     */
    public static function pageJsBefore(array &$value): string
    {
        $data = [];   // 表单数据
        $btf  = '';   // 字段名称
        HtmlAbs::genBaseVarAgr($value, $data, $btf);
        $md5     = substr(strtolower(md5(json_encode($value))), 0, 9);
        $id      = 'table_' . $md5;
        $table   = '$table_' . $md5;
        $toolbar = '$toolbar_' . $md5;
        $columns = ["{
          field: 'state',
          checkbox: true,
          rowspan: 1,
          align: 'center',
          valign: 'middle'
        }"];
//        $js      = [];
        $var = [];
        if (isset($data['editTable'])) {
            $editTable = json_decode($data['editTable'], true);
            if (!empty($editTable) && is_array($editTable)) {
                foreach ($editTable as $val) {
                    if (!empty($val) && isset($val['attr'])) {
                        $type = self::parseType($btf, $val, $value);
//                        if (!empty($type['script'])) {
//                            $js[] = $type['script'];
//                        }
                        if (!empty($type['var'])) {
                            $var[] = $type['var'];
                        }
                        $field     = parse_name($value['field'], 1, false);
                        $columns[] = <<<JSON
{
          field: '$field',
          title: '{$val['name']}',
          align: '{$val['attr']['alignment']}',
          formatter: function (data, item, index) {
            if (data === undefined) data = '';
            return '{$type['html']}';
          }
        }
JSON;
                    }
                }
            }
        }
        $columns = implode(',', $columns);
        $var     = implode(PHP_EOL, $var);
        return <<<script
  // 定义表格
  var $table = $('#$id');
  // 定义表格数据
  var data_$md5 = $table.data('data');
  // 定义选中行数组
  var selections_$md5 = [];
  // 定义表格工具栏
  var $toolbar = $('.cla$md5 > .toolbar');
  // 返回选定的行，如果未选择任何记录，则返回一个空数组
  var getIdSelections_$md5 = function () {
    return $.map($table.bootstrapTable('getSelections'), function (row) {
      return row.index;
    });
  };
  // 定义表格初始化参数
  var bootstrapTableOption_$md5 = function () {
    var option = {
      locale: 'zh-CN',
      columns: [
        {$columns}
      ]
    };
    return Object.assign(option, {data:data_$md5});
  };
$var
script;
    }

    /**
     * parseType
     * @param string $bindTableFiled
     * @param array  $value
     * @param array  $data
     * @return array
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 11:34
     */
    private static function parseType(string $bindTableFiled, array $value, array $data): array
    {
        $btf    = parse_name($bindTableFiled, 1, false);
        $field  = parse_name($value['field'], 1, false);
        $tdf    = parse_name($value['attr']['toolbarDisplayField'], 1, false);
        $tsf    = parse_name($value['attr']['toolbarSaveField'], 1, false);
        $md5    = substr(strtolower(md5(json_encode($data))), 0, 9);
        $id     = md5(json_encode($value));
        $type   = trim($value['attr']['type']);
        $var    = '';
        $script = '';
        switch ($type) {
            case '输入框':
                $html = '<input data-index="\'+index+\'" data-id="' . $id . '" class="form-control empty" type="text" name="' . $btf . '[\'+index+\'][' . $field . ']" placeholder="请输入' . $value['name'] . '" value="\'+data+\'" autocomplete="off">';
                break;
            case '下拉框':
                $default = '';
                if (isset($value['attr']['toolbarDefaultValue'])) {
                    $default = ' else {
            $(e).val(' . $value['attr']['toolbarDefaultValue'] . ');
          }';
                }
                $html    = '<select data-index="\'+index+\'" data-value="\'+data+\'" data-id="' . $id . '" class="form-control empty" name="' . $btf . '[\'+index+\'][' . $field . ']" autocomplete="off"><option value="-1">==请选择==</option></select>';
                $url     = (string)url('base.Control/getTableData');
                $table   = '$table_' . $md5;
                $select2 = '$select2_' . $id;
                $var     = <<<sctipt
  // 定义表格中select2控件的初始化参数
  var bootstrapTableSelect2Option_$id = null;
  // 定义表格初始化数据
  var init_data_a5731894b = function(){
    data_$md5 = $table.data('data');
    _.map(data_$md5,function (row,index) {
      row.index = index;
    })
  }();
sctipt;
                $script  = <<<text
      var $select2 = $table.find('[data-id="{$id}"]').select2($.concatCpt('select2'));
      var update_$id = function () {
        $select2.html(bootstrapTableSelect2Option_$id);
        _.forEach($select2,function (e) {
          if ($(e).data('value') !== "") {
            $(e).val($(e).data('value'))
          }$default
        })
        $select2.select2($.concatCpt('select2'));
      };
      var create_$id = function () {
        if(bootstrapTableSelect2Option_$id === null){
                dm.request({
        type: 'get',
        data: {tableName: '{$value['attr']['toolbarDataOption']}', field: '$tdf, $tsf'},
        url: '{$url}',
        success: function (res) {
          if (res.code) {
            var h = '<option value="-1">==请选择==</option>';
            if (res.hasOwnProperty('data')) {
              _.forEach(res.data, function (value) {
                h += '<option value="' + value[ '$tsf' ] + '">' + value['$tdf' ] + '</option>';
              })
            }
              bootstrapTableSelect2Option_$id = h;
              update_$id();
          }
      }});
        }else{
          update_$id();
        }
      }();
text;
                break;
            default:
                $html = "<span class=\"text\">' + data + '</span>";
                $html .= '<input data-id="' . $id . '" data-index="\'+index+\'" type="hidden" name="' . $btf . '[\'+index+\'][' . $field . ']" value="\'+data+\'">';

        }
        return ['html' => $html, 'id' => $id, 'script' => $script, 'var' => $var];
    }

    /**
     * pageJsAfter
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:20
     */
    public static function pageJsAfter(array &$value): string
    {
        $data = [];   // 表单数据
        $btf  = '';   // 字段名称
        HtmlAbs::genBaseVarAgr($value, $data, $btf);
        $md5   = substr(strtolower(md5(json_encode($value))), 0, 9);
        $table = '$table_' . $md5;
        $js    = [];
        if (isset($data['editTable'])) {
            $editTable = json_decode($data['editTable'], true);
            if (!empty($editTable) && is_array($editTable)) {
                foreach ($editTable as $val) {
                    if (!empty($val) && isset($val['attr'])) {
                        $type = self::parseType($btf, $val, $value);
                        if (!empty($type['script'])) {
                            $js[] = $type['script'];
                        }
                    }
                }
            }
        }
        $js      = implode(PHP_EOL, $js);
        $toolbar = '$toolbar_' . $md5;
        return <<<SCRIPT
    // 在表体呈现并在DOM中可用之后触发
    $table.on('post-body.bs.table',function(){
{$js}
    });
    
    // 编辑表格行选中与取消
    $table.on('check.bs.table uncheck.bs.table ' + 'check-all.bs.table uncheck-all.bs.table', function () {
      // 保存数据，这里只保存当前页面
      selections_$md5 = getIdSelections_$md5();
    });
    
    // 编辑表格的元素改变事件
    $table.on('input propertychange change','input,select', function () {
      var index = $(this).data('index');
      var val = $(this).val();
      var name = $(this).attr('name');
      /\[(.+)]/.test(name);
      name = RegExp.$1.split("][")[ 1 ]
      data_{$md5}[ index ][ name ] = val;
    });
    
    // 先注销再重新初始化编辑表格
    $table.bootstrapTable('destroy').bootstrapTable(bootstrapTableOption_$md5());
    
    // 编辑表格添加行
    $toolbar.find('[data-event="add"]').click(function () {
      data_$md5.push({index: data_$md5.length});
      $table.bootstrapTable('destroy').bootstrapTable(bootstrapTableOption_$md5());
    })
    
    // 编辑表格删除行
    $toolbar.find('[data-event="del"]').click(function () {
      var data = [];
      _.forEach(data_$md5, function (row) {
        if (!selections_$md5.includes(row.index)) {
          data.push(row);
        }
      })
      data_$md5 = data;
      $table.bootstrapTable('destroy').bootstrapTable(bootstrapTableOption_$md5());
    })
SCRIPT;
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
        return ImportAbs::css([
                                  '/assets/vendor/select2/select2.css',
                                  '/assets/fonts/glyphicons/glyphicons.min.css',
                                  '/assets/vendor/bootstrap-table/bootstrap-table.min.css',
                                  '/assets/vendor/bootstrap-table/bootstrap-table-fixed-columns/bootstrap-table-fixed-columns.css',
                              ]);
    }

    /**
     * vendorJs
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 11:16
     */
    public static function vendorJs(array &$value): string
    {
        return ImportAbs::js([
                                 '/assets/vendor/select2/select2.full.min.js',
                                 '/assets/vendor/select2/i18n/zh-CN.js',
                                 '/assets/vendor/bootstrap-table/tableExport/tableExport.js',
                                 '/assets/vendor/bootstrap-table/bootstrap-table.min.js',
                                 '/vendor/bootstrap-table/bootstrap-table-locale-all.min.js',
                                 '/assets/vendor/bootstrap-table/extensions/export/bootstrap-table-export.min.js',
                                 '/assets/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js',
                             ]);
    }

    /**
     * initialCode
     * @param array $value
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/7/7 11:16
     */
    public static function initialCode(array &$value): string
    {
        return ExtraAbs::empty($value);
    }

}
