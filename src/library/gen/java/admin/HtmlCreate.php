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
use com\agf2\traits\HtmlFormJava;

class HtmlCreate extends LibJavaAdminAbs
{
    use HtmlFormJava;

    public function build(): string
    {
        $html = $this->adminConfig->getTemplate()->getHtml();
        $path = self::isTabs($this->data) ? $html->getFormTabs() : $html->getForm();
        return $this->setTemplate($path)
                    ->replaceAll(self::form($this->data))
                    ->replaceAll([
                                     'action'   => 'create',
                                     'formBody' => self::formBody($this->data),
                                 ])
                    ->getTemplate();
    }
}
