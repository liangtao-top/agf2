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
// | Version: 2.0 2021/8/20 9:04
// +----------------------------------------------------------------------
namespace com\agf2\library\config\java\api;

use com\agf2\abs\ConfAbs;
use com\agf2\library\config\java\api\template\JavaConfig;

class TemplateConfig extends ConfAbs
{

    private JavaConfig $java;

    /**
     * @return \com\agf2\library\config\java\api\template\JavaConfig
     */
    public function getJava(): JavaConfig
    {
        return $this->java;
    }

    /**
     * @param \com\agf2\library\config\java\api\template\JavaConfig $java
     */
    public function setJava(JavaConfig $java): void
    {
        $this->java = $java;
    }


}
