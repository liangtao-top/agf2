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
// | Version: 2.0 2021/6/30 16:51
// +----------------------------------------------------------------------

namespace com\agf2\traits;

use BadFunctionCallException;
use com\agf\cg\library\Form;
use com\agf2\component\java\CheckBox;
use com\agf2\component\java\Code;
use com\agf2\component\java\Datepicker;
use com\agf2\component\java\DateSectionPicker;
use com\agf2\component\java\Editor;
use com\agf2\component\java\Information;
use com\agf2\component\java\Input;
use com\agf2\component\java\Organization;
use com\agf2\component\java\Radio;
use com\agf2\component\java\Select;
use com\agf2\component\java\Table;
use com\agf2\component\java\Textarea;
use com\agf2\component\java\Upload;
use com\agf2\component\java\UploadPicture;
use com\agf2\util\Helper;
use JetBrains\PhpStorm\ArrayShape;

trait HtmlFormJava
{

    /**
     * 是否为选项卡表单
     * @param array $data
     * @return bool
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2021/8/24 13:56
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    protected static function isTabs(array &$data): bool
    {
        return count($data[1]['tabs']['data'] ?? []) > 1;
    }

    /**
     * 生成表单通用部分
     * @param array $data
     * @return array
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/25 11:10
     */
    #[ArrayShape(['cssFormBody' => "string", 'formTile' => "string", 'jsFormBody' => "string"])] protected static function form(array &$data): array
    {
        return [
            'cssFormBody' => self::css($data),
            'formTile'    => self::tile($data),
            'jsFormBody'  => self::js($data),
        ];
    }

