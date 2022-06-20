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
// | Version: 2.0 2021/8/24 15:10
// +----------------------------------------------------------------------
namespace com\agf2\library\gen\php\admin;

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
use com\agf2\abs\lib\LibPHPAdminAbs;
use com\agf2\enum\AdminModule;
use com\agf2\exception\GenerateException;
use com\agf2\util\FileUtil;
use com\agf2\util\Helper;
use Throwable;

class CssForm extends LibPHPAdminAbs
{

    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getCss()->getForm();
        return $this->setTemplate($path)
                    ->replaceAll(['cssFromBody' => self::style($this->data)])
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
            $this->setModule(AdminModule::CSS_FORM);
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
            $this->setModule(AdminModule::CSS_FORM);
            FileUtil::rm($this->getFileName());
        } catch (Throwable $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }

    /**
     * 当前页面样式
     * @param array $data
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2021/8/25 15:42
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
                14 => Form::pageCss($value),
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
