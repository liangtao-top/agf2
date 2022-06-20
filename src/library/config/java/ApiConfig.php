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
// | Version: 2.0 2021/8/20 8:59
// +----------------------------------------------------------------------
namespace com\agf2\library\config\java;

use com\agf2\abs\ConfAbs;
use com\agf2\library\config\java\api\TemplateConfig;

class ApiConfig extends ConfAbs
{
    private TemplateConfig $template;

    /**
     * @return \com\agf2\library\config\java\api\TemplateConfig
     */
    public function getTemplate(): TemplateConfig
    {
        return $this->template;
    }

    /**
     * @param \com\agf2\library\config\java\api\TemplateConfig $template
     */
    public function setTemplate(TemplateConfig $template): void
    {
        $this->template = $template;
    }
}