    /**
     * 页面插件js
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 14:14
     */
    private static function js(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($value) use (&$code) {
            $code[] = match ((int)$value['type_id']) {
                2 => Input::vendorJs($value),
                3 => Textarea::vendorJs($value),
                4 => Editor::vendorJs($value),
                5 => Radio::vendorJs($value),
                6 => CheckBox::vendorJs($value),
                7 => Select::vendorJs($value),
                8 => Datepicker::vendorJs($value),
                9 => DateSectionPicker::vendorJs($value),
                10 => Code::vendorJs($value),
                11 => Organization::vendorJs($value),
                12 => Information::vendorJs($value),
                13 => Upload::vendorJs($value),
                14 => Form::vendorJs($value),
                15 => UploadPicture::vendorJs($value),
                default => '',
            };
        });
        return Helper::format($code);
    }

    /**
     * 页面插件css
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 14:13
     */
    private static function css(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($value) use (&$code) {
            $code[] = match ((int)$value['type_id']) {
                2 => Input::vendorCss($value),
                3 => Textarea::vendorCss($value),
                4 => Editor::vendorCss($value),
                5 => Radio::vendorCss($value),
                6 => CheckBox::vendorCss($value),
                7 => Select::vendorCss($value),
                8 => Datepicker::vendorCss($value),
                9 => DateSectionPicker::vendorCss($value),
                10 => Code::vendorCss($value),
                11 => Organization::vendorCss($value),
                12 => Information::vendorCss($value),
                13 => Upload::vendorCss($value),
                14 => Form::vendorCss($value),
                15 => UploadPicture::vendorCss($value),
                default => '',
            };
        });
        return Helper::format($code);
    }

    /**
     * 表单标题
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 14:09
     */
    private static function tile(array &$data): string
    {
        $value = [];
        try {
            Helper::each($data, function ($val) use (&$value) {
                if ((int)$val['type_id'] === 1) {
                    $value = $val;
                    throw new BadFunctionCallException();
                }
            });
        } catch (BadFunctionCallException) {
        }
        return empty($value) ? '' : PHP_EOL . <<<html
    <div class="page-header">
        <h1 class="page-title">{$value['title']}</h1>
    </div>
html;
    }

    /**
     * 表单内容区
     * @param array $data
     * @param bool  $isEdit
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2020/4/13 12:47
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    private static function formBody(array &$data, bool $isEdit = false): string
    {
        $html = [];
        if ($isEdit) {
            $html[] = '                <input type="hidden" name="id" ' . 'th:value="${info?.id}"' . '>';
        }
        $tabs     = $data[1]['tabs']['data'];
        $controls = $data[1]['controls'];
        if (count($tabs) > 1) {
            $html[] = self::formTabs($data, $isEdit);
        } else {
            foreach ($controls[0] as $value) {
                $html[] = match ((int)$value['type_id']) {
                    2 => Input::html($value, $isEdit),
                    3 => Textarea::html($value, $isEdit),
                    4 => Editor::html($value, $isEdit),
                    5 => Radio::html($value, $isEdit),
                    6 => CheckBox::html($value, $isEdit),
                    7 => Select::html($value, $isEdit),
                    8 => Datepicker::html($value, $isEdit),
                    9 => DateSectionPicker::html($value, $isEdit),
                    10 => Code::html($value, $isEdit),
                    11 => Organization::html($value, $isEdit),
                    12 => Information::html($value, $isEdit),
                    13 => Upload::html($value, $isEdit),
                    14 => Table::html($value, $isEdit),
                    15 => UploadPicture::html($value, $isEdit),
                    default => '',
                };
            }
        }
        return Helper::format($html);
    }

    /**
     * formTabs
     * @param array $data
     * @param bool  $isEdit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/4/13 14:38
     */
    private static function formTabs(array $data, bool $isEdit = false): string
    {
        $nav  = self::formTabsNav($data);
        $body = self::formTabsContent($data, $isEdit);
        return <<<html
                <ul class="nav nav-tabs nav-tabs-solid" role="tablist">$nav
                </ul>
                <div class="tab-content">$body
                </div>
html;
    }

    /**
     * 表单选项卡导航
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/3/30 11:35
     */
    private static function formTabsNav(array $data): string
    {
        $html = [];
        $tabs = $data[1]['tabs']['data'];
        foreach ($tabs as $key => $value) {
            $active = $key === 0 ? ' active' : '';
            $html[] = <<<html
                    <li class="nav-item">
                        <a class="nav-link$active" data-sort="{$value['sort']}" data-toggle="tab" href="#formTabsSolid$key" aria-controls="formTabsSolid$key" role="tab">
                            {$value['name']}
                        </a>
                    </li>
html;
        }
        return Helper::format($html);
    }

    /**
     * 表单选项卡内容区
     * @param array $data
     * @param bool  $isEdit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/4/13 14:37
     */
    private static function formTabsContent(array $data, bool $isEdit): string
    {
        $html     = [];
        $controls = $data[1]['controls'];
        foreach ($controls as $key => $value) {
            $active = $key === 0 ? ' active' : '';
            $html[] = <<<html
                    <div class="tab-pane$active" id="formTabsSolid$key" role="tabpanel">
                        <div class="row">
html;
            foreach ($value as $val) {
                $html[] = match ((int)$val['type_id']) {
                    2 => Input::html($val, $isEdit),
                    3 => Textarea::html($val, $isEdit),
                    4 => Editor::html($val, $isEdit),
                    5 => Radio::html($val, $isEdit),
                    6 => CheckBox::html($val, $isEdit),
                    7 => Select::html($val, $isEdit),
                    8 => Datepicker::html($val, $isEdit),
                    9 => DateSectionPicker::html($val, $isEdit),
                    10 => Code::html($val, $isEdit),
                    11 => Organization::html($val, $isEdit),
                    12 => Information::html($val, $isEdit),
                    13 => Upload::html($val, $isEdit),
                    14 => Table::html($val, $isEdit),
                    15 => UploadPicture::html($val, $isEdit),
                    default => '',
                };
            }
            $html[] = <<<html
                        </div>
                    </div>
html;
        }
        return Helper::format($html);
    }


}
