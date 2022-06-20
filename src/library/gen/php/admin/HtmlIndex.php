<?php /** @noinspection DuplicatedCode */
// +----------------------------------------------------------------------
// | CodeEngine
// +----------------------------------------------------------------------
// | Copyright 艾邦
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: TaoGe <liangtao.gz@foxmail.com>
// +----------------------------------------------------------------------
// | Version: 2.0 2020/3/27 18:38
// +----------------------------------------------------------------------

namespace com\agf2\library\gen\php\admin;

use com\agf2\abs\lib\LibPHPAdminAbs;
use com\agf2\enum\AdminModule;
use com\agf2\exception\GenerateException;
use com\agf2\traits\Search;
use com\agf2\util\FileUtil;
use com\agf2\util\Helper;
use com\agf2\util\ImportPHP;
use Throwable;

class HtmlIndex extends LibPHPAdminAbs
{

    use Search;

    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getHtml()->getIndex();
        return $this->setTemplate($path)
                    ->replaceAll([
                                     'paging'              => $this->data[3]['form']['paging'] ? 'true' : 'false',
                                     'vendorCss'           => self::vendorCss($this->data),
                                     'vendorJs'            => self::vendorJs($this->data),
                                     'toolbarButton'       => self::toolbarButton($this->data),
                                     'toolbarSearch'       => self::toolbarSearch($this->data),
                                     'mobileToolbarSearch' => self::mobileToolbarSearch($this->data)
                                 ])
                    ->getTemplate();
    }

    /**
     * write
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 9:12
     */
    public function write(): void
    {
        try {
            $this->setModule(AdminModule::HTML_INDEX);
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
            $this->setModule(AdminModule::HTML_INDEX);
            FileUtil::rm($this->getFileName());
        } catch (Throwable $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }

    /**
     * vendorCss
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 12:17
     */
    private static function vendorCss(array &$data): string
    {
        $code = [];
        self::each($data, function ($value, $field) use (&$code) {
            switch ((int)$field['type_id']) {
                case 5:
                case 6:
                case 7:
                    $selectType = isset($form_data['selectType']) ? (int)$form_data['selectType'] : 0;

                    $code[] = $selectType === 1 ? ImportPHP::css("/static/assets/vendor/select2/select2.min.css") : ImportPHP::css("/static/assets/vendor/bootstrap-select/bootstrap-select.min.css");
                    break;
            }
        });
        return Helper::format($code);
    }

    /**
     * vendorJs
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 12:21
     */
    private static function vendorJs(array &$data): string
    {
        $code = [];
        self::each($data, function ($value, $field) use (&$code) {
            switch ((int)$field['type_id']) {
                case 5:
                case 6:
                case 7:
                    $selectType = isset($field['formData']['selectType']) ? (int)$field['formData']['selectType'] : 0;
                    $code[]     = $selectType === 1 ? ImportPHP::js(["/static/assets/vendor/select2/select2.full.min.js", "/static/assets/vendor/select2/i18n/zh-CN.js"]) : ImportPHP::js("/static/assets/vendor/bootstrap-select/bootstrap-select.min.js");
                    break;
            }
        });
        return Helper::format($code);
    }

    /**
     * 生成工具栏操作按钮
     * @param array $data
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2020/3/30 11:36
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    private static function toolbarButton(array &$data): string
    {
        ['system' => $system] = $data[3]['action'];
        $var             = $data['var'] ?? [];
        $html_array      = [];
        $html            = [];
        $btn_group_array = [];
        $btn_group       = [];
        $i               = 0;
        // 提取有效的系统内置按钮
        if (!empty($system) && is_array($system)) {
            foreach ($system as $key => $value) {
                if ($value['state']) {
                    $html_array[$key] = $value;
                }
            }
        }
        // 提取有效的自定义按钮
        if (!empty($var) && is_array($var)) {
            foreach ($var as $value) {
                if ($value['state']) {
                    $btn_group_array[] = $value;
                }
            }
        }
        $max = (count($html_array) + count($btn_group_array)) > 4 ? 3 : 4;
        if (!empty($html_array) && is_array($html_array)) {
            foreach ($html_array as $key => $value) {
                $i++;
                $className = ' batch-operation';
                if ($key === 'create') {
                    $className = ' create-operation';
                }
                if ($i <= $max) {
                    $html[] = <<<HTML
                    <button type="button" class="btn btn-inverse$className" data-operation="$key">
                        <i class="{$value['icon']}" aria-hidden="true"></i>
                        <span class="hidden-sm-down">{$value['text']}</span>
                    </button>
HTML;
                } else {
                    $btn_group[] = <<<HTML
                            <a class="dropdown-item$className" data-operation="$key" href="javascript:void(0);" role="menuitem">
                                <i class="{$value['icon']}" aria-hidden="true"></i>
                                <span>{$value['text']}</span>
                            </a>
HTML;
                }
            }
        }
        if (!empty($btn_group_array) && is_array($btn_group_array)) {
            foreach ($btn_group_array as $value) {
                $i++;
                if ($i <= $max) {
                    $html[] = <<<HTML
                    <button id="{$value['id']}" type="button" class="btn btn-inverse">
                        <i class="{$value['icon']}" aria-hidden="true"></i>
                        <span class="hidden-sm-down">{$value['name']}</span>
                    </button>
HTML;
                } else {
                    $btn_group[] = <<<HTML
                            <a id="{$value['id']}" class="dropdown-item" href="javascript:void(0);" role="menuitem">
                                <i class="icon {$value['icon']}" aria-hidden="true"></i>
                                <span>{$value['name']}</span>
                            </a>
HTML;
                }
            }
        }
        if ($max === 3 && count($btn_group)) {
            $btn_group = array_unique($btn_group);
            $btn_group = implode(PHP_EOL, $btn_group);
            $html[]    = <<<html
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-block btn-inverse dropdown-toggle" id="ToolbarSearchFormIconDropdown"
                                data-toggle="dropdown" aria-expanded="false">
                            <span class="hidden-sm-down">更多</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="ToolbarSearchFormIconDropdown" role="menu">
$btn_group
                        </div>
                    </div>
html;
        }
        return Helper::format($html);
    }

    /**
     * 生成工具栏搜索项
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/3/30 18:09
     */
    private static function toolbarSearch(array &$data): string
    {
        $form  = $data[2]['form'] ?? [];
        $array = $data[2]['data'] ?? [];
        $html  = [];
        if (isset($form['search']) && !empty($form['search']) && is_array($form['search'])) {
            if (!empty($array) && is_array($array)) {
                $search = $form['search'];
                foreach ($array as $val) {
                    $id = $val['id'];
                    foreach ($search as $value) {
                        if ((int)$id === (int)$value['id']) {
                            $arr     = explode('.', $value['field']);
                            $name    = $arr[1];
                            $field   = Helper::getFieldAttr($value['field'], $data);
                            $text    = $field['formData']['componentName'] ?: '关键字';
                            $type_id = (int)$field['type_id'];
                            switch ($type_id) {
                                case 2:
                                case 3:
                                case 4:
                                case 10:
                                    $html[] = <<<HTML
                <label class="hidden-xl-down" for="{$name}_PC_SEARCH">
                    <input type="text" id="{$name}_PC_SEARCH" style="width: {$value['width']}px;" class="form-control empty search" name="$name" placeholder="请输入$text" autocomplete="off">
                </label>
HTML;
                                    break;
                                case 5:
                                case 6:
                                case 7:
                                    $selectType  = isset($field['formData']['selectType']) ? (int)$field['formData']['selectType'] : 0;
                                    $dataSources = (int)$field['formData']['dataSources'];
                                    if ($dataSources === 1) {
                                        $val    = '$key';
                                        $option = '$vo';
                                    } else {
                                        $val    = '$vo[\'' . $field['formData']['saveField'] . '\']';
                                        $option = '$vo.' . $field['formData']['displayField'];
                                    }
                                    $select = $selectType === 0 ?
                                        '<select id="' . $name . '_PC_SEARCH" name="' . $field['formData']['bindTableFiled'] . '" class="form-control empty search" data-plugin="selectpicker" title="请选择' . $text . '" style="width: ' . $value['width'] . 'px;" autocomplete="off">' :
                                        '<select id="' . $name . '_PC_SEARCH" name="' . $field['formData']['bindTableFiled'] . '" class="form-control empty search" data-plugin="select2" style="width: ' . $value['width'] . 'px;" autocomplete="off">' . '<option value=""></option>';
                                    $html[] = '                <label class="hidden-xl-down" for="' . $name . '_PC_SEARCH">
                    ' . $select . '
                    {if isset($data.' . $field['formData']['bindTableFiled'] . ') && !empty($data.' . $field['formData']['bindTableFiled'] . ') }
                    {foreach $data.' . $field['formData']['bindTableFiled'] . ' as $key=>$vo }
                    <option value="{' . $val . '}">{' . $option . '}</option>
                    {/foreach}
                    {/if}
                    </select>
                </label>';
                                    break;
                            }
                        }
                    }
                }
            }
        }
        if ((int)$form['timeQuery'] === 1) {
            $timeField = (string)$form['timeField'] === '-1' ? 'create_time' : $form['timeField'];
            $html[]    = <<<HTML
                <div class="search hidden-xl-down" style="width: {$form['boxWidth']}px;">
                    <div class="input-daterange" data-plugin="datepicker" data-language="zh-CN">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon wb-calendar" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" class="form-control" name="$timeField[start]" placeholder="开始时间" autocomplete="off">
                            <input type="text" class="form-control" name="$timeField[end]" placeholder="结束时间" autocomplete="off">
                        </div>
                    </div>
                </div>
HTML;
        }
        if (count($html)) {
            $html[] = <<<HTML
                <button type="button" class="btn btn-inverse btn-pc-search" data-event="search">
                    <i class="icon wb-search" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn btn-inverse btn-pc-search" data-event="clear">
                    <i class="icon wb-trash" aria-hidden="true"></i>
                </button>
HTML;
        }
        return Helper::format($html);
    }

    /**
     * 手机版生成工具栏搜索项
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/3/30 18:09
     */
    private static function mobileToolbarSearch(array &$data): string
    {
        $form  = $data[2]['form'];
        $array = $data[2]['data'] ?? [];
        $html  = [];
        if (isset($form['search']) && !empty($form['search']) && is_array($form['search'])) {
            if (!empty($array) && is_array($array)) {
                $search = $form['search'];
                foreach ($array as $val) {
                    $id = $val['id'];
                    foreach ($search as $value) {
                        if ((int)$id === (int)$value['id']) {
                            $arr     = explode('.', $value['field']);
                            $name    = $arr[1];
                            $field   = Helper::getFieldAttr($value['field'], $data);
                            $text    = $field['formData']['componentName'] ?: '关键字';
                            $type_id = (int)$field['type_id'];
                            switch ($type_id) {
                                case 2:
                                case 3:
                                case 4:
                                case 10:
                                    $html[] = <<<HTML
                    <div class="form-group">
                        <label class="col-form-label" for="{$name}_MOBILE_SEARCH">$text</label>
                        <input type="text" id="{$name}_MOBILE_SEARCH" class="form-control" name="$name" placeholder="请输入$text" autocomplete="off">
                    </div>
HTML;
                                    break;
                                case 5:
                                case 6:
                                case 7:
                                    $selectType  = isset($field['formData']['selectType']) ? (int)$field['formData']['selectType'] : 0;
                                    $dataSources = (int)$field['formData']['dataSources'];
                                    if ($dataSources === 1) {
                                        $val    = '$key';
                                        $option = '$vo';
                                    } else {
                                        $val    = '$vo[\'' . $field['formData']['saveField'] . '\']';
                                        $option = '$vo.' . $field['formData']['displayField'];
                                    }
                                    $select = $selectType === 0 ?
                                        '<select id="' . $name . '_MOBILE_SEARCH" name="' . $field['formData']['bindTableFiled'] . '" class="form-control empty search" data-plugin="selectpicker" title="请选择' . $text . '" autocomplete="off">' :
                                        '<select id="' . $name . '_MOBILE_SEARCH" name="' . $field['formData']['bindTableFiled'] . '" class="form-control empty search" data-plugin="select2" autocomplete="off">' . '<option value=""></option>';
                                    $html[] = '
                    <div class="form-group">
                        <label class="col-form-label" for="' . $name . '_MOBILE_SEARCH">' . $text . '</label>
                        ' . $select . '
                        {if isset($data.' . $field['formData']['bindTableFiled'] . ') && !empty($data.' . $field['formData']['bindTableFiled'] . ') }
                        {foreach $data.' . $field['formData']['bindTableFiled'] . ' as $key=>$vo }
                        <option value="{' . $val . '}">{' . $option . '}</option>
                        {/foreach}
                        {/if}
                        </select>
                    </div>';
                                    break;
                            }
                        }
                    }
                }
            }
        }
        if ((int)$form['timeQuery'] === 1) {
            $timeField = (string)$form['timeField'] === '-1' ? 'create_time' : $form['timeField'];
            $html[]    = <<<HTML
                    <div class="form-group">
                        <label class="col-form-label">日期</label>
                        <div class="input-daterange" data-plugin="datepicker" data-language="zh-CN">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="icon wb-calendar" aria-hidden="true"></i>
                                </span>
                                </div>
                                <input type="text" class="form-control" name="$timeField[start]" placeholder="开始时间" autocomplete="off">
                                <input type="text" class="form-control" name="$timeField[end]" placeholder="结束时间" autocomplete="off">
                            </div>
                        </div>
                    </div>
HTML;
        }
        return Helper::format($html);
    }
}
