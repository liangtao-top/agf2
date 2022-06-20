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
use com\agf2\traits\Search;
use com\agf2\util\Helper;

class CssIndex extends LibJavaAdminAbs
{

    use Search;

    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getCss()->getIndex();
        return $this->setTemplate($path)
                    ->replaceAll(['indexCss' => self::style($this->data)])
                    ->getTemplate();
    }

    /**
     * 首页Css(搜索用)
     * @param array $data
     * @return string
     * @author       TaoGe <liangtao.gz@foxmail.com>
     * @date         2021/8/25 15:29
     * @noinspection DuplicatedCode
     */
    private static function style(array &$data): string
    {
        $code = [];
        self::each($data, function ($value, $field) use (&$code) {
            switch ((int)$field['type_id']) {
                case 5:
                case 6:
                case 7:
                    $selectType = isset($field['formData']['selectType']) ? (int)$field['formData']['selectType'] : 0;
                    $code[]     = $selectType === 1 ? '
#' . $field['formData']['bindTableFiled'] . '_PC_SEARCH + span.select2 {
    display: inline-block;
}
' : '';
                    break;
            }
        });
        return Helper::format($code);
    }

}
