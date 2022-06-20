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
// | Version: 2.0 2021/8/25 15:23
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

class CssForm extends LibJavaAdminAbs
{

    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getCss()->getForm();
        return $this->setTemplate($path)
                    ->replaceAll(['cssFromBody' => self::style($this->data)])
                    ->getTemplate();
    }

    /**
     * 当前页面样式
     * @param array $data
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2021/8/25 15:43
     * @noinspection DuplicatedCode
     */
    public static function style(array &$data): string
    {
        // 无标题栏的样式高度补偿
        $style[]  = '#myForm {
    min-height: calc(100vh - 79px);
}
#myForm > .nav-tabs-horizontal > .tab-content {
    min-height: calc(100vh - 123px);
}';
        $is_title = false;
        Helper::each($data, function ($value) use (&$style, &$is_title) {
            $type_id = (int)$value['type_id'];
            if ($type_id === 1) {
                $is_title = true;
            }
            $style[] = match ($type_id) {
                2 => Input::pageCss($value),
                3 => Textarea::pageCss($value),
                4 => Editor::pageCss($value),
                5 => Radio::pageCss($value),
                6 => CheckBox::pageCss($value),
                7 => Select::pageCss($value),
                8 => Datepicker::pageCss($value),
                9 => DateSectionPicker::pageCss($value),
                10 => Code::pageCss($value),
                11 => Organization::pageCss($value),
                12 => Information::pageCss($value),
                13 => Upload::pageCss($value),
                14 => Table::pageCss($value),
                15 => UploadPicture::pageCss($value),
                default => ''
            };
        });
        if ($is_title) {
            unset($style[0]);
        }
        return Helper::format($style);
    }
}
