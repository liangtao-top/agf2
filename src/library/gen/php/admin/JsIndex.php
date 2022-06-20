<?php /** @noinspection DuplicatedCode */
declare(strict_types=1);
// +----------------------------------------------------------------------
// | CodeEngine
// +----------------------------------------------------------------------
// | Copyright 艾邦
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: TaoGe <liangtao.gz@foxmail.com>
// +----------------------------------------------------------------------
// | Version: 2.0 2021/8/24 16:14
// +----------------------------------------------------------------------
namespace com\agf2\library\gen\php\admin;

use com\agf2\abs\lib\LibPHPAdminAbs;
use com\agf2\enum\AdminModule;
use com\agf2\exception\GenerateException;
use com\agf2\util\FileUtil;
use com\agf2\util\Helper;
use Throwable;

class JsIndex extends LibPHPAdminAbs
{

    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getJs()->getIndex();
        return $this->setTemplate($path)
                    ->replaceAll([
                                     'beforeJsBootstrapTableOperating' => self::beforeJsBootstrapTableOperating($this->data),
                                     'bootstrapTableOperating'         => self::bootstrapTableOperating($this->data),
                                     'bootstrapTableColumns'           => self::bootstrapTableColumns($this->data),
                                     'toolbarVarButton'                => self::toolbarVarButton($this->data[3]['action']['var'] ?? []),
                                     'beforeIndexJs'                   => self::beforeIndexJs($this->data),
                                     'afterIndexJs'                    => self::afterIndexJs($this->data),
                                 ])
                    ->getTemplate();
    }

    /**
     * write
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 9:56
     */
    public function write(): void
    {
        try {
            $this->setModule(AdminModule::JS_INDEX);
            FileUtil::write($this->getFileName(), $this->getContent());
        } catch (Throwable $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }

    /**
     * clean
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 15:11
     */
    public function clean(): void
    {
        try {
            $this->setModule(AdminModule::JS_INDEX);
            FileUtil::rm($this->getFileName());
        } catch (Throwable $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }

    /**
     * 设置bootstrapTabled的Columns数据
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/5/21 10:15
     */
    private static function bootstrapTableColumns(array &$data): string
    {
        $column = $data [3]['column'] ?? [];
        $html   = [];
        if (is_array($column) && !empty($column)) {
            foreach ($column as $value) {
                $arr       = explode('.', $value['name']);
                $attr      = Helper::getFieldAttr($value['name'], $data);
                $desc      = $attr['formData']['componentName'];
                $type_id   = (int)$attr['type_id'];
                $formatter = '            return data;';
                switch ($type_id) {
                    case 3: // 文本区
                    case 4: // 编辑器
                        $formatter = <<<stript
            return dm.helper.htmlEncode(data);
stript;
                        break;
                    case 5:
                    case 6:
                    case 7:
                        $formatter = <<<stript
            return dm.helper.multipleDataFormat(data, \$AssociatedData, '$arr[1]',  '{$attr['formData']['displayField']}', '{$attr['formData']['saveField']}');
stript;
                        break;
                    case 9: // 日期区间
                        $formatter = <<<stript
            if (Object.prototype.toString.call(data) === '[object Object]') {
              return data.start + '~' + data.end;
            }
            return data;
stript;
                        break;
                    case 11: // 单位组织
                        $typeSelection = (int)$attr['formData']['typeSelection'];
                        if ($typeSelection === 3 || $typeSelection === 2) {
                            $formatter = <<<JS
            var html = [];
            if(_.isArray(data) || _.isObject(data)){
              _.forEach(data,function (value) {
                html.push(value.name);
              })
            }
            return html.join(',');
JS;
                        } else if ($typeSelection === 1) {
                            $formatter = <<<TEXT
            var html = [];
            var data_source = \$AssociatedData.find('[data-id="$arr[1]"]').data('json');
            if (_.isArray(data_source) || _.isObject(data_source)) {
              _.forEach(data_source, function (value) {
                if(Number(data) === Number(value.id)){
                  html.push(value.name);  
                }
              });
            }
            return html.join(',');
TEXT;
                        }

                        break;
                    case 12: // 当前信息
                        $typeSelection = (int)$attr['formData']['typeSelection'];
                        // 当前用户
                        if ($typeSelection === 3) {
                            $arr[1] = $arr[1] . '_text';
                        }
                        $formatter = '            return data;';
                        break;
                    case 13: // 附件上传
                        $arr[1]    = $arr[1] . '_text';
                        $formatter = <<<stript
            if (_.isEmpty(data)) return '-';
            return data;
stript;
                        break;
                    case 15: // 图片上传
                        $arr[1]    = $arr[1] . '_default';
                        $formatter = <<<stript
            return dm.helper.bootstrapTableColumnsImg(data, row, index, field);
stript;
                        break;
                    default:
                        $formatter = '            return data;';
                }
                $isSort      = $value['isSort'] ? 'true' : 'false';
                $printIgnore = $value['print'] ? 'false' : 'true';
                $html []     = <<<JSON
{
          title: '$desc',
          field: '$arr[1]',
          rowspan: 1,
          align: '{$value['alignment']}',
          valign: 'middle',
          width: '{$value['width']}',
          class: 'text-truncate',
          visible: {$value['visibility']},
          sortable: $isSort,
          printIgnore: $printIgnore,
          formatter: function (data, row, index, field) {
$formatter
          },
          printFormatter: function (data, row, index, field) {
$formatter
          }
        }
JSON;
            }
        }
        return Helper::format($html, ', ');
    }

    /**
     * 操作栏js
     * @param array $data
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2020/7/27 14:30
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    private static function beforeJsBootstrapTableOperating(array &$data): string
    {
        $html      = [];
        $operating = $data [3]['operating'] ?? [];
        $var       = $operating['var'] ?? [];
        if (!empty($var) && is_array($var)) {
            foreach ($var as $value) {
                if ($value['state']) {
                    $code   = (isset($value['code']) && !empty($value['code'])) ? PHP_EOL . '    ' . $value['code'] : '';
                    $html[] = <<<js
  // 自定义操作栏按钮[{$value['name']}]事件
  dm.bootstrapTable.operateEvents[ 'click .{$value['id']}' ] = function (e, value, row, index) {
    e.stopPropagation();
    console.log(e);
    console.log(value);
    console.log(row);
    console.log(index);$code
  };
js;
                }
            }
        }
        return Helper::format($html);
    }

    /**
     * 定义bootstrapTabled的操作栏数据
     * @param array $data
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2020/6/17 9:12
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    private static function bootstrapTableOperating(array &$data): string
    {
        $html      = '';
        $operating = $data [3]['operating'] ?? [];
        $system    = $operating['system'] ?? [];
        $var       = $operating['var'] ?? [];
        $count     = count($system) + count($var);
        $button    = [];
        $width     = 14.012;
        if ($count > 0) {
            if (!empty($system) && is_array($system)) {
                foreach ($system as $key => $value) {
                    if ($value['state']) {
                        $width    = $width + 40 + (mb_strlen($value['text'], "utf-8") * 13.795);
                        $button[] = <<<html
<button type="button" class="btn btn-inverse btn-sm $key"><i class="icon {$value['icon']}" aria-hidden="true"></i> <span class="hidden-sm-down">{$value['text']}</span></button>
html;
                    }
                }
            }
            if (!empty($var) && is_array($var)) {
                foreach ($var as $value) {
                    if ($value['state']) {
                        $width    = $width + 40 + (mb_strlen($value['name'], "utf-8") * 13.795);
                        $button[] = <<<html
<button type="button" class="btn btn-inverse btn-sm {$value['id']}"><i class="icon {$value['icon']}" aria-hidden="true"></i> <span class="hidden-sm-down">{$value['name']}</span></button>
html;
                    }
                }
            }
            $button = array_unique($button);
            $button = implode('', $button);
            $html   = <<<TEXT
, {
          title: '操作',
          width: $width,
          class: 'text-truncate',
          align: 'center',
          valign: 'middle',
          sortable: false,
          printIgnore: true,
          events: dm.bootstrapTable.operateEvents,
          formatter: function (value, row, index) {
            return '<div class="btn-group">$button</div>';
          }
        }
TEXT;
        }
        return $html;
    }

    /**
     * 工具栏自定按钮的JS
     * @param array $var
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/3/30 14:56
     */
    private static function toolbarVarButton(array $var): string
    {
        $html = [];
        if (!empty($var)) {
            foreach ($var as $value) {
                if ($value['state']) {
                    $code   = (isset($value['code']) && !empty($value['code'])) ? PHP_EOL . '      ' . $value['code'] : '';
                    $html[] = <<<SCRIPT
    // 自定义工具栏按钮[{$value['name']}]事件
    $('#{$value['id']}').click(function () {
      // noinspection JSUnresolvedFunction
      var rows = \$table.bootstrapTable('getSelections');
      console.log(rows);$code
    });
SCRIPT;
                }
            }
        }
        return Helper::format($html);
    }

    /**
     * 首页Js(搜索用)
     * @param array $data
     * @return string
     * @author Jerry Yan <792602257@qq.com>
     * @date   2020/6/9 11:11
     */
    private static function beforeIndexJs(array &$data): string
    {
        $form  = $data[2]['form'] ?? [];
        $array = $data[2]['data'] ?? [];
        $html  = [];
        if (!empty($array) && isset($form['search']) && !empty($form['search']) && is_array($form['search'])) {
            $search = $form['search'];
            foreach ($array as &$v) {
                foreach ($search as $v2) {
                    if ((int)$v2['id'] === (int)$v['id']) {
                        $v = array_merge($v, $v2);
                    }
                }
            }
            foreach ($array as $value) {
                $field          = Helper::getFieldAttr($value['field'], $data);
                $formData       = $field['formData'] ?? [];
                $bindTableFiled = $formData['bindTableFiled'] ?? '';
                $type_id        = (int)$field['type_id'] ?? 0;
                switch ($type_id) {
                    case 5:
                    case 6:
                    case 7:
                        $name = ucfirst($bindTableFiled);
                        $info = <<<script
  var \$selectName$name = $('select[name="$bindTableFiled"]');
  var querySelectName{$name}Value = dm.helper.getQueryString('$bindTableFiled');
script;
                        break;
                    default:
                        $info = '';
                }
                if (!empty($info)) {
                    $html[] = $info;
                }
            }
        }
        return Helper::format($html);
    }

    /**
     * afterIndexJs
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 16:49
     * @noinspection PhpUnnecessaryCurlyVarSyntaxInspection
     */
    private static function afterIndexJs(array &$data): string
    {
        $form  = $data[2]['form'] ?? [];
        $array = $data[2]['data'] ?? [];
        $html  = [];
        if (!empty($array) && isset($form['search']) && !empty($form['search']) && is_array($form['search'])) {
            $search = $form['search'];
            foreach ($array as &$v) {
                foreach ($search as $v2) {
                    if ((int)$v2['id'] === (int)$v['id']) {
                        $v = array_merge($v, $v2);
                    }
                }
            }
            foreach ($array as $value) {
                $field          = Helper::getFieldAttr($value['field'], $data);
                $formData       = $field['formData'] ?? [];
                $bindTableFiled = $formData['bindTableFiled'] ?? '';
                $ucFirst        = ucfirst($bindTableFiled);
                $type_id        = (int)$field['type_id'] ?? 0;
                switch ($type_id) {
                    case 5:
                    case 6:
                    case 7:
                        $liveSearch              = isset($field['formData']['liveSearch']) ? (int)$field['formData']['liveSearch'] : 0;
                        $selectType              = isset($field['formData']['selectType']) ? (int)$field['formData']['selectType'] : 0;
                        $relationScript          = '';
                        $minimumResultsForSearch = $liveSearch === 0 ? ', minimumResultsForSearch: -1' : '';
                        if (isset($field['formData']['relationTo']) && !empty($relationTo = $field['formData']['relationTo']) && isset($field['formData']['relationshipField']) && !empty($relationshipField = $field['formData']['relationshipField'])) {
                            $url               = (string)url('base.Control/getTableData');
                            $_refreshScript    = $selectType === 1 ?
                                <<<SCRIPT
select2($.concatCpt('select2', {placeholder: '请选择{$field['title']}'$minimumResultsForSearch}));
SCRIPT
                                :
                                <<<SCRIPT
selectpicker('refresh');
SCRIPT;
                            $_refreshOption    = $selectType === 1 ? <<<SCRIPT
<option value=""></option>
SCRIPT
                                : '';
                            $isComment         = function ($type, $value) {
                                return $type === 1 ? PHP_EOL . '      ' . ($value === 'true' ? '' : '    ') . '$field.attr(\'disabled\', ' . $value . ');' : '';
                            };
                            $ucFirstRelationTo = ucfirst($relationTo);
                            $relationScript    .= <<<SCRIPT
    // 初始化{$field['title']}的关联关系插件
    \$selectName$ucFirstRelationTo.on('change', function(){
      var \$field = \$selectName$ucFirst;
      // noinspection DuplicatedCode{$isComment($selectType, 'true')}
      dm.request({
        type: 'get',
        url: '$url',
        data: {tableName: '{$field['formData']['dataOption']}', field: '{$field['formData']['displayField']}, {$field['formData']['saveField']}', where: {{$relationshipField}: this.value}},
        success: function (res) {
          if (res.code) {
            var h = '$_refreshOption';
            if (res.hasOwnProperty('data')) {
              _.forEach(res.data, function (value) {
                h += '<option value="' + value[ '{$field['formData']['saveField']}' ] + '"' + (String(\$field.val()) === String(value[ '{$field['formData']['saveField']}' ]) ? ' selected' : '') + '>' + value['{$field['formData']['displayField']}' ] + '</option>';
              })
            }
            \$field.html(h).$_refreshScript
          }
        },
        complete: function () {{$isComment($selectType, 'false')}
        }
      });
    }).eq(0).trigger('change');
SCRIPT;
                        }
                        $initScript = $selectType === 1 ?
                            <<<SCRIPT
    // 初始化{$field['title']}的Select2插件
    if (querySelectName{$ucFirst}Value) \$selectName$ucFirst.val(querySelectName{$ucFirst}Value);
    \$selectName$ucFirst.select2($.concatCpt('select2', {placeholder: '请选择{$field['title']}'$minimumResultsForSearch}));
SCRIPT
                            :
                            <<<SCRIPT
    // 初始化{$field['title']}的Bootstrap Select插件
    if (querySelectName{$ucFirst}Value) \$selectName$ucFirst.val(querySelectName{$ucFirst}Value);
    \$selectName$ucFirst.selectpicker('refresh');
SCRIPT;
                        if (!empty($relationScript)) {
                            $html[] = $relationScript;
                        }
                        $info = $initScript;
                        break;
                    default:
                        $info = '';
                }
                if (!empty($info)) {
                    $html[] = $info;
                }
            }
        }
        return Helper::format($html);
    }

}
