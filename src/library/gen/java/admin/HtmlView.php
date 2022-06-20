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
// | Version: 2.0 2021/8/25 11:05
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
use com\agf2\traits\HtmlFormJava;
use com\agf2\util\Helper;

class HtmlView extends LibJavaAdminAbs
{

    use HtmlFormJava;

    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getHtml()->getView();
        return $this->setTemplate($path)
                    ->replaceAll([
                                     'action'          => 'view',
                                     'formTile'        => self::tile($this->data),
                                     'vendorJs'        => self::vendorJs($this->data),
                                     'vendorCss'       => self::vendorCss($this->data),
                                     'formViewContent' => self::content($this->data),
                                 ])
                    ->getTemplate();

    }

    /**
     * vendorJs
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/25 11:56
     */
    private static function vendorJs(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($value) use (&$code) {
            $code[] = match ((int)$value['type_id']) {
                14 => Table::vendorJs($value),
                default => '',
            };
        });
        return Helper::format($code);
    }

    /**
     * vendorCss
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/25 11:56
     */
    private static function vendorCss(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($value) use (&$code) {
            $code[] = match ((int)$value['type_id']) {
                14 => Table::vendorCss($value),
                15 => UploadPicture::vendorCss($value),
                default => '',
            };
        });
        return Helper::format($code);
    }

    /**
     * content
     * @param array $data
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2021/8/25 11:50
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    private static function content(array &$data): string
    {
        $html     = [];
        $tabs     = $data[1]['tabs']['data'];
        $controls = $data[1]['controls'];
        foreach ($controls as $key => $value) {
            $html[] = <<<html
                <div class="col-12"><h2 class="content-divider">{$tabs[$key]['name']}</h2></div>
html;
            foreach ($value as $val) {
                $html[] = match ((int)$val['type_id']) {
                    2 => Input::view($val),
                    3 => Textarea::view($val),
                    4 => Editor::view($val),
                    5 => Radio::view($val),
                    6 => CheckBox::view($val),
                    7 => Select::view($val),
                    8 => Datepicker::view($val),
                    9 => DateSectionPicker::view($val),
                    10 => Code::view($val),
                    11 => Organization::view($val),
                    12 => Information::view($val),
                    13 => Upload::view($val),
                    14 => Table::view($val),
                    15 => UploadPicture::view($val),
                    default => '',
                };
            }
        }
        return Helper::format($html);
    }

}
