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
// | Version: 2.0 2021/8/24 16:14
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
use com\agf2\util\ValidationRule;
use Throwable;

class JsForm extends LibPHPAdminAbs
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
     * write
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 9:56
     */
    public function write(): void
    {
        try {
            $this->setModule(AdminModule::JS_FORM);
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
            $this->setModule(AdminModule::JS_FORM);
            FileUtil::rm($this->getFileName());
        } catch (Throwable $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }

    /**
     * 页面加载完成后执行js
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/24 16:54
     */
    private static function afterJs(array &$data): string
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
                14 => Form::pageJsAfter($value),
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
     * @date   2021/8/24 16:55
     */
    private static function beforeJs(array &$data): string
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
                14 => Form::pageJsBefore($value),
                15 => UploadPicture::pageJsBefore($value),
                default => '',
            };
        });
        return Helper::format($code);
    }

}
