<?php
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
// | Version: 2.0 2021/8/25 14:53
// +----------------------------------------------------------------------
namespace com\agf2\library\gen\java\admin;

use com\agf2\abs\lib\LibJavaAdminAbs;
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
use com\agf2\util\ValidationRule;

class JsForm extends LibJavaAdminAbs
{

    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getJs()->getForm();
        return $this->setTemplate($path)
                    ->replaceAll([
                                     'pageJsAfter'     => self::afterJs($this->data),
                                     'pageJsBefore'    => self::beforeJs($this->data),
                                     'filedValidation' => ValidationRule::filedValidation($this->data),
                                 ])
                    ->getTemplate();
    }

    /**
     * 页面加载完成后执行js
     * @param array $data
     * @return string
     * @author Lmb
     * @date   2020/4/1 0001 18:10
     */
    public static function afterJs(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($value) use (&$code) {
            $code[] = match ((int)$value['type_id']) {
                2 => Input::pageJsAfter($value),
                3 => Textarea::pageJsAfter($value),
                4 => Editor::pageJsAfter($value),
                5 => Radio::pageJsAfter($value),
                6 => CheckBox::pageJsAfter($value),
                7 => Select::pageJsAfter($value),
                8 => Datepicker::pageJsAfter($value),
                9 => DateSectionPicker::pageJsAfter($value),
                10 => Code::pageJsAfter($value),
                11 => Organization::pageJsAfter($value),
                12 => Information::pageJsAfter($value),
                13 => Upload::pageJsAfter($value),
                14 => Table::pageJsAfter($value),
                15 => UploadPicture::pageJsAfter($value),
                default => '',
            };
        });
        return Helper::format($code);
    }

    /**
     * 页面加载完成前执行js
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/25 15:05
     */
    public static function beforeJs(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($value) use (&$code) {
            $code[] = match ((int)$value['type_id']) {
                2 => Input::pageJsBefore($value),
                3 => Textarea::pageJsBefore($value),
                4 => Editor::pageJsBefore($value),
                5 => Radio::pageJsBefore($value),
                6 => CheckBox::pageJsBefore($value),
                7 => Select::pageJsBefore($value),
                8 => Datepicker::pageJsBefore($value),
                9 => DateSectionPicker::pageJsBefore($value),
                10 => Code::pageJsBefore($value),
                11 => Organization::pageJsBefore($value),
                12 => Information::pageJsBefore($value),
                13 => Upload::pageJsBefore($value),
                14 => Table::pageJsBefore($value),
                15 => UploadPicture::pageJsBefore($value),
                default => '',
            };
        });
        return Helper::format($code);
    }
}
