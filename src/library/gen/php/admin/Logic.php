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
// | Version: 2.0 2020/3/27 17:40
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

/**
 * Class Logic
 * @package com\generator
 */
class Logic extends LibPHPAdminAbs
{

    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getPhp()->getLogic();
        return $this->setTemplate($path)
                    ->replaceAll([
                                     'append'           => self::append($this->data),
                                     'initialCode'      => self::initialCode($this->data),
                                     'proportionSearch' => self::proportionSearch($this->data[2]['form']['proportionSearch'] ?? [])
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
            $this->setModule(AdminModule::LOGIC);
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
            $this->setModule(AdminModule::LOGIC);
            FileUtil::rm($this->getFileName());
        } catch (Throwable $exception) {
            throw new GenerateException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }

    /**
     * 自定义属性补偿器
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 18:21
     */
    private static function append(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($value) use (&$code) {
            switch ((int)$value['type_id']) {
                case 12: // 当前信息
                    $typeSelection = (int)$value['formData']['typeSelection'];
                    if ($typeSelection === 3) {
                        $code[] = '\'' . $value['formData']['bindTableFiled'] . '_text\'';
                    }
                    break;
                case 13: // 附件上传
                    $code[] = '\'' . $value['formData']['bindTableFiled'] . '_text\'';
                    break;
                case 15: // 图片上传
                    $code[] = '\'' . $value['formData']['bindTableFiled'] . '_default\'';
                    break;
            }
        });
        return Helper::format($code, ',', false, true, false);
    }

    /**
     * initialCode
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:33
     */
    private static function initialCode(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($value) use (&$code) {
            $code[] = match ((int)$value['type_id']) {
                2 => Input::initialCode($value),
                3 => Textarea::initialCode($value),
                4 => Editor::initialCode($value),
                5 => Radio::initialCode($value),
                6 => CheckBox::initialCode($value),
                7 => Select::initialCode($value),
                8 => Datepicker::initialCode($value),
                9 => DateSectionPicker::initialCode($value),
                10 => Code::initialCode($value),
                11 => Organization::initialCode($value),
                12 => Information::initialCode($value),
                13 => Upload::initialCode($value),
                14 => Form::initialCode($value),
                15 => UploadPicture::initialCode($value),
                default => ''
            };
        });
        return Helper::format($code);
    }

    /**
     * proportionSearch
     * @param array $field
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/5/21 10:14
     */
    private static function proportionSearch(array $field): string
    {
        $html = [];
        if (!empty($field)) {
            foreach ($field as $value) {
                $arr    = explode('.', $value['field']);
                $html[] = $arr[1];
            }
        }
        return implode('|', $html);
    }

}
