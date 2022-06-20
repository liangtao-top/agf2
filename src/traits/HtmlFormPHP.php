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
// | Version: 2.0 2021/8/24 13:48
// +----------------------------------------------------------------------
namespace com\agf2\traits;

use BadFunctionCallException;
use com\agf\cg\Control;
use com\agf\cg\library\CheckBox;
use com\agf\cg\library\Code;
use com\agf\cg\library\Datepicker;
use com\agf\cg\library\DateSectionPicker;
use com\agf\cg\library\Editor;
use com\agf\cg\library\Form;
use com\agf\cg\library\Information;
use com\agf\cg\library\Input;
use com\agf\cg\library\Organization;
use com\agf\cg\library\Radio;
use com\agf\cg\library\Select;
use com\agf\cg\library\Textarea;
use com\agf\cg\library\Upload;
use com\agf\cg\library\UploadPicture;
use com\agf2\util\Helper;
use JetBrains\PhpStorm\ArrayShape;

trait HtmlFormPHP
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
     * 表单通用替换部分
     * @param array $data
     * @return array
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 14:04
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
        return Helper::format($code, PHP_EOL, true, true, true, true);
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
     * 表单内容区
     * @param array $data
     * @param bool  $is_edit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/4/13 12:47
     */
    private static function formBody(array &$data, bool $is_edit = false): string
    {
        $code = [];
        if ($is_edit) {
            $code[] = '                <input type="hidden" name="id" value="{$info.id}">';
        }
        $tabs     = $data[1]['tabs']['data'];
        $controls = $data[1]['controls'];
        if (count($tabs) > 1) {
            $code[] = self::formTabs($data, $is_edit);
        } else {
            foreach ($controls[0] as $value) {
                $code[] = Control::parse($value, $is_edit);
            }
        }
        return Helper::format($code);
    }

    /**
     * formTabs
     * @param array $data
     * @param bool  $is_edit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/4/13 14:38
     */
    private static function formTabs(array &$data, bool $is_edit = false): string
    {
        $nav  = self::formTabsNav($data);
        $body = self::formTabsContent($data, $is_edit);
        return <<<html
                <ul class="nav nav-tabs nav-tabs-solid" role="tablist">
$nav
                </ul>
                <div class="tab-content">
$body
                </div>
html;
    }

    /**
     * 表单选项卡导航
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/3/30 11:35
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    private static function formTabsNav(array &$data): string
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
        return implode(PHP_EOL, $html);
    }

    /**
     * 表单选项卡内容区
     * @param array $data
     * @param bool  $is_edit
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/4/13 14:37
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    private static function formTabsContent(array &$data, bool $is_edit): string
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
                $html[] = Control::parse($val, $is_edit);
            }
            $html[] = <<<html
                        </div>
                    </div>
html;
        }
        return implode(PHP_EOL, $html);
    }
}
