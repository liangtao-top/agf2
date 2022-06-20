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
// | Version: 2.0 2021/8/25 10:23
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

class ServiceImpl extends LibJavaAdminAbs
{
    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getJava()->getServiceImpl();
        return $this->setTemplate($path)
                    ->replaceAll([
                                     'import'           => self::import($this->data),
                                     'append'           => self::append($this->data),
                                     'initialCode'      => self::initialCode($this->data),
                                     'proportionSearch' => self::proportionSearch($this->data[2]['form']['proportionSearch'] ?? []),
                                 ])
                    ->getTemplate();
    }

    /**
     * initialCode
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2020/6/16 19:33
     */
    public static function initialCode(array &$data): string
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
                14 => Table::initialCode($value),
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
     * @date   2021/8/25 10:30
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

    /**
     * 自定义属性补偿器
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/25 10:29
     * @noinspection DuplicatedCode
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
        return Helper::format($code, ',', true, true, false);
    }

    /**
     * import
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/25 10:26
     */
    private static function import(array &$data): string
    {
        $import = [];
        Helper::each($data, function ($value) use (&$import) {
            $form_data    = $value['formData'] ?? [];
            $data_sources = $form_data['dataSources'] ?? 1;
            if ((int)$data_sources === 2) {
                $import[] = 'import com.dm.frame.extend.jpa.NativeQuery;';
            }
        });
        return Helper::format($import);
    }
}
