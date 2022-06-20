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
// | Version: 2.0 2021/8/25 15:14
// +----------------------------------------------------------------------
namespace com\agf2\library\gen\java\admin;

use com\agf2\abs\lib\LibJavaAdminAbs;
use com\agf2\component\java\Table;
use com\agf2\util\Helper;

class JsView extends LibJavaAdminAbs
{

    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getJs()->getView();
        return $this->setTemplate($path)
                    ->replaceAll([
                                     'pageJsAfter'  => self::afterJs($this->data),
                                     'pageJsBefore' => self::beforeJs($this->data),
                                 ])
                    ->getTemplate();
    }

    /**
     * afterJs
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/25 15:21
     */
    public static function afterJs(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($value) use (&$code) {
            $code[] = match ((int)$value['type_id']) {
                14 => Table::pageJsAfter($value),
                default => ''
            };
        });
        return Helper::format($code);
    }

    /**
     * beforeJs
     * @param array $data
     * @return string
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/25 15:21
     */
    public static function beforeJs(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($value) use (&$code) {
            $code[] = match ((int)$value['type_id']) {
                14 => Table::pageJsBefore($value),
                default => ''
            };
        });
        return Helper::format($code);
    }
}
