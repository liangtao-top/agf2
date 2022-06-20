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

use com\agf2\library\config\java\ApiConfig;

abstract class LibJavaApiAbs extends LibJavaAbs
{
    protected ApiConfig $apiConfig;

    protected function __construct()
    {
        parent::__construct();
        $this->apiConfig = $this->config->getApi();
    }
}
