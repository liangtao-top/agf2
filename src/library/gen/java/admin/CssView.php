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
// | Version: 2.0 2021/8/25 15:46
// +----------------------------------------------------------------------
namespace com\agf2\library\gen\java\admin;

use com\agf2\abs\lib\LibJavaAdminAbs;
use com\agf2\component\java\Table;
use com\agf2\component\java\UploadPicture;
use com\agf2\util\Helper;

class CssView extends LibJavaAdminAbs
{
    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getCss()->getView();
        return $this->setTemplate($path)
                    ->replaceAll(['cssFromBody' => self::style($this->data)])
                    ->getTemplate();
    }

    /**
     * style
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/25 15:50
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
