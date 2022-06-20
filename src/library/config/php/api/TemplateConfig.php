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
namespace com\agf2\library\config\php\api;

use com\agf2\abs\ConfAbs;
use com\agf2\library\config\php\api\template\PHPConfig;

class TemplateConfig extends ConfAbs
{

    private PHPConfig $php;

    /**
     * @return \com\agf2\library\config\php\api\template\PHPConfig
     */
    public function getPhp(): PHPConfig
    {
        return $this->php;
    }

    /**
     * @param \com\agf2\library\config\php\api\template\PHPConfig $php
     */
    public function setPhp(PHPConfig $php): void
    {
        $this->php = $php;
    }

}
