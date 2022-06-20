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
// | Version: 2.0 2021/8/25 10:33
// +----------------------------------------------------------------------
namespace com\agf2\library\gen\java\admin;

use com\agf2\abs\lib\LibJavaAdminAbs;

class Model extends LibJavaAdminAbs
{
    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getJava()->getModel();
        return $this->setTemplate($path)->getTemplate();
    }
}
