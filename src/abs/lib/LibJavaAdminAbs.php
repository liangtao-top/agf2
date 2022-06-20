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
// | Version: 2.0 2021/8/20 17:36
// +----------------------------------------------------------------------
namespace com\agf2\abs\lib;

use com\agf2\library\config\java\AdminConfig;

abstract class LibJavaAdminAbs extends LibJavaAbs
{

    protected AdminConfig $adminConfig;

    public function __construct()
    {
        parent::__construct();
        $this->adminConfig = $this->config->getAdmin();
    }

}
